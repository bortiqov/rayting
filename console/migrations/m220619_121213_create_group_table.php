<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%group}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%course}}`
 * - `{{%employee}}`
 */
class m220619_121213_create_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%group}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'course_id' => $this->integer(),
            'employee_id' => $this->integer(),
        ]);

        // creates index for column `course_id`
        $this->createIndex(
            '{{%idx-group-course_id}}',
            '{{%group}}',
            'course_id'
        );

        // add foreign key for table `{{%course}}`
        $this->addForeignKey(
            '{{%fk-group-course_id}}',
            '{{%group}}',
            'course_id',
            '{{%course}}',
            'id',
            'CASCADE'
        );

        // creates index for column `employee_id`
        $this->createIndex(
            '{{%idx-group-employee_id}}',
            '{{%group}}',
            'employee_id'
        );

        // add foreign key for table `{{%employee}}`
        $this->addForeignKey(
            '{{%fk-group-employee_id}}',
            '{{%group}}',
            'employee_id',
            '{{%employee}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%course}}`
        $this->dropForeignKey(
            '{{%fk-group-course_id}}',
            '{{%group}}'
        );

        // drops index for column `course_id`
        $this->dropIndex(
            '{{%idx-group-course_id}}',
            '{{%group}}'
        );

        // drops foreign key for table `{{%employee}}`
        $this->dropForeignKey(
            '{{%fk-group-employee_id}}',
            '{{%group}}'
        );

        // drops index for column `employee_id`
        $this->dropIndex(
            '{{%idx-group-employee_id}}',
            '{{%group}}'
        );

        $this->dropTable('{{%group}}');
    }
}
