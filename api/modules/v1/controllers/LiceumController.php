<?php

namespace api\modules\v1\controllers;

use common\components\CrudController;
use common\models\Company;
use common\models\Liceum;
use common\models\School;
use common\models\search\CompanySearch;
use common\models\University;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class LiceumController extends Controller
{

    public function actionIndex()
    {
        $query = Liceum::find()->orderBy(['rating' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $dataProvider;
    }

}