<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "course_time".
 *
 * @property int $id
 * @property int|null $day
 * @property int|null $start_at
 * @property int|null $end_at
 * @property int|null $group_id
 *
 * @property Group $group
 */
class CourseTime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course_time';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day', 'start_at', 'end_at', 'group_id'], 'default', 'value' => null],
            [['day', 'start_at', 'end_at', 'group_id'], 'integer'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['group_id' => 'id']],
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
            'group_id' => 'Group ID',
        ];
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }
}
