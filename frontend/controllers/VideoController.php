<?php

namespace frontend\controllers;

use common\models\Video;
use common\models\VideoLike;
use common\models\VideoView;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class VideoController extends Controller
{

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['like', 'dislike', 'history'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@']
                        ]
                    ]
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'like' => ['POST'],
                        'dislike' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest)
            $this->layout = 'main';

        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->with('createdBy')->published()->latest(),
            'pagination' => [
                'pageSize' => 5
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView($video_id)
    {
        // TODO Prevent duplicate views
        $this->layout = 'video';
        $video = $this->findVideo($video_id);

        $videoView = new VideoView();
        $videoView->video_id = $video_id;
        $videoView->user_id = Yii::$app->user->id;
        $videoView->created_at = time();
        $videoView->save();

        $similarVideos = Video::find()
            ->published()
            ->andWhere(['NOT', ['video_id' => $video_id]])
            ->byKeyword($video->title)
            ->limit(10)
            ->all();

        return $this->render('view', [
            'model' => $video,
            'similarVideos' => $similarVideos
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findVideo($video_id)
    {
        $video = Video::findOne($video_id);
        if (!$video) {
            throw new NotFoundHttpException('Video not found!');
        }
        return $video;
    }

    /**
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     */
    public function actionLike($video_id)
    {
        $video = $this->findVideo($video_id);
        $user_id = Yii::$app->user->id;

        $videoLikeDislike = VideoLike::find()->userIdVideId($user_id, $video_id)->one();

        if (!$videoLikeDislike) {
            $this->saveLikeDislike($video_id, $user_id, VideoLike::TYPE_LIKE);
        } else if ($videoLikeDislike->type === VideoLike::TYPE_LIKE) {
            $videoLikeDislike->delete();
        } else {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($video_id, $user_id, VideoLike::TYPE_LIKE);
        }

        return $this->renderAjax('_buttons', ['model' => $video]);
    }

    protected function saveLikeDislike($video_id, $user_id, $type)
    {
        $videoLikeDislike = new VideoLike();
        $videoLikeDislike->video_id = $video_id;
        $videoLikeDislike->user_id = $user_id;
        $videoLikeDislike->type = $type;
        $videoLikeDislike->created_at = time();
        $videoLikeDislike->save();
    }

    /**
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     */
    public function actionDislike($video_id)
    {
        $video = $this->findVideo($video_id);
        $user_id = Yii::$app->user->id;

        $videoLikeDislike = VideoLike::find()->userIdVideId($user_id, $video_id)->one();

        if (!$videoLikeDislike) {
            $this->saveLikeDislike($video_id, $user_id, VideoLike::TYPE_DISLIKE);
        } else if ($videoLikeDislike->type === VideoLike::TYPE_DISLIKE) {
            $videoLikeDislike->delete();
        } else {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($video_id, $user_id, VideoLike::TYPE_DISLIKE);
        }

        return $this->renderAjax('_buttons', ['model' => $video]);
    }

    public function actionSearch($keyword)
    {
        if (!Yii::$app->user->isGuest)
            $this->layout = 'main';

        $query = Video::find()->published()->latest();
        if ($keyword) {
            // TODO sql injection maybe accured for this line fix this later
            $query->byKeyword($keyword)->orderBy("MATCH(title,description,tags)
            AGAINST ('$keyword') DESC");
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ]
        ]);

        return $this->render('search', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionHistory()
    {
        if (!Yii::$app->user->isGuest)
            $this->layout = 'main';

        $query = Video::find()
            ->with('createdBy')
            ->alias('v')
            ->innerJoin('(SELECT video_id, MAX(created_at) as max_date FROM `video_view`
                               WHERE user_id = :userId
                               GROUP BY video_id) vv', 'vv.video_id = v.video_id', ['userId' => Yii::$app->user->id])
            ->orderBy('vv.max_date DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ]
        ]);

        return $this->render('history', [
            'dataProvider' => $dataProvider
        ]);
    }
}
