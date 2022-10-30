<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%district_rating}}`.
 */
class m221029_210726_add_year_column_to_district_rating_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%district_rating}}', 'year', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%district_rating}}', 'year');
    }
}
