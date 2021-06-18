<?php
$Core = new Core();
$vSession = $Core->vSession();
$vSqlTable = $Core->pSqlTable(false);
$Core->fBuilderAID();

#Ngôn ngữ hiển thị WebForm
switch ($_SESSION['WorkManager.Language']) {
    case 'lang=vi':
        $CurrentLanguage = 'NameVietnamese';
        break;
    case 'lang=cn' :
        $CurrentLanguage = 'NameChinese';
        break;
    default :
        $CurrentLanguage = 'NameVietnamese';
}

if (isset($_POST['ButtonHiddenLogOut'])) {
    session_unset();
    header('Location: ../../../../index.php');
    exit();
}

$Customize = new Customize($CurrentLanguage);
$Customize->oWorkManager();
$vProcessForm = $Customize->pForm();
$fString = $Core->fString();

#@Khu vực phiên dịch
$MachineWorkManager = $vProcessForm->Translate('MachineWorkManager');
$LogOut = $vProcessForm->Translate('LogOut');
$BarcodeScanner = $vProcessForm->Translate('BarcodeScanner');
$CurrentTarget = $vProcessForm->Translate('CurrentTarget');
$CurrentCount = $vProcessForm->Translate('CurrentCount');
$Different = $vProcessForm->Translate('Different');
$KnefCutCount = $vProcessForm->Translate('KnefCutCount');
$MachineID = $vProcessForm->Translate('MachineID');
$TitleDate = $vProcessForm->Translate('Date');
$Employee = $vProcessForm->Translate('Employee');
$TabControlMachineOperation = $vProcessForm->Translate('MachineOperation');
$TabControlRemoveMold = $vProcessForm->Translate('RemoveMold');
$TabControlQualityControl = $vProcessForm->Translate('OperationControl');
$TabControlRepairMachine = $vProcessForm->Translate('RemodelingWork');
$Operation = $vProcessForm->Translate('Operation');
$HandlerAID = $vProcessForm->Translate('HandlerAID');
$CommandID = $vProcessForm->Translate('CommandID');
$LoopID = $vProcessForm->Translate('LoopID');
$ProductQty = $vProcessForm->Translate('ProductQty');
$MoldTerimalA = $vProcessForm->Translate('MoldTerimalA');
$TerminalA = $vProcessForm->Translate('TerminalA');
$MoldTerimalB = $vProcessForm->Translate('MoldTerimalB');
$TerminalB = $vProcessForm->Translate('TerminalB');
$MoldAndTermial = $vProcessForm->Translate('MoldAndTermial');
$MachineMoldTerimalA = $vProcessForm->Translate('MachineMoldTerimalA');
$MachineMoldTerimalB = $vProcessForm->Translate('MachineMoldTerimalB');
$GroupMoldOfTermial = $vProcessForm->Translate('GroupMoldOfTermial');
$RemoveMoldA = $vProcessForm->Translate('RemoveMoldA');
$RemoveMoldB = $vProcessForm->Translate('RemoveMoldB');
$Remove = $vProcessForm->Translate('Remove');
$GroupQC = $vProcessForm->Translate('GroupQC');
$Length = $vProcessForm->Translate('Length');
$PeeledA = $vProcessForm->Translate('TermialAPeeled');
$Pressing = $vProcessForm->Translate('Pressing');
$FHeight = $vProcessForm->Translate('FrontHeight');
$FWidth = $vProcessForm->Translate('FrontWidth');
$BHeight = $vProcessForm->Translate('BackHeight');
$BWidth = $vProcessForm->Translate('BackWidth');
$PeeledB = $vProcessForm->Translate('TermialBPeeled');
$Save = $vProcessForm->Translate('Save');
$Remodeler = $vProcessForm->Translate('Remodeler');
$MachineMoldID = $vProcessForm->Translate('MachineMoldID');
$TypeMachine = $vProcessForm->Translate('Machine/Mold/Crimping');
$RemodelingTime = $vProcessForm->Translate('RemodelingTime');
$ProducedQty = $vProcessForm->Translate('ProducedQty');
$UnProduceQty = $vProcessForm->Translate('UnProduceQty');
$Continue = $vProcessForm->Translate('Continue');

