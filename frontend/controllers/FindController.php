<?php
namespace frontend\controllers;

use common\models\Find;
use common\models\FindImage;
use common\utility\PdfUtil;
use Mpdf\Mpdf;
use Yii;
use yii\db\Query;
use yii\helpers\Html;
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

    public function actionPdf($id)
    {
        $find = Find::findOne($id);
        if (empty($find)) {
            throw new HttpException(404);
        }
        $find_pdf_obj = PdfUtil::GetFindPdfObject($find);
        $parentName = $find->site->region->name . '. ' . $find->site->name;

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
                    <td width="45%">' . Yii::t('app', 'Lab "LIA ARTEMIR"') . '</td>
                    <td width="10%" align="center">{PAGENO}</td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Novosibirsk State University') . '</td>
                </tr>
                <tr>
                    <td width="45%">' . HTML::a('mobileart.artemiris.org/find/view/' . $id,
                'http://mobileart.artemiris.org/' . Yii::$app->language . '/find/view/' . $id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RNF #18-78-10079') . '</td>
                </tr>
            </table>'
        );
        $mpdf->WriteHTML($this->renderPartial('pdf_view', [
            'find'=>$find,
            'image_objects' => $find_pdf_obj['image_objects'],
            'attrib_objects' => $find_pdf_obj['attribute_objects'],
            'parentName' => $parentName
        ]));
        $mpdf->Output($parentName . '. ' . $find->name . '.pdf', 'D');
    }
}
