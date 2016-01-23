<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Orders;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $form ActiveForm */
?>
<div class="site-Form">

    <?php $form = ActiveForm::begin();
        $model = new Orders;
    ?>

        <?= $form->field($model, 'work_dir') ?>
        <?= $form->field($model, 'link') ?>
        <?= $form->field($model, 'price') ?>
        <?= $form->field($model, 'time_begin') ?>
        <?= $form->field($model, 'time_total') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-Form -->