//Xử lý biến Login
$CurrentMachineID = $_SESSION[oWorkManager::_MachineID];
$CurrentEmployeeAID = $_SESSION[oWorkManager::_CurrentEmployeeAID];
$CurrentDate = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
$CurrentRecordDate = $CurrentDate->format('yy/m/d H:i:s');

//Lấy tên nhân viên
$SelectCommandEmployee = "SELECT dbo.GetWebEmployeeInfo('@EmployeeAID', '@Language') AS EmployeeInfo";
$ParmetersEmployee = array('@EmployeeAID', '@Language');
$ValuesEmployee = array($CurrentEmployeeAID, $CurrentLanguage);
$TableEmployee = $vSqlTable->TableSelectParmeter($SelectCommandEmployee, $ParmetersEmployee, $ValuesEmployee);
$StringEmployee = explode(',', $TableEmployee[0]['EmployeeInfo']);
$TextBoxEmployeeID = $StringEmployee[0];
$TextBoxNameEmployee = $StringEmployee[1];
$TableEmployeeInfo = $vSqlTable->TableSelect(oWorkManager::scBasEmployeeInfo, $CurrentLanguage);

#@Khởi tạo biến chạy Web Barcode
$SelectCommandBarcode = "SELECT        ResultID, ResultMessage, CommandAID, CirictLoopItemAID, PlanAID, MachineID, ProducedQty, CommandID, CommandQty, LoopID, MaterialAIDTerminalA, MaterialAIDTerminalB, SetTerminalA, SetTerminalB, SetCut, 
                                                 OperationID, OperationName, TabControl AS GroupOperationID, MaterialIDTerminalA, MaterialIDTerminalB, IsNeedConfirmed
                        FROM            dbo.GetWebBacodeScannerResult('@BarcodeValue', '@Language', '@MachineID', '@CirictLoopItemAID')";
$Parmeters = array('@BarcodeValue', '@Language', '@MachineID', '@CirictLoopItemAID');

//Lấy giá trị Barcode tạm thời thông qua Scan
$CurrentBarcodeScanner = isset($_POST['TextBoxBarcodeScanner']) ? $fString->BuildBarcode($_POST['TextBoxBarcodeScanner']) : null;

//Lấy giá trị đơn lệnh được scan trước khi scan operation
$CircictLoopItemAID = $_SESSION[oWorkManager::_CurrentCirictLoopItemAID] ?? null;
$Values = array($CurrentBarcodeScanner, $CurrentLanguage, $CurrentMachineID, $CircictLoopItemAID);

//Lấy ra được table sau khi so sánh Barcode
$TabeCheckBarcode = $vSqlTable->TableSelectParmeter($SelectCommandBarcode, $Parmeters, $Values);

//Lấy thông tin máy
$SelectCommandMachine = "SELECT        MachineID, CommandQty, ProducedQty, UnProducedQty, StoreMoldAAID, StoreMoldIDA, StoreMoldBAID, StoreMoldIDB
                            FROM            dbo.GetProduceMachineInfoWeb('@MachineID')";
$TableMachine = $vSqlTable->TableSelectParmeter($SelectCommandMachine, '@MachineID', $CurrentMachineID);
$IsNeedConfirmed = !empty($TabeCheckBarcode) ? $TabeCheckBarcode[0]['IsNeedConfirmed'] : 0;
$DialogConfirmed = !empty($TabeCheckBarcode) ? $TabeCheckBarcode[0]['ResultMessage'] : 0;


if (isset($TabeCheckBarcode[0]['CirictLoopItemAID']))
    $_SESSION[oWorkManager::_CurrentCirictLoopItemAIDictLoopItemAID] = $TabeCheckBarcode[0]['CirictLoopItemAID'];

$CurrentCirictLoopItemAID = $_SESSION[oWorkManager::_CurrentCirictLoopItemAID] ?? null;

