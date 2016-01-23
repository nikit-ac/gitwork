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
 * @property integer $time_total
 * @property integer $active
 */
class Orders1 extends \yii\db\ActiveRecord
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
            [['work_dir', 'link', 'price', 'time_begin', 'time_total', 'active'], 'required'],
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
            'work_dir' => 'Work Dir',
            'link' => 'Link',
            'price' => 'Price',
            'time_begin' => 'Time Begin',
            'time_total' => 'Time Total',
            'active' => 'Active',
        ];
    }
}
