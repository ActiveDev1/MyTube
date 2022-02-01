<?php

/* @var $this yii\web\View */
/* @var $latestVideo Video */
/* @var $numberOfView integer */
/* @var $numberOfSubscriber integer */

/* @var $subscribers Subscriber[] */

use common\helpers\Html;
use common\models\Subscriber;
use common\models\Video;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index d-flex ">
    <div class="card m-3" style="width: 14rem;">
        <?php if ($latestVideo): ?>
            <a href="<?= Url::to(['video/update', 'video_id' => $latestVideo->video_id]) ?>">
                <div class="ratio ratio-16x9">
                    <video src="<?= $latestVideo->getVideoLink(); ?>" poster="<?= $latestVideo->getThumbnailLink() ?>"
                           style="object-fit: cover"
                           title="<?= $latestVideo->title ?>"
                    ></video>
                </div>
            </a>
            <div class="card-body">
                <h6 class="card-title"><?= $latestVideo->title ?></h6>
                <p class="card-text">
                    Likes: <?= $latestVideo->getLikes()->count() ?>
                    Views: <?= $latestVideo->getViews()->count() ?>
                </p>
            </div>
        <?php else: ?>
            <div class="card-body">
                You don't have uploaded videos yet.
            </div>
        <?php endif; ?>
    </div>
    <div class="card m-3" style="width: 14rem;">
        <div class="card-body">
            <h6 class="card-title">Total Views</h6>
            <p class="card-text fs-1">
                <?= $numberOfView ?>
            </p>
        </div>
    </div>
    <div class="card m-3" style="width: 14rem;">
        <div class="card-body">
            <h6 class="card-title">Total Subscribers</h6>
            <p class="card-text fs-1">
                <?= $numberOfSubscriber ?>
            </p>
        </div>
    </div>
    <div class="card m-3" style="width: 14rem;">
        <div class="card-body">
            <h6 class="card-title">Latest Subscribers</h6>
            <?php foreach ($subscribers as $subscriber): ?>
                <div>
                    <?= Html::channelLink($subscriber->user, false, true) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
