<?php

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-md navbar-light bg-light shadow-sm',
    ],
    'collapseOptions' => [
        'class' => 'justify-content-end',
    ],
]);

$menuItems = [];

if (Yii::$app->user->isGuest) {
    $menuItems = [
        ['label' => 'Signup', 'url' => ['/site/signup']],
        ['label' => 'Login', 'url' => ['/site/login']]
    ];
} else {
    $menuItems[] = [
        'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
        'url' => ['/site/logout'],
        'options' => ['class' => 'ms-md-auto'],
        'linkOptions' => [
            'data-method' => 'post'
        ]
    ];
}
?>

    <form action="<?= \yii\helpers\Url::to(['video/search']) ?>" class="d-flex me-auto">
        <input class="form-control me-2" type="search" placeholder="Search" name="keyword"
               value="<?= Yii::$app->request->get('keyword') ?>">
        <button class="btn btn-outline-success">Search</button>
    </form>

<?php
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => $menuItems,
]);
NavBar::end();
