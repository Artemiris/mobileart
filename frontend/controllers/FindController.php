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
}
