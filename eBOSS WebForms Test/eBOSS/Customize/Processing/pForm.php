<?php
class pForm
{
    private $vSqlTable;
    private $Language;
    private $vTableSysSectionItem;
    private $vSession;

    public function __construct($Language){
        $this->Language = $Language;
        $this->vSqlTable = new pSqlTable(true);
        $this->vSession = new Session();
        $this->vTableSysSectionItem = $this->vSqlTable->TableSelect(oWorkManager::scSectionItem, $Language);
    }

    public function Translate($ColumnName){
        $Result = $this->vSqlTable->GetValue($this->vTableSysSectionItem, oWorkManager::coSectionItemID, $ColumnName, oWorkManager::coSectionItemName);
        RETURN $Result;
    }

}