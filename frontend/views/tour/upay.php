<?php
/**
 * Created by PhpStorm.
 * User: izzat
 * Date: 24.05.18
 * Time: 16:51
 */
?>
<form class="payment-card__form" method="post" action="https://pay.smst.uz/prePay.do">
    <input value="1390" name="service_id" type="hidden">
    <input value="<?= $userid ?>" name="personalAccount" type="hidden" />
    <input name="summa" type="hidden" value="<?=$amount?>"><
</form>
