<?php

/* @var $this yii\web\View */
/* @var $model \common\modules\tariff\models\Tariff */
?>
<?php $widget->itemOptions['class'] = 'col-12 col-sm-5 col-lg-3 mb-5 mt-5 mt-sm-0'; ?>

<div class="tarif-type-card">
    <div class="tarif-type-card-header"><?= $model->title[Yii::$app->language]?></div>
    <div class="tarif-price"><?= $model->getPrettyDay() ?><b class="mx-2">*</b> <span><?= Yii::$app->formatter->asDecimal($model->price) ?></span>/UZS
    </div>
    <div class="tarif-line">
        <img src="/images/tarif-line.svg" alt="line">
    </div>
    <div class="mt-2"><?=__('Тарифный статус рассчитывается с даты подключения')?></div>
    <div class="price-btn"><a class="primary" href="<?=\yii\helpers\Url::to(['tariff/view', 'id' => $model->id])?>"><?=__('Подробнее')?></a></div>
</div>
