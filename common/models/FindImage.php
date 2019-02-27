<?php

namespace common\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['find_id', 'image'], 'required'],
            [['image'], 'string'],
            [['find_id'], 'exist', 'skipOnError' => true, 'targetClass' => Find::className(), 'targetAttribute' => ['find_id' => 'id']],
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
        $baseDir = self::DIR_IMAGE;

        if (!empty($this->image) and file_exists($baseDir . '/' . $this->image)) {
            unlink($baseDir . '/' . $this->image);
        }

        return parent::beforeDelete();
    }
}
