<?php


namespace common\utility;

class XmlService extends \Sabre\Xml\Service
{
    public function initLidoMap()
    {
        $this->namespaceMap = [
            'http://www.lido-schema.org'=>'lido',
            'http://www.w3.org/2001/XMLSchema-instance'=>'xsi'
        ];
    }

    public function write(string $rootElementName, $value, string $contextUri = null)
    {
        $w = $this->getWriter();
        $w->openMemory();
        $w->contextUri = $contextUri;
        $w->setIndent(true);
        $w->startDocument('1.0', 'UTF-8');
        $w->writeElement($rootElementName, $value);

        return $w->outputMemory();
    }
}