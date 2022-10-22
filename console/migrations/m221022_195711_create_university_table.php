<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%university}}`.
 */
class m221022_195711_create_university_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%university}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'prof_teach' => $this->float(),
            'teach_method' => $this->float(),
            'pupil_smart' => $this->float(),
            'physical' => $this->float(),
            'year' => $this->float(),
            'total' => $this->float(),
            'expert' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%university}}');
    }
}
