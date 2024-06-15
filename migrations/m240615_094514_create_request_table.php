<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 */
class m240615_094514_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'surname' => $this->string(255)->notNull(),
            'patronymic' => $this->string(255),
            'description' => $this->text(),
            'service_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'accept_date' => $this->date()->defaultExpression('NOW()'),
            'status' => $this->integer()->defaultValue(0)
        ]);

        $this->createIndex(
            'idx-request-service_id',
            'request',
            'service_id'
        );

        $this->addForeignKey(
            'fk-request-service_id',
            'request',
            'service_id',
            'service',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-request-user_id',
            'request',
            'user_id'
        );

        $this->addForeignKey(
            'fk-request-user_id',
            'request',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%request}}');
    }
}
