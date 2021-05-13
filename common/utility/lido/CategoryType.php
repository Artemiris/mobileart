<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class CategoryType implements \Sabre\Xml\XmlSerializable
{
    public $concept_type;
    public $concept_value;

    /**
     * array
     * type = ['lang'=>'value']
     */
    public $terms = [];

    /**
     * CategoryType constructor.
     * @param $concept_type
     * @param $value
     * @param array $terms ['lang'=>'value']
     */
    public function __construct($concept_type, $value, array $terms)
    {
        $this->concept_type = $concept_type;
        $this->concept_value = $value;
        $this->terms = $terms;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $ns = LidoSerializer::NS;
        $category = [
            'name'=>$ns.'category',
            'value'=>[
                [
                    'name'=>$ns.'conceptID',
                    'attributes'=>[
                        $ns.'type' => $this->concept_type
                    ],
                    'value'=>$this->concept_value
                ]
            ]
        ];
        foreach ($this->terms as $term_lang=>$term_value) {
            $category['value'][]=[
                'name'=>$ns.'term',
                'attributes'=>[
                    'xml:lang'=>$term_lang
                ],
                'value'=>$term_value
            ];
        }
        $writer->write($category);
    }
}