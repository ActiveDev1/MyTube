<?php

use backend\assets\TagsInputAssets;
use common\models\Video;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $dataProvider yii\data\ActiveDataProvider */
TagsInputAssets::register($this);

$this->title = 'Videos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Video', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'content' => function (Video $model) {
                    return $this->render('_video_item', ['model' => $model]);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'status',
                'content' => function (Video $model) {
                    return $model->getStatusLabels()[$model->status];
                },
                'format' => 'raw'
            ],
//            [
//                'attribute' => 'tags',
//                'content' => function ($model) {
//                    return Html::textInput('tag', $model->tags);
//                },
//                'format' => 'raw'
//            ],
            //'has_thumbnail',
            //'video_name',
            //'created_by',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Video $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'video_id' => $model->video_id]);
                }
            ],
        ],
    ]); ?>


</div>