$ParametersCommandInfo = array('@CirictLoopItemAID', '@IsContinue');
// Xử lý trường hợp khác máy
if ($IsNeedConfirmed === null) {
    $ValuesCommandInfo = array($CurrentCirictLoopItemAID, 1);
} else {
    $ValuesCommandInfo = array($CurrentCirictLoopItemAID, isset($_POST['ButtonContinue']));
}

//Lấy thông tin mã chế lệnh
$TableCommandInfo = $vSqlTable->TableSelectParmeter(oWorkManager::scPlanCommandInfo, $ParametersCommandInfo, $ValuesCommandInfo);
$CurrentStatusBarcode = !empty($TabeCheckBarcode) ? $TabeCheckBarcode[0]['ResultMessage'] : null;
if (!empty($CurrentStatusBarcode))
    $_SESSION[oWorkManager::_CurrentStatus] = $CurrentStatusBarcode;

// Xử lý Operation
$CurrentOperationIDCommand = !empty($TabeCheckBarcode) ? $TabeCheckBarcode[0]['OperationID'] : null;
$_SESSION[oWorkManager::_CurrentTabControl] = !empty($TabeCheckBarcode) ? $TabeCheckBarcode[0]['GroupOperationID'] : 1;
$OperationNameCommand = !empty($TabeCheckBarcode) ? $TabeCheckBarcode[0]['OperationName'] : null;

$CheckSetTerminalA = !empty($TableCommandInfo) ? $TableCommandInfo[0]['SetTerminalA'] : null;
$CheckSetTerminalB = !empty($TableCommandInfo) ? $TableCommandInfo[0]['SetTerminalB'] : null;
//$CurrentCirictLoopItemAID = !empty($TabeCheckBarcodeScanner) ? $TabeCheckBarcodeScanner[0]['CirictLoopItemAID'] : null;
$TextBoxMoldTerminalAAID = !empty($TableCommandInfo) ? $TableCommandInfo[0]['MaterialAIDTerminalA'] : null;
$TextBoxMoldTerminalBAID = !empty($TableCommandInfo) ? $TableCommandInfo[0]['MaterialAIDTerminalB'] : null;
$TextBoxCommandID = !empty($TableCommandInfo) ? $TableCommandInfo[0]['CommandID'] : null;
$TextBoxLoopID = !empty($TableCommandInfo) ? $TableCommandInfo[0]['LoopID'] : null;
$CurrentPlanAID = !empty($TableCommandInfo) ? $TableCommandInfo[0]['PlanAID'] : null;
$TextBoxTerminalA = !empty($TableCommandInfo) ? $TableCommandInfo[0]['MaterialIDTerminalA'] : null;
$TextBoxTerminalB = !empty($TableCommandInfo) ? $TableCommandInfo[0]['MaterialIDTerminalB'] : null;
$TextBoxSetTerminalA = !empty($TableCommandInfo) ? $TableCommandInfo[0]['SetTerminalA'] : null;
$TextBoxSetTerminalB = !empty($TableCommandInfo) ? $TableCommandInfo[0]['SetTerminalB'] : null;
$TextBoxProductQty = !empty($TableCommandInfo) ? $TableCommandInfo[0]['CommandQty'] : 0;
#END

// List lấy thông tin tất cả khuôn thuộc mã barcode đã scan --
    $SelectCommandGetListMold = "SELECT dbo.GetListMoldFromTerminal('@TextBoxMoldTerminalAID') AS ListMold";
$GetListMoldA = $vSqlTable->TableSelectParmeter($SelectCommandGetListMold, '@TextBoxMoldTerminalAID', $TextBoxMoldTerminalAAID);
$GetListMoldB = $vSqlTable->TableSelectParmeter($SelectCommandGetListMold, '@TextBoxMoldTerminalAID', $TextBoxMoldTerminalBAID);

