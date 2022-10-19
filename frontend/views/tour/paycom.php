<?php
/**
 * Created by PhpStorm.
 * User: izzat
 * Date: 24.05.18
 * Time: 16:51
 */
?>
<form id="form" class="payment-card__form" action="https://checkout.paycom.uz" method="post">
    <input name="merchant" value="<?=\Yii::$app->params['paycom']['merchant_id']?>" type="hidden">
    <input name="account[user_id]" value="<?=$userId?>" type="hidden">
    <input name="amount" value="<?=$amount*100?>" type="hidden">
    <input name="callback" value="<?=\Yii::$app->urlManager->createUrl(['user/profile'])?>" type="hidden">

</form>
