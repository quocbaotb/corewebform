<?php
class Core
{
    protected $vSession = NULL;
    protected $pSqlTable = NULL;
    protected $ucRequestHtml = NULL;
    protected $fBuilderAID = NULL;
    protected $fCheckLogin = NULL;
    protected $fString = NULL;
    protected $fXml = NULL;
    protected $fGetLanguage = NULL;

    public function vSession(){
        require_once('Session/Session.php');
        RETURN $this->vSession = new Session();
    }

    public function pSqlTable($IsSystem){
        require_once('Functions/pSqlTable.php');
        RETURN $this->pSqlTable = new pSqlTable($IsSystem);
    }

    public function ucRequestHtml(){
        require_once('Control/ucRequestHtml.php');
        RETURN $this->ucRequestHtml = new ucRequestHtml();
    }

    public function fBuilderAID(){
        require_once ('Functions/fBuilder.php');
        RETURN $this->fBuilderAID = new fBuilder();
    }

    public function fCheckLogin(){
        require_once ('Functions/fCheckLogin.php');
        RETURN $this->fCheckLogin = new fCheckLogin();
    }

    public function fString(){
        require_once ('Functions/fString.php');
        RETURN $this->fString = new fString();
    }

    public function fXml($LinkXml){
        require_once ('Functions/fXml.php');
        RETURN $this->fXml = new fXml($LinkXml);
    }

    public function fGetLanguage(){
        require_once ('Functions/fGetLanguage.php');
        RETURN $this->fGetLanguage = new fGetLanguage();
    }


}