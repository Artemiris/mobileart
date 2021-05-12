<?php
namespace frontend\controllers;

use common\models\Region;
use common\models\Site;
use common\utility\PdfUtil;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;

/**
 * Class RegionController
 * @package frontend\controllers
 */
class RegionController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $regions = Region::find()->all();

        return $this->render('index', [
            'regions' => $regions,
        ]);
    }

    public function actionView($id)
    {
        $region = Region::findOne($id);

        if (empty($region)) {
            throw new HttpException(404);
        }

        return $this->render('view', [
            'region' => $region,
        ]);
    }

    public function actionPdf($id)
    {
        $region = Region::find()->where(['id'=>$id])->one();
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
                    <td width="45%">' . HTML::a('mobileart.artemiris.org/region/view/' . $id,
                'http://mobileart.artemiris.org/' . Yii::$app->language . '/region/view/' . $id) . '</td>
                    <td width="10%" align="center"></td>
                    <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RNF #18-78-10079') . '</td>
                </tr>
            </table>'
        );
        $mpdf->WriteHTML($this->renderPartial('pdf_view', ['region'=>$region]));
        foreach ($region->sites as $site) {
            $mpdf->AddPage();
            $mpdf->SetHTMLFooter('
                <hr>
                <table width="100%">
                    <tr>
                        <td width="45%">' . Yii::t('app', 'Lab "LIA ARTEMIR"') . '</td>
                        <td width="10%" align="center">{PAGENO}</td>
                        <td width="45%" style="text-align: right;">' . Yii::t('app', 'Novosibirsk State University') . '</td>
                    </tr>
                    <tr>
                        <td width="45%">' . HTML::a('mobileart.artemiris.org/site/view/' . $site->id,
                'http://mobileart.artemiris.org/' . Yii::$app->language . '/site/view/' . $site->id) . '</td>
                        <td width="10%" align="center"></td>
                        <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RNF #18-78-10079') . '</td>
                    </tr>
                </table>'
            );
            $mpdf->WriteHTML($this->renderPartial('site_pdf_view', [
                'site' => $site,
            ]));
            foreach ($site->getFindsData() as $find) {
                $find_pdf_obj = PdfUtil::GetFindPdfObject($find);
                $mpdf->AddPage();
                $parentName = $site->region->name . '. ' . $site->name;
                $mpdf->SetHTMLFooter('
                    <hr>
                    <table width="100%">
                        <tr>
                            <td width="45%">' . Yii::t('app', 'Lab "LIA ARTEMIR"') . '</td>
                            <td width="10%" align="center">{PAGENO}</td>
                            <td width="45%" style="text-align: right;">' . Yii::t('app', 'Novosibirsk State University') . '</td>
                        </tr>
                        <tr>
                            <td width="45%">' . HTML::a('mobileart.artemiris.org/find/view/' . $find->id,
                                'http://mobileart.artemiris.org/' . Yii::$app->language . '/find/view/' . $find->id) . '</td>
                            <td width="10%" align="center"></td>
                            <td width="45%" style="text-align: right;">' . Yii::t('app', 'Project supported by RNF #18-78-10079') . '</td>
                        </tr>
                    </table>'
                );
                $mpdf->WriteHTML($this->renderPartial('find_pdf_view', [
                    'find' => $find,
                    'image_objects' => $find_pdf_obj['image_objects'],
                    'attrib_objects' => $find_pdf_obj['attribute_objects'],
                    'parentName' => $parentName
                ]));
            }
        }


        $mpdf->Output($region->name . '.pdf', 'D');
    }
}
