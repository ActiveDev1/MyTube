<?php

namespace common\helpers;

use Yii;
use yii\helpers\Url;

class Html
{
    public static function channelLink($user, $schema = false, $isFrontendUrl = false)
    {
        return \yii\helpers\Html::a($user->username,
            $isFrontendUrl ? Yii::$app->params['frontendUrl'] . 'c/' . $user->username :
                Url::to(['channel/view', 'username' => $user->username], $schema),
            ['class' => 'text-decoration-none text-dark']);
    }

}