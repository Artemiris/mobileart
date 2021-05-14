<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class ObjectIdentificationType implements \Sabre\Xml\XmlSerializable
{
    /**
     * @var ObjectTitleSetType[] $titleSets
     */
    public $titleSets = [];

    /**
     * ObjectIdentificationType constructor.
     * @param ObjectTitleType[] $titleSets
     */
    public function __construct(array $titleSets)
    {
        $this->titleSets = $titleSets;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            'name'=>'lido:objectTitleSet',
            'value'=>$this->titleSets
        ]);
    }
}