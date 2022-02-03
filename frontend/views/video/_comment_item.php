<?php

/** @var $model Comment */


use common\helpers\Html;
use common\models\Comment;
use yii\helpers\Url;

?>

<div class="d-flex mb-3 comment-item">
    <div class="flex-shrink-0">
        <img class="mr-3 comment-avatar" src="/img/avatar-default.svg" alt="avatar">
    </div>
    <div class="flex-grow-1 ms-3">
        <h6>
            <?= Html::channelLink($model->createdBy) ?>
            <small class="text-muted">
                <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
            </small>
        </h6>
        <div class="d-flex justify-content-between align-items-baseline">
            <div class="comment-text">
                <?= $model->comment ?>
            </div>

           
            <?php if ($model->belongsTo(Yii::$app->user->id) || $model->video->belongsTo(Yii::$app->user->id)): ?>
                <div class="dropdown comment-actions">
                    <button class="btn" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-left">

                        <?php if (Yii::$app->user->id == $model->video->belongsTo(Yii::$app->user->id)): ?>
                            <li><a class="dropdown-item item-pin-action"
                                   href="<?= Url::to(['comment/pin', 'id' => $model->id]) ?>">
                                    <i class="bi bi-pin-angle-fill"></i> Pin</a></li>
                        <?php endif; ?>

                        <?php if ($model->belongsTo(Yii::$app->user->id)): ?>
                            <li><a class="dropdown-item item-edit-action"
                                   href="<?= Url::to(['comment/edit', 'id' => $model->id]) ?>">
                                    <i class="bi bi-pencil-square"></i> Edit</a></li>

                        <?php endif; ?>
                        <li><a class="dropdown-item item-delete-action"
                               href="<?= Url::to(['comment/delete', 'id' => $model->id]) ?>">
                                <i class="bi bi-trash-fill"></i> Delete</a></li>

                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div class="mt-2">
            <button class="btn btn-sm btn-light">REPLY</button>
        </div>
    </div>
</div>