<?php
namespace app\models;

use yii\base\Model;

class RegistroForm extends Model
{
    public $username;
    public $password;
    public $usu_nombre;
    public $usu_apellido;
    public $usu_telefono;
    public $usu_sexo;
    public $usu_creacion;
    public $usu_activo;
    public $usu_nacimiento;
    public $usu_peso;

    public function rules()
    {
        return [
            ['username', 'unique'],
            [['username', 'password', 'usu_nombre', 'usu_apellido', 'usu_telefono', 'usu_sexo', 'usu_nacimiento', 'usu_peso'], 'required'],
            [['usu_creacion', 'usu_nacimiento'], 'safe'],
            [['usu_peso'], 'number'],
            [['usu_nombre', 'usu_apellido'], 'string', 'max' => 45],
            [['usu_telefono'], 'string', 'max' => 15],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'usu_nombre' => 'Nombre',
            'usu_apellido' => 'Apellido',
            'usu_telefono' => 'Telefono',
            'usu_sexo' => 'Sexo',
            'usu_nacimiento' => 'Nacimiento',
            'usu_peso' => 'Peso',
            'usu_creacion' => 'Creacion',
        ];
    }
}
