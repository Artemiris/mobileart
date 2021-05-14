<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DescriptiveMetadataType implements XmlSerializable
{
    public $lang;

    /**
     * @var ObjectWorkTypeType[] $objectWorkTypes content of lido:objectWorkType
     */
    public $objectWorkTypes = [];

    /**
     * @var ObjectClassificationType[] $classifications content of lido:classification
     */
    public $classifications = [];

    /**
     * @var ObjectTitleSetType[] $titleSets
     */
    public $titleSets = [];

    /**
     * @var ObjectDescriptionSetType[] $descriptionSets
     */
    public $descriptionSets = [];

    /**
     * @var EventType[] $events
     */
    public $events = [];

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $content = [
            'name'=>'lido:descriptiveMetadata',
            'attributes'=>[
                'xml:lang'=>$this->lang
            ],
            'value'=>[
                [//objectClassificationWrap
                    'name'=>'lido:objectClassificationWrap',
                    'value'=>[
                        [
                            'name'=>'lido:objectWorkTypeWrap',
                            'value'=>$this->objectWorkTypes
                        ],
                        [
                            'name'=>'lido:classificationWrap',
                            'value'=>$this->classifications
                        ]
                    ]
                ],
                [//objectIdentificationWrap
                    'name'=>'lido:objectIdentificationWrap',
                    'value'=>[
                        [
                            'name'=>'lido:titleWrap',
                            'value'=>$this->titleSets
                        ],
                        [
                            'name'=>'lido:objectDescriptionWrap',
                            'value'=> $this->descriptionSets
                        ]
                    ]
                ],
                [//eventWrap
                    'name'=>'lido:eventWrap',
                    'value'=> $this->events
                ]
            ]
        ];

        $writer->write($content);
    }
}