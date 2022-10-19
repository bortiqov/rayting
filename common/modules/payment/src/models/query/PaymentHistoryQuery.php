<?php

namespace rakhmatov\payment\models\query;

/**
 * This is the ActiveQuery class for [[\rakhmatov\payment\models\PaymentHistory]].
 *
 * @see \rakhmatov\payment\models\PaymentHistory
 */
class PaymentHistoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \rakhmatov\payment\models\PaymentHistory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \rakhmatov\payment\models\PaymentHistory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
