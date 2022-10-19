<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%course_time}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%group}}`
 */
class m220619_121339_create_course_time_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%course_time}}', [
            'id' => $this->primaryKey(),
            'day' => $this->integer(),
            'start_at' => $this->integer(),
            'end_at' => $this->integer(),
            'group_id' => $this->integer(),
        ]);

        // creates index for column `group_id`
        $this->createIndex(
            '{{%idx-course_time-group_id}}',
            '{{%course_time}}',
            'group_id'
        );

        // add foreign key for table `{{%group}}`
        $this->addForeignKey(
            '{{%fk-course_time-group_id}}',
            '{{%course_time}}',
            'group_id',
            '{{%group}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%group}}`
        $this->dropForeignKey(
            '{{%fk-course_time-group_id}}',
            '{{%course_time}}'
        );

        // drops index for column `group_id`
        $this->dropIndex(
            '{{%idx-course_time-group_id}}',
            '{{%course_time}}'
        );

        $this->dropTable('{{%course_time}}');
    }
}
