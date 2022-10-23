<?php

namespace api\modules\v1\controllers;

use backend\models\Region;
use common\components\ApiController;
use common\components\CrudController;
use common\models\Company;
use common\models\search\CompanySearch;
use common\models\University;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\rest\OptionsAction;
use yii\rest\Serializer;

class UniversityController extends ApiController
{
    public $modelClass = University::class;
    public $searchModel = University::class;

    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
            ]
        ];
    }

//    public $serializer = [
//        'class' => 'yii\rest\MySerializer',
//        'collectionEnvelope' => 'items',
//    ];

    public function actionIndex($year)
    {
        $query = University::find()->andWhere(['year' => $year]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

//       qvar_dump(Yii::$app->request->post(),$_FILES);
//        die();
//        $dataProvider->pagination->pageSize = 100;
        return $dataProvider;
    }

}