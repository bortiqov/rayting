<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%school}}`.
 */
class m221029_212300_add_year_column_to_school_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%school}}', 'year', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%school}}', 'year');
    }
}
