<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "working_time".
 *
 * @property int $id
 * @property int|null $day
 * @property int|null $start_at
 * @property int|null $end_at
 * @property int|null $employee_id
 */
class WorkingTime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'working_time';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day', 'start_at', 'end_at', 'employee_id'], 'default', 'value' => null],
            [['day', 'start_at', 'end_at', 'employee_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day' => 'Day',
            'start_at' => 'Start At',
            'end_at' => 'End At',
            'employee_id' => 'Employee ID',
        ];
    }
}
