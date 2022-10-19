<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banner}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%file}}`
 */
class m220619_120800_create_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banner}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'sub_title' => $this->string(),
            'link' => $this->string(),
            'file_id' => $this->integer(),
        ]);

        // creates index for column `file_id`
        $this->createIndex(
            '{{%idx-banner-file_id}}',
            '{{%banner}}',
            'file_id'
        );

        // add foreign key for table `{{%file}}`
        $this->addForeignKey(
            '{{%fk-banner-file_id}}',
            '{{%banner}}',
            'file_id',
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
            '{{%fk-banner-file_id}}',
            '{{%banner}}'
        );

        // drops index for column `file_id`
        $this->dropIndex(
            '{{%idx-banner-file_id}}',
            '{{%banner}}'
        );

        $this->dropTable('{{%banner}}');
    }
}
