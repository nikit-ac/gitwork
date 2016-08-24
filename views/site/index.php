<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Button;
use app\models\Orders;
use yii\grid\GridView;
$this->registerJsFile('js/site-index.js', ['depends' => \yii\web\JqueryAsset::className()]);
$this->title = 'Система учета времени работы над проектами';
?>
<div class="site-index">
    <div class="row">
        <div class="site-Form col-md-4" id="new-order">
            <h3>Добавить новый заказ</h3>
            <?php
            Pjax::begin();
            $form = ActiveForm::begin([
                'method' => 'post',
                'action' => ['site/add'],
                'options' => ['data-pjax' => true]
            ]);
            $model = new Orders;
            ?>
            <?= $form->field($model, 'work_dir') ?>
            <?= $form->field($model, 'link') ?>
            <?= $form->field($model, 'price') ?>
            <div class="form-group">
                <?= Html::submitButton('Начать работу', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php
            ActiveForm::end();
            Pjax::end();
            ?>
            <div id="stop_div" <?php if (!$activeOrder) echo "hidden"; ?> >
                Ведется работа над заказом <?= $activeOrder ?>
                <?php             Pjax::begin();

                echo Button::widget([
                    'label' => 'Прекратить работу',
                    'options' => [
                        'class' => 'btn btn-sm'
                    ],
                    'id' => 'stop_btn'
                ]);
                Pjax::end();

                ?>
            </div>
        </div>
        <div class="col-md-8" id="last-works">
            <h3>Последние работы</h3>
            <?php             Pjax::begin();?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'data-pjax' => true,
                    'class' => 'table table-condensed table-striped table-bordered'
                ],
                'columns' => [
//                    ['class' => 'yii\grid\SerialColumn'],
        
                        ],
                    ],
                    'link',
                    'price',
                    'time_begin',
                    'time_total',
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Продолжить',
                        'template' => '{edit}',
                        'buttons' => [
                            'edit' => function ($url, $model, $key) {
                                return Html::a(
                                    'Edit',
                                    ['site/edit', 'id' => $model->ID],
                                    ['class' => 'btn btn-success']);
                            },
                        ],
                    ]
                ]
            ]);
            Pjax::end();
            ?>


        </div>
    </div>
</div>
