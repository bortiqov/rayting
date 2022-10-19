<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="sb2-2">
    <!--== breadcrumbs ==-->
    <div class="sb2-2-2">
        <ul>
            <li><a href="<?= \yii\helpers\Url::to(['/']) ?>"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
            </li>
            <li class="active-bre"><a href="<?= \yii\helpers\Url::to(['/student/create']) ?>"> Add new student</a>
            </li>
            <li class="page-back"><a href="<?= \yii\helpers\Url::to() ?>">
                    <i class="fa fa-backward" aria-hidden="true"></i> Back</a>
            </li>
        </ul>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp admin-form">
                    <div class="inn-title">
                        <h4>Yangi hodim qo'shish</h4>
                        <p>Here you can edit your website basic details URL, Phone, Email, Address, User and password
                            and more</p>
                    </div>
                    <div class="tab-inn">
                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'fieldConfig' => ['options' => ['tag' => false]]]) ?>
                        <div class="row">
                            <div class="input-field col-md-6 s6">
                                <?= $form->field($model, 'first_name')->textInput(['id' => 'list-title', 'placeholder' => 'First Name', 'class' => 'validate'])->label(false) ?>
                            </div>
                            <div class="input-field col-md-6 s6">
                                <?= $form->field($model, 'last_name')->textInput(['id' => 'list-name', 'placeholder' => 'Last Name', 'class' => 'validate'])->label(false) ?>
                            </div>
                            <div class="input-field col-md-6 s6">
                                <?= $form->field($model, 'username')->textInput(['id' => 'list-username', 'placeholder' => 'Username', 'class' => 'validate'])->label(false) ?>
                            </div>
                            <div class="input-field col-md-6 s6">
                                <?= $form->field($model, 'email')->textInput(['id' => 'list-email', 'type' => 'email', 'placeholder' => 'Email', 'class' => 'validate'])->label(false) ?>
                            </div>
                            <div class="input-field col-md-6 s6">
                                <?= $form->field($model, 'password')->passwordInput(['id' => 'list-password', 'placeholder' => 'Password', 'class' => 'validate', 'max' => 15, 'min' => 6])->label(false) ?>
                            </div>
                            <div class="input-field col-md-6 s6">
                                <?= $form->field($model, 'password_confirm')->passwordInput(['id' => 'list-password-confirm', 'placeholder' => 'Password Confirm', 'class' => 'validate'])->label(false) ?>
                            </div>
                            <div class="input-field col-md-6 s6">
                                <?= $form->field($model, 'phone')->textInput(['id' => 'list-phone', 'type' => 'number', 'placeholder' => 'Phone', 'class' => 'validate'])->label(false) ?>
                            </div>
                            <div class="input-field col-md-6 s6">
                                <?= $form->field($model, 'address')->textInput(['id' => 'list-address', 'placeholder' => 'Address', 'class' => 'validate'])->label(false) ?>
                            </div>
                            <div class="input-field col-md-6 s6">
                                <div class="mb-2">Tugilgan sanasi</div>
                                <?= $form->field($model, 'birthday')->textInput(['id' => 'list-work_start_date', 'placeholder' => 'O\'qishni boshlagan sanasi', 'type' => 'date', 'class' => 'validate'])->label(false) ?>
                            </div>
                            <div class="input-field col-md-6 s6">
                                <div class="mb-2">O'qishni boshlash sanasi</div>
                                <?= $form->field($model, 'work_start_date')->textInput(['id' => 'list-work_start_date', 'placeholder' => 'O\'qishni boshlagan sanasi', 'type' => 'date', 'class' => 'validate'])->label(false) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col-6 s6">
                                <select name="Employee[gender]">
                                    <option value="" disabled>
                                    </option>

                                    <?php foreach ($model->getGenderList() as $key => $value): ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-field col-6 s6">
                                <select name="Employee[role]">
                                    <option value="" disabled>
                                    </option>
                                    <?php foreach ($model->getRoleList() as $key => $value): ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-field col s">
                                <select name="Employee[status]">
                                    <option value="" disabled>Hodimlar holatini tanlang
                                    </option>
                                    <?php foreach ($model->getStatusList() as $key => $value): ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-field col-6 s6">
                                <select name="Employee[position]">
                                    <option value="" disabled>Hodimni Lavozimini tanlang
                                    </option>
                                    <?php foreach (\common\models\Position::findAll(['status' => \common\models\Position::STATUS_ACTIVE]) as $key => $value): ?>
                                        <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="file-field input-field">
                            <div class="btn admin-upload-btn">
                                <span>Avatar</span>
                                <input type="file" name="avatar">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text"
                                       placeholder="Upload course banner image">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="waves-effect waves-light btn-large waves-input-wrapper"
                                   style="">
                                    <input type="submit" class="waves-button-input"></i>
                            </div>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
