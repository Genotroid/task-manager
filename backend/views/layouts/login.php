<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;

AppAsset::register($this);

if (class_exists('deyraka\materialdashboard\web\MaterialDashboardAsset')) {
    deyraka\materialdashboard\web\MaterialDashboardAsset::register($this);
};

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/deyraka/yii2-material-dashboard/assets/');
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= Yii::$app->name ?> | Авторизация</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body class="login-page">
    <?php $this->beginBody() ?>

    <div class="login-box">
        <?= $content ?>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
