<?php

namespace api\modules\v1\controllers;

use common\components\CrudController;
use common\models\Company;
use common\models\search\CompanySearch;
use common\models\University;
use yii\rest\Controller;

class CompanyController extends Controller
{

    public function actionIndex()
    {
        $model = University::find()->select(['id','title', 'total'])->all();
        return $model;
    }

}