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

$menuItems = [
    ['label' => 'Create', 'url' => ['/video/create']],
];

if (Yii::$app->user->isGuest) {
    $menuItems = [
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
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => $menuItems,
]);
NavBar::end();

?>