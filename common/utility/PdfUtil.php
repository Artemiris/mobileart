<?php


namespace common\utility;


use common\models\Find;
use common\models\FindImage;
use Yii;

class PdfUtil
{
    static function GetFindPdfObject(Find $find):array
    {
        $find_image_objects = [];
        if(!empty($find->image)){
            $find_image_objects[] = [
                'name' => Yii::t('find', 'Image'),
                'image' => Find::SRC_IMAGE . '/' . $find->thumbnailImage,
                'author' => $find->image_author,
                'copyright' => $find->image_copyright,
                'source' => $find->image_source
            ];
        }
        foreach ($find->getImagesData() as $image) {
            $find_image_objects[] = [
                'name' => '',
                'image' => FindImage::SRC_IMAGE . '/' . FindImage::THUMBNAIL_PREFIX . $image->image,
                'author' => $image->image_author,
                'copyright' => $image->image_copyright,
                'source' => $image->image_source
            ];
        }

        $find_attrib_objects = [];
        if(!empty($find->technique)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'Manufacturing technique'),
                'data' => $find->technique
            ];
        }
        if(!empty($find->traces_disposal)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'Use-wear traces'),
                'data' => $find->traces_disposal
            ];
        }
        if(!empty($find->storage_location)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'Storage location'),
                'data' => $find->storage_location
            ];
        }
        if(!empty($find->inventory_number)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'Inventory number'),
                'data' => $find->inventory_number
            ];
        }
        if(!empty($find->museum_kamis)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'The Museum KAMIS'),
                'data' => $find->museum_kamis
            ];
        }
        if(!empty($find->size)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'Size'),
                'data' => $find->size
            ];
        }
        if(!empty($find->material)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'Material'),
                'data' => $find->material
            ];
        }
        if(!empty($find->dating)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'Dating'),
                'data' => $find->dating
            ];
        }
        if(!empty($find->culture)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'Culture'),
                'data' => $find->culture
            ];
        }
        if(!empty($find->author_excavation)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'The author of the excavations'),
                'data' => $find->author_excavation
            ];
        }
        if(!empty($find->link)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'Links'),
                'data' => $find->link
            ];
        }
        if(!empty($find->publication)){
            $find_attrib_objects[] = [
                'name' => Yii::t('find', 'Publications'),
                'data' => $find->publication
            ];
        }

        return [
            'find' => $find,
            'image_objects' => $find_image_objects,
            'attribute_objects' => $find_attrib_objects
        ];
    }
}