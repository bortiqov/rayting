<?php

use common\modules\user\models\User;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\lesson\models\lesson */
/* @var $form yii\widgets\ActiveForm */

$languages = \common\modules\langs\models\Langs::find()->active()->all();

?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

<div class="container-fluid mt-4">

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <?= $form->field($model, 'transaction_id')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'amount')->textInput() ?>
                    <?= $form->field($model, 'reason')->textInput() ?>
                    <?= $form->field($model, 'state')->textInput() ?>
                    <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                        'data' => User::getDropDownList(),
                        'options' => [
                            'placeholder' => 'Select a User ...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <?= $form->field($model, 'time')->textInput() ?>
                    <?= $form->field($model, 'created_at')->textInput() ?>
                    <?= $form->field($model, 'perform_at')->textInput() ?>
                    <?= $form->field($model, 'cancel_at')->textInput() ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>