<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class ObjectWorkTypeType implements \Sabre\Xml\XmlSerializable
{
    public $terms = [];

    /**
     * ObjectWorkTypeType constructor.
     * @param string[] $terms
     */
    public function __construct(array $terms)
    {
        $this->terms = $terms;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $content = [
            'name'=>'lido:objectWorkType',
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