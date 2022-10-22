<?php

namespace backend\controllers;

use common\models\Branch;
use common\models\Companies;
use common\models\Kindergarten;
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
class ImportController extends Controller
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
        $query = Kindergarten::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        $dataProvider->pagination->pageSize = 100;
        error_reporting(!8);
        $transaction = \Yii::$app->db->beginTransaction();
        $imageFile = './uploads/Marketing.xls';

        $model = new Branch();
        $xls = UploadedFile::getInstance($model, 'file');
        $simple = new  SimpleXLSX($xls->tempName);
//        $xlsx = SimpleXLSX::parse($xls->tempName)
//        $simple->sheetsCount();

        if ($xlsx = SimpleXLSX::parse($xls->tempName)) {
            $rows = $simple->rows();

            $data = [];

            foreach ($rows as $index => $row) {

                if ($index < 8 || $index > 22) {
                    continue;
                }
                $hudud = $row[1] ?? "Jami";
                $child_count = $row[2];
                $boy_count = $row[3];
                $total_mtt_count = $row[4];
                $country_mtt_count = $row[5];
                $child_count_two = $row[6];
                $boy_count_two = $row[7];
                $total_mtt_two = $row[8];

                $data[] = [$hudud, $child_count, $boy_count, $total_mtt_count, $country_mtt_count, $child_count_two, $boy_count_two, $total_mtt_two];
            }

            Yii::$app->db->createCommand()->batchInsert('kindergarten', [
                'hudud',
                'child_count',
                'boy_count',
                'total_mtt_count',
                'country_mtt_count',
                'child_count_two',
                'boy_count_two',
                'total_mtt_two',
            ], $data)->execute();

            $transaction->commit();
            return $this->redirect('index');
        }

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }
}
