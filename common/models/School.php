<?php

namespace common\models;

use backend\models\Region;
use Yii;

/**
 * This is the model class for table "school".
 *
 * @property int $id
 * @property int|null $region_id
 * @property string|null $district_title
 * @property string|null $title
 * @property float|null $rayting
 */
class School extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'school';
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
            [['district_title', 'title'], 'string', 'max' => 255],
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
            'district_title' => 'District Title',
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
