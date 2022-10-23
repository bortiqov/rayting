<?php

namespace backend\controllers;

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
class SchoolController extends Controller
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
        $query = University::find()->andWhere(['year' => 2021]);
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
            $rows = $simple->rows();
//            echo "<pre>";
//            var_dump($rows);
//            die();
            $data = [];

            foreach ($rows as $index => $row) {

                if ($index < 2) {
                    continue;
                }
                $title = $row[5];
                $prof_teach = round($row[6], 2);
                $method_teach = round($row[7], 2);
                $pupil_smart = round($row[8], 2);
                $physical = round($row[9], 2);
                $total = round($row[10], 2);
                $expert = $row[11];

                $data[] = [$title, $prof_teach, $method_teach, $pupil_smart, $physical, $expert, $total, 2021];
            }

            Yii::$app->db->createCommand()->batchInsert('university', [
                'title',
                'prof_teach',
                'teach_method',
                'pupil_smart',
                'physical',
                'expert',
                'total',
                'year'
            ], $data)->execute();
            $transaction->commit();
        }

        return $this->render('index', [
            'model' => $model,
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

    public function action2019()
    {
        $xls = UploadedFile::getInstanceByName('file');
        $simple = new  SimpleXLSX($xls->tempName);
//        $xlsx = SimpleXLSX::parse($xls->tempName)
//        $simple->sheetsCount();

        if ($xlsx = SimpleXLSX::parse($xls->tempName)) {
            $rows = $simple->rows();
//            echo "<pre>";
//            var_dump($rows);
//            die();
            $data = [];

            foreach ($rows as $index => $row) {

                if ($index < 4) {
                    continue;
                }
                $title = $row[3];
                $prof_teach = round($row[4], 2);
                $method_teach = round($row[5], 2);
                $pupil_smart = round($row[6], 2);
                $physical = round($row[7], 2);
                $total = round($row[8], 2);
                $expert = $row[9];

                $data[] = [$title, $prof_teach, $method_teach, $pupil_smart, $physical, $expert, $total, 2019];
            }

            Yii::$app->db->createCommand()->batchInsert('university', [
                'title',
                'prof_teach',
                'teach_method',
                'pupil_smart',
                'physical',
                'total',
                'expert',
                'year'
            ], $data)->execute();
        }
    }


    public function action2020()
    {
        $xls = UploadedFile::getInstanceByName('file');
        $simple = new  SimpleXLSX($xls->tempName);
//        $xlsx = SimpleXLSX::parse($xls->tempName)
//        $simple->sheetsCount();

        if ($xlsx = SimpleXLSX::parse($xls->tempName)) {
            $rows = $simple->rows();
//            echo "<pre>";
//            var_dump($rows);
//            die();
            $data = [];

            foreach ($rows as $index => $row) {

                if ($index < 2) {
                    continue;
                }
                $title = $row[4];
                $prof_teach = round($row[5], 2);
                $method_teach = round($row[6], 2);
                $pupil_smart = round($row[7], 2);
                $physical = round($row[8], 2);
                $total = round($row[9], 2);
                $expert = $row[10];

                $data[] = [$title, $prof_teach, $method_teach, $pupil_smart, $physical, $expert, $total, 2019];
            }

            Yii::$app->db->createCommand()->batchInsert('university', [
                'title',
                'prof_teach',
                'teach_method',
                'pupil_smart',
                'physical',
                'expert',
                'total',
                'year'
            ], $data)->execute();
        }
    }
}
