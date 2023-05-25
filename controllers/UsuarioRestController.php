<?php

namespace app\controllers;

use Yii;
use app\models\RegistroForm;
use app\models\UserForm;
use app\models\Usuario;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\models\forms\LoginForm;

class UsuarioRestController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin'                        => ['http://localhost:8100', 'http://localhost'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 600, // Cache (seconds)
            ],
        ];
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],
            'except' => ['login', 'registrar'],
        ];
        return $behaviors;
    }    

    public $modelClass = 'app\models\Usuario';

    public $enableCsrfValidation = false;

    public function actionLogin() 
    {
        $token = '';
        $model = new LoginForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        // Autenticar al usuario por teléfono en lugar del nombre de usuario
        if ($model->login()) {
            $token = User::findOne(['username' => $model->username])->auth_key;           
        }
        return $token;
    }

    public function actionRegistrar() 
    {
        $token = '';
        $model = new RegistroForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        $user                   = new User();
        $usuario                = new Usuario();
        $user->username         = $model->username;
        $user->password         = $model->password;
        $user->status           = User::STATUS_ACTIVE;
        $user->email_confirmed  = 1;

        if ($user->save()) {
            $usuario->usu_nombre        = $model->usu_nombre;
            $usuario->usu_apellido      = $model->usu_apellido;
            $usuario->usu_telefono      = $model->username;
            $usuario->usu_sexo          = $model->usu_sexo;
            $usuario->usu_creacion      = date('Y-m-d H:i:s');
            $usuario->usu_activo        = 1;
            $usuario->usu_nacimiento    = $model->usu_nacimiento;
            $usuario->usu_peso          = $model->usu_peso;
            $usuario->usu_fkuser        = $user->id;

            if ($usuario->save()) {
                return $token = $user->auth_key;
            } else {
                return $usuario;
            }
        } else {
            return $user;
        }

        return $token;
    }

    public function actionUser() {
        $model = new UserForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $usuario = Usuario::find()->joinWith(['usuFkuser'])->where(['username' => $model->username])->one();
        
        return $usuario;
    }
}