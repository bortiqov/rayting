<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseTime */

$this->title = 'Create Course Time';
$this->params['breadcrumbs'][] = ['label' => 'Course Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-time-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
