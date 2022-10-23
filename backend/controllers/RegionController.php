<?php

namespace backend\controllers;

use backend\models\DistrictRating;
use backend\models\Region;
use common\models\Branch;
use common\models\Companies;
use common\models\Kindergarten;
use common\models\University;
use common\modules\excel\models\FromExcel;
use common\modules\language\models\Language;
use common\modules\tournament\models\Category;
use PHPExcel_IOFactory;
use Shuchkin\SimpleXLSX;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * StoreController implements the CRUD actions for Store model.
 */
class RegionController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    /**
     * Creates a new Store model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Exception
     */

    public function actionIndex()
    {
        $query = Region::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

//        var_dump(Yii::$app->request->post(),$_FILES);
//        die();
        $dataProvider->pagination->pageSize = 100;
        $transaction = \Yii::$app->db->beginTransaction();

        $xls = UploadedFile::getInstanceByName('file');
        $simple = new  SimpleXLSX($xls->tempName);
//        $xlsx = SimpleXLSX::parse($xls->tempName)
//        $simple->sheetsCount();

        if ($xlsx = SimpleXLSX::parse($xls->tempName)) {
            $rows = $simple->rows(1);
//            echo "<pre>";
//            var_dump($rows);
//            die();
            $data = [];

            foreach ($rows as $index => $row) {

                if ($index < 2) {
                    continue;
                }

                $region_id = Region::find()->andWhere(['title' => $row[1]])->one()->id;
                $title = $row[2];
                $rating = round($row[3], 2);

                $data[] = [$region_id, $title, $rating];
            }

            Yii::$app->db->createCommand()->batchInsert('district_rating', [
                'region_id',
                'title',
                'rating',
            ], $data)->execute();
            $transaction->commit();
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }




    public function actionCreate()
    {
        $file = UploadedFile::getInstanceByName('university');
        var_dump($file);
        die();
        if ($_FILES) {
            var_dump($_FILES);
            die();
        }
        return $this->render('create');
    }

}
