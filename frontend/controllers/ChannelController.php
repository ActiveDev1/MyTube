<?php

namespace frontend\controllers;

use common\models\Subscriber;
use common\models\User;
use common\models\Video;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;

class ChannelController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['subscribe'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView($username)
    {
        if (!Yii::$app->user->isGuest)
            $this->layout = 'main';

        $channel = $this->findChannel($username);

        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->creator($channel->id)->published()
        ]);

        return $this->render('view', [
            'channel' => $channel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param $username
     * @return User
     * @throws NotFoundHttpException
     */
    protected function findChannel($username)
    {
        $channel = User::findByUsername($username);
        if (!$channel) {
            throw new NotFoundHttpException('Channel does not exist.');
        }
        return $channel;
    }

    /**
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws NotAcceptableHttpException
     */
    public function actionSubscribe($username)
    {
        $channel = $this->findChannel($username);
        $userId = Yii::$app->user->id;

        if ($userId === $channel->id) {
            throw new NotAcceptableHttpException('You can`t subscribe your channel');
        }

        $subscriber = $channel->isSubscribed($userId);

        if ($subscriber) {
            $subscriber->delete();
        } else {
            $subscriber = new Subscriber();
            $subscriber->channel_id = $channel->id;
            $subscriber->user_id = $userId;
            $subscriber->created_at = time();
            $subscriber->save();

            Yii::$app->mailer->compose([
                'html' => 'subscriber-html', 'text' => 'subscriber-text'
            ], [
                'channel' => $channel,
                'user' => Yii::$app->user->identity
            ])
                ->setFrom(Yii::$app->params['senderEmail'])
                ->setTo($channel->email)
                ->setSubject('You have new subscriber')
                ->send();
        }

        return $this->renderAjax('_subscribe', ['channel' => $channel]);
    }
}
