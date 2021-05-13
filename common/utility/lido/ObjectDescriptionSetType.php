<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class ObjectDescriptionSetType implements \Sabre\Xml\XmlSerializable
{
    /**
     * @var string $id
     */
    public $id;

    /**
     * @var string $value
     */
    public $value;

    /**
     * @var string $type
     */
    public $type;

    /**
     * ObjectDescriptionSetType constructor.
     * @param string $value
     */
    public function __construct(string $id, string $value, string $type)
    {
        $this->id = $id;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            'name'=>'lido:objectDescriptionSet',
            'value'=>[
                [
                    'name'=>'lido:descriptiveNoteID',
                    'attributes' => [
                        'lido:type'=>$this->type
                    ],
                    'value'=>$this->id
                ],
                [
                    'name'=>'lido:descriptiveNoteValue',
                    'value'=>$this->value
                ]
            ]
        ]);
    }
}