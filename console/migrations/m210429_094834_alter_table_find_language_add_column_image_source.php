<?php

use yii\db\Migration;

/**
 * Class m210429_094834_alter_table_find_language_add_column_image_source
 */
class m210429_094834_alter_table_find_language_add_column_image_source extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('find_language', 'image_source', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('find_language', 'image_source');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210429_094834_alter_table_find_language_add_column_image_source cannot be reverted.\n";

        return false;
    }
    */
}
