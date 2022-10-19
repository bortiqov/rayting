<?php

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */

/** @var \common\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
?>
<section>
    <div class="ad-log-main">
        <div class="ad-log-in">
            <div class="ad-log-in-logo">
                <h1><img src="" alt="">Bahodir BMI</h1>
            </div>
            <div class="ad-log-in-con d-flex justify-content-center">
                <div class="log-in-pop-right text-center">
                    <h4>Login</h4>
                    <?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false], 'template' => '{input}{label}']]) ?>
                    <div>
                        <div class="input-field s12">
                            <?= $form->field($model, 'username')->textInput(['class' => 'validate form-control','placeholder' => 'Email'])->label(false) ?>
                        </div>
                    </div>
                    <div>
                        <div class="input-field s12">
                            <?= $form->field($model, 'password')->passwordInput(['class' => 'validate form-control', 'placeholder' => 'Password', 'data-ng-model' => 'name'])->label(false) ?>
                        </div>
                    </div>
                    <div>
                        <div class="s12 log-ch-bx mb-5">
                            <p>
                                <?= $form->field($model, 'rememberMe')->checkbox(['id' => 'test5', 'class' => ''], false)->label('Remember me', ['for' => 'test5']) ?>
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="input-field s4 mt-3">
                            <i class="waves-effect waves-light log-in-btn waves-input-wrapper" style=""><input
                                        type="submit" value="Login" class="waves-button-input"></i></div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</section>
