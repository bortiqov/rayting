<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_course}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%course}}`
 */
class m220806_083129_create_user_course_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_course}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'course_id' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_course-user_id}}',
            '{{%user_course}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_course-user_id}}',
            '{{%user_course}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `course_id`
        $this->createIndex(
            '{{%idx-user_course-course_id}}',
            '{{%user_course}}',
            'course_id'
        );

        // add foreign key for table `{{%course}}`
        $this->addForeignKey(
            '{{%fk-user_course-course_id}}',
            '{{%user_course}}',
            'course_id',
            '{{%course}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_course-user_id}}',
            '{{%user_course}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_course-user_id}}',
            '{{%user_course}}'
        );

        // drops foreign key for table `{{%course}}`
        $this->dropForeignKey(
            '{{%fk-user_course-course_id}}',
            '{{%user_course}}'
        );

        // drops index for column `course_id`
        $this->dropIndex(
            '{{%idx-user_course-course_id}}',
            '{{%user_course}}'
        );

        $this->dropTable('{{%user_course}}');
    }
}
