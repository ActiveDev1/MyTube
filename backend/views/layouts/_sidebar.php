<?php use yii\bootstrap5\Nav;

?>

<aside class="shadow-sm">
    <?php echo Nav::widget([
        'options' => [
            'class' => 'd-flex flex-column nav-pills'
        ],
        'encodeLabels' => false,
        'items' => [
            [
                'label' => '<i class="bi bi-speedometer2"></i> Dashboard',
                'url' => ['/site/index']
            ],
            [
                'label' => '<i class="bi bi-camera-video"></i> Videos',
                'url' => ['/video/index']
            ]
        ]
    ]) ?>
</aside>