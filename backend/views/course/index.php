<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
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
                        <h4>Course Details</h4>
                        <p>Barcha kurlar haqida malumot</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <? ?>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Rasm</th>
                                    <th>Kurs Nomi</th>
                                    <th>Turi</th>
                                    <th>Davomiyligi</th>
                                    <th>Boshlanish vaqti</th>
                                    <th>Narxi</th>
                                    <th>Status</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                    <tr>
                                        <td><span class="list-img"><img src="/images/course/sm-1.jpg"
                                                                        alt=""></span>
                                        </td>
                                        <td><a href="<?= Url::to(['/course/view', 'id' => $model->id]) ?>">
                                                <span class="list-enq-name"><?= $model->name ?></span></a>
                                        </td>
                                        <td><?= $model->name ?></td>
                                        <td>davomiyligi</td>
                                        <td><?= $model->start_date?></td>
                                        <td><?= $model->price ?></td>
                                        <td>
                                            <span class="label label-success">Active</span>
                                        </td>
                                        <td><a href="<?= Url::to(['course/update', 'id' => $model->id]) ?>"
                                               class="ad-st-view">Edit</a></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

