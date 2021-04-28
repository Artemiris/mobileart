<?php

use yii\db\Migration;

/**
 * Class m210423_081418_add_table_outraged
 */
class m210423_081418_add_table_outraged extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('page_report',[
            'id' => $this->primaryKey(),
            'page_ref' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'fb_mail' => $this->string(255)->notNull(),
            'fb_name' => $this->string(1024)->notNull(),
            'date' => $this->dateTime()->notNull(),
            'solved' => $this->boolean()->defaultValue(false),
            'solver_id' => $this->integer()->defaultValue(-1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('page_report');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210423_081418_add_table_outraged cannot be reverted.\n";

        return false;
    }
    */
}
