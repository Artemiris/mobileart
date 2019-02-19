<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * Find model
 *
 * @property integer $id
 * @property integer $site_id
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property string $annotation
 * @property string $annotation_en
 * @property string $publication
 * @property string $publication_en
 * @property string $technique
 * @property string $technique_en
 * @property string $traces_disposal
 * @property string $traces_disposal_en
 * @property string $storage_location
 * @property string $storage_location_en
 * @property string $inventory_number
 * @property string $inventory_number_en
 * @property string $museum_kamis
 * @property string $museum_kamis_en
 * @property string $size
 * @property string $size_en
 * @property string $material
 * @property string $material_en
 * @property string $dating
 * @property string $dating_en
 * @property string $culture
 * @property string $culture_en
 * @property string $author_excavation
 * @property string $author_excavation_en
 * @property integer $year
 * @property integer $year_en
 * @property string $link
 * @property string $link_en
 * @property string $image
 * @property string $fileImage
 * @property string $images
 * @property string $fileImages
 */
class Find extends ActiveRecord
{

    const DIR_IMAGE = 'uploads/find';
    const THUMBNAIL_W = 800;
    const THUMBNAIL_H = 500;
    const SCENARIO_CREATE = 'create';
    const COUNT_SYB = 500;

    public $fileImage;
    public $fileImages;

    /**
     * {@inheritdoc}
     */
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
                'langForeignKey' => 'find_id',
                'tableName' => "{{%find_language}}",
                'attributes' => [
                    'name',
                    'annotation',
                    'description',
                    'publication',
                    'technique',
                    'traces_disposal',
                    'storage_location',
                    'inventory_number',
                    'museum_kamis',
                    'size',
                    'material',
                    'dating',
                    'culture',
                    'author_excavation',
                    'year',
                    'link',
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_en', 'site_id'], 'required'],
            [['name', 'annotation', 'description', 'publication', 'technique', 'traces_disposal', 'storage_location', 'inventory_number', 'museum_kamis', 'size', 'material', 'dating', 'culture', 'author_excavation', 'link',], 'string'],
            ['image', 'string'],
            ['year', 'integer'],
            [['site_id'], 'exist', 'skipOnError' => true, 'targetClass' => Site::className(), 'targetAttribute' => ['site_id' => 'id']],
            [['fileImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            [['fileImages'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxFiles' => 30],
        ];
    }

    /**
     * @return MultilingualQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'annotation', 'description', 'publication', 'image', 'x', 'y'];

        return $scenarios;
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload()
    {
        if ($this->validate() and !empty($this->fileImage)) {

            $path = self::DIR_IMAGE;

            if (!empty($this->image) and file_exists($path . '/' . $this->image)) {
                unlink($path . '/' . $this->image);
            }

            FileHelper::createDirectory($path);

            $newName = md5(uniqid($this->id));
            $this->fileImage->saveAs($path . '/' . $newName . '.' . $this->fileImage->extension);
            $this->image = $newName . '.' . $this->fileImage->extension;

//            Image::thumbnail($path . '/' . $newName . '.' . $this->fileImage->extension, self::THUMBNAIL_W, self::THUMBNAIL_H)
//                ->resize(new Box(self::THUMBNAIL_W, self::THUMBNAIL_H))
//                ->save($path . '/' . $newName . '.' . $this->fileImage->extension, ['quality' => 80]);

            $this->scenario = self::SCENARIO_CREATE;
            return $this->save();
        } else {
            return false;
        }
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function uploadImages()
    {
        if ($this->validate() and $this->id) {

            $path = FindImage::DIR_IMAGE;
            $is_error = false;

            foreach ($this->fileImages as $file) {
                FileHelper::createDirectory($path);

                $newName = $this->id . '_' . uniqid();
                $file->saveAs($path . '/' . $newName . '.' . $file->extension);

                Image::thumbnail($path . '/' . $newName . '.' . $file->extension, FindImage::THUMBNAIL_W, FindImage::THUMBNAIL_H)
                    ->resize(new Box(FindImage::THUMBNAIL_W, FindImage::THUMBNAIL_H))
                    ->save($path . '/' . FindImage::THUMBNAIL_PREFIX . $newName . '.' . $file->extension, ['quality' => 80]);

                $image = new FindImage();
                $image->find_id = $this->id;
                $image->image = $newName . '.' . $file->extension;
                if (!$image->save()) {
                    $is_error = true;
                    \Yii::$app->session->setFlash('error', 'Не удалось внести запись допю изображения. ' . print_r($image->errors, 1));
                }
            }

            return !$is_error;
        } else {
            return false;
        }
    }

    /**
     * label attr
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'site_id' => 'Памятник',
            'name' => 'Название',
            'name_en' => 'Название на английском',
            'description' => 'Описание',
            'description_en' => 'Описание на английском',
            'annotation' => 'Аннотация',
            'annotation_en' => 'Аннотация на английском',
            'publication' => 'Публикации',
            'publication_en' => 'Публикации на английском',
            'technique' => 'Техника изготовления',
            'technique_en' => 'Техника изготовления на английском',
            'traces_disposal' => 'Следы утилизации',
            'traces_disposal_en' => 'Следы утилизации на английском',
            'storage_location' => 'Место хранения',
            'storage_location_en' => 'Место хранения на английском',
            'inventory_number' => 'Инвентарный номер',
            'inventory_number_en' => 'Инвентарный номер на английском',
            'museum_kamis' => 'Музейная КАМИС',
            'museum_kamis_en' => 'Музейная КАМИС на английском',
            'size' => 'Размеры',
            'size_en' => 'Размеры на английском',
            'material' => 'Материалы',
            'material_en' => 'Материалы на английском',
            'dating' => 'Возраст',
            'dating_en' => 'Возраст на английском',
            'culture' => 'Культура',
            'culture_en' => 'Культура на английском',
            'author_excavation' => 'Автор раскопок',
            'author_excavation_en' => 'Автор раскопок на английском',
            'year' => 'Год',
            'year_en' => 'Год на английском',
            'link' => 'Ссылки',
            'link_en' => 'Ссылки на английском',
            'image' => 'Изображение',
            'fileImage' => 'Изображение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Site::className(), ['id' => 'site_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(FindImage::className(), ['find_id' => 'id']);
    }

    /**
     * Удаляем файл перед удалением записи
     *
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeDelete()
    {
        $baseDir = self::DIR_IMAGE;

        if (!empty($this->image) and file_exists($baseDir . '/' . $this->image)) {
            unlink($baseDir . '/' . $this->image);
        }

        return parent::beforeDelete();
    }
}
