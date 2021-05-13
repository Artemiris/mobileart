<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class ObjectTitleType implements \Sabre\Xml\XmlSerializable
{
    /**
     * @var AppellationValueType[] $values
     */
    public $values = [];

    /**
     * ObjectTitleType constructor.
     * @param AppellationValueType[] $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write($this->values);
    }
}