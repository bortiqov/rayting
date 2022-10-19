<?php

namespace rakhmatov\payment\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `transaction`.
 */
class Transaction extends Migration
{
    const TABLE = '{{%transaction}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'transaction_id' => $this->string(25),
            'time' => $this->bigInteger(15),
            'created_at' => $this->bigInteger(15),
            'perform_at' => $this->bigInteger(15),
            'cancel_at' => $this->bigInteger(15),
            'amount' => $this->bigInteger(20),
            'state' => $this->integer(2),
            'reason' => $this->integer(2),
            'user_id' => $this->bigInteger(20)
        ]);

        $this->createIndex(
            'idx-transaction-user_id',
            self::TABLE,
            'user_id'
        );

        $this->addForeignKey(
            'fk-transaction-user_id-user-id',
            self::TABLE,
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-transaction-transaction_id',
            self::TABLE,
            '[[transaction_id]]'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropIndex(
            'idx-transaction-transaction_id',
            self::TABLE
        );

        $this->dropIndex(
            'idx-transaction-user_id',
            self::TABLE
        );

        $this->dropForeignKey(
            'fk-transaction-user_id-user-id',
            self::TABLE
        );


        $this->dropTable('transaction');
    }
}
