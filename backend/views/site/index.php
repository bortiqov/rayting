<?php

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $courseDataProvider \yii\data\ActiveDataProvider
 */

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Home';
?>

>
<div class="sb2-2">
    <!--== breadcrumbs ==-->
    <!--== DASHBOARD INFO ==-->
    <div class="sb2-2-1">
        <h2>Boshqaruv paneli</h2>
        <p>Boshqaruv paneli yordamida siz tizimni to'liq boshqarishingiz mumkim</p>
        <div class="db-2">
            <ul>
                <li>
                    <div class="dash-book dash-b-1">
                        <h5>Barcha universitetlar</h5>
                        <h4><?= $courseDataProvider->count ?></h4>
                        <a href="<?= \yii\helpers\Url::to(['course/index']) ?>">Ko'rish</a>
                    </div>
                </li>

            </ul>
        </div>
    </div>

    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Course Details</h4>
                        <p>All about courses, program structure, fees, best course lists (ranking), syllabus, teaching
                            techniques and other details.</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <?= GridView::widget([
                                'dataProvider' => $courseDataProvider,
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

