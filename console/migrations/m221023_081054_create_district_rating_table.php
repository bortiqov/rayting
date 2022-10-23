<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%district_rating}}`.
 */
class m221023_081054_create_district_rating_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%district_rating}}', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer(),
            'title' => $this->string(),
            'rating' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%district_rating}}');
    }
}
