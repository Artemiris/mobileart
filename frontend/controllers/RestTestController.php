<?php


namespace frontend\controllers;


use common\models\FindImage;
use yii\web\HttpException;

class RestTestController extends \yii\rest\Controller
{
    public function actionFindImageSave()
    {
        if(\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();
            if (empty($model)) {
                throw new HttpException(500);
            }
            $model = FindImage::find()->multilingual()->where(['id' => $data['id']])->one();
            $model->image_author = $data['author'];
            $model->image_copyright = $data['copyright'];
            $model->image_author_en = $data['author_en'];
            $model->image_copyright_en = $data['copyright_en'];
            $model->image_source = $data['source'];
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");
                return $this->redirect(['manager/find-image', 'id' => $model->find_id]);
            }

            \Yii::$app->session->setFlash('error', "Данные не внесены. " . print_r($model->errors, true));
            return $this->redirect(['manager/find-image', 'id' => $model->find_id]);
        }

        var_dump(\Yii::$app->request->method);
    }
}