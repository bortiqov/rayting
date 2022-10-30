<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%liceum}}`.
 */
class m221030_070743_create_liceum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%liceum}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'year' => $this->integer(),
            'rating' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%liceum}}');
    }
}
