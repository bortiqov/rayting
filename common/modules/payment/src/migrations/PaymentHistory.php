<?php

namespace rakhmatov\payment\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `payment_history`.
 */
class PaymentHistory extends Migration
{

    const TABLE = '{{%payment_history}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'user_id' => $this->bigInteger(20),
            'payment_type' => $this->integer(3),
            'amount' => $this->bigInteger(14),
            'created_at' => $this->bigInteger(15),
            'transaction_id' => $this->integer(),
            'description' => $this->text()
        ]);

        $this->createIndex(
            'idx-payment_history-user_id',
            self::TABLE,
            'user_id'
        );

        $this->addForeignKey(
            'fk-payment_history-user_id-user-id',
            self::TABLE,
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-payment_history-transaction_id',
            self::TABLE,
            'transaction_id'
        );

        $this->addForeignKey(
            'fk-payment_history-transaction_id-transaction-id',
            self::TABLE,
            'transaction_id',
            '{{%transaction}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            'fk-payment_history-user_id-user-id',
            self::TABLE
        );

        $this->dropIndex(
            'idx-payment_history-user_id',
            self::TABLE
        );

        $this->dropForeignKey(
            'fk-payment_history-transaction_id-transaction-id',
            self::TABLE
        );

        $this->dropIndex(
            'idx-payment_history-transaction_id',
            self::TABLE
        );

        $this->dropTable(self::TABLE);
    }
}

