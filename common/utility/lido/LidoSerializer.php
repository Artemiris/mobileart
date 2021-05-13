<?php


namespace common\utility\lido;


use common\utility\XmlService;

class LidoSerializer
{
    const NS = '{http://www.lido-schema.org}';

    public function test()
    {
        $lido = new Lido();
        $lido->recordID = new RecordIDType('IS Rock art of Siberia', 'local', '12345');

        $lido->category = new CategoryType('URI', 'http://rockart.artemiris.org', [
            'en'=>'Paleolithic Art',
            'ru'=>'Искусство Палеолита'
        ]);

        $desc = new DescriptiveMetadataType();
        $desc->lang = 'en';
        $desc->objectWorkTypes[]= new ObjectWorkTypeType(['Petroglyph', 'Rock art']);
        $desc->classifications[] = new ObjectClassificationType('хз че это за тип', ['PETROGLYPH']);
        $desc->titleSets[] = new ObjectTitleSetType([
            new ObjectTitleType([
                new AppellationValueType('', true, 'name'),
                new AppellationValueType('en', false, 'name1'),
            ])
        ]);
        $desc->descriptionSets[] = new ObjectDescriptionSetType('description_header', 'description_body', 'some_mandatory_type');
        $desc->descriptionSets[] = new ObjectDescriptionSetType('description_header2', 'description_body2', 'some_mandatory_type');
        $desc->events[] = new EventType('excavation', new ActorInRoleType('person', 'excavator =)', [
            new AppellationValueType('en', true, 'molodin')
        ]), '1100-01-01');
        $lido->descriptiveMeta[]=$desc;

        $adm = new AdministrativeMetadataType();
        $adm->record = new RecordType('12345', 'single object', new RecordSourceType(
            'legal_body_id',
            'lb_source',
            'URI',
            new AppellationValueType('en', true, 'Novosibirsk State University'),
            'https://nsu.ru'
        ));

        $lido->administrativeMeta[]=$adm;

        $service = new XmlService();
        $service->namespaceMap = [
            'http://www.lido-schema.org'=>'lido',
            'http://www.w3.org/2001/XMLSchema-instance'=>'xsi'
        ];
        file_put_contents('test_lido.xml',$service->write(self::NS.'lido', $lido));
    }
}