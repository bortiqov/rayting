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
use yii\web\NotFoundHttpException;

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
        $requestParams = \Yii::$app->request->queryParams;
        $query = University::find();
        if ($requestParams['type']) {
            $query->leftJoin('university', 'university_rating.university_id=university.id')
                ->andWhere(['university.expert' => $requestParams['type']]);
        }

        $query->leftJoin('university_rating ur', 'university.id=ur.university_id')
            ->andWhere(['ur.year' => $year])->orderBy(['ur.rating' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $dataProvider;
    }

    public function actionView($id)
    {
        $model = University::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }
        return $model;
    }

}