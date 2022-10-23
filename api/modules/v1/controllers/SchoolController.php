<?php

namespace api\modules\v1\controllers;

use common\components\CrudController;
use common\models\Company;
use common\models\School;
use common\models\search\CompanySearch;
use common\models\University;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\rest\OptionsAction;

class SchoolController extends Controller
{

    public function actions()
    {
        return [
            'options' => OptionsAction::class
        ];
    }

    public function actionIndex()
    {
        $requestParams = \Yii::$app->request->queryParams;

        $query = School::find()->orderBy(['rayting' => SORT_DESC]);

        if ($requestParams['region_id']) {
            $query->andWhere(['region_id' => $requestParams['region_id']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $dataProvider->pagination->pageSize = 100;
        return $dataProvider;
    }

}