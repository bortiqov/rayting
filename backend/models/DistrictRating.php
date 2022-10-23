<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "district_rating".
 *
 * @property int $id
 * @property int|null $region_id
 * @property string|null $title
 * @property float|null $rayting
 */
class DistrictRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'district_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'default', 'value' => null],
            [['region_id'], 'integer'],
            [['rayting'], 'number'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Region ID',
            'title' => 'Title',
            'rayting' => 'Rayting',
        ];
    }


    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    public function extraFields()
    {
        return [
            'region'
        ];
    }
}
