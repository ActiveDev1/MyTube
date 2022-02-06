<?php

/** @var $model Comment */


use common\helpers\Html;
use common\models\Comment;
use yii\helpers\Url;

$subCommentCount = $model->getComments()->count();
?>

<div class="flex-fill mb-3 comment-item position-relative" data-id="<?= $model->id ?>">
    <div class="d-flex media-comment">
        <div class="flex-shrink-0">
            <img class="mr-3 comment-avatar" src="/img/avatar-default.svg" alt="avatar">
        </div>
        <div class="flex-grow-1 ms-3">
            <h6>
                <?php if ($model->pinned): ?>
                    <small class="pinned-text text-muted mb-1">
                        <i class="bi-pin-fill"></i> Pinned comment
                    </small> <br>
                <?php endif ?>
                <?= Html::channelLink($model->createdBy) ?>
                <small class="comment-time text-muted">
                    <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
                    <?php if ($model->created_at != $model->updated_at): ?>
                        (edited)
                    <?php endif; ?>
                </small>
            </h6>
            <div class="comment-text">
                <div class="text-wrapper">
                    <?= $model->comment ?>

                </div>
                <div class="my-2 bottom-actions">
                    <button data-action="<?= Url::to(['comment/reply']) ?>"
                            class="btn btn-sm btn-light btn-reply">
                        REPLY
                    </button>
                </div>

                <div class="reply-section"></div>

                <?php if ($subCommentCount): ?>
                    <div class="mb-2">
                        <a class="view-sub-comments"
                           href="<?= Url::to(['comment/by-parent', 'id' => $model->id]) ?>">View <?= $subCommentCount ?>
                            replies</a>
                    </div>
                <?php endif ?>

                <div class="sub-comments">

                </div>
            </div>

            <?php if ($model->belongsTo(Yii::$app->user->id) || $model->video->belongsTo(Yii::$app->user->id)): ?>
                <div class="dropdown comment-actions">
                    <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown"></i>
                    <ul class="dropdown-menu dropdown-menu-left">
                        <?php if (!$model->parent_id && $model->video->belongsTo(Yii::$app->user->id)): ?>
                            <li>
                                <a class="dropdown-item item-pin-comment"
                                   data-pinned="<?= $model->pinned ?>"
                                   href="<?= Url::to(['comment/pin', 'id' => $model->id]) ?>">
                                    <i class="bi bi-pin-angle-fill"></i>
                                    <?php if ($model->pinned): ?>
                                        Unpin
                                    <?php else: ?>
                                        Pin
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($model->belongsTo(Yii::$app->user->id)): ?>
                            <li>
                                <a class="dropdown-item item-edit-comment"
                                   href="#">
                                    <i class="bi bi-pencil-square"></i> Edit</a>
                            </li>
                        <?php endif; ?>

                        <li>
                            <a class="dropdown-item item-delete-comment"
                               href="<?= Url::to(['comment/delete', 'id' => $model->id]) ?>">
                                <i class="bi bi-trash-fill"></i> Delete</a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="media-input">
        <div class="flex-shrink-0">
            <img class="mr-3 comment-avatar" src="/img/avatar-default.svg" alt="avatar">
        </div>
        <div class="flex-grow-1 ms-3">
            <form class="comment-edit-section" method="post"
                  action="<?= Url::to(['/comment/update', 'id' => $model->id]) ?>">
            <textarea rows="1"
                      class="form-control"
                      name="comment"
                      placeholder="Add a public comment"></textarea>
                <div class="action-buttons text-end mt-2">
                    <button type="button" class="btn btn-light btn-cancel">Cancel</button>
                    <button class="btn btn-primary btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
