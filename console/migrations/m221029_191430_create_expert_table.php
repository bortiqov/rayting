<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expert}}`.
 */
class m221029_191430_create_expert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%expert}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%expert}}');
    }
}
