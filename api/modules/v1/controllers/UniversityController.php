<?php

namespace api\modules\v1\controllers;

use backend\models\Region;
use common\components\ApiController;
use common\components\CrudController;
use common\models\Company;
use common\models\search\CompanySearch;
use common\models\University;
use common\models\UniversityRating;
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
        $requestParams = \Yii::$app->request->queryParams['filter'];
        $query = UniversityRating::find()->andWhere(['university_rating.year' => $year]);
        if ($requestParams['type']) {
            $query->leftJoin('university', 'university_rating.university_id=university.id')
                ->andWhere(['university.expert' => $requestParams['type']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

//       qvar_dump(Yii::$app->request->post(),$_FILES);
//        die();
        $dataProvider->pagination->pageSize = 100;
        return $dataProvider;
    }

    public function action()
    {

    }

}