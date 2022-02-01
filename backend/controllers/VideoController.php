<?php

namespace backend\controllers;

use common\models\Video;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * VideoController implements the CRUD actions for Video model.
 */
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
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@']
                        ]
                    ]
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Video models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->creator(Yii::$app->user->id)->latest(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'video_id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Video();

        $model->video = UploadedFile::getInstanceByName('video');

        if (Yii::$app->request->isPost && $model->save()) {
            return $this->redirect(['update', 'video_id' => $model->video_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Video model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $video_id Video ID
     * @return string|Response
     * @throws NotFoundHttpException|Exception if the model cannot be found
     */
    public function actionUpdate($video_id)
    {
        $model = $this->findModel($video_id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->thumbnail = UploadedFile::getInstanceByName('Video[thumbnail]');
            if ($model->save()) {
                return $this->redirect(['update', 'video_id' => $model->video_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Video model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $video_id Video ID
     * @return Video the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($video_id)
    {
        if (($model = Video::findOne(['video_id' => $video_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Deletes an existing Video model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $video_id Video ID
     * @return Response
     * @throws NotFoundHttpException|StaleObjectException if the model cannot be found
     */
    public function actionDelete($video_id)
    {
        $this->findModel($video_id)->delete();

        return $this->redirect(['index']);
    }
}
