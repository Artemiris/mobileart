<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class ObjectClassificationType implements \Sabre\Xml\XmlSerializable
{
    public $type;
    public $terms = [];

    /**
     * ObjectClassificationType constructor.
     * @param string $type
     * @param string[] $terms
     */
    public function __construct(string $type, array $terms)
    {
        $this->type = $type;
        $this->terms = $terms;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $content = [
            'name'=>'lido:classification',
            'attributes'=>[
                'lido:type'=>$this->type
            ],
            'value'=>[]
        ];

        foreach ($this->terms as $term)
        {
            $content['value'][]=[
                'name'=>'lido:term',
                'value'=>$term
            ];
        }

        $writer->write($content);
    }
}