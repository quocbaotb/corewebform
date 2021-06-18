<?php

class pWorkManager
{
    private $vLanguage;
    private $pSqlTable;
    private $vSession;

    public function __construct()
    {
        $Core = new Core();
        $fGetLanguage = $Core->fGetLanguage();
        $this->vLanguage = $fGetLanguage->GetLanguage();
        $Customize = new Customize($this->vLanguage);
        $this->pSqlTable = $Core->pSqlTable(false);
        $this->vSession = $Core->vSession();
        $Customize->oWorkManager();
    }

    private function SetTableEmployee()
    {
        return $this->pSqlTable->TableSelect(oWorkManager::scBasEmployeeInfo, $this->vLanguage);
    }

    public function GetEmployeeID()
    {
        $EmployeeAID = $this->vSession->GetSession(oWorkManager::_CurrentEmployeeAID);
        return $this->pSqlTable->GetValue($this->SetTableEmployee(), oWorkManager::coEmployeeAID, $EmployeeAID, oWorkManager::coEmployeeID);
    }

    public function GetEmployeeName()
    {
        $EmployeeAID = $this->vSession->GetSession(oWorkManager::_CurrentEmployeeAID);
        return $this->pSqlTable->GetValue($this->SetTableEmployee(), oWorkManager::coEmployeeAID, $EmployeeAID, oWorkManager::coEmployeeName);
    }

    private function SetTableMachine()
    {
        return $this->pSqlTable->TableSelect(oWorkManager::scBasMachineInfo, $this->vLanguage);
    }

    private function SetTableMachineMold()
    {
        return $this->pSqlTable->TableSelect(oWorkManager::scBasMoldInfo, $this->vLanguage);
    }

    private function SetTableMold(){
        RETURN $this->pSqlTable->TableSelect(oWorkManager::scListMold, $this->vLanguage);
    }

    //Lấy khuôn được lưu vào máy trước đó
    private function GetMachineStoreMoldA()
    {
        $MachineID = $this->vSession->GetSession(oWorkManager::_MachineID);
        return $this->pSqlTable->GetValue($this->SetTableMachine(), oWorkManager::coMachineID, $MachineID, oWorkManager::coStoreMoldAAID);
    }

    private function GetMachineStoreMoldB()
    {
        $MachineID = $this->vSession->GetSession(oWorkManager::_MachineID);
        return $this->pSqlTable->GetValue($this->SetTableMachine(), oWorkManager::coMachineID, $MachineID, oWorkManager::coStoreMoldBAID);
    }

    public function GetMoldAAID()
    {
        $StoreMoldA = $this->GetMachineStoreMoldA();
        $CurrentMoldAAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalAAID);
        $MoldAAID = !empty($StoreMoldA) ? $StoreMoldA : $CurrentMoldAAID;
        return $MoldAAID;
    }

    public function GetMoldBAID()
    {
        $StoreMoldB = $this->GetMachineStoreMoldB();
        $CurrentMoldBAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalBAID);
        $MoldBAID = !empty($StoreMoldB) ? $StoreMoldB : $CurrentMoldBAID;
        return $MoldBAID;
    }

    /**
     * @param $MoldTerminalAID : Mã AID của khuôn
     * @return mixed
     */
    public function GetMoldTerminalID($MoldTerminalAID)
    {
        return $this->pSqlTable->GetValue($this->SetTableMachineMold(), 'MoldAID', $MoldTerminalAID, 'MoldID');
    }

    public function GetMoldTerminalAID($MoldTerminalID)
    {
        return $this->pSqlTable->GetValue($this->SetTableMachineMold(), 'MoldID', $MoldTerminalID, 'MoldAID');
    }

    private function SetTableOperation()
    {
        return $this->pSqlTable->TableSelect(oWorkManager::scBasOperation, $this->vLanguage);
    }

    public function GetOperationName()
    {
        $CurrentOperationID = $this->vSession->GetSession(oWorkManager::_CurrentOperationCode);
        return $this->pSqlTable->GetValue($this->SetTableOperation(), oWorkManager::coOperationID, $CurrentOperationID, oWorkManager::coOperationName);
    }

    public function GetOperationGroup()
    {
        $CurrentOperationID = $this->vSession->GetSession(oWorkManager::_CurrentOperationCode);
        return $this->pSqlTable->GetValue($this->SetTableOperation(), oWorkManager::coOperationID, $CurrentOperationID, oWorkManager::coGroupOperation);
    }

    //Table CommandStage
    private function SetTableCommandStage()
    {
        return $this->pSqlTable->TableSelect(oWorkManager::scCommandStage, $this->vLanguage);
    }

    //List Mold dùng để Check
    public function GetListMold()
    {
        return $this->GetListMoldA() . ',' . $this->GetListMoldB();
    }

    public function CheckMoldTerminal($MoldTerminalID)
    {
        return in_array(strtoupper($MoldTerminalID), explode(',', $this->GetListMold()));
    }


    //Lấy thông tin của CommandStage
    private function GetCommandInfo($ColumnName){
        $TableCommandStage = $this->SetTableCommandStage();
        $CurrentCircictLoopItemAID = $this->vSession->GetSession(oWorkManager::_CurrentCirictLoopItemAID);
        RETURN $this->pSqlTable->GetValue($TableCommandStage, oWorkManager::coCirictLoopItemAID, $CurrentCircictLoopItemAID, $ColumnName);
    }

    public function GetCommandID(){
        RETURN $this->GetCommandInfo(oWorkManager::coCommandID);
    }

    public function GetLoopID(){
        RETURN $this->GetCommandInfo(oWorkManager::coLoopID);
    }

    public function GetProduceQty(){
        RETURN $this->GetCommandInfo(oWorkManager::coQty);
    }

    public function GetPlanAID(){
        RETURN $this->GetCommandInfo(oWorkManager::coPlanAID);
    }

    public function GetTerminalA(){
        RETURN $this->GetCommandInfo('TerminalA');
    }

    public function GetTerminalB(){
        RETURN $this->GetCommandInfo('TerminalB');
    }

    public function GetSetTerminalA(){
        RETURN $this->GetCommandInfo(oWorkManager::coSetTerminalA);
    }

    public function GetSetTerminalB(){
        RETURN $this->GetCommandInfo(oWorkManager::coSetTerminalB);
    }

    public function GetListMoldA(){
        $TableListMold = $this->SetTableMold();
        RETURN $this->pSqlTable->GetValue($TableListMold, oWorkManager::coTerminal, $this->GetTerminalA(), oWorkManager::coListMold);
    }

    public function GetListMoldB(){
        $TableListMold = $this->SetTableMold();
        RETURN $this->pSqlTable->GetValue($TableListMold, oWorkManager::coTerminal, $this->GetTerminalB(), oWorkManager::coListMold);
    }

}