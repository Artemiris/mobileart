<?php


namespace common\utility;

class XmlService extends \Sabre\Xml\Service
{
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