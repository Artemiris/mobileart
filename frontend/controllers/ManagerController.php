<?php

namespace frontend\controllers;

use common\models\BannerImage;
use common\models\FindImage;
use common\models\Region;
use common\models\Site;
use common\models\Find;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;

/**
 * Manager controller
 */
class ManagerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'region-delete' => ['post'],
                    'site-delete' => ['post'],
                    'find-delete' => ['post'],
                    'image-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionRegion()
    {
        $regions = Region::find()->orderBy(['id' => SORT_DESC])->all();

        return $this->render('region_list', ['regions' => $regions]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionRegionCreate()
    {
        $model = new Region();

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/region-update', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('region_create', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionRegionUpdate($id)
    {
        $model = Region::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->refresh();
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('region_update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRegionDelete($id)
    {
        $model = Region::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        if (empty($model->sites)) {
            $model->delete();
        } else {
            \Yii::$app->session->setFlash('error', 'Невозможно удалить данный регион, так как к нему привязаны памятники');
        }

        return $this->redirect(['manager/region']);
    }

    /**
     * @return string
     */
    public function actionSite()
    {
        $sites = Site::find()->orderBy(['id' => SORT_DESC])->all();

        return $this->render('site_list', ['sites' => $sites]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionSiteCreate()
    {
        $model = new Site();

        $regions = Region::find()->all();
        $data = ArrayHelper::map($regions, 'id', 'name');

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/site-update', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('site_create', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionSiteUpdate($id)
    {
        $model = Site::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        $regions = Region::find()->all();
        $data = ArrayHelper::map($regions, 'id', 'name');

        if ($model->load(\Yii::$app->request->post())) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');

            if ($model->save()) {
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->refresh();
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('site_update', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionSiteDelete($id)
    {
        $model = Site::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        $model->delete();

        return $this->redirect(['manager/site']);
    }

    /**
     * @return string
     */
    public function actionFind()
    {
        $finds = Find::find()->orderBy(['id' => SORT_DESC])->all();

        return $this->render('find_list', ['finds' => $finds]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionFindCreate()
    {
        $model = new Find();

        $regions = Site::find()->all();
        $data = ArrayHelper::map($regions, 'id', 'name');

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->save()) {
                $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/find-update', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('find_create', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionFindUpdate($id)
    {
        $model = Find::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        $regions = Site::find()->all();
        $data = ArrayHelper::map($regions, 'id', 'name');

        if ($model->load(\Yii::$app->request->post())) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');

            if ($model->save()) {
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->refresh();
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('find_update', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionFindDelete($id)
    {
        $model = Find::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        $model->delete();

        return $this->redirect(['manager/find']);
    }

    public function actionFindImage($id)
    {
        $model = Find::find()->multilingual()->where(['id' => $id])->one();

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {
            $model->fileImages = UploadedFile::getInstances($model, 'fileImages');
            if ($model->uploadImages()) {
                \Yii::$app->session->setFlash('success', "Данные внесены");
                return $this->refresh();
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('find_image', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionImageDelete($id)
    {
        $model = FindImage::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        $find = $model->find;
        $model->delete();

        return $this->redirect(['manager/find-image', 'id' => $find->id]);
    }

    public function actionFindImageSave()
    {
        if(\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();
            $model = FindImage::find()->multilingual()->where(['id' => $data['id']])->one();
            if (empty($model)) {
                throw new HttpException(500);
            }
            $model->image_author = $data['author'];
            $model->image_copyright = $data['copyright'];
            $model->image_author_en = $data['author_en'];
            $model->image_copyright_en = $data['copyright_en'];
            $model->image_source = $data['source'];
            if ($model->save()) {
                return "OK";
            }
            return "Данные не внесены. " . print_r($model->errors, true);
        }
    }

    /**
     * @return string
     */
    public function actionBannerImage()
    {
        $bannerImages = BannerImage::find()->orderBy(['position' => SORT_ASC])->all();

        return $this->render('banner_image_list', ['bannerImages' => $bannerImages]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionBannerImageCreate()
    {
        $model = new BannerImage();

        if ($model->load(\Yii::$app->request->post())) {
            $reposition = false;
            $bannerImageItemMaxPosition = BannerImage::find()->orderBy('position DESC')->one();
            $maxPosition = empty($bannerImageItemMaxPosition) ? 0 : $bannerImageItemMaxPosition->position;
            if (!empty($model->position)) {
                $reposition = true;
                $model->position = $model->position > ($maxPosition + 1) ? ($maxPosition + 1) : $model->position;
            } else {
                $model->position = $maxPosition + 1;
            }
            if ($model->save()) {
                if ($reposition) {
                    \Yii::$app->db->createCommand('update ' . BannerImage::tableName() . ' set position = position + 1 where position >= :position and id != :id', [
                        ':id' => $model->id,
                        ':position' => $model->position,
                    ])->execute();
                }
                $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->redirect(['manager/banner-image-update', 'id' => $model->id]);
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }

        return $this->render('banner_image_create', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionBannerImageUpdate($id)
    {
        $model = BannerImage::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        if ($model->load(\Yii::$app->request->post())) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');

            $reposition = false;
            $oldPosition = $model->oldAttributes['position'];
            $bannerImageItemMaxPosition = BannerImage::find()->orderBy('position DESC')->one();
            $maxPosition = empty($bannerImageItemMaxPosition) ? 0 : $bannerImageItemMaxPosition->position;
            if ($model->position != $oldPosition and !empty($model->position)) {
                $reposition = true;
                $model->position = $model->position > $maxPosition ? $maxPosition : $model->position;
            } elseif(empty($model->position)) {
                $model->position = $maxPosition + 1;
            }

            if ($model->save()) {
                if ($reposition) {
                    if ($model->position < $oldPosition) {
                        \Yii::$app->db->createCommand('update ' . BannerImage::tableName() . ' set position = position + 1 where position >= :newPosition and position <= :oldPosition and id != :id', [
                            ':id' => $model->id,
                            ':newPosition' => $model->position,
                            ':oldPosition' => $oldPosition,
                        ])->execute();
                    } else {
                        \Yii::$app->db->createCommand('update ' . BannerImage::tableName() . ' set position = position - 1 where position <= :newPosition and position >= :oldPosition and id != :id', [
                            ':id' => $model->id,
                            ':newPosition' => $model->position,
                            ':oldPosition' => $oldPosition,
                        ])->execute();
                    }
                }
                $model->upload();
                \Yii::$app->session->setFlash('success', "Данные внесены");

                return $this->refresh();
            }

            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения<br>" . print_r($model->errors, true));
        }


        return $this->render('banner_image_update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBannerImageDelete($id)
    {
        $model = BannerImage::findOne($id);

        if (empty($model)) {
            throw new HttpException(500);
        }

        $model->delete();

        return $this->redirect(['manager/banner-image']);
    }
}
