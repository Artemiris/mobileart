<?php
namespace frontend\controllers;

use common\models\Find;
use common\models\FindImage;
use yii\db\Query;
use yii\web\Controller;

/**
 * Class FindController
 * @package frontend\controllers
 */
class FindController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $finds = Find::find()->all();

        return $this->render('index', [
            'finds' => $finds,
        ]);
    }

    public function actionView($id)
    {
        $find = Find::findOne($id);

        if (empty($find)) {
            throw new HttpException(404);
        }

        return $this->render('view', [
            'find' => $find,
        ]);
    }

    public function actionGetImageData($id, $lng)
    {
        $imgid = (new Query)->select(['id'])
            ->from('find_image')
            ->where(['image'=>$id])
            ->one();
        $img = (new Query)->select(['image_author','image_copyright','image_source'])
            ->from('find_image_language')
            ->where(['find_image_id'=>$imgid])
            ->andWhere(['locale'=>$lng])
            ->one();

        /*$res = [
            'author' => $img['image_author'],
            'copyright' => $img['image_copyright'],
            'source' => $img['image_source'],
        ];*/

        return json_encode($img);
    }

    public function actionGetMainImageData($id, $lng)
    {
        $img = (new Query)->select(['image_author','image_copyright','image_source'])
            ->from('find_language')
            ->where(['find_id'=>$id])
            ->andWhere(['locale'=>$lng])
            ->one();

        return json_encode($img);
    }
}
