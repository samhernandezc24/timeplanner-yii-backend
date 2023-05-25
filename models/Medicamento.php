<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medicamento".
 *
 * @property int $med_id
 * @property int $med_tipo
 * @property string $med_nombre
 * @property string $med_dosis
 * @property string $med_horario
 * @property string|null $med_nota
 * @property string $med_duracion
 * @property int $med_fkcita
 *
 * @property Cita $medFkcita
 */
class Medicamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medicamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['med_tipo', 'med_nombre', 'med_dosis', 'med_horario', 'med_duracion', 'med_fkcita'], 'required'],
            [['med_tipo', 'med_fkcita'], 'integer'],
            [['med_duracion'], 'safe'],
            [['med_nombre', 'med_horario'], 'string', 'max' => 100],
            [['med_dosis'], 'string', 'max' => 150],
            [['med_nota'], 'string', 'max' => 255],
            [['med_fkcita'], 'exist', 'skipOnError' => true, 'targetClass' => Cita::class, 'targetAttribute' => ['med_fkcita' => 'cit_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'med_id' => 'Med ID',
            'med_tipo' => 'Med Tipo',
            'med_nombre' => 'Med Nombre',
            'med_dosis' => 'Med Dosis',
            'med_horario' => 'Med Horario',
            'med_nota' => 'Med Nota',
            'med_duracion' => 'Med Duracion',
            'med_fkcita' => 'Med Fkcita',
        ];
    }

    /**
     * Gets query for [[MedFkcita]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedFkcita()
    {
        return $this->hasOne(Cita::class, ['cit_id' => 'med_fkcita']);
    }
}
