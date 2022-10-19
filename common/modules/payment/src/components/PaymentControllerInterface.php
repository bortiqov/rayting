<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package payment
 */

namespace rakhmatov\payment\components;


interface PaymentControllerInterface
{

    public function authorize();

    public function actionIndex();

    public function checkPerformTransaction();

    public function checkTransaction();

    public function createTransaction();

    public function performTransaction();

    public function cancelTransaction();

    public function changePassword();

}