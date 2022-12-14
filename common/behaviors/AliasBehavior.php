<?php
namespace common\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\validators\UniqueValidator;

/**
 * Class SlugBehavior
 * @package jakharbek\core\behaviors
 */
class AliasBehavior extends AttributeBehavior
{
    /**
     * @var string
     */
    public $attribute = "alias";
    /**
     * @var string
     */
    public $attribute_title = "title";

    /**
     * @var bool
     */
    public $force = false;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT  => 'slugEvent',
        ];
    }


    /**
     * @throws \Exception
     */
    public function slugEvent(){
        if((strlen($this->owner->{$this->attribute}) == 0) || ($this->force)):
            $slug = $this->slug($this->translit($this->owner->{$this->attribute_title}['en']));
//            $slug = $this->slug($this->translit($this->owner->{$this->attribute_title}));
            if ($this->validateSlug($slug))
                $this->owner->{$this->attribute} = $slug;
            else $this->owner->{$this->attribute} = $slug . "-" . rand(0,1000);
        endif;
    }

    protected function validateSlug($slug)
    {
        /* @var $validator UniqueValidator */
        /* @var $model BaseActiveRecord */
        $validator = Yii::createObject(
            [
                'class' => UniqueValidator::className(),
            ]
        );

        $model = clone $this->owner;
        $model->clearErrors();
        $model->{$this->attribute} = $slug;

        $validator->validateAttribute($model, $this->attribute);
        return !$model->hasErrors();
    }

    /**
     * @param $string
     * @param array $replace
     * @param string $delimiter
     * @return mixed|null|string|string[]
     * @throws \Exception
     */
    function slug($string, $replace = array(), $delimiter = '-') {
        $string = $this->translit($string);
        if (!extension_loaded('iconv')) {
            throw new \Exception('iconv module not loaded');
        }
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        if (!empty($replace)) {
            $clean = str_replace((array) $replace, ' ', $clean);
        }
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }


    /**
     * @param $string
     * @return string
     */
    function translit($string){
        $converter = array(
            '??' => 'a',   '??' => 'b',   '??' => 'v',
            '??' => 'g',   '??' => 'd',   '??' => 'e',
            '??' => 'e',   '??' => 'zh',  '??' => 'z',
            '??' => 'i',   '??' => 'y',   '??' => 'k',
            '??' => 'l',   '??' => 'm',   '??' => 'n',
            '??' => 'o',   '??' => 'p',   '??' => 'r',
            '??' => 's',   '??' => 't',   '??' => 'u',
            '??' => 'f',   '??' => 'h',   '??' => 'c',
            '??' => 'ch',  '??' => 'sh',  '??' => 'sch',
            '??' => '\'',  '??' => 'y',   '??' => '\'',
            '??' => 'e',   '??' => 'yu',  '??' => 'ya',

            '??' => 'A',   '??' => 'B',   '??' => 'V',
            '??' => 'G',   '??' => 'D',   '??' => 'E',
            '??' => 'E',   '??' => 'J',  '??' => 'Z',
            '??' => 'I',   '??' => 'Y',   '??' => 'K',
            '??' => 'L',   '??' => 'M',   '??' => 'N',
            '??' => 'O',   '??' => 'P',   '??' => 'R',
            '??' => 'S',   '??' => 'T',   '??' => 'U',
            '??' => 'F',   '??' => 'H',   '??' => 'C',
            '??' => 'Ch',  '??' => 'Sh',  '??' => 'Sh',
            '??' => '\'',  '??' => 'Y',   '??' => '\'',
            '??' => 'E',   '??' => 'Yu',  '??' => 'Ya',
        );
        return strtr($string, $converter);
    }
}