<?php

namespace common\behaviors;

use common\modules\product\models\Category;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class ModelBehavior
 * @package common\modules\service\behaviors
 */
class SelectBehavior extends AttributeBehavior
{
    /**
     * @var string
     */
    public $attribute = "categories";

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT  => 'save',
            ActiveRecord::EVENT_BEFORE_UPDATE  => 'save',
            ActiveRecord::EVENT_AFTER_FIND  => 'getData'
        ];
    }

    /**
     *
     */
    public function save()
    {
        if(!$this->owner->isNewRecord) {
            $this->unlink();
        }

        $this->link();
    }

    /**
     * @return bool
     */
    private function unlink()
    {
        $services = $this->owner->categories;

        if(count($services) == 0){
            return false;
        }

        foreach ($services as $service) {
            $this->owner->unlink('categories', $service, true);
        }
    }

    /**
     * @return bool
     */
    private function link()
    {
        $ids = $this->owner->{$this->attribute};

        if(empty($ids)){
            return false;
        }

        $category = Category::find()->where(['id' => $ids])->all();

        if(!$category){
            return false;
        }

        foreach($category as $service) {
            $this->owner->link('categories', $service);
        }
    }
    public function getData() {

        $this->owner->{$this->attribute} =  ArrayHelper::getColumn($this->owner->categories, 'id');

    }

//    public function getData()
//    {
//        $this->owner->{$this->attribute} = implode(",", ArrayHelper::getColumn($this->owner->categories, 'id'));
//    }
}
