<?php

namespace common\behaviors;

use common\modules\product\models\Category;
use common\modules\product\models\PriceChange;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class ModelBehavior
 * @package common\modules\service\behaviors
 */
class PriceChangeBehavior extends AttributeBehavior
{
    /**
     * @var string
     */
    public $attributes = [];
    public $old_attributes = [];

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE  => 'save',
        ];
    }

    /**
     *
     */
    public function save()
    {

        $this->old_attributes = $this->owner->oldAttributes;
        $this->attributes = $this->owner->attributes;


        $priceChange = new PriceChange([
            'old_value' => "".$this->old_attributes['sell_price'],
            'new_value' => "".$this->attributes['sell_price'],
            'product_variation_id' => $this->old_attributes['product_variation_id'],
            'waybill_id' => $this->old_attributes['waybill_id']
        ]);
        $priceChange->save();
    }

}
