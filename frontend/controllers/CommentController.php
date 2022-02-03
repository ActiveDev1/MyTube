<?php

namespace frontend\controllers;

use common\models\Comment;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'content' => [
                'class' => ContentNegotiator::class,
                'only' => ['create', 'update', 'delete'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ],
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    public function actionCreate()
    {
        $comment = new Comment();
        if ($comment->load(Yii::$app->request->post(), '') && $comment->save()) {
            return [
                'success' => true,
                'comment' => $this->renderPartial('@app/views/video/_comment_item', ['model' => $comment])
            ];
        }

        return [
            'success' => false,
            'errors' => $comment->errors
        ];
    }

    /**
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        $comment = $this->findModel($id);
        if ($comment->created_by != Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $comment->delete();
        return ['success' => true];
    }

//    public function actionUpdate()
//    {
//        return $this->render('update');
//    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $comment = Comment::findOne($id);
        if (!$comment) {
            throw new NotFoundHttpException();
        }
        return $comment;
    }
}
