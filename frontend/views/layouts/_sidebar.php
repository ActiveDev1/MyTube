<?php use yii\bootstrap5\Nav;

?>

<aside class="shadow-sm">
    <?php echo Nav::widget([
        'options' => [
            'class' => 'd-flex flex-column nav-pills'
        ],
        'encodeLabels' => false, // if false icons will display
        'items' => [
            [
                'label' => '<i class="bi bi-house"></i> Home',
                'url' => ['/video/index']
            ],
            [
                'label' => '<i class="bi bi-clock-history"></i> History',
                'url' => ['/video/history']
            ]
        ]
    ]) ?>
</aside>