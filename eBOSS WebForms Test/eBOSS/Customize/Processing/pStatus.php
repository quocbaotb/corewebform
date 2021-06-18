<?php
class pStatus
{
    private $Language;
    private $vSqlTable;
    private $vSession;
    private $vTableStatus;
    private $vTableMachineMold;
    private $vTableListMold;
    private $vTableCommandStage;

    public $vStatus;
    public $vShowButtonContinue;
    public $vShowDialog;

    private $CurrentBarcodeCommand;

    private $CurrentCircictLoopItemAID;
    private $CurrentCommandID;
    Private $CurrentLoopID;
    Private $CurrentMachineID;
    Private $CurrentCommandQty;
    Private $CurrentProducedQty;
    private $CurrentSetTerminalA; //thả public để test
    private $CurrentSetTerminalB;

    public $vIsTerminalA;
    public $vIsTerminalB;

    private $IsCommandStage;

    private $vIsSubmit;

    private $vMoldStatusSID; // 1: Scan 1AA, 2: Scan 1DD, 3: Scan 1XX, 4: Scan 1YY

    public function __construct($Language)
    {
        $this->Language = $Language;
        $this->vSqlTable = new pSqlTable(false);
        $this ->vSession = new Session();
        $this -> vTableStatus = $this->vSqlTable->TableSelect(oWorkManager::scStatus, $this->Language);
        $this->vTableMachineMold = $this->vSqlTable->TableSelect(oWorkManager::scBasMoldInfo, $this->Language);
        $this->vTableCommandStage = $this->vSqlTable->TableSelect(oWorkManager::scCommandStage, $this->Language);
        $this->vTableListMold = $this->vSqlTable->TableSelect(oWorkManager::scListMold, $this->Language);
        $this->vStatus = $this->vSqlTable->GetValue($this->vTableStatus, oWorkManager::coStatusID, 'CommandStageStartScan', oWorkManager::coStatusName);
    }
    public function SetBarcodeCommand($CurrentBarcodeCommand){
        $this->CurrentBarcodeCommand = strtoupper($CurrentBarcodeCommand);
    }

    private function IsSubmit ($Boolean){
         $this->vIsSubmit = $Boolean;
        RETURN $Boolean;
    }

    private function SetTablePlanCommand(){
        $BarcodeScanner = str_replace(' ', '', $this->CurrentBarcodeCommand);
        RETURN $this->vSqlTable->TableSelect(oWorkManager::scPlanCommandInfo, $BarcodeScanner);
    }

    private function SetCommandStage(){
        $BarcodeScanner = str_replace(' ', '', $this->CurrentBarcodeCommand);
        $TablePlanCommandInfo = $this->vSqlTable->TableSelect(oWorkManager::scPlanCommandInfo, $BarcodeScanner);
        $this -> CurrentLoopID = trim(strstr($this->CurrentBarcodeCommand, ' '));
        $this-> CurrentCommandID = trim(substr($this->CurrentBarcodeCommand, 0, strlen($this->CurrentBarcodeCommand) - strlen(trim(strstr($this->CurrentBarcodeCommand, ' ')))));
        $this -> CurrentCircictLoopItemAID = !empty($TablePlanCommandInfo) ? $TablePlanCommandInfo[0]['CirictLoopItemAID'] : null;
        $this -> CurrentMachineID = !empty($TablePlanCommandInfo) ? $TablePlanCommandInfo[0]['MachineID'] : null;
        $this -> CurrentCommandQty = !empty($TablePlanCommandInfo) ? $TablePlanCommandInfo[0]['CommandQty'] : null;
        $this -> CurrentProducedQty = !empty($TablePlanCommandInfo) ? $TablePlanCommandInfo[0]['ProducedQty'] : null;
        $this->CurrentSetTerminalA = !empty($TablePlanCommandInfo) ? $TablePlanCommandInfo[0]['SetTerminalA'] : null;
        $this->CurrentSetTerminalB  = !empty($TablePlanCommandInfo) ? $TablePlanCommandInfo[0]['SetTerminalB'] : null;
    }

