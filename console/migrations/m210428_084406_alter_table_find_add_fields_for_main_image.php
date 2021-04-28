<?php

use yii\db\Migration;

/**
 * Class m210428_084406_alter_table_find_add_fields_for_main_image
 */
class m210428_084406_alter_table_find_add_fields_for_main_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('find_language', 'image_author', $this->string());
        $this->addColumn('find_language', 'image_copyright', $this->string());
        $this->addColumn('find', 'image_source', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('find_language', 'image_author');
        $this->dropColumn('find_language', 'image_copyright');
        $this->dropColumn('find', 'image_source');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210428_084406_alter_table_find_add_fields_for_main_image cannot be reverted.\n";

        return false;
    }
    */
}