$CurrentLisMoldTerminalA = !empty($GetListMoldA) ? $GetListMoldA[0]['ListMold'] : null;
$CurrentLisMoldTerminalB = !empty($GetListMoldB) ? $GetListMoldB[0]['ListMold'] : null;
#@Thao tác với Database để lấy ra PlanAID
$TablePlanMain = $vSqlTable->TableSelectParmeter(oWorkManager::scPlanMain, '@PlanAID', $CurrentPlanAID);
$TextBoxProducedQty = !empty($TablePlanMain) ? $TablePlanMain[0]['ProducedQty'] : 0;
$TextBoxUnProduceQty = $TextBoxProductQty - $TextBoxProducedQty;
//Khu vực Insert
function UpdatePlanMain($PlanAID, $StatusID, $ProducedQty = null, $MoldTerminalAAID = null, $MoldTerminalBAID = null)
{
    $UpdateTablePlanMain = new pSqlTable(false);
    $UpdateTablePlanMain->SetTableName(oWorkManager::tbPlanMain);
    if (!empty($ProducedQty))
        $UpdateTablePlanMain->SetValue(oWorkManager::coProducedQty, $ProducedQty);
    if (!empty($MoldTerminalAAID))
        $UpdateTablePlanMain->SetValue(oWorkManager::coMoldTermialAAID, $MoldTerminalAAID);
    if (!empty($MoldTerminalBAID))
        $UpdateTablePlanMain->SetValue(oWorkManager::coMoldTermialBAID, $MoldTerminalBAID);
    $UpdateTablePlanMain->SetValue(oWorkManager::coStatusID, $StatusID);
    $WherePlanMain = oWorkManager::coPlanAID . '=' . "'$PlanAID'";
    return $UpdateTablePlanMain->TableUpdate($WherePlanMain);
}

$CurrentProduceQty = isset($_POST['CurrentProduceQty']) ? (float)$_POST['CurrentProduceQty'] : '';
if (isset($_POST['CurrentProduceQty'])) {
    if ($CurrentProduceQty <= $TextBoxUnProduceQty) {
        $TextBoxProducedQty = (float)$TextBoxProducedQty + $CurrentProduceQty;
        UpdatePlanMain($CurrentPlanAID, '02', $TextBoxProducedQty);
    } else {
        $CurrentProduceQty = '';
    }
}
$TextBoxUnProduceQty = $TextBoxProductQty - $TextBoxProducedQty;

if (isset($_POST['ButtonContinue'])) {
    $UpdateMachinePlanMain = new pSqlTable(false);
    $UpdateMachinePlanMain->SetTableName(oWorkManager::tbPlanMain);
    $UpdateMachinePlanMain->SetValue(oWorkManager::coProduceMachineID, $CurrentMachineID);
    $UpdateMachinePlanMainWhere = oWorkManager::coCirictLoopItemAID . '=' . "'" . $CurrentCirictLoopItemAID . "'";
    $UpdateMachinePlanMain->TableUpdate($UpdateMachinePlanMainWhere);
}

if (isset($CurrentOperationIDCommand)) {
    $InsertTableOperation = new pSqlTable(false);
    $InsertTableOperation->SetTableName(oWorkManager::tbOperation);
    $InsertTableOperation->SetValue(oWorkManager::coOperationAID, fBuilder::BuilderAID());
    $InsertTableOperation->SetValue(oWorkManager::coPlanAID, $CurrentPlanAID);
    $InsertTableOperation->SetValue(oWorkManager::coOperationID, strtoupper($CurrentOperationIDCommand));
    $InsertTableOperation->SetValue(oWorkManager::coRecordDate, $CurrentRecordDate);
    $InsertTableOperation->SetValue(oWorkManager::coEmployeeHandlerAID, $CurrentEmployeeAID);
    $InsertTableOperation->SetValue(oWorkManager::coMachineID, $CurrentMachineID);
    $InsertTableOperation->TableInsert();
}

if (!empty($CurrentOperationIDCommand))
    $_SESSION[oWorkManager::_CurrentOperationCode] = $CurrentOperationIDCommand;

$OperationID = $_SESSION[oWorkManager::_CurrentOperationCode] ?? null;
$NumberLengths = $NumberLength = $_POST['NumberLength'] ?? null;
$NumberPeeledA = $NumberTermialAPeeled = $_POST['NumberPeeledA'] ?? null;
$NumberPressingA = $NumberTermialAPressing = $_POST['NumberPressingA'] ?? null;
$NumberFHeight = $NumberTermialAFrontHeight = $_POST['NumberFHeight'] ?? null;
$NumberFWidthA = $NumberTermialAFrontWidth = $_POST['NumberFWidthA'] ?? null;
$NumberBHeightA = $NumberTermialABackHeight = $_POST['NumberBHeightA'] ?? null;
$NumberBWidthA = $NumberTermialABackWidth = $_POST['NumberBWidthA'] ?? null;
$NumberPeeledB = $NumberTermialBPeeled = $_POST['NumberPeeledB'] ?? null;
$NumberPressingB = $NumberTermialBPressing = $_POST['NumberPressingB'] ?? null;
$NumberFHeightB = $NumberTermialBFrontHeight = $_POST['NumberFHeightB'] ?? null;
$NumberFWidthB = $NumberTermialBFrontWidth = $_POST['NumberFWidthB'] ?? null;
$NumberBHeightB = $NumberTermialBBackHeight = $_POST['NumberBHeightB'] ?? null;
$NumberBWidthB = $NumberTermialBBackWidth = $_POST['NumberBWidthB'] ?? null;

//Lấy thông tin khuôn --
$SelectCommandMold = "SELECT        ResultID, ResultMessage, MoldTerminalAAID, MoldTerminalBAID, OperationID, OperationName
                        FROM            dbo.GetWebMoldTerminalCompareResult('@MoldTerminalAID', '@MoldTerminalBID', '@MachineID', '@CirictLoopItemAID', '@Language')";
$MoldA = $_POST['TextBoxMoldTerminalA'] ?? null;
$MoldB = $_POST['TextBoxMoldTerminalB'] ?? null;
//$CurrentMoldTerminalA = isset($_SESSION[oWorkManager::_CurrentMoldTerminalAID]) ? $_SESSION[oWorkManager::_CurrentMoldTerminalAID] : null;
$ParamtersCommandMold = array('@MoldTerminalAID', '@MoldTerminalBID', '@MachineID', '@CirictLoopItemAID', '@Language');
$ValuesCommandMold = array($MoldA, $MoldB, $CurrentMachineID, $CurrentCirictLoopItemAID, $CurrentLanguage);
//Lấy table chứa thông tin khuôn --
$TableCommandMold = $vSqlTable->TableSelectParmeter($SelectCommandMold, $ParamtersCommandMold, $ValuesCommandMold);

//Cập nhật thông tin table khuôn --
function UpdateMachineStoreMold($CurrentMachineID, $ColumnStoreMold, $MoldTerminalAID = null, $ColumStoreMoldB = null, $MoldTerminalBAID = null)
{
    $UpdateTableStoreMold = new pSqlTable(false);
    $UpdateTableStoreMold->SetTableName(oWorkManager::tbMachineInfo);
    $UpdateTableStoreMold->SetValue($ColumnStoreMold, $MoldTerminalAID);
    if (!empty($ColumStoreMoldB)) {
        $UpdateTableStoreMold->SetValue($ColumStoreMoldB, $MoldTerminalBAID);
    }
    $Where = oWorkManager::coMachineID . '=' . "'$CurrentMachineID'";
    $UpdateTableStoreMold->TableUpdate($Where);
}

if (!empty($TableCommandMold) && !empty($TableCommandMold[0]['MoldTerminalAAID'])) {
    UpdateMachineStoreMold($CurrentMachineID, oWorkManager::coStoreMoldAAID, $TableCommandMold[0]['MoldTerminalAAID']);
    $_SESSION[oWorkManager::_CurrentMoldTerminalAAID] = $TableCommandMold[0]['MoldTerminalAAID'];
} else if (!empty($TableCommandMold) && !empty($TableCommandMold[0]['MoldTerminalBAID'])) {
    UpdateMachineStoreMold($CurrentMachineID, oWorkManager::coStoreMoldBAID, $TableCommandMold[0]['MoldTerminalBAID']);
    $_SESSION[oWorkManager::_CurrentMoldTerminalBAID] = $TableCommandMold[0]['MoldTerminalBAID'];
}
$CurrentMoldTerminalAAID = $_SESSION[oWorkManager::_CurrentMoldTerminalAAID] ?? null;
$CurrentMoldTerminalBAID = $_SESSION[oWorkManager::_CurrentMoldTerminalBAID] ?? null;
if ($CurrentOperationIDCommand === 'A05') {
    UpdatePlanMain($CurrentPlanAID, '02', $CurrentMoldTerminalAAID, $CurrentMoldTerminalAAID);
} elseif ($CurrentOperationIDCommand === 'A03') {
    UpdatePlanMain($CurrentPlanAID, '02', $CurrentMoldTerminalBAID, $CurrentMoldTerminalBAID);
} elseif ($CurrentOperationIDCommand === 'A04') {
    UpdatePlanMain($CurrentPlanAID, '02');
} else if ($CurrentOperationIDCommand === 'A14') {
    UpdatePlanMain($CurrentPlanAID, '03', $TextBoxProductQty);
    $vSession->DelSession(oWorkManager::_CurrentCirictLoopItemAID);
}

