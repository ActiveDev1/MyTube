<?php

/* @var $this yii\web\View */

/* @var $model common\models\Video */

/* @var $similarVideos common\models\Video[] */

use yii\helpers\Html;

?>
<div class="row">
    <div class="col-sm-8">
        <div class="ratio ratio-16x9">
            <video src="<?= $model->getVideoLink(); ?>" poster="<?= $model->getThumbnailLink() ?>"
                   style="object-fit: cover"
                   title="<?= $model->title ?>"
                   controls></video>
        </div>
        <h6 class="mt-2"> <?= $model->title ?></h6>
        <div class="d-flex justify-content-between align-items-center">
            <div><?= $model->getViews()->count() ?> views
                • <?= Yii::$app->formatter->asDate($model->created_at) ?></div>
            <div>
                <?php \yii\widgets\Pjax::begin() ?>
                <?= $this->render('_buttons', [
                    'model' => $model
                ]) ?>
                <?php \yii\widgets\Pjax::end() ?>
            </div>
        </div>
        <div>
            <p> <?= \common\helpers\Html::channelLink($model->createdBy) ?> </p>
            <p> <?= Html::encode($model->description) ?> </p>
        </div>
    </div>

    <div class="col-sm-4">
        <?php foreach ($similarVideos as $similarVideo): ?>
            <div class="d-flex align-items-center mb-2">
                <a class="ratio ratio-16x9 flex-shrink-0" style=" width: 8.5rem"
                   href="<?= \yii\helpers\Url::to(['/video/view', 'video_id' => $similarVideo->video_id]) ?>">
                    <video src="<?= $similarVideo->getVideoLink(); ?>"
                           poster="<?= $similarVideo->getThumbnailLink() ?>"
                           style="object-fit: cover"
                           title="<?= $similarVideo->title ?>"
                    ></video>
                </a>
                <div class="flex-grow-1 p-2">
                    <h6 class="m-0"><?= $similarVideo->title ?></h6>
                    <small class="text-muted">
                        <?= \common\helpers\Html::channelLink($similarVideo->createdBy) ?>
                    </small>
                    <br>
                    <small class="text-muted">
                        <?= $similarVideo->getViews()->count() ?> views
                        • <?= Yii::$app->formatter->asRelativeTime($similarVideo->created_at) ?>
                    </small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
