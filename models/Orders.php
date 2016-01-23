<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property string $ID
 * @property string $work_dir
 * @property string $link
 * @property integer $price
 * @property string $time_begin
 * @property string $time_total
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_dir', 'price',], 'required'],
            [['price', 'time_total', 'active'], 'integer'],
            [['time_begin'], 'safe'],
            [['work_dir'], 'string', 'max' => 32],
            [['link'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'work_dir' => 'Папка',
            'link' => 'Ссылка',
            'price' => 'Цена',
            'time_begin' => 'Время начала',
            'time_total' => 'Время работы',
        ];
    }
}
