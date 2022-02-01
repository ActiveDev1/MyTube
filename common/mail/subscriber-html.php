<?php

use common\helpers\Html;
use common\models\User;

/** @var $channel User */
/** @var $user User */
?>


<p>Hello <?= $channel->username ?></p>
<p>User <?= Html::channelLink($user, true) ?>
    has subscribed to you
</p>

<p>YouTube team</p>