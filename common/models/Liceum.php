<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "liceum".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $year
 * @property float|null $rating
 */
class Liceum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'liceum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'default', 'value' => null],
            [['year'], 'integer'],
            [['rating'], 'number'],
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
            'title' => 'Title',
            'year' => 'Year',
            'rating' => 'Rating',
        ];
    }
}