$CurrentOperationIDMold = !empty($TableCommandMold) ? $TableCommandMold[0]['OperationID'] : null;
$CurrentOperationNameMold = !empty($TableCommandMold) ? $TableCommandMold[0]['OperationName'] : null;
$CurrentStatusMold = !empty($TableCommandMold) ? $TableCommandMold[0]['ResultMessage'] : null;
function GetResultMessage($ResultID, $CurrentLanguage)
{
    $SelectCommandStatus = "SELECT dbo.GetWebOperationStatusResultMessage('@ResultID', '@Language') AS ResultMessage";
    $ParametersStatus = array('@ResultID', '@Language');
    $ValuesStatus = array($ResultID, $CurrentLanguage);
    $vSqlTable = new pSqlTable(false);
    $TableStatus = $vSqlTable->TableSelectParmeter($SelectCommandStatus, $ParametersStatus, $ValuesStatus);
    return isset($TableStatus) ? $TableStatus[0]['ResultMessage'] : null;
}

if (isset($_POST['TextBoxMoldTerminalA']) || isset($_POST['TextBoxMoldTerminalB'])) {
    $CurrentStatusIsset = $CurrentStatusMold;
} else if (isset($_POST['ButtonSave'])) {
    $SelectCommandQualityControl = "SELECT dbo.GetWebQualityControlResult('@PlanAID', '@OperationID') AS IsQualityControl";
    $ParamtersQualityControl = array('@PlanAID', '@OperationID');
    $ValuesQualityControl = array($CurrentPlanAID, $OperationID);
    $TableQualityControl = $vSqlTable->TableSelectParmeter($SelectCommandQualityControl, $ParamtersQualityControl, $ValuesQualityControl);
    $IsQualityControl = $TableQualityControl[0]['IsQualityControl'];
    #Ihêm Insert
    $QueryQualityControl = new pSqlTable(false);
    $QueryQualityControl->SetTableName(oWorkManager::tbQualityControl);
    $QueryQualityControl->SetValue(oWorkManager::coPlanAID, $CurrentPlanAID);
    $QueryQualityControl->SetValue(oWorkManager::coRecordDate, $CurrentRecordDate);
    $QueryQualityControl->SetValue(oWorkManager::coEmployeeHandlerAID, $CurrentEmployeeAID);
    $QueryQualityControl->SetValue(oWorkManager::coLength, (double)$NumberLength);
    $QueryQualityControl->SetValue(oWorkManager::coTermialAPeeled, (double)$NumberTermialAPeeled);
    $QueryQualityControl->SetValue(oWorkManager::coTermialAPressing, (double)$NumberTermialAPressing);
    $QueryQualityControl->SetValue(oWorkManager::coTermialAFrontHeight, (double)$NumberTermialAFrontHeight);
    $QueryQualityControl->SetValue(oWorkManager::coTermialAFrontWidth, (double)$NumberTermialAFrontWidth);
    $QueryQualityControl->SetValue(oWorkManager::coTermialABackHeight, (double)$NumberTermialABackHeight);
    $QueryQualityControl->SetValue(oWorkManager::coTermialABackWidth, (double)$NumberTermialABackWidth);
    $QueryQualityControl->SetValue(oWorkManager::coTermialBPeeled, (double)$NumberTermialBPeeled);
    $QueryQualityControl->SetValue(oWorkManager::coTermialBPressing, (double)$NumberTermialBPressing);
    $QueryQualityControl->SetValue(oWorkManager::coTermialBFrontHeight, (double)$NumberTermialBFrontHeight);
    $QueryQualityControl->SetValue(oWorkManager::coTermialBFrontWidth, (double)$NumberTermialBFrontWidth);
    $QueryQualityControl->SetValue(oWorkManager::coTermialBBackHeight, (double)$NumberTermialBBackHeight);
    $QueryQualityControl->SetValue(oWorkManager::coTermialBBackWidth, (double)$NumberTermialBBackWidth);
    $QueryQualityControl->SetValue(oWorkManager::coMachineID, $CurrentMachineID);
    $WhereUpdateQC = "(PlanAID = " . "'$CurrentPlanAID') AND (OperationID = " . "'$OperationID')";
    if ($IsQualityControl === 0) {
        $QueryQualityControl->SetValue(oWorkManager::coQualityControlAID, fBuilder::BuilderAID());
        $QueryQualityControl->SetValue(oWorkManager::coOperationID, $OperationID);
        $QueryQualityControl->TableInsert();
    } else {
        $QueryQualityControl->TableUpdate($WhereUpdateQC);
    }
    $CurrentStatusIsset = GetResultMessage('SaveSuccessfull', $CurrentLanguage);
} else if (isset($_POST['ButtonContinue'])) {
    $CurrentStatusIsset = GetResultMessage('CommandStageSuccessfull', $CurrentLanguage);
} else if (isset($_POST['ButtonChangeMold'])) {
    if (isset($_POST['CheckboxMoldTermialA']) && isset($_POST['CheckboxMoldTermialB'])) {
        UpdateMachineStoreMold($CurrentMachineID, oWorkManager::coStoreMoldAAID, null, oWorkManager::coStoreMoldBAID);
    } else if (isset($_POST['CheckboxMoldTermialA'])) {
        UpdateMachineStoreMold($CurrentMachineID, oWorkManager::coStoreMoldAAID);
    } else {
        UpdateMachineStoreMold($CurrentMachineID, oWorkManager::coStoreMoldBAID);
    }
    $CurrentStatusIsset = GetResultMessage('MoldChangeSuccessfull', $CurrentLanguage);
} else if (isset($_POST['ButtonSubmitRepair'])) {
    $EmployeeRepairAID = $_POST['ucRemodeler'] ?? null;
    $RepairTime = $_POST['TextBoxRemodelingTime'] ?? null;
    $InsertTableRepair = new pSqlTable(false);
    $InsertTableRepair->SetTableName(oWorkManager::tbPlanStop);
    $InsertTableRepair->SetValue(oWorkManager::coStopAID, fBuilder::BuilderAID());
    $InsertTableRepair->SetValue(oWorkManager::coPlanAID, $CurrentPlanAID);
    $InsertTableRepair->SetValue(oWorkManager::coEmployeeRepairAID, $EmployeeRepairAID);
    $InsertTableRepair->SetValue(oWorkManager::coEmployeeHandlerAID, $CurrentEmployeeAID);
    $InsertTableRepair->SetValue(oWorkManager::coRecordDate, $CurrentRecordDate);
    $InsertTableRepair->SetValue(oWorkManager::coRepairTime, $RepairTime);
    $InsertTableRepair->SetValue(oWorkManager::coMachineID, $CurrentMachineID);
    $InsertTableRepair->TableInsert();
    $CurrentStatusIsset = GetResultMessage('MachineContinue', $CurrentLanguage);

} else if (isset($_POST['ButtonUpdateProduced'])) {
    if ($CurrentProduceQty === '') {
        $CurrentStatusIsset = GetResultMessage('SaveError', $CurrentLanguage);
    } else {
        $CurrentStatusIsset = GetResultMessage('SaveSuccessfull', $CurrentLanguage);
    }
} else {
    $CurrentStatusIsset = null;
}
//Bảng table lấy MachineID
$TableMachine = $vSqlTable->TableSelectParmeter($SelectCommandMachine, '@MachineID', $CurrentMachineID);
$TextBoxMoldTerminalA = !empty($TableMachine) ? $TableMachine[0]['StoreMoldIDA'] : null;
$TextBoxMoldTerminalB = !empty($TableMachine) ? $TableMachine[0]['StoreMoldIDB'] : null;

