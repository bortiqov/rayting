<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StudentGroup */

$this->title = 'Create Student Group';
$this->params['breadcrumbs'][] = ['label' => 'Student Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
