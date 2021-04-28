<?php

use yii\db\Migration;

/**
 * Class m210428_094613_alter_table_find_image_add_field_source
 */
class m210428_094613_alter_table_find_image_add_field_source extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('find_image', 'image_source', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('find_image', 'image_source');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210428_094613_alter_table_find_image_add_field_source cannot be reverted.\n";

        return false;
    }
    */
}
