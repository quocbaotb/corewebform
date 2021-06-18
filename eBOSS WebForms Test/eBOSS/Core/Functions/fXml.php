<?php
require_once('iData.php');
require_once('iXml.php');

class fXml implements iData, iXml
{
    private $vLinkXml;

    function __construct($LinkXml)
    {
        $this->vLinkXml = $LinkXml;
    }

    /**
     * @param $Element: Tên XML
     * @param $Child: Tên XML con
     * @return false|SimpleXMLElement
     */
    public function GetXmlDatabase($Element, $Child)
    {
        $xml=simplexml_load_file($this->vLinkXml);
        RETURN $xml->$Element[0]->$Child;
    }

    public function CheckXML($TenXML)
    {
        $XmlDatabase = new SimpleXMLElement("../Xml/Databases.xml", null, true);
        $Element = $XmlDatabase->$TenXML[0];
        if (!$Element) {
            RETURN false;
        } else
            RETURN true;
    }

}