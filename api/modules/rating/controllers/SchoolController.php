<?php

namespace api\modules\rating\controllers;

use common\components\ApiController;
use common\models\School;
use common\models\University;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\rest\OptionsAction;

class SchoolController extends ApiController
{

    public function actions()
    {
        return [
            'options' => OptionsAction::class
        ];
    }

    public function actionIndex($year)
    {
        $requestParams = \Yii::$app->request->queryParams;

        $query = School::find()->orderBy(['rayting' => SORT_DESC]);
        $query->andWhere(['year' => $year]);
        if ($requestParams['region_id']) {
            $query->andWhere(['region_id' => $requestParams['region_id']]);
        }

        if ($requestParams['type']) {
            $query->andWhere(['type' => $requestParams['type']]);
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $dataProvider;
    }

}