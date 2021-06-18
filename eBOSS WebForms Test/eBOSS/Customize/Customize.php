<?php
class Customize
{
    private $vLanguage;
    protected $vStatus   = NULL;
    protected $pForm   = NULL;
    protected $oWorkManager = NULL;
    protected $oSysProgress = NULL;
    protected $pSysProgress = NULL;
    protected $pChangeForm = NULL;
    public function __construct($Language)
    {
        $this->vLanguage = $Language;
    }

    public function pForm(){
        require_once('Processing/pForm.php');
        RETURN $this->pForm = new pForm($this->vLanguage);
    }

    public function pStatus() {
        require_once('Processing/pStatus.php');
        RETURN $this->vStatus = new pStatus($this->vLanguage);
    }

    public function oWorkManager(){
        require_once('DesignerForms/oWorkManager.php');
        RETURN $this->oWorkManager = new oWorkManager();
    }

    public function oWorkManagerQuality(){
        require_once ('DesignerForms/oWorkManagerQuality.php');
        RETURN $this->oWorkManager = new oWorkManagerQuality();
    }

    public function pChangeForm(){
        require_once('Processing/pChangeForm.php');
        RETURN $this->pChangeForm = new pChangeForm();
    }

}