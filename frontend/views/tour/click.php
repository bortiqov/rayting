<?php
/**
 * Created by PhpStorm.
 * User: izzat
 * Date: 24.05.18
 * Time: 16:51
 */
?>
<form method="post" action="https://my.click.uz/pay/" id="form">
    <input value="<?=$amount?>" type="hidden" name="MERCHANT_TRANS_AMOUNT">
    <input value="17215" name="MERCHANT_ID" type="hidden">
    <input value="27658" name="MERCHANT_USER_ID" type="hidden">
    <input value="24692" name="MERCHANT_SERVICE_ID" type="hidden">
    <input value="<?= $userId ?>" name="MERCHANT_TRANS_ID" type="hidden">
    <input value="Ishtimoiy markaz" name="MERCHANT_TRANS_NOTE" type="hidden">
    <input value="" name="MERCHANT_USER_PHONE" type="hidden">
    <input value="<?= date('Y-m-j h:i:s') ?>" name="SIGN_TIME" type="hidden">
    <input value="LE6vg8ctmW" name="SIGN_STRING" type="hidden">
    <input value="aWQgMjIyMDg=" name="MERCHANT_TRANS_NOTE_BASE64" type="hidden">
</form>
