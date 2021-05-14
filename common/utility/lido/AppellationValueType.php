<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class AppellationValueType implements \Sabre\Xml\XmlSerializable
{
    /**
     * @var string $lang
     */
    public $lang;

    /**
     * @var bool $preferred
     */
    public $preferred;

    /**
     * @var string $val
     */
    public $val;

    /**
     * ObjectTitleType constructor.
     * @param string $lang
     * @param bool $preferred
     * @param string $val
     */
    public function __construct(string $lang, bool $preferred, string $val)
    {
        $this->lang = $lang;
        $this->preferred = $preferred;
        $this->val = $val;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $content = [
            'name'=>'lido:appellationValue',
            'attributes'=>[
                'lido:pref'=>$this->preferred?'preferred':'alternate',
                'xml:lang'=>$this->lang
            ],
            'value'=>$this->val
        ];
        if(empty($this->lang)) unset($content['attributes']['xml:lang']);
        $writer->write($content);
    }
}