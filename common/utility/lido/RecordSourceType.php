<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class RecordSourceType implements \Sabre\Xml\XmlSerializable
{
    /**
     * @var string
     */
    public $legalBodyID;
    /**
     * @var string
     */
    public $legalBodySource;
    /**
     * @var string
     */
    public $legalBodyType;
    /**
     * @var AppellationValueType
     */
    public $legalBodyName;
    /**
     * @var string
     */
    public $legalBodyLink;

    /**
     * RecordSourceType constructor.
     * @param string $legalBodyID
     * @param string $legalBodySource
     * @param string $legalBodyType
     * @param AppellationValueType $legalBodyName
     * @param string $legalBodyLink
     */
    public function __construct(string $legalBodyID, string $legalBodySource, string $legalBodyType, AppellationValueType $legalBodyName, string $legalBodyLink)
    {
        $this->legalBodyID = $legalBodyID;
        $this->legalBodySource = $legalBodySource;
        $this->legalBodyType = $legalBodyType;
        $this->legalBodyName = $legalBodyName;
        $this->legalBodyLink = $legalBodyLink;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            'name'=>'lido:recordSource',
            'value'=>[
                [
                    'name'=>'lido:legalBodyID',
                    'attributes'=>[

                        'lido:type'=>$this->legalBodyType
                    ],
                    'value'=>$this->legalBodyID
                ],
                [
                    'name'=>'lido:legalBodyName',
                    'value'=>$this->legalBodyName
                ],
                [
                    'name'=>'lido:legalBodyWeblink',
                    'value'=>$this->legalBodyLink
                ]
            ]
        ]);
    }
}