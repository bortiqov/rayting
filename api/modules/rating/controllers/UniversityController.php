<?php

namespace api\modules\rating\controllers;

use backend\models\Region;
use common\components\ApiController;
use common\components\CrudController;
use common\models\Company;
use common\models\search\CompanySearch;
use common\models\University;
use common\models\UniversityRating;
use SebastianBergmann\ObjectReflector\TestFixture\ChildClass;
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

        $query->leftJoin('university_rating ur', 'university.id=ur.university_id')
            ->andWhere(['ur.year' => $year]);
        $query->orderBy(['ur.total' => SORT_DESC]);
        if ($requestParams['type']) {
            $query->andWhere(['university.expert' => $requestParams['type']]);
        }

//        $query->groupBy(['university.id']);

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