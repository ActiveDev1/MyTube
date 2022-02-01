<?php

use common\helpers\Html;
use common\models\Video;
use yii\helpers\Url;

/** @var $model Video */
?>

<div class="card m-3" style="width: 14rem;">
    <a href="<?= Url::to(['/video/view', 'video_id' => $model->video_id]) ?>">
        <div class="ratio ratio-16x9">
            <video src="<?= $model->getVideoLink(); ?>" poster="<?= $model->getThumbnailLink() ?>"
                   style="object-fit: cover"
                   title="<?= $model->title ?>"
            ></video>
        </div>
    </a>
    <div class="card-body p-2">
        <h6 class="card-title m-0"><?= $model->title ?></h6>
        <p class="text-muted card-text m-0">
            <?= Html::channelLink($model->createdBy) ?>
        </p>
        <p class="text-muted card-text m-0">
            <?= $model->getViews()->count() ?> views • <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
        </p>
    </div>
</div>
