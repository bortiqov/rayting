<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%university_rating}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%university}}`
 */
class m221029_190910_create_university_rating_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%university_rating}}', [
            'id' => $this->primaryKey(),
            'university_id' => $this->integer(),
            'prof_teach' => $this->float(),
            'teach_method' => $this->float(),
            'pupil_smart' => $this->float(),
            'physical' => $this->float(),
            'total' => $this->float(),
            'year' => $this->integer(),
            'expert' => $this->integer(),
        ]);

        // creates index for column `university_id`
        $this->createIndex(
            '{{%idx-university_rating-university_id}}',
            '{{%university_rating}}',
            'university_id'
        );

        // add foreign key for table `{{%university}}`
        $this->addForeignKey(
            '{{%fk-university_rating-university_id}}',
            '{{%university_rating}}',
            'university_id',
            '{{%university}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%university}}`
        $this->dropForeignKey(
            '{{%fk-university_rating-university_id}}',
            '{{%university_rating}}'
        );

        // drops index for column `university_id`
        $this->dropIndex(
            '{{%idx-university_rating-university_id}}',
            '{{%university_rating}}'
        );

        $this->dropTable('{{%university_rating}}');
    }
}
