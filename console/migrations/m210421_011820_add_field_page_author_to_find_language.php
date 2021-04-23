<?php

use yii\db\Migration;

/**
 * Class m210421_011820_add_field_page_author_to_find_language
 */
class m210421_011820_add_field_page_author_to_find_language extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('find_language', 'author_page', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('find_language', 'author_page');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210421_011820_add_field_page_author_to_find_language cannot be reverted.\n";

        return false;
    }
    */
}
