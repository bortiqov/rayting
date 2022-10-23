<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Course */


$this->title = 'Create Course';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

