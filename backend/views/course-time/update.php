<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseTime */

$this->title = 'Update Course Time: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Course Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-time-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
