<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WorkingTime */

$this->title = 'Create Working Time';
$this->params['breadcrumbs'][] = ['label' => 'Working Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="working-time-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
