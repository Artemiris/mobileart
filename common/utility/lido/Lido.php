<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class Lido implements \Sabre\Xml\XmlSerializable
{
    /**
     * @var RecordIDType $recordID
     */
    public $recordID;
    /**
     * @var CategoryType $category
     */
    public $category;
    /**
     * @var DescriptiveMetadataType[] $descriptiveMeta
     */
    public $descriptiveMeta = [];
    /**
     * @var AdministrativeMetadataType[] $administrativeMeta
     */
    public $administrativeMeta = [];

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->writeAttribute('xsi:schemaLocation', 'http://www.lido-schema.org http://www.lido-schema.org/schema/v1.0/lido-v1.0.xsd');
        $writer->write([
           $this->recordID,
           $this->category,
           $this->descriptiveMeta,
           $this->administrativeMeta
        ]);
    }
}