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


$CurrentMachineID = $_SESSION[oWorkManager::_MachineID];

// XỬ lý đăng nhập : lấy dc mã máy, ngày và nhân viên
$CurrentEmployeeAID = $_SESSION[oWorkManager::_CurrentEmployeeAID];
$CurrentDate = new DateTime('now',new DateTimeZone('Asia/Ho_Chi_Minh'));
$CurrentRecordDate = $CurrentDate->format('yy/m/d H:i:s');

// Lấy nhân viên
$EmployeeCommand = "SELECT dbo.GetWebEmployeeInfo('@EmployeeAID, @Language') AS EmployeeInfo";
$ParametersEmPloYee = array('@EmployeeAID','@Language');
$ValuesEmPloYee = array($CurrentEmployeeAID, $CurrentLanguage);
$TableEmPloYee = $vSqlTable->TableSelectParmeter($EmployeeCommand,$ParametersEmPloYee,$ValuesEmPloYee);
$Employee = explode(',',$TableEmPloYee[0]['EmPloyeeInfo']);
$TextBoxEmployeeID = $Employee[0];
$TextBoxNameEmPloYee = $Employee[1];
$TableEmPloYeeInfo = $vSqlTable->TableSelectParmeter(oWorkManager::scBasEmployeeInfo,$CurrentLanguage);

$BarcodeCommand = "SELECT        ResultID, ResultMessage, CommandAID, CirictLoopItemAID, PlanAID, MachineID, ProducedQty, CommandID, CommandQty, LoopID, MaterialAIDTerminalA, MaterialAIDTerminalB, SetTerminalA, SetTerminalB, SetCut, 
                                                 OperationID, OperationName, TabControl AS GroupOperationID, MaterialIDTerminalA, MaterialIDTerminalB, IsNeedConfirmed
                        FROM            dbo.GetWebBacodeScannerResult('@BarcodeValue', '@Language', '@MachineID', '@CirictLoopItemAID')";
$ParametersBarcode = array('@BarcodeValue','@Language','@MachineID','@CirictLoopItemAID');

$CurrentBarcodeScanner = isset($_POST['TextBoxBarcodeScanner']) ? $fString->BuildBarcode($_POST['TextBoxBarcodeScanner']) : null;

$CirictLoopItemAID = !empty($_SESSION[oWorkManager::_CurrentCirictLoopItemAID]) ? $_SESSION[oWorkManager::_CurrentCirictLoopItemAID] : null;
$ValuesBarcode = array($CurrentLanguage,$CurrentMachineID,$CurrentBarcodeScanner,$CirictLoopItemAID);
$TableBarcodeScan = $vSqlTable->TableSelectParmeter($BarcodeCommand,$ParametersBarcode,$ValuesBarcode);

$MachineCommand = "SELECT        MachineID, CommandQty, ProducedQty, UnProducedQty, StoreMoldAAID, StoreMoldIDA, StoreMoldBAID, StoreMoldIDB
                            FROM            dbo.GetProduceMachineInfoWeb('@MachineID')";
$TableMachine = $vSqlTable->TableSelectParmeter($MachineCommand,'@MachineID',$CurrentMachineID);

$IsNeedConfirmed = !empty($TableBarcodeScan) ? $TableBarcodeScan['IsNeedConfirmed'][0] : 0;
$DialogConfirmed = !empty($TableBarcodeScan) ? $TableBarcodeScan['ResultMessage'][0] : 0;

if(isset($TableBarcodeScan[0]['CirictLoopItemAID']))
    $_SESSION[oWorkManager::_CurrentCirictLoopItemAID]=$TableBarcodeScan[0]['CirictLoopItemAID'];

$CurrentCirictLoopItemAID = !empty($_SESSION[oWorkManager::_CurrentCirictLoopItemAID] ) ? $_SESSION[oWorkManager::_CurrentCirictLoopItemAID] : null ;
$Parameters = array('@CirictLoopItemAID','@IsContinue');

if($IsNeedConfirmed == null){
    $Values = array($CurrentCirictLoopItemAID,1);
}else {
    $Values = array($CurrentCirictLoopItemAID, isset($_POST['ButtonContinue']));
}

$TablePlanCommand = $vSqlTable->TableSelectParmeter(oWorkManager::scPlanCommandInfo,$Parameters,$Values);
$CurrentStatusBarCode = !empty($TableBarcodeScan) ? $TableBarcodeScan[0]['ResultMessage'] : null;
if(!empty($CurrentStatusBarCode))
    $_SESSION[oWorkManager::_CurrentStatus] = $CurrentStatusBarCode;

//Xử lý operation
$CurrentOperationID = !empty($TableBarcodeScan) ? $TableBarcodeScan[0]['OperationID'] : null;
$_SESSION[oWorkManager::_CurrentTabControl] = !empty($TableBarcodeScan) ? $TableBarcodeScan[0]['OperationGroupID'] : null;
$CurrentOperationName = !empty($TableBarcodeScan) ? $TableBarcodeScan[0]['OperationName'] : null;

$CheckSetTerminalA = !empty($TablePlanCommand) ? $TablePlanCommand[0]['SetTerminalA'] : null;
$CheckSetTerminalB = !empty($TablePlanCommand) ? $TablePlanCommand[0]['SetTerminalB'] : null;
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

$SelectCommandGetListMold = "SELECT dbo.GetListMoldFromTerminal('@TextBoxMoldTerminalAID') AS ListMold";
$GetListMoldA = $vSqlTable->TableSelectParmeter($SelectCommandGetListMold, '@TextBoxMoldTerminalAID', $TextBoxMoldTerminalAAID);
$GetListMoldB = $vSqlTable->TableSelectParmeter($SelectCommandGetListMold, '@TextBoxMoldTerminalAID', $TextBoxMoldTerminalBAID);

$CurrentLisMoldTerminalA = !empty($GetListMoldA) ? $GetListMoldA[0]['ListMold'] : null;
$CurrentLisMoldTerminalB = !empty($GetListMoldB) ? $GetListMoldB[0]['ListMold'] : null;

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



$NumberFWidthA = null;
$NumberBHeightB = null;
$NumberBWidthB = null;












