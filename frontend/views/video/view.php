<?php

/* @var $this yii\web\View */

/* @var $model common\models\Video */
/* @var $comments common\models\Comment[] */

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
        <div class="comments mt-5">
            <h4 class="mb-3"><span id="comment-count"><?= count($comments) ?></span> Comments</h4>
            <div class="create-comment mb-3">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img class="mr-3 comment-avatar" src="/img/avatar-default.svg" alt="avatar">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <form id="create-comment-form" method="post"
                              action="<?= \yii\helpers\Url::to(['comment/create', 'video_id' => $model->video_id]) ?>">
                            <input type="hidden" name="video_id" value="<?= $model->video_id ?>">
                            <textarea id="leave-comment"
                                      class="form-control"
                                      name="comment"
                                      rows="1"
                                      placeholder="Add a public comment"></textarea>
                            <div class="action-buttons text-end mt-2">
                                <button type="button" id="cancel-comment" class="btn btn-light">Cancel</button>
                                <button class="btn btn-primary">Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="comments-wrapper">
                <?php foreach ($comments as $comment) {
                    echo $this->render('_comment_item', ['model' => $comment]);
                } ?>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <?php foreach ($similarVideos as $similarVideo): ?>
            <div class="d-flex align-items-center mb-3">
                <a class="ratio ratio-16x9 flex-shrink-0" style=" width: 8.5rem"
                   href="<?= \yii\helpers\Url::to(['/video/view']) ?>">
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
