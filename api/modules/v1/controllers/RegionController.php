<?php

namespace api\modules\v1\controllers;

use backend\models\DistrictRating;
use backend\models\Region;
use common\components\CrudController;
use common\models\Company;
use common\models\search\CompanySearch;
use common\models\University;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class RegionController extends Controller
{

    public function actionIndex()
    {
        $query = Region::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $dataProvider->pagination->pageSize = 100;
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


}