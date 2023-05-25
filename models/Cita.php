<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cita".
 *
 * @property int $cit_id
 * @property string $cit_asunto
 * @property string $cit_fecha
 * @property string $cit_doctor
 * @property string $cit_numdoctor
 * @property int $cit_fkusuario
 *
 * @property Usuario $citFkusuario
 * @property Medicamento[] $medicamentos
 */
class Cita extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cita';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cit_asunto', 'cit_fecha', 'cit_doctor', 'cit_numdoctor', 'cit_fkusuario'], 'required'],
            [['cit_fecha'], 'safe'],
            [['cit_fkusuario'], 'integer'],
            [['cit_asunto'], 'string', 'max' => 255],
            [['cit_doctor'], 'string', 'max' => 100],
            [['cit_numdoctor'], 'string', 'max' => 45],
            [['cit_fkusuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['cit_fkusuario' => 'usu_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cit_id' => 'Cit ID',
            'cit_asunto' => 'Cit Asunto',
            'cit_fecha' => 'Cit Fecha',
            'cit_doctor' => 'Cit Doctor',
            'cit_numdoctor' => 'Cit Numdoctor',
            'cit_fkusuario' => 'Cit Fkusuario',
        ];
    }

    /**
     * Gets query for [[CitFkusuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCitFkusuario()
    {
        return $this->hasOne(Usuario::class, ['usu_id' => 'cit_fkusuario']);
    }

    /**
     * Gets query for [[Medicamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedicamentos()
    {
        return $this->hasMany(Medicamento::class, ['med_fkcita' => 'cit_id']);
    }
}
