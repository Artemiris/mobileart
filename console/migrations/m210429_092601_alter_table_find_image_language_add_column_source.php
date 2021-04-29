<?php

use yii\db\Migration;

/**
 * Class m210429_092601_alter_table_find_image_language_add_column_source
 */
class m210429_092601_alter_table_find_image_language_add_column_source extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('find_image_language','image_source',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('find_image_language', 'image_source');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210429_092601_alter_table_find_image_language_add_column_source cannot be reverted.\n";

        return false;
    }
    */
}
