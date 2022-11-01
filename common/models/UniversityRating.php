<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "university_rating".
 *
 * @property int $id
 * @property int|null $university_id
 * @property float|null $prof_teach
 * @property float|null $teach_method
 * @property float|null $pupil_smart
 * @property float|null $physical
 * @property float|null $total
 * @property int|null $year
 * @property int|null $expert
 *
 * @property University $university
 */
class UniversityRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'university_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['university_id', 'year', 'expert'], 'default', 'value' => null],
            [['university_id', 'year', 'expert'], 'integer'],
            [['prof_teach', 'teach_method', 'pupil_smart', 'physical', 'total'], 'number'],
            [['university_id'], 'exist', 'skipOnError' => true, 'targetClass' => University::className(), 'targetAttribute' => ['university_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'university_id' => 'University ID',
            'prof_teach' => 'Prof Teach',
            'teach_method' => 'Teach Method',
            'pupil_smart' => 'Pupil Smart',
            'physical' => 'Physical',
            'total' => 'Total',
            'year' => 'Year',
            'expert' => 'Expert',
        ];
    }

    /**
     * Gets query for [[University]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['id' => 'university_id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        return array_merge($fields, [
            'title' => function ($model) {
                return $model->university->title;
            },
            'number' => function ($model) {
                return static::find()->andWhere(['<', 'id', $model->id])
                        ->andWhere(['year' => $model->year])->count() + 1;
            }

        ]);
    }

    public function extraFields()
    {
        return [
            'university'
        ];
    }
}
