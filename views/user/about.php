<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'about '.$user;
// $this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::tag('h2', 'This page about'.$user)?>
<div class="row">
    <div class='col-md-6'>
        <?= Html::img('@web/images/'.$imgfile, ['alt' => 'Userpic' ]) ?>
    </div>
    <div class="about col-md-6">
        <?=
          Html::tag('b', 'Name: ');
          echo $user;
        ?>
        <br>
        <?= Html::tag('b', 'About me: ');?>
        <br>
        <?= Html::tag('p', $info);?>

    </div>
</div>
