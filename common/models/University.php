<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "university".
 *
 * @property int $id
 * @property string|null $title
 * @property float|null $prof_teach
 * @property float|null $teach_method
 * @property float|null $pupil_smart
 * @property float|null $physical
 * @property float|null $year
 * @property float|null $total
 * @property string|null $expert
 */
class University extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'university';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prof_teach', 'teach_method', 'pupil_smart', 'physical', 'year', 'total'], 'number'],
            [['title', 'expert'], 'string', 'max' => 255],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'prof_teach' => 'Prof Teach',
            'teach_method' => 'Teach Method',
            'pupil_smart' => 'Pupil Smart',
            'physical' => 'Physical',
            'year' => 'Year',
            'total' => 'Total',
            'expert' => 'Expert',
        ];
    }

    public function getExpertName()
    {
        return $this->hasOne(Expert::class, ['id' => 'expert']);
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'expert',
        ];
    }
}
