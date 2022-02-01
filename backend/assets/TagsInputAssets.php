<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class TagsInputAssets extends AssetBundle
{
    public $basePath = '@webroot/tagsinput';
    public $baseUrl = '@web/tagsinput';
    public $css = [
        'tagify.css',
    ];
    public $js = [
        'tagify.js'
    ];
    public $depends = [
        JqueryAsset::class,
    ];
}