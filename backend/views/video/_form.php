<?php

use backend\assets\TagsInputAssets;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\bootstrap5\ActiveForm */
TagsInputAssets::register($this)
?>

<div class="video-form">

    <?php $form = ActiveForm::begin() ?>

    <div class="row">
        <div class="col-sm-8">

            <?= $form->errorSummary($model) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'thumbnail')->fileInput(['accept' => 'image/jpeg']) ?>

            <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-sm-4">

            <div class="ratio ratio-16x9 mb-3">
                <video src="<?= $model->getVideoLink(); ?>" poster="<?= $model->getThumbnailLink() ?>"
                       style="object-fit: cover"
                       title="<?= $model->title ?>"
                       controls></video>
            </div>

            <div class="mb-3">
                <div class="text-muted">Video Link</div>
                <a href="<?= $model->getVideoLink(); ?>">Open video</a>
            </div>


            <div class="mb-3">
                <div class="text-muted">Video Name</div>
                <?= $model->video_name ?>
            </div>

            <?= $form->field($model, 'status')->dropDownList($model->getStatusLabels()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
