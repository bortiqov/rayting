<?php
/* @var $this yii\web\View */
?>
<div class="container-fluid full">
    <div class="col-12 row mt-5 justify-content-center">
        <div class="col-12 container row d-flex justify-content-center">
            <div class="tarif-text col-12 col-sm-8 text-center first-color ">
            </div>
            <div class="col-12 col-sm-8 row mb-5 pb-3">
                <div class="col-6 col-lg-3 px-2 mb-3 mb-lg-0">
                    <a href="<?= \yii\helpers\Url::to(['tour/charge', 'method' => 'paycom', 'amount' => $model->course->price, 'userId' => 1]) ?>"
                       class="pay-by">
                        <img src="/images/payme.svg" alt="payme">
                    </a>
                </div>
                <div class="col-6 col-lg-3 px-2 mb-3 mb-lg-0">
                    <a href="<?= \yii\helpers\Url::to(['tour/charge', 'method' => 'click', 'amount' => $model->course->price, 'userId' => 1]) ?>"
                       class="pay-by">
                        <img src="/images/click.svg" alt="click">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
