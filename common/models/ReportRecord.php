<?php


namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Class ReportRecord
 * @package common\models
 *
 * @property integer $id
 * @property string $page_ref
 * @property string $description
 * @property string $fb_mail
 * @property string $fb_name
 * @property integer $date
 * @property boolean $solved
 * @property integer $solver_id
 */
class ReportRecord extends ActiveRecord
{
    public static function tableName()
    {
        return '{{page_report}}';
    }

    public function rules()
    {
        return [
            [['page_ref','description','fb_mail','fb_name'], 'required'],
            [['page_ref','description','fb_mail','fb_name'], 'string'],
            [['solver_id'], 'integer'],
            [['solved'], 'boolean'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }
}