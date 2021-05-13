<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class ObjectTitleSetType implements XmlSerializable
{
    /**
     * @var ObjectTitleType[] $titles
     */
    public $titles = [];

    /**
     * ObjectTitleSetType constructor.
     * @param ObjectTitleType[] $titles
     */
    public function __construct(array $titles)
    {
        $this->titles = $titles;
    }

    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            'name'=>'lido:titleSet',
            'value'=>$this->titles
        ]);
    }
}