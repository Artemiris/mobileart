<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class AdministrativeMetadataType implements \Sabre\Xml\XmlSerializable
{
    /**
     * @var RecordType $record
     */
    public $record;

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            'name'=>'lido:administrativeMetadata',
            'attributes'=>[
                'xml:lang'=>'en'
            ],
            'value'=>[
                [
                    'name'=>'lido:recordWrap',
                    'value'=>$this->record
                ]
            ]
        ]);
    }
}