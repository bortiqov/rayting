<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%position}}`
 */
class m220619_113112_create_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'middle_name' => $this->string(),
            'gender' => $this->integer(),
            'birthday' => $this->integer(),
            'address' => $this->string(),
            'phone' => $this->string(),
            'work_start_date' => $this->integer(),
            'user_id' => $this->integer(),
            'position_id' => $this->integer(),
            'status' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-employee-user_id}}',
            '{{%employee}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-employee-user_id}}',
            '{{%employee}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `position_id`
        $this->createIndex(
            '{{%idx-employee-position_id}}',
            '{{%employee}}',
            'position_id'
        );

        // add foreign key for table `{{%position}}`
        $this->addForeignKey(
            '{{%fk-employee-position_id}}',
            '{{%employee}}',
            'position_id',
            '{{%position}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-employee-user_id}}',
            '{{%employee}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-employee-user_id}}',
            '{{%employee}}'
        );

        // drops foreign key for table `{{%position}}`
        $this->dropForeignKey(
            '{{%fk-employee-position_id}}',
            '{{%employee}}'
        );

        // drops index for column `position_id`
        $this->dropIndex(
            '{{%idx-employee-position_id}}',
            '{{%employee}}'
        );

        $this->dropTable('{{%employee}}');
    }
}
