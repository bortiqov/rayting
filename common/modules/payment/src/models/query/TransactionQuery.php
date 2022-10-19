<?php

namespace rakhmatov\payment\models\query;

/**
 * This is the ActiveQuery class for [[\rakhmatov\payment\models\Transaction]].
 *
 * @see \rakhmatov\payment\models\Transaction
 */
class TransactionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \rakhmatov\payment\models\Transaction[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \rakhmatov\payment\models\Transaction|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
