<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
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
                        <h4>Hodimlar malumotlari</h4>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Avatar</th>
                                    <th>Full name</th>
                                    <th>Tel nomer</th>
                                    <th>Address</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                    <tr>
                                        <td>
                                            <span class="list-img"><img src="<?= $model->user->avatar ? $model->user->avatar->getSrc('small') : "/images/course/sm-1.jpg" ?>" alt=""></span>
                                        </td>
                                        <td><a href="<?= Url::to(['/student/view', 'id' => $model->id]) ?>">
                                                <span class="list-enq-name"><?= $model->first_name . " " . $model->last_name ?></span></a>
                                        </td>
                                        <td><?= $model->phone ?></td>
                                        <td><?= $model->address ?></td>
                                        <td><?= $model->user->username ?></td>
                                        <td><?= $model->user->email ?></td>
                                        <td>
                                            <span class="label label-success">Active</span>
                                        </td>
                                        <td><a href="<?= Url::to(['employee/update', 'id' => $model->id]) ?>"
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
