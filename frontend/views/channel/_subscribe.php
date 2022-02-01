<?php
/** @var $channel User */

use common\models\User;
use yii\helpers\Url;

?>

<a class="btn <?= $channel->id === Yii::$app->user->id ? 'd-none' : '' ?> <?= $channel->isSubscribed(Yii::$app->user->id) ? 'btn-secondary' : 'btn-danger' ?>"
   href="<?= Url::to(['channel/subscribe', 'username' => $channel->username]) ?>"
   data-method="post"
   data-pjax="1"
   role="button">Subscribe <i class="bi bi-bell"></i>
</a> <?= $channel->id === Yii::$app->user->id ? false : $channel->getSubscriber()->count() ?>
