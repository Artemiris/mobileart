<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%find}}`.
 */
class m190214_043111_create_find_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('find', [
            'id' => $this->primaryKey(),
            'image' => $this->string(),
        ]);

        $this->createTable('find_language', [
            'id' => $this->primaryKey(),
            'find_id' => $this->integer()->notNull(),
            'locale' => $this->string(10)->notNull(),
            'name' => $this->string()->notNull(),
            'annotation' => $this->text()->comment('Аннотация'),
            'description' => $this->text()->comment('Описание'),
            'publication' => $this->text()->comment('Публикация'),
            'technique' => $this->text()->comment('Техника изготовления'),
            'traces_disposal' => $this->text()->comment('Следы утилизации'),
            'storage_location' => $this->text()->comment('Место хранения'),
            'inventory number' => $this->text()->comment('Инвентарный номер'),
            'museum_kamis' => $this->text()->comment('Музейная КАМИС'),
            'size' => $this->text()->comment('Размеры'),
            'material' => $this->text()->comment('Материалы'),
            'age' => $this->text()->comment('Возраст'),
            'culture' => $this->text()->comment('Культура'),
            'author_excavation' => $this->text()->comment('Автор раскопок'),
            'year' => $this->integer(4)->comment('Год'),
            'link' => $this->text()->comment('Ссылки'),
        ]);

        $this->addForeignKey(
            'fk-find_language-find',
            'find_language',
            'find_id',
            'find',
            'id',
            'CASCADE'
        );

        $this->createTable('find_image', [
            'id' => $this->primaryKey(),
            'find_id' => $this->integer()->notNull(),
            'image' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-find_image-find',
            'find_image',
            'find_id',
            'find',
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
            'fk-find_image-find',
            'find_image'
        );

        $this->dropTable('find_image');

        $this->dropForeignKey(
            'fk-find_language-find',
            'find_language'
        );

        $this->dropTable('find_language');

        $this->dropTable('find');
    }
}
