<?php
namespace frontend\controllers;

use common\models\Site;
use common\utility\PdfUtil;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $sites = Site::find()->all();

        return $this->render('index', [
            'sites' => $sites,
        ]);
    }

    public function actionView($id)
    {
        $site = Site::findOne($id);

        if (empty($site)) {
            throw new HttpException(404);
        }

        return $this->render('view', [
            'site' => $site,
        ]);
    }

    public function actionPdf($id)
    {
        $site = Site::find()->where(['id'=>$id])->one();
        $mpdf = new \Mpdf\Mpdf(['format'=>'A4']);
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->SetHTMLHeader('
            <div style="text-align: right;">' .
            Yii::t('app', 'Information System of Mobile Art') .
            '</div>
            <hr>'
        );
        $mpdf->SetHTMLFooter('
            <hr>
            <table width="100%">
                <tr>
                    <td width="45%">' . Yii::t('app', 'Prehistoric Art in Eurasia Lab') . '</td>
                    <td width="10%" align="center">{PAGENO}</td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Novosibirsk State University') . '</td>
                </tr>
                <tr>
                    <td width="45%">' . HTML::a('mobileart.artemiris.org/site/view/' . $id,
                'http://mobileart.artemiris.org/' . Yii::$app->language . '/site/view/' . $id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RSF #18-78-10079') . '</td>
                </tr>
            </table>'
        );
        $mpdf->WriteHTML($this->renderPartial('pdf_view', [
            'site' => $site,
        ]));
        foreach ($site->getFindsData() as $find)
        {
            $find_pdf_obj = PdfUtil::GetFindPdfObject($find);
            $mpdf->AddPage();
            $parentName = $site->region->name . '. ' . $site->name;
            $mpdf->SetHTMLFooter('
            <hr>
            <table width="100%">
                <tr>
                    <td width="45%">' . Yii::t('app', 'Prehistoric Art in Eurasia Lab') . '</td>
                    <td width="10%" align="center">{PAGENO}</td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Novosibirsk State University') . '</td>
                </tr>
                <tr>
                    <td width="45%">' . HTML::a('mobileart.artemiris.org/find/view/' . $find->id,
                    'http://mobileart.artemiris.org/' . Yii::$app->language . '/find/view/' . $find->id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RSF #18-78-10079') . '</td>
                </tr>
            </table>'
            );
            $mpdf->WriteHTML($this->renderPartial('find_pdf_view', [
                'find'=>$find,
                'image_objects' => $find_pdf_obj['image_objects'],
                'attrib_objects' => $find_pdf_obj['attribute_objects'],
                'parentName' => $parentName
            ]));
        }


        $mpdf->Output($site->region->name . '. ' . $site->name . '.pdf', 'D');
    }
}
