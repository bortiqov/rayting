<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student_group}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%student}}`
 * - `{{%group}}`
 */
class m220619_121556_create_student_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%student_group}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer(),
            'group_id' => $this->integer(),
            'start_date' => $this->integer(),
            'status' => $this->integer(),
        ]);

        // creates index for column `student_id`
        $this->createIndex(
            '{{%idx-student_group-student_id}}',
            '{{%student_group}}',
            'student_id'
        );

        // add foreign key for table `{{%student}}`
        $this->addForeignKey(
            '{{%fk-student_group-student_id}}',
            '{{%student_group}}',
            'student_id',
            '{{%student}}',
            'id',
            'CASCADE'
        );

        // creates index for column `group_id`
        $this->createIndex(
            '{{%idx-student_group-group_id}}',
            '{{%student_group}}',
            'group_id'
        );

        // add foreign key for table `{{%group}}`
        $this->addForeignKey(
            '{{%fk-student_group-group_id}}',
            '{{%student_group}}',
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
        // drops foreign key for table `{{%student}}`
        $this->dropForeignKey(
            '{{%fk-student_group-student_id}}',
            '{{%student_group}}'
        );

        // drops index for column `student_id`
        $this->dropIndex(
            '{{%idx-student_group-student_id}}',
            '{{%student_group}}'
        );

        // drops foreign key for table `{{%group}}`
        $this->dropForeignKey(
            '{{%fk-student_group-group_id}}',
            '{{%student_group}}'
        );

        // drops index for column `group_id`
        $this->dropIndex(
            '{{%idx-student_group-group_id}}',
            '{{%student_group}}'
        );

        $this->dropTable('{{%student_group}}');
    }
}
