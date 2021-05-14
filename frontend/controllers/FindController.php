<?php
namespace frontend\controllers;

use common\models\Find;
use common\models\FindImage;
use common\utility\lido\ActorInRoleType;
use common\utility\lido\AdministrativeMetadataType;
use common\utility\lido\AppellationValueType;
use common\utility\lido\DescriptiveMetadataType;
use common\utility\lido\EventType;
use common\utility\lido\Lido;
use common\utility\lido\ObjectClassificationType;
use common\utility\lido\ObjectDescriptionSetType;
use common\utility\lido\ObjectTitleSetType;
use common\utility\lido\ObjectTitleType;
use common\utility\lido\ObjectWorkTypeType;
use common\utility\lido\RecordIDType;
use common\utility\lido\RecordSourceType;
use common\utility\lido\RecordType;
use common\utility\PdfUtil;
use common\utility\XmlService;
use yii\helpers\Url;
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

    public function actionLido($id)
    {
        $appLang = Yii::$app->language;
        Yii::$app->language = 'ru';
        $find = Find::find()->multilingual()->where(['id'=>$id])->one();
        if(empty($find))
            throw new HttpException(404);
        $service = new XmlService();
        $service->initLidoMap();
        $lido = new Lido();

        $lido->recordID = new RecordIDType(Url::home(true), 'local', $id);
        $descriptiveMetaEn = new DescriptiveMetadataType();
        $descriptiveMetaEn->lang = 'en';
        $descriptiveMetaEn->titleSets = [
            new ObjectTitleSetType([
                new ObjectTitleType([
                    new AppellationValueType('en', true, $find->name_en)
                ])
            ])
        ];
        $descriptiveMetaEn->classifications = [
            new ObjectClassificationType('local',[
                'Object'
            ])
        ];
        $descriptiveMetaEn->objectWorkTypes = [
            new ObjectWorkTypeType(['Mobiliary Art'])
        ];

        $descriptiveMetaEn->descriptionSets[] = new ObjectDescriptionSetType('Description', strip_tags(preg_replace( "/\r|\n/", "", $find->description_en)), 'local');

        if(!empty($find->traces_disposal_en))
            $descriptiveMetaEn->descriptionSets[] = new ObjectDescriptionSetType('Use-wear traces', strip_tags(preg_replace( "/\r|\n/", "", $find->traces_disposal_en)), 'local');

        if(!empty($find->author_excavation_en))
            $descriptiveMetaEn->events = [
                new EventType('Excavation',
                    new ActorInRoleType('person', 'Executive', [
                        new AppellationValueType('en', true, $find->author_excavation_en)
                    ]), $find->year_en)
            ];

        $descriptiveMetaRu = new DescriptiveMetadataType();
        $descriptiveMetaRu->lang = 'ru';
        $descriptiveMetaRu->titleSets = [
            new ObjectTitleSetType([
                new ObjectTitleType([
                    new AppellationValueType('ru', true, $find->name)
                ])
            ])
        ];
        $descriptiveMetaRu->classifications = [
            new ObjectClassificationType('local',[
                'Объект'
            ])
        ];
        $descriptiveMetaRu->objectWorkTypes = [
            new ObjectWorkTypeType(['Мобильное искусство'])
        ];
        $descriptiveMetaRu->descriptionSets[] = new ObjectDescriptionSetType('Описание', strip_tags(preg_replace( "/\r|\n/", "", $find->description)), 'local');

        if(!empty($find->traces_disposal))
            $descriptiveMetaEn->descriptionSets[] = new ObjectDescriptionSetType('Use-wear traces', strip_tags(preg_replace( "/\r|\n/", "", $find->traces_disposal)), 'local');

        if(!empty($find->author_excavation))
            $descriptiveMetaRu->events = [
                new EventType('Раскопки',
                    new ActorInRoleType('person', 'Исполнитель', [
                        new AppellationValueType('ru', true, $find->author_excavation)
                    ]), $find->year)
            ];

        $lido->descriptiveMeta[] = $descriptiveMetaEn;
        $lido->descriptiveMeta[] = $descriptiveMetaRu;

        $administrativeMeta = new AdministrativeMetadataType();
        $administrativeMeta->record = new RecordType($id, 'Single object',
            new RecordSourceType(Url::home(true), ' ', 'URL',
                new AppellationValueType('en', true,'Information system of portable art of Siberia and Far East'), Url::home(true)
            )
        );
        $lido->administrativeMeta[] = $administrativeMeta;
        $filename = '../../storage/web/lido_obj_temp.xml';
        $xml_result = $service->write('lido:lido', $lido);
        file_put_contents($filename, $xml_result);

        Yii::$app->language = $appLang;
        if(file_exists($filename))
            Yii::$app->response->sendFile($filename, 'lido_obj_'.$id.'.xml');
        else
            throw new HttpException(404);
    }
}
