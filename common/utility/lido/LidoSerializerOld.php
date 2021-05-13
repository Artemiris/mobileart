<?php


namespace common\utility\lido;

use common\models\Petroglyph;
use Sabre\Xml\Writer;

class LidoSerializerOld implements \Sabre\Xml\XmlSerializable
{
    const LNS = '{http://www.lido-schema.org}';
    public $value;

    /**
     * LidoRootElement constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->writeAttribute('xsi:schemaLocation', 'http://www.lido-schema.org http://www.lido-schema.org/schema/v1.0/lido-v1.0.xsd');
        $writer->write($this->value);
    }

    public static function getLidoReadyFromPetroglyph($id) : array
    {
        $p = Petroglyph::find()->where(['id'=>$id])->one();
        $title = $p->name;
        return [
            [
                'name'=>self::LNS.'lidoRecID',
                'attributes'=>[
                    self::LNS.'source'=>'IS Rockart of Siberia',
                    self::LNS.'type'=>'local'
                ],
                'value'=>empty($p->index) ? $id : $p->index,
            ],
            [
                'name'=>self::LNS.'descriptiveMetadata',
                'attributes'=>[
                    'xml:lang'=>'en'
                ],
                'value'=>[
                    [
                        'name'=>self::LNS.'objectClassificationWrap',
                        'value'=>[
                            [
                                'name'=>self::LNS.'objectWorkTypeWrap',
                                'value'=>[
                                    [
                                        'name'=>self::LNS.'objectWorkType',
                                        'value'=>[
                                            [
                                                'name'=>self::LNS.'term',
                                                'value'=>'petroglyph'
                                            ],
                                            [
                                                'name'=>self::LNS.'term',
                                                'attributes'=>[
                                                    self::LNS.'addedSearchTerm'=>'yes',
                                                ],
                                                'value'=>'rock art'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'name'=>self::LNS.'objectIdentificationWrap',
                        'value'=>[
                            [
                                'name'=>self::LNS.'titleWrap',
                                'value'=>[
                                    [
                                        'name'=>self::LNS.'titleSet',
                                        'value'=>[
                                            [
                                                'name'=>self::LNS.'appellationValue',
                                                'attributes'=>[
                                                    self::LNS.'pref'=>'preferred'
                                                ],
                                                'value'=>$title
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ]
                ]
            ],
            [
                'name'=>self::LNS.'administrativeMetadata',
                'attributes'=>[
                    'xml:lang'=>'en'
                ],
                'value'=>[
                    [
                        'name'=>self::LNS.'recordWrap',
                        'value'=>[
                            [
                                'name'=>self::LNS.'recordID',
                                'attributes'=>[
                                    self::LNS.'type'=>'local'
                                ],
                                'value'=>$id
                            ],
                            [
                                'name'=>self::LNS.'recordType',
                                'value'=>[
                                    [
                                        'name'=>self::LNS.'term',
                                        'value'=>'single object'
                                    ]
                                ]
                            ],
                            [
                                'name'=>self::LNS.'recordSource',
                                'value'=>[
                                    [
                                        'name'=>self::LNS.'legalBodyID',
                                        'attributes'=>[
                                            self::LNS.'type'=>'URI',
                                            self::LNS.'source'=>'license source?'
                                        ],
                                        'value'=>'license link?'
                                    ],
                                    [
                                        'name'=>self::LNS.'legalBodyName',
                                        'value'=>[
                                            [
                                                'name'=>self::LNS.'appellationValue',
                                                'value'=>'IS Rock Art of Siberia'
                                            ]
                                        ]
                                    ],
                                    [
                                        'name'=>self::LNS.'legalBodyWeblink',
                                        'value'=>'http://rockart.artemiris.org'
                                    ]
                                ]
                            ]
                        ],
                    ]
                ]
            ]
        ];
    }
}