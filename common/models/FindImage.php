<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * FindImage model
 *
 * @property integer $id
 * @property integer $find_id
 * @property integer $find
 * @property string $image
 */
class FindImage extends ActiveRecord
{

    const DIR_IMAGE = 'storage/web/find_image';
    const SRC_IMAGE = '/storage/find_image';
    const THUMBNAIL_W = 800;
    const THUMBNAIL_H = 500;
    const SCENARIO_CREATE = 'create';
    const COUNT_SYB = 500;
    const THUMBNAIL_PREFIX = 'thumbnail_';

    public $fileImage;

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['find_id', 'image'], 'required'],
            [['image', 'image_source', 'image_author', 'image_copyright'], 'string'],
            [['find_id'], 'exist', 'skipOnError' => true, 'targetClass' => Find::className(), 'targetAttribute' => ['find_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => [
                    'ru' => 'Russian',
                    'en' => 'English',
                ],
                'languageField' => 'locale',
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'find_image_id',
                'tableName' => "{{%find_image_language}}",
                'attributes' => [
                    'image_author',
                    'image_copyright',
                    'image_source'
                ]
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFind()
    {
        return $this->hasOne(Find::className(), ['id' => 'find_id']);
    }

    /**
     * Удаляем файл перед удалением записи
     *
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeDelete()
    {
        $baseDir = self::basePath();

        if (!empty($this->image) and file_exists($baseDir . '/' . $this->image)) {
            unlink($baseDir . '/' . $this->image);
        }

        return parent::beforeDelete();
    }

    /**
     * Устанавливает путь до директории
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public static function basePath()
    {
        $path = \Yii::getAlias('@' . self::DIR_IMAGE);

        // Создаем директорию, если не существует
        FileHelper::createDirectory($path);

        return $path;
    }
}
