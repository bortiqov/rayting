<?php

namespace api\modules\v1\controllers;

use common\components\CrudController;
use common\models\Company;
use common\models\search\CompanySearch;
use common\models\University;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class UniversityController extends Controller
{

    public function actionIndex($year)
    {
        $query = University::find()->andWhere(['year' => $year]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

//       qvar_dump(Yii::$app->request->post(),$_FILES);
//        die();
        $dataProvider->pagination->pageSize = 100;
        return $dataProvider;
    }

}