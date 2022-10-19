<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%working_time}}`.
 */
class m220619_120952_create_working_time_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%working_time}}', [
            'id' => $this->primaryKey(),
            'day' => $this->integer(),
            'start_at' => $this->integer(),
            'end_at' => $this->integer(),
            'employee_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%working_time}}');
    }
}
