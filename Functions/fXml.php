<?php
namespace eBOSS\Functions;

class fXml
{
    private $vLinkXml;

    function __construct($LinkXml)
    {
        $this->vLinkXml = $LinkXml;
    }

    public function GetXmlDatabase($Element, $Child)
    {
        $xml = simplexml_load_file($this->vLinkXml);
        RETURN $xml->$Element[0]->$Child;
    }

}