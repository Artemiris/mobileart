<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class RecordType implements \Sabre\Xml\XmlSerializable
{
    /**
     * @var string $recordID
     */
    public $recordID;
    /**
     * @var string $recordTypeTerm
     */
    public $recordTypeTerm;

    /**
     * @var RecordSourceType
     */
    public $recordSource;

    /**
     * RecordType constructor.
     * @param string $recordID
     * @param string $recordTypeTerm
     * @param RecordSourceType $recordSource
     */
    public function __construct(string $recordID, string $recordTypeTerm, RecordSourceType $recordSource)
    {
        $this->recordID = $recordID;
        $this->recordTypeTerm = $recordTypeTerm;
        $this->recordSource = $recordSource;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            [
                'name'=>'lido:recordID',
                'attributes'=>[
                    'lido:type'=>'local'
                ],
                'value'=>$this->recordID
            ],
            [
                'name'=>'lido:recordType',
                'value'=>[
                    'name'=>'lido:term',
                    'value'=>$this->recordTypeTerm
                ]
            ],
            $this->recordSource
        ]);
    }
}