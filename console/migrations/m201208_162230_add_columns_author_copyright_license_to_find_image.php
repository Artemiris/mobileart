<?php

use yii\db\Migration;

/**
 * Class m201208_162230_add_columns_author_copyright_license_to_find_image
 */
class m201208_162230_add_columns_author_copyright_license_to_find_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('find_image', 'author', $this->string());
        $this->addColumn('find_image', 'copyright', $this->string());
        $this->addColumn('find_image', 'license', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('find_image', 'author');
        $this->dropColumn('find_image', 'copyright');
        $this->dropColumn('find_image', 'license');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201208_162230_add_columns_author_copyright_license_to_find_image cannot be reverted.\n";

        return false;
    }
    */
}