<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%school}}`.
 */
class m221023_104005_create_school_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%school}}', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer(),
            'district_title' => $this->string(),
            'title' => $this->string(),
            'rayting' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%school}}');
    }
}
