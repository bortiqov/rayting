<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%course}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%file}}`
 */
class m220619_120653_create_course_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%course}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'start_date' => $this->integer(),
            'status' => $this->integer(),
            'price' => $this->integer(),
            'logo_id' => $this->integer(),
            'description' => $this->string(),
        ]);

        // creates index for column `logo_id`
        $this->createIndex(
            '{{%idx-course-logo_id}}',
            '{{%course}}',
            'logo_id'
        );

        // add foreign key for table `{{%file}}`
        $this->addForeignKey(
            '{{%fk-course-logo_id}}',
            '{{%course}}',
            'logo_id',
            '{{%file}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%file}}`
        $this->dropForeignKey(
            '{{%fk-course-logo_id}}',
            '{{%course}}'
        );

        // drops index for column `logo_id`
        $this->dropIndex(
            '{{%idx-course-logo_id}}',
            '{{%course}}'
        );

        $this->dropTable('{{%course}}');
    }
}
