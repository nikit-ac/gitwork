<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\Button;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;



AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= Html::csrfMetaTags() ?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php

    NavBar::begin(
        [
            'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]
    );
    /*echo Html::a('Прекратить работу', ['/site/stop'], [
        'class'=>'btn btn-sm',
        'style' => 'margin: 10px'
    ]);/**/
//    echo "Ведется работа над заказом".$
   /* echo Button::widget([
        'label' => $,
        'options' => [
            'class' => 'btn btn-sm',
            'style' => 'margin: 10px'
        ],
        'id' => "stop-order "
    ]);*/
    if (Yii::$app->user->isGuest) {
        $itemsMenu [] = ['label' => 'Войти', 'url' => ['/user/login']];
        $itemsMenu [] = ['label' => 'Регистрация', 'url' => ['/user/reg']];
    } else{
        $itemsMenu [] = [
            'label' => 'Выйти (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $itemsMenu
    ]);
    NavBar::end();

    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My ss Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