$CurrentOperationIDCommand = !empty($_SESSION[oWorkManager::_CurrentOperationCode]) ? $_SESSION[oWorkManager::_CurrentOperationCode] : null;
$SelectCommandOperationName = "SELECT dbo.GetWebMachineOperationName('@OperationID', '@Language') AS OperationName";
$TableOperationName = $vSqlTable->TableSelectParmeter($SelectCommandOperationName, array('@OperationID', '@Language'), array($CurrentOperationIDCommand, $CurrentLanguage));
$OperationNameCommand = !empty($TableOperationName) ? $TableOperationName[0]['OperationName'] : null;
//--
$CurrentOperationID = !empty($CurrentOperationIDMold) ? $CurrentOperationIDMold : $CurrentOperationIDCommand;
$TextBoxNameOperationID = !empty($CurrentOperationIDMold) ? $CurrentOperationNameMold : $OperationNameCommand;
$CurrentStatus = !empty($CurrentStatusIsset) ? $CurrentStatusIsset : $CurrentStatusBarcode;
$CurrentGroupOperation = $_SESSION[oWorkManager::_CurrentTabControl] ?? 1;

// Lấy thông số của thiết bị --
$SelectCommandCheck = "SELECT        Length, TermialAPeeled, TermialAPressing, TermialAFrontHeight, TermialAFrontWidth, TermialABackHeight, TermialABackWidth, TermialBPeeled, TermialBPressing, TermialBFrontHeight, TermialBFrontWidth, 
                         TermialBBackHeight, TermialBBackWidth
                        FROM            dbo.tblProduceMachinePlanQualityControl
                        WHERE        (PlanAID = '@PlanAID') AND (OperationID = '@OperationID')";

