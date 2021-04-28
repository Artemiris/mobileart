<?php

use yii\db\Migration;

/**
 * Class m210428_093709_create_table_find_image_language
 */
class m210428_093709_create_table_find_image_language extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('find_image_language',[
            'id' => $this->primaryKey(),
            'find_image_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'image_author' => $this->string(),
            'image_copyright' => $this->string(),
        ]);

        $this->addForeignKey(
            'fk-find_image_language-find_image',
            'find_image_language',
            'find_image_id',
            'find_image',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-find_image_language-find_image',
            'find_image_language'
        );

        $this->dropTable('find_image_language');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210428_093709_create_table_find_image_language cannot be reverted.\n";

        return false;
    }
    */
}
