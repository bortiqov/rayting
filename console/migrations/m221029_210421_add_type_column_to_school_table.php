<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%school}}`.
 */
class m221029_210421_add_type_column_to_school_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%school}}', 'type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%school}}', 'type');
    }
}
