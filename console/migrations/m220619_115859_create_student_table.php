<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m220619_115859_create_student_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%student}}', [
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
            'position' => $this->string(),
            'status' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-student-user_id}}',
            '{{%student}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-student-user_id}}',
            '{{%student}}',
            'user_id',
            '{{%user}}',
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
            '{{%fk-student-user_id}}',
            '{{%student}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-student-user_id}}',
            '{{%student}}'
        );

        $this->dropTable('{{%student}}');
    }
}
