<?php

namespace app\models;

use yii\base\Model;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $accessToken
 */
class RegForm extends Model
{
    public $username;
    public $password;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'min' => 6, 'max' => 64],
            ['username', 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    public function reg()
    {
        $user = New User();
        $user->username = $this->username;
        $user->status = $this->status;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user: null;
    }
}