    /* Kiểm tra chế lệnh sản xuất trả về các ID Status*/
    private function CheckCommandStage(){
        $this->SetCommandStage();
        $CurrentMachineID = $this->vSession->GetSession(oWorkManager::_CurrentMachineID);
        if (empty($this->CurrentCircictLoopItemAID)) {
            $this ->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            RETURN 'CommandStageError';
        } else if ($this->CurrentProducedQty == $this->CurrentCommandQty) {
            $this ->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            RETURN 'CommandStageErrorQty';
        } else if ($this->CurrentMachineID <> $CurrentMachineID) {
            $this->vShowButtonContinue = '1';
            $this->vShowDialog = str_replace('{0}', '[' . trim($this->CurrentCommandID) . ']' . '[' . trim($this->CurrentLoopID) . ']', $this->vSqlTable->GetValue($this->vTableStatus, oWorkManager::coStatusID, 'ContinueUseCommandStage', oWorkManager::coStatusName));
            RETURN 'ContinueUseCommandStage';
        } else {
            $this ->vSession->SetSession(oWorkManager::_CurrentCirictLoopItemAID, $this->CurrentCircictLoopItemAID);
            RETURN 'CommandStageSuccessfull';
        }
    }

    /* Kiểm tra giá trị của khuôn đã nhập vào -- Chưa hoàn thiện */
    private function CheckMoldTerminal(){
        $CurrentCirictLoopItemAID = $this->vSession->GetSession(oWorkManager::_CurrentCirictLoopItemAID);
        $TemptTerminalA = $this->vSqlTable->GetValue($this->vTableCommandStage, 'CirictLoopItemAID', $CurrentCirictLoopItemAID, 'TerminalA');
        $TemptTerminalB = $this->vSqlTable->GetValue($this->vTableCommandStage, 'CirictLoopItemAID', $CurrentCirictLoopItemAID, 'TerminalB');
        $CheckMoldAAID = $this->vSqlTable->GetValue($this->vTableListMold, oWorkManager::coTerminal, $TemptTerminalA, 'ListMold');
        $CheckMoldBAID = $this->vSqlTable->GetValue($this->vTableListMold, oWorkManager::coTerminal, $TemptTerminalB, 'ListMold');
        $CheckListMold = $CheckMoldAAID . ',' . $CheckMoldBAID;
        $CurrentMoldTerminalAAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalAAID);
        $CurrentMoldTerminalBAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalBAID);
        $TextBoxMoldTerminalA = $this->vSqlTable->GetValue($this->vTableMachineMold, 'MoldAID', $CurrentMoldTerminalAAID, 'MoldID');
        $TextBoxMoldTerminalB = $this->vSqlTable->GetValue($this->vTableMachineMold, 'MoldAID', $CurrentMoldTerminalBAID, 'MoldID');
        $this->vIsTerminalA = in_array($TextBoxMoldTerminalA, explode(',', $CheckListMold));
        $this->vIsTerminalB = in_array($TextBoxMoldTerminalB, explode(',', $CheckListMold));
    }

    private function CheckSetCutTerminal()
    {
        $this->SetCommandStage();
        $this->CheckMoldTerminal();
        $CurrentMoldTerminalAAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalAAID);
        $CurrentMoldTerminalBAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalBAID);

        if ($this->CurrentSetTerminalA == 'P' && $this->CurrentSetTerminalB == 'P') {
            if (!empty($CurrentMoldTerminalAAID) || !empty($CurrentMoldTerminalBAID)) {
                $this->vMoldStatusSID = 2;
                return 'Scan[1DD]ChangeMoldA/B';
            } else {
                $this->vMoldStatusSID = 4;
                return 'NoMoldTerminalSuccessFull'; /* Return 1 giá trị tiếp tục thao tác */
            }

        } else if ($this->CurrentSetTerminalA == '6W' || $this->CurrentSetTerminalB == '6W') {
            if (!empty($CurrentMoldTerminalAAID) && !empty($CurrentMoldTerminalBAID)) {
                if (($this->vIsTerminalA == false) && ($this->vIsTerminalB == false)) {
                    $this->vMoldStatusSID = 2;
                    return 'Scan[1DD]ChangeMoldA/B';
                } else if ($this->vIsTerminalA == false) {
                    $this->vMoldStatusSID = 2;
                    return 'Scan[1DD]ChangeMoldA';
                } else if ($this->vIsTerminalB == false) {
                    $this->vMoldStatusSID = 2;
                    return 'Scan[1DD]ChangeMoldB';
                } else {
                    $this->vMoldStatusSID = 3;
                    return 'MoldTerminalSuccessFull';
                }
            } else {
                if (!empty($CurrentMoldTerminalAAID)) {
                    if ($this->vIsTerminalA == false) {
                        $this->vMoldStatusSID = 2;
                        return 'Scan[1DD]ChangeMoldA';
                    } else {
                        $this->vMoldStatusSID = 1;
                        return 'Scan[1AA]AddMoldB';
                    }
                } else if (!empty($CurrentMoldTerminalBAID)) {
                    if ($this->vIsTerminalB = false) {
                        $this->vMoldStatusSID = 2;
                        return 'Scan[1DD]ChangeMoldB';
                    } else {
                        $this->vMoldStatusSID = 1;
                        return 'Scan[1AA]AddMoldA';
                    }
                } else {
                    $this->vMoldStatusSID = 1;
                    return 'Scan[1AA]AddMoldA/B';
                }
            }
        } else {
            if (empty($CurrentMoldTerminalAAID) && empty($CurrentMoldTerminalBAID)) {
                $this->vMoldStatusSID = 1;
                RETURN 'Scan[1AA]AddMoldA/B'; //Lắp khuôn A hoặc khuôn B
            }else{
                if (!empty($CurrentMoldTerminalAAID)) {
                    if ($this->vIsTerminalA == false) {
                        $this->vMoldStatusSID = 2;
                        RETURN 'Scan[1DD]ChangeMoldA';
                    } else {
                        $this->vMoldStatusSID = 3;
                        RETURN 'MoldTerminalSuccessFull'; /*Add khuôn A hoặc khuôn B */
                    }
                } else{
                    if ($this->vIsTerminalB == false) {
                        $this->vMoldStatusSID = 2;
                        RETURN 'Scan[1DD]ChangeMoldB';
                    } else {
                        $this->vMoldStatusSID = 3;
                        RETURN 'MoldTerminalSuccessFull'; /*Add khuôn A hoặc khuôn B */
                    }
                }
            }
        }
    }

    private function CheckOperation1AA(){
        $this -> CheckSetCutTerminal();
        if ($this->vMoldStatusSID == 3){
            $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            RETURN 'BeforeChangeMold';
        } else if ($this->vMoldStatusSID == 4){
            $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            RETURN 'NoMoldTerminalSuccessFull';
        } else if ($this->vMoldStatusSID == 2) {
            $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            return 'Scan[1DD]ChangeMoldA/B';
        } else{
            $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '1AA');
            RETURN 'MoldStartChange';
        }
    }


    private function CheckOperation1YY(){
        $this -> CheckSetCutTerminal();
        if ($this->vMoldStatusSID == 4){
            $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '1YY');
            RETURN 'NoMoldStartSuccessfull';
        } else{
            $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            RETURN 'NoMoldStartError';
        }
    }

    private function CheckOperation1XX(){
        $this -> CheckSetCutTerminal();
        if ($this->vMoldStatusSID == 3){
            $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '1XX');
            RETURN 'MoldContinueSuccessful';
        } else{
            $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            RETURN 'MoldContinueError';
        }
    }

    private function CheckOperation1DD(){
        $CurrentMoldTerminalAAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalAAID);
        $CurrentMoldTerminalBAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalBAID);
        if (empty($CurrentMoldTerminalAAID) && empty($CurrentMoldTerminalBAID)){
            $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            RETURN 'MoldChangeError';
        }else{
            $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '1DD');
            RETURN 'MoldNoteRemove';
        }
    }

    private function CheckOperation1ZZ(){
        $CurrentMoldTerminalAAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalAAID);
        $CurrentMoldTerminalBAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalBAID);
        if (empty($CurrentMoldTerminalAAID) && empty($CurrentMoldTerminalBAID)){
            $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            RETURN 'MoldSaveError';
        }else{
            $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '1ZZ');
            RETURN 'SaveSuccessfull';
        }
    }

    private function Check4F(){
        $CurrentCirictLoopItemAID = $this->vSession->GetSession(oWorkManager::_CurrentCirictLoopItemAID);
        $TableQualityControl = $this->vSqlTable->TableSelect(oWorkManager::scQualityControl, $this->Language);
        $CurrentPlanAID = $this->vSqlTable->GetValue($this->vTableCommandStage, oWorkManager::coCirictLoopItemAID, $CurrentCirictLoopItemAID, oWorkManager::coPlanAID);
        $ColumnsQualityControl = array('0' => oWorkManager::coPlanAID, '1' => oWorkManager::coOperationID);
        $ValuesQualityControl = array('0' => $CurrentPlanAID, '1' => '4++');
        $CheckQualityControl = $this->vSqlTable->GetValues($TableQualityControl, $ColumnsQualityControl, $ValuesQualityControl, oWorkManager::coOperationID);
        RETURN !empty($CheckQualityControl);
    }

    private function CheckOperation2AA(){
        if ($this->Check4F()) {
            $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '2AA');
            RETURN'ProcessInputSuccessfull';
        } else {
            $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            RETURN 'Finish[4++]';
        }
    }

    private function CheckOperation2BB(){
        $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '2BB');
        RETURN 'MachineStopSuccessful';
    }

    private function CheckOperation2CC(){
        $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '2CC');
        RETURN 'ContinueWork';
    }

    private function CheckOperation2EE(){
    }

    private function CheckOperation2FF(){
    }

    private function CheckOperation2ZZ(){
        if ($this->Check4F()) {
            $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '2ZZ');
            RETURN 'CommandStageEnd';
        } else {
            $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            RETURN 'Finish[4++]';
        }
    }

    private function CheckOperation2WW(){
        if ($this->Check4F()) {
            $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '2WW');
            RETURN 'ProcessWorkShiftSuccessful';
        } else {
            $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            RETURN 'Finish[4++]';
        }
    }

    private function CheckOperation4B(){
        $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '4--');
        RETURN 'QCRecordStart';
    }

    private function Check4B(){
        $CurrentCirictLoopItemAID = $this->vSession->GetSession(oWorkManager::_CurrentCirictLoopItemAID);
        $TableQualityControl = $this->vSqlTable->TableSelect(oWorkManager::scQualityControl, $this->Language);
        $CurrentPlanAID = $this->vSqlTable->GetValue($this->vTableCommandStage, oWorkManager::coCirictLoopItemAID, $CurrentCirictLoopItemAID, oWorkManager::coPlanAID);
        $ColumnsQualityControl = array('0' => oWorkManager::coPlanAID, '1' => oWorkManager::coOperationID);
        $ValuesQualityControl = array('0' => $CurrentPlanAID, '1' => '4--');
        $CheckQualityControl = $this->vSqlTable->GetValues($TableQualityControl, $ColumnsQualityControl, $ValuesQualityControl, oWorkManager::coOperationID);
        RETURN !empty($CheckQualityControl);
    }

    private function CheckOperation4F()
    {
        if ($this->Check4B()) {
            $this->vSession->SetSession(oWorkManager::_CurrentOperationCode, '4++');
            return 'QCRecordEnd';
        } else {
            $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
            return 'QCScan4++Error';
        }
    }

    //Get Status
    public function  GetStatus($Status){
        $this->vStatus = $this->vSqlTable->GetValue($this->vTableStatus, oWorkManager::coStatusID, $Status, oWorkManager::coStatusName);
    }

    private function IsCommandStage(){
        $CheckCommandStage = $this->vSession->GetSession(oWorkManager::_CurrentCirictLoopItemAID);
        RETURN !empty($CheckCommandStage);
    }

    public function GetStatusCommandStage(){
        if ($this->CheckCommandStage() == 'CommandStageSuccessfull') {
            $this->GetStatus($this->CheckSetCutTerminal());
        } else {
            $this->vStatus = str_replace('{0}', '[' . trim($this->CurrentCommandID) . ']' . '[' . trim($this->CurrentLoopID) . ']', $this->vSqlTable->GetValue($this->vTableStatus, oWorkManager::coStatusID, $this->CheckCommandStage(), oWorkManager::coStatusName));
        }
    }

    public function  GetStatusOperationCode($OperationID)
    {
        if ($this->IsCommandStage()){
                switch (strtoupper($OperationID)) {
                    case '1AA':
                        $this->GetStatus($this->CheckOperation1AA());
                        break;
                    case '1DD':
                        $this->GetStatus($this->CheckOperation1DD());
                        break;
                    case '1XX':
                        $this->GetStatus($this->CheckOperation1XX());
                        break;
                    case '1YY':
                        $this->GetStatus($this->CheckOperation1YY());
                        break;
                    case '1ZZ':
                        $this->GetStatus($this->CheckOperation1ZZ());
                        break;
                    case '2AA':
                        $this->GetStatus($this->CheckOperation2AA());
                        break;
                    case '2BB':
                        $this->GetStatus($this->CheckOperation2BB());
                        break;
                    case '2CC':
                        $this->GetStatus($this->CheckOperation2CC());
                        break;
                    case '2EE':
                        $this->GetStatus($this->CheckOperation2EE());
                        break;
                    case '2FF':
                        $this->GetStatus($this->CheckOperation2FF());
                        break;
                    case '2WW':
                        $this->GetStatus($this->CheckOperation2WW());
                        break;
                    case '2ZZ':
                        $this->GetStatus($this->CheckOperation2ZZ());
                        break;
                    case '4--':
                        $this->GetStatus($this->CheckOperation4B());
                        break;
                    case '4++':
                        $this->GetStatus($this->CheckOperation4F());
                        break;
                    default:
                        $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
                        $this->GetStatus('OperationError');
                        break;
                }
            }else{
                $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
                $this->GetStatus('CommandStageCheckBefore');
            }
    }

    public function ExcuteContinue(){
        $this->GetStatus($this->CheckSetCutTerminal());

        $this->SetCommandStage();
        $this->vSession->SetSession(oWorkManager::_CurrentCirictLoopItemAID, $this->CurrentCircictLoopItemAID);

        $UpdateMachinePlanMain = new pSqlTable(false);
        $UpdateMachinePlanMain->SetTableName(oWorkManager::tbPlanMain);
        $UpdateMachinePlanMain->SetValue(oWorkManager::coProduceMachineID, $this->vSession->GetSession(oWorkManager::_CurrentMachineID));
        $UpdateMachinePlanMainWhere = oWorkManager::coCirictLoopItemAID . '=' . "'" . $this->CurrentCircictLoopItemAID . "'";
        $UpdateMachinePlanMain->TableUpdate($UpdateMachinePlanMainWhere);
    }

    private function UpdateMoldToMachine(){
        $TextBoxMoldTerminalAAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalAAID);
        $TextBoxMoldTerminalBAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalBAID);

        $UpdateTableMachine = new pSqlTable(false);
        $UpdateTableMachine->SetTableName(oWorkManager::tbMachineInfo);
        $UpdateTableMachine->SetValue(oWorkManager::coStoreMoldAAID, $TextBoxMoldTerminalAAID);
        $UpdateTableMachine->SetValue(oWorkManager::coStoreMoldBAID, $TextBoxMoldTerminalBAID);
        $Where = oWorkManager::coMachineID . '=' . "'" . $this->vSession->GetSession(oWorkManager::_CurrentMachineID) . "'";
        $UpdateTableMachine->TableUpdate($Where);
    }

    public function ExcuteChangeMold($IsMoldA, $IsMoldB){
        if ($IsMoldA == true && $IsMoldB == true) {
            $this-> vSession->DelSession(oWorkManager::_CurrentMoldTerminalAAID);
            $this-> vSession->DelSession(oWorkManager::_CurrentMoldTerminalBAID);
            $this-> vSession->DelSession(oWorkManager::_CurrentOperationCode);
            $this->GetStatus('MoldChangeSuccessfull');
        } else if ($IsMoldA) {
            $this-> vSession->DelSession(oWorkManager::_CurrentMoldTerminalAAID);
            $this-> vSession->DelSession(oWorkManager::_CurrentOperationCode);
            $this->GetStatus('MoldChangeSuccessfull');
        } else if ($IsMoldB){
            $this-> vSession->DelSession(oWorkManager::_CurrentMoldTerminalBAID);
            $this-> vSession->DelSession(oWorkManager::_CurrentOperationCode);
            $this->GetStatus('MoldChangeSuccessfull');
        }

        $this->UpdateMoldToMachine();
    }


    public function ExcuteRepair($EmployeeRepairAID, $RepairTime){
        $CurrentCirictLoopItemAID = $this->vSession->GetSession(oWorkManager::_CurrentCirictLoopItemAID);
        $CurrentPlanAID = $this->vSqlTable->GetValue($this->vTableCommandStage, oWorkManager::coCirictLoopItemAID, $CurrentCirictLoopItemAID, oWorkManager::coPlanAID);
        $CurrentEmployeeAID = $this->vSession->GetSession(oWorkManager::_CurrentEmployeeAID);
        $CurrentDate = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $CurrentRecordDate = $CurrentDate->format('yy/m/d H:i:s');
        $CurrentMachineID = $this->vSession->GetSession(oWorkManager::_MachineID);

        $TableRepair = new pSqlTable(false);
        $TableRepair->SetTableName(oWorkManager::tbPlanStop);
        $TableRepair->SetValue(oWorkManager::coStopAID, fBuilder::BuilderAID());
        $TableRepair->SetValue(oWorkManager::coPlanAID, $CurrentPlanAID);
        $TableRepair->SetValue(oWorkManager::coEmployeeRepairAID, $EmployeeRepairAID);
        $TableRepair->SetValue(oWorkManager::coEmployeeHandlerAID, $CurrentEmployeeAID);
        $TableRepair->SetValue(oWorkManager::coRecordDate, $CurrentRecordDate);
        $TableRepair->SetValue(oWorkManager::coRepairTime, $RepairTime);
        $TableRepair->SetValue(oWorkManager::coMachineID, $CurrentMachineID);
        $TableRepair->TableInsert();

        $this->GetStatus('MachineContinue');
        $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
    }

    public function ExcuteOperation($OperationID){
        $CurrentCirictLoopItemAID = $this->vSession->GetSession(oWorkManager::_CurrentCirictLoopItemAID);
        $CurrentPlanAID = $this->vSqlTable->GetValue($this->vTableCommandStage, oWorkManager::coCirictLoopItemAID, $CurrentCirictLoopItemAID, oWorkManager::coPlanAID);
        $CurrentEmployeeAID = $this->vSession->GetSession(oWorkManager::_CurrentEmployeeAID);
        $CurrentDate = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
        $CurrentRecordDate = $CurrentDate->format('yy/m/d H:i:s');
        $CurrentMachineID = $this->vSession->GetSession(oWorkManager::_MachineID);

        $TableOperation = new pSqlTable(false);
        $TableOperation->SetTableName(oWorkManager::tbOperation);
        $TableOperation->SetValue(oWorkManager::coOperationAID, fBuilder::BuilderAID());
        $TableOperation->SetValue(oWorkManager::coPlanAID, $CurrentPlanAID);
        $TableOperation->SetValue(oWorkManager::coOperationID, strtoupper($OperationID));
        $TableOperation->SetValue(oWorkManager::coRecordDate, $CurrentRecordDate);
        $TableOperation->SetValue(oWorkManager::coEmployeeHandlerAID, $CurrentEmployeeAID);
        $TableOperation->SetValue(oWorkManager::coMachineID, $CurrentMachineID);
        $TableOperation->TableInsert();
    }

    public function Excute1ZZ(){
        $TextBoxMoldTerminalAAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalAAID);
        $TextBoxMoldTerminalBAID = $this->vSession->GetSession(oWorkManager::_CurrentMoldTerminalBAID);
        $CurrentMachineID = $this->vSession->GetSession(oWorkManager::_MachineID);
        $CurrentCirictLoopItemAID = $this->vSession->GetSession(oWorkManager::_CurrentCirictLoopItemAID);
        $CurrentPlanAID = $this->vSqlTable->GetValue($this->vTableCommandStage, oWorkManager::coCirictLoopItemAID, $CurrentCirictLoopItemAID, oWorkManager::coPlanAID);

        $UpdateTableStoreMold = new pSqlTable(false);
        $UpdateTableStoreMold->SetTableName(oWorkManager::tbMachineInfo);
        $UpdateTableStoreMold->SetValue(oWorkManager::coStoreMoldAAID, $TextBoxMoldTerminalAAID);
        $UpdateTableStoreMold->SetValue(oWorkManager::coStoreMoldBAID, $TextBoxMoldTerminalBAID);
        $Where = oWorkManager::coMachineID . '=' . "'" . $CurrentMachineID . "'";
        $UpdateTableStoreMold->TableUpdate($Where);

        $UpdateTablePlanMain = new pSqlTable(false);
        $UpdateTablePlanMain->SetTableName(oWorkManager::tbPlanMain);
        $UpdateTablePlanMain->SetValue(oWorkManager::coMoldTermialAAID, $TextBoxMoldTerminalAAID);
        $UpdateTablePlanMain->SetValue(oWorkManager::coMoldTermialBAID, $TextBoxMoldTerminalBAID);
        $WherePlanMain = oWorkManager::coPlanAID . '=' . "'" . $CurrentPlanAID . "'";
        $UpdateTablePlanMain->TableUpdate($WherePlanMain);
    }

    public function Excute2ZZ($CurrentProduceQty){
        $CurrentCirictLoopItemAID = $this->vSession->GetSession(oWorkManager::_CurrentCirictLoopItemAID);
        $CurrentPlanAID = $this->vSqlTable->GetValue($this->vTableCommandStage, oWorkManager::coCirictLoopItemAID, $CurrentCirictLoopItemAID, oWorkManager::coPlanAID);

        $UpdateQty = new pSqlTable(false);
        $UpdateQty->SetTableName(oWorkManager::tbPlanMain);
        $UpdateQty->SetValue('ProducedQty', $CurrentProduceQty);
        $Where = oWorkManager::coPlanAID . '=' . "'" . $CurrentPlanAID . "'";
        $UpdateQty->TableUpdate($Where);

        $this->vSession->DelSession(oWorkManager::_CurrentCirictLoopItemAID);
        $this->vSession->DelSession(oWorkManager::_CurrentOperationCode);
    }

    public function SetMoldTerminalID($TerminalID){

    }


}