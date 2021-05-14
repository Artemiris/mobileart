<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class RecordIDType implements XmlSerializable
{
    /**
     * @var string
     */
    public $source;
    /**
     * @var string
     */
    public $type;
    /**
     * @var string
     */
    public $value;

    /**
     * RecordIDType constructor.
     * @param string $source
     * @param string $type
     * @param string $value
     */
    public function __construct(string $source, string $type, string $value)
    {
        $this->source = $source;
        $this->type = $type;
        $this->value = $value;
    }

    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            'name'=>'lido:lidoRecID',
            'attributes'=>[
                'lido:source'=>$this->source,
                'lido:type'=>$this->type
            ],
            'value'=>$this->value
        ]);
    }
}