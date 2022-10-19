<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sb2-2">
    <!--== breadcrumbs ==-->
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Add new course</a>
            </li>
            <li class="page-back"><a href="index-2.html"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
            </li>
        </ul>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp admin-form">
                    <div class="sb2-2-add-blog sb2-2-1">
                        <h2>Add New Course</h2>
                        <p>The .table class adds basic styling (light padding and only horizontal dividers) to a
                            table:</p>

                        <ul class="nav nav-tabs tab-list">
                            <li class="active"><a data-toggle="tab" href="#home" aria-expanded="true"><i
                                            class="fa fa-info" aria-hidden="true"></i> <span>Detail</span></a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#menu1" aria-expanded="false"><i class="fa fa-bed"
                                                                                                     aria-hidden="true"></i>
                                    <span>Course Syllabus</span></a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#menu2" aria-expanded="false"><i
                                            class="fa fa-picture-o" aria-hidden="true"></i>
                                    <span>Banner Image</span></a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#menu3" aria-expanded="false"><i
                                            class="fa fa-facebook" aria-hidden="true"></i> <span>Time table</span></a>
                            </li>
                            <li class=""><a data-toggle="tab" href="#menu4" aria-expanded="false"><i class="fa fa-phone"
                                                                                                     aria-hidden="true"></i>
                                    <span>Contact Info</span></a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade active in">
                                <div class="box-inn-sp">
                                    <div class="inn-title">
                                        <h4>Course Information</h4>
                                        <p>Airtport Hotels The Right Way To Start A Short Break Holiday</p>
                                    </div>
                                    <div class="bor">
                                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'fieldConfig' => ['options' => ['tag' => false]]]) ?>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <?= $form->field($model, 'name')->textInput(['id' => 'list-title', 'class' => 'validate'])->label('Kursi nomi', ['for' => 'list-title']) ?>
                                            </div>
                                            <div class="input-field col s12">
                                                <?= $form->field($model, 'price')->textInput(['id' => 'list-name', 'type' => 'number', 'class' => 'validate'])->label('Narxi', ['for' => 'list-name']) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <?= $form->field($model, 'description')->textarea(['class' => 'materialize-textarea'])->label('Kurs tavsifi') ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <?= $form->field($model, 'start_date')->textInput(['id' => 'list-title', 'class' => 'validate', 'type' => 'date'])->label(false) ?>
                                            </div>
                                            <div class="input-field col s12">
                                                <select name="Course[status]">
                                                    <option value="" disabled>Kurs holatini tanlang
                                                    </option>
                                                    <?php foreach ($model->getStatusList() as $key => $value): ?>
                                                        <option value="<?= $key ?>"><?= $value ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="file-field input-field">
                                            <div class="btn admin-upload-btn">
                                                <span>File</span>
                                                <input type="file" name="logo">
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
            </div>
        </div>
    </div>
</div>
