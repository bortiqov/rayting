<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Course */
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
                            <div id="menu 1" title="Tez kunda" class="tab-pane fade">
                                <div class="inn-title">
                                    <h4>Requirements, feese, student profile and how to apply</h4>
                                    <p>Airtport Hotels The Right Way To Start A Short Break Holiday</p>
                                </div>
                                <div class="bor ad-cou-deta-h4">
                                    <form>
                                        <h4>Requirements:</h4>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea class="materialize-textarea"></textarea>
                                                <label>Course Descriptions:</label>
                                            </div>
                                        </div>
                                        <h4>Feese:</h4>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="number" class="validate" required>
                                                <label>1'st terms feese</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="number" class="validate" required>
                                                <label>2'nd terms feese</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="number" class="validate" required>
                                                <label>3'rd terms feese</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <textarea class="materialize-textarea"></textarea>
                                                <label>Price Descriptions:</label>
                                            </div>
                                        </div>
                                        <h4>Student Profile:</h4>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea class="materialize-textarea"></textarea>
                                                <label>Student Profile Descriptions:</label>
                                            </div>
                                        </div>
                                        <h4>How to apply this course:</h4>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" class="validate" required>
                                                <label>Step 1 Descriptions:</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="text" class="validate" required>
                                                <label>Step 2 Descriptions:</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="text" class="validate" required>
                                                <label>Step 3 Descriptions:</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="text" class="validate" required>
                                                <label>Step 4 Descriptions:</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="text" class="validate" required>
                                                <label>Step 5 Descriptions:</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="waves-effect waves-light btn-large waves-input-wrapper"
                                                   style=""><input type="submit" class="waves-button-input"
                                                                   value="Submit"></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="menu 2" class="tab-pane fade">
                                <div class="inn-title">
                                    <h4>Photo Gallery</h4>
                                    <p>Airtport Hotels The Right Way To Start A Short Break Holiday</p>
                                </div>
                                <div class="bor">
                                    <form action="#">
                                        <div class="file-field input-field">
                                            <div class="btn admin-upload-btn">
                                                <span>File</span>
                                                <input type="file" multiple="">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text"
                                                       placeholder="Upload course banner image">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="waves-effect waves-light btn-large waves-input-wrapper"
                                                   style=""><input type="submit" class="waves-button-input"
                                                                   value="Upload"></i>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <div id="menu 3" class="tab-pane fade">
                                <div class="inn-title">
                                    <h4>Time table</h4>
                                    <p>Airtport Hotels The Right Way To Start A Short Break Holiday</p>
                                </div>
                                <div class="bor ad-cou-deta-h4">
                                    <form>
                                        <h4>1st semester:</h4>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" class="validate" required>
                                                <label>Title:</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <textarea class="materialize-textarea"></textarea>
                                                <label>Descriptions:</label>
                                            </div>
                                        </div>
                                        <h4>2nd semester:</h4>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" class="validate" required>
                                                <label>Title:</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <textarea class="materialize-textarea"></textarea>
                                                <label>Descriptions:</label>
                                            </div>
                                        </div>
                                        <h4>3rd semester:</h4>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" class="validate" required>
                                                <label>Title:</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <textarea class="materialize-textarea"></textarea>
                                                <label>Descriptions:</label>
                                            </div>
                                        </div>
                                        <h4>4th semester:</h4>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" class="validate" required>
                                                <label>Title:</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <textarea class="materialize-textarea"></textarea>
                                                <label>Descriptions:</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="waves-effect waves-light btn-large waves-input-wrapper"
                                                   style=""><input type="submit" class="waves-button-input"
                                                                   value="Submit"></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="menu 4" class="tab-pane fade" disabled="disabled">
                                <div class="inn-title">
                                    <h4>Contact Info</h4>
                                    <p>Airtport Hotels The Right Way To Start A Short Break Holiday</p>
                                </div>
                                <div class="bor">
                                    <form>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="t5-n1" type="text" class="validate">
                                                <label for="t5-n1">Contact Name</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="t5-n2" type="text" class="validate">
                                                <label for="t5-n2">Alter Contact Name</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="t5-n3" type="number" class="validate">
                                                <label for="t5-n3">Phone</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="t5-n4" type="number" class="validate">
                                                <label for="t5-n4">Mobile</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="t5-n5" type="email" class="validate">
                                                <label for="t5-n5">Email</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea id="t5-n6" class="materialize-textarea"></textarea>
                                                <label for="t5-n6">Listing Descriptions:</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <i class="waves-effect waves-light btn-large waves-input-wrapper"
                                                   style=""><input type="submit" class="waves-button-input"
                                                                   value="Upload"></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
