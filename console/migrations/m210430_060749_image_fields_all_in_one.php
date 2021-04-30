<?php

use yii\db\Migration;

/**
 * Class m210430_060749_image_fields_all_in_one
 */
class m210430_060749_image_fields_all_in_one extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('find_language', 'image_author', $this->string());
        $this->addColumn('find_language', 'image_copyright', $this->string());
        $this->addColumn('find_language', 'image_source', $this->string());

        $this->createTable('find_image_language',[
            'id' => $this->primaryKey(),
            'find_image_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'image_author' => $this->string(),
            'image_copyright' => $this->string(),
            'image_source' => $this->string()
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
        $this->dropColumn('find_language', 'image_author');
        $this->dropColumn('find_language', 'image_copyright');
        $this->dropColumn('find_language', 'image_source');

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
        echo "m210430_060749_image_fields_all_in_one cannot be reverted.\n";

        return false;
    }
    */
}
