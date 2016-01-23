<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\widgets\Pjax;
    use app\models\Orders;
    use yii\grid\GridView;

    $this->title = 'Система учета времени работы над проектами';
?>
<div class="site-index">
    <div class="row">
        <h3>Добавить новый заказ</h3>
        <div class="site-Form col-md-9">
            <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['site/addnew'],
                ]);
            $model = new Orders;
            ?>
            <?= $form->field($model, 'work_dir') ?>
            <?= $form->field($model, 'link') ?>
            <?= $form->field($model, 'price') ?>
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?php Pjax::begin(); ?>
    <p id='text-info'> св <?php $tim ?> </p>
    <?php Pjax::end(); ?>

        <?php
        if (!isset($_GET['resultAdd'])) {
            $_GET['resultAdd'] = NULL;
            echo "<p>";
        }

           // echo $_GET['resultAdd'];
            if ($_GET['resultAdd'] == 1) {
                echo "<p class='text-success'>";
                echo 'Можно продолжать работу';
            } elseif ($_GET['resultAdd'] == 2) {
                echo "<p class='text-danger'>";
                echo "Ошибка. Вы уже работаете над другим заказом";
            } elseif ($_GET['resultAdd'] == 3) {
                echo "<p class='text-success'>";
                echo "Заказ добавлен. Работа начата";
            }
        ?>
    </p>
    <div class="body-content">
        <div class="row">
            <h3>Последние работы</h3>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-condensed table-striped table-bordered'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'ID',
                    'work_dir',
                    'link',
                    'price',
                    'time_begin',
                    'time_total',

                    ['class' => 'yii\grid\ActionColumn',
                        'header'=>'Продолжить',
                        'template' => '{edit}',
                        'buttons' => [
                            'edit' => function ($url,$model,$key) {
                                return Html::a(
                                'Edit',
                                ['site/edit', 'id' => $model->ID],
                                ['class' => 'btn btn-success']);
                            },
                        ],
                    ]


                ]
            ]); ?>










        </div>
    </div>
</div>
