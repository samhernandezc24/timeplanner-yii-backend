<?php

namespace app\models;

use Yii;
use webvimark\modules\UserManagement\models\User;

/**
 * This is the model class for table "usuario".
 *
 * @property int $usu_id
 * @property string $usu_nombre
 * @property string $usu_apellido
 * @property string $usu_telefono
 * @property string|null $usu_password
 * @property string|null $usu_historial
 * @property int $usu_sexo
 * @property string|null $usu_foto
 * @property string $usu_creacion
 * @property string|null $usu_actualizacion
 * @property int $usu_activo
 * @property string $usu_nacimiento
 * @property float $usu_peso
 * @property string|null $usu_seguro
 * @property string|null $usu_nss
 * @property int|null $usu_fkuser
 *
 * @property Cita[] $citas
 * @property User $usuFkuser
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usu_nombre', 'usu_apellido', 'usu_telefono', 'usu_sexo', 'usu_creacion', 'usu_nacimiento', 'usu_peso', 'usu_fkuser'], 'required'],
            [['usu_sexo', 'usu_activo', 'usu_fkuser'], 'integer'],
            [['usu_creacion', 'usu_actualizacion', 'usu_nacimiento'], 'safe'],
            [['usu_peso'], 'number'],
            [['usu_nombre', 'usu_apellido'], 'string', 'max' => 45],
            [['usu_telefono'], 'string', 'max' => 15],
            [['usu_password'], 'string', 'max' => 150],
            [['usu_historial', 'usu_foto', 'usu_seguro', 'usu_nss'], 'string', 'max' => 255],
            [['usu_fkuser'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['usu_fkuser' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usu_id' => 'Usu ID',
            'usu_nombre' => 'Usu Nombre',
            'usu_apellido' => 'Usu Apellido',
            'usu_telefono' => 'Usu Telefono',
            'usu_password' => 'Usu Password',
            'usu_historial' => 'Usu Historial',
            'usu_sexo' => 'Usu Sexo',
            'usu_foto' => 'Usu Foto',
            'usu_creacion' => 'Usu Creacion',
            'usu_actualizacion' => 'Usu Actualizacion',
            'usu_activo' => 'Usu Activo',
            'usu_nacimiento' => 'Usu Nacimiento',
            'usu_peso' => 'Usu Peso',
            'usu_seguro' => 'Usu Seguro',
            'usu_nss' => 'Usu Nss',
            'usu_fkuser' => 'Usu Fkuser',
        ];
    }

    /**
     * Gets query for [[Citas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCitas()
    {
        return $this->hasMany(Cita::class, ['cit_fkusuario' => 'usu_id']);
    }

    /**
     * Gets query for [[UsuFkuser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuFkuser()
    {
        return $this->hasOne(User::class, ['id' => 'usu_fkuser']);
    }
}
