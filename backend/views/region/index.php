<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Viloyatlar';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="sb2-2">
    <!--== breadcrumbs ==-->
    <div class="sb2-2-2">
        <ul>
            <li><a href="<?= Url::to(['/']) ?>"><i class="fa fa-home" aria-hidden="true"></i>Bosh sahifa</a>
            </li>
            <li class="active-bre"><a href="#">Dashboard</a>
            </li>
            <li class="page-back"><a href="<?= Url::to(['/']) ?>"><i class="fa fa-backward"
                                                                     aria-hidden="true"></i> Back</a>
            </li>
        </ul>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Viloyatlar</h4>
                        <p>Barcha kurlar haqida malumot</p>
                    </div>

                    <div class="tab-inn">
<!--                        --><?php //$form = ActiveForm::begin([
//                            'options' => [
//                                'enctype' => "multipart/form-data"
//                            ]
//                        ]) ?>
<!--                        <input class="form-control" type="file" name="file">-->
<!--                        <input class="form-control" type="submit" name="submit" value="Yuborish">-->
<!--                        --><?php //ActiveForm::end() ?>
                        <div class="table-responsive table-desi">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

