<?php

namespace common\models;

use common\behaviors\DateTimeBehavior;
use common\modules\file\models\File;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $start_date
 * @property int|null $status
 * @property int|null $price
 * @property int|null $logo_id
 * @property string|null $description
 *
 * @property Group[] $groups
 * @property File $logo
 */
class Course extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_InACTIVE = 2;
    const STATUS_DELETE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course';
    }

    public function behaviors()
    {
        return [
            'start_date' => [
                'class' => DateTimeBehavior::class,
                'attribute' => 'start_date',
                'format' => 'd.m.Y'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_date', 'status', 'price', 'logo_id'], 'default', 'value' => null],
            [['start_date', 'status', 'price', 'logo_id'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
            [['logo_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['logo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'start_date' => 'Start Date',
            'status' => 'Status',
            'price' => 'Price',
            'logo_id' => 'Logo ID',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Groups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Logo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogo()
    {
        return $this->hasOne(File::className(), ['id' => 'logo_id']);
    }

    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_InACTIVE => 'InActive',
            self::STATUS_DELETE => 'Delete',
        ];
    }
}
