<?php

namespace api\modules\v1\controllers;

use backend\models\DistrictRating;
use backend\models\Region;
use common\components\ApiController;
use yii\data\ActiveDataProvider;
use yii\rest\OptionsAction;

class RegionController extends ApiController
{

    public $modelClass = Region::class;
    public $searchModel = Region::class;

    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
            ]
        ];
    }

    public function actionIndex()
    {
        $query = Region::find();

        $query->orderBy(['title' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $dataProvider;
    }

    public function actionDistrict($id)
    {
        $query = DistrictRating::find()->andWhere(['region_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

//        var_dump(Yii::$app->request->post(),$_FILES);
//        die();
        $dataProvider->pagination->pageSize = 100;

        return $dataProvider;

    }


    public function actionDistrictList()
    {
        $query = DistrictRating::find();
        $query->orderBy(['rating' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $requestParams = \Yii::$app->request->queryParams;
        if ($requestParams['region_id']) {
            $query->andWhere(['region_id' => $requestParams['region_id']]);
        }


        return $dataProvider;
    }


}