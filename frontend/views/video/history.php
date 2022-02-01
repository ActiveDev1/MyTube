<?php
/* @var $this yii\web\View */

/* @var $dataProvider ActiveDataProvider */

use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

?>
<h1>My History</h1>
<?php echo ListView::widget([
    'dataProvider' => $dataProvider,
    'pager' => [
        'class' => LinkPager::class
    ],
    'itemView' => '_video_item',
    'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}',
    'itemOptions' => [
        'tag' => false
    ]

])

?>
