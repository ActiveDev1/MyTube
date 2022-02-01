<?php

use common\models\User;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider ActiveDataProvider */
/* @var $channel User */
?>

<div class="p-4 mb-4 bg-light rounded-3">
    <h1 class="display-4"><?= $channel->username ?></h1>
    <hr class="my-4">
    <?php Pjax::begin() ?>
    <?= $this->render('_subscribe', ['channel' => $channel]) ?>
    <?php Pjax::end() ?>
</div>

<?php echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '@frontend/views/video/_video_item',
    'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}',
    'itemOptions' => [
        'tag' => false
    ]
])

?>