$ParametersCheck = array('@PlanAID', '@OperationID');
if ($CurrentOperationID === 'A10') {
    $ValuesCheck = array($CurrentPlanAID, 'A11');
} else {
    $ValuesCheck = array($CurrentPlanAID, 'A10');
}
$TableCheck = $vSqlTable->TableSelectParmeter($SelectCommandCheck, $ParametersCheck, $ValuesCheck);

$ShowLength = !empty($TableCheck) ? ((float) $TableCheck[0]['Length'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['Length'], 0)) : '-';
$ShowPeeledA = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialAPeeled'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['TermialAPeeled'], 2)) : '-';
$ShowPressingA = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialAPressing'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['TermialAPressing'], 2)): '-';
$ShowFHeightA = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialAFrontHeight'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['TermialAFrontHeight'], 2)) : '-';
$ShowFWidthA = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialAFrontWidth'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['TermialAFrontWidth'], 2)) : '-';
$ShowBHeightA = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialABackHeight'] === 0.00 ? '' : number_format((float) $TableCheck[0]['TermialABackHeight'], 2)) : '-';
$ShowBWidthA = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialABackWidth'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['TermialABackWidth'], 2)) : '-';
$ShowPeeledB = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialBPeeled'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['TermialBPeeled'], 2)) : '-';
$ShowPressingB = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialBPressing'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['TermialBPressing'], 2)) : '-';
$ShowFHeightB = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialBFrontHeight'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['TermialBFrontWidth'], 2)) : '-';
$ShowFWidthB = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialBFrontWidth'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['TermialBFrontWidth'], 2)) : '-';
$ShowBHeightB = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialBBackHeight'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['TermialBBackHeight'], 2)) : '-';
$ShowBWidthB = !empty($TableCheck) ? ((float) $TableCheck[0]['TermialBBackWidth'] === 0.00 ? '-' : number_format((float) $TableCheck[0]['TermialBBackWidth'], 2)) : '-';
?>
