<?php

use common\models\Video;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/** @var $model Video */
?>


<div class="d-flex">
    <a href="<?= Url::to(['/video/update', 'video_id' => $model->video_id]) ?>">
        <div class="flex-shrink-0">
            <video src="<?= $model->getVideoLink(); ?>" poster="<?= $model->getThumbnailLink(); ?>"
                   class="ratio-16x9 ratio" style="width: 120px"
            >
        </div>
    </a>

    <div class="flex-grow-1 ms-2">
        <h6><?= $model->title ?></h6>
        <?= StringHelper::truncateWords($model->description, 10) ?>
    </div>
</div>

