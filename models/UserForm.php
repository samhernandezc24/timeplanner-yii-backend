<?php
namespace app\models;

use yii\base\Model;

class UserForm extends Model
{
    public $username;    

    public function rules()
    {
        return [            
            [['username'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
        ];
    }
}
