<?php

class fGetLanguage
{
    /**
     * @return false|mixed|SimpleXMLElement: Lấy Language được lưu trong XML
     */

    private function GetServerLanguage(){
        $vSession = new Session();
        $fXml = new fXml('../../../../Core/Xml/Databases.xml');
        $CheckLanguage = $vSession->GetSession(oWorkManager::_Language);
        if (!empty($CheckLanguage)){
            RETURN $CheckLanguage;
        }else{
            RETURN $fXml->GetXmlDatabase('Database', 'Language');
        }
    }

    /**
     * @return string: Chuyển đổi kiểm dữ liệu thành Name
     */
    public function GetLanguage(){
        switch ($this->GetServerLanguage()) {
            case 'lang=cn' :
                RETURN 'NameChinese';
            default :
                RETURN 'NameVietnamese';
        }
    }

}