<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\Subscriber;
use common\models\Video;
use common\models\VideoView;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $userId = Yii::$app->user->id;

        $latestVideo = Video::find()->latest()->creator($userId)->limit(1)->one();
        $numberOfView = VideoView::find()->alias('vv')
            ->innerJoin(Video::tableName() . 'v',
                'v.video_id = vv.video_id')
            ->andWhere(['v.created_by' => $userId])
            ->count();

        $numberOfSubscriber = Yii::$app->cache->get('subscribers-' . $userId);
        if (!$numberOfSubscriber) {
            $numberOfSubscriber = $user->getSubscriber()->count();
            Yii::$app->cache->set('subscribers-' . $userId, $numberOfSubscriber);
        }

        $subscribers = Subscriber::find()
            ->with('user')
            ->andWhere([
                'channel_id' => $userId
            ])
            ->orderBy('created_at DESC')
            ->limit(3)
            ->all();

        return $this->render('index', [
            'latestVideo' => $latestVideo,
            'numberOfView' => $numberOfView,
            'numberOfSubscriber' => $numberOfSubscriber,
            'subscribers' => $subscribers,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
