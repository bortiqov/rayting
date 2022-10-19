<?php
/* @var $this yii\web\View */
/* @var $model \common\modules\tariff\models\Tariff */
?>
<div class="container-fluid full">
    <div class="col-12 row mt-5 justify-content-center" style="background: white; border-radius: 10px; padding: 20px;">
        <div class="col-12 container row d-flex">


            <div class="col-12 kurs-shkola-title ">
                <?=$model->title[\Yii::$app->language]?>
            </div>

            <div class="tarif-text col-12">
                <?=$model->description[\Yii::$app->language]?>
            </div>

            <h5><?= __("Ushbu tariffdagi mavjud curslar") ?></h5>
            <div class="tarif-text col-12">
                <?php foreach ($model->courses as $course): ?>
                    <a href="<?= $course->getLink() ?>"><?= $course->title[Yii::$app->language] ?></a> |
                <?php endforeach;?>
            </div>

            <div class="col-12"><?= Yii::$app->formatter->asDecimal($model->price) ?> <?=__('сум')?></div>
            <div class="mt-3"><a class="primary" href="<?=\yii\helpers\Url::to(['tariff/buy', 'id' => $model->id])?>"><?=__('Включить')?></a></div>

        </div>
    </div>
</div>
