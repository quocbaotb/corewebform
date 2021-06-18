<?php
session_start();
include_once('../../../Core/Core.php');
include_once('../../../Customize/Customize.php');
include_once("../../../LoadLibrabry.php");


$Core = new Core();
$vSession = $Core->vSession();
$vSqlTable = $Core->pSqlTable(false);
$Core->fBuilderAID();
$fBuildString = $Core->fString();

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

$Customize = new Customize($CurrentLanguage);
$Customize->oWorkManagerQuality();
$Customize->oWorkManager();
$vProcessForm = $Customize->pForm();
$WorkManagerQuality = $vProcessForm->Translate('WorkManagerQuality');
$GroupLastQuality = $vProcessForm->Translate('GroupLastQuality');
$CheckBarcodeScanner = $vProcessForm->Translate('CheckBarcodeScanner');
$CheckCommand = $vProcessForm->Translate('CheckCommand');
$CheckSerial = $vProcessForm->Translate('CheckSerial');
$CheckVersion = $vProcessForm->Translate('CheckVersion');
$CheckNumberTwo = $vProcessForm->Translate('CheckNumberTwo');
$CheckMachine = $vProcessForm->Translate('CheckMachine');
$CheckQty = $vProcessForm->Translate('CheckQty');
$CheckType = $vProcessForm->Translate('CheckType');
$AutoCheckTime = $vProcessForm->Translate('AutoCheckTime');
$ErrorPosition = $vProcessForm->Translate('ErrorPosition');
$CheckDate = $vProcessForm->Translate('CheckDate');
$CheckTime = $vProcessForm->Translate('CheckTime');
$EmployeeCheck1 = $vProcessForm->Translate('EmployeeCheck1');
$EmployeeCheck2 = $vProcessForm->Translate('EmployeeCheck2');
$EndDateTimeCheck = $vProcessForm->Translate('EndDateTimeCheck');
$StartDateTimeCheck = $vProcessForm->Translate('StartDateTimeCheck');
$EmployeeQuickRepair = $vProcessForm->Translate('EmployeeQuickRepair');
$CheckIsQuickRepair = $vProcessForm->Translate('CheckIsQuickRepair');
$TotalCheckTime = $vProcessForm->Translate('TotalCheckTime');
$CheckProduct = $vProcessForm->Translate('CheckProduct');
$ErrorID = $vProcessForm->Translate('ErrorID');
$ErrorCiritLoop = $vProcessForm->Translate('ErrorCiritLoop');
$IsEmployeeQuickRepair = $vProcessForm->Translate('IsEmployeeQuickRepair');
$CheckOperation = $vProcessForm->Translate('CheckOperation');
$CheckNeedQty = $vProcessForm->Translate('CheckNeedQty');
$CheckGoodQty = $vProcessForm->Translate('CheckGoodQty');
$CheckRealQty = $vProcessForm->Translate('CheckRealQty');
$CheckNgQty = $vProcessForm->Translate('CheckNgQty');
$CheckRate = $vProcessForm->Translate('CheckRate');
$CheckRec = $vProcessForm->Translate('CheckRec');
$CheckTotalTime = $vProcessForm->Translate('CheckTotalTime');
$CheckQtyBatch = $vProcessForm->Translate('CheckQtyBatch');
$CheckFinishDate = $vProcessForm->Translate('CheckFinishDate');
$LogOut = 'Đăng xuất';

$CurrentDate = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
$CurrentRecordDateTime = $CurrentDate->format('yy/m/d H:i:s');
$CurrentRecordDate = $CurrentDate->format('yy/m/d');
$CurrentRecordTimeNow = $CurrentDate->format('H:i:s');


if (isset($_POST['ButtonHiddenLogOut'])) {
    session_unset();
    header('Location: ../../../../index.php');
    exit();
}

$CurrentMachineID = !empty($_SESSION[oWorkManager::_MachineID]) ? $_SESSION[oWorkManager::_MachineID] : null;

$CurrentWorkShiftID = !empty($_SESSION[oWorkManager::_CurrentWorkShiftID]) ? $_SESSION[oWorkManager::_CurrentWorkShiftID] : null;

$CurrentEmployeeCheck01AID = !empty($_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck1AID]) ? $_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck1AID] : null;

$CurrentEmployeeCheck02AID = !empty($_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck2AID]) ? $_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck2AID] : null;

//---
if (isset($_POST['TextboxBarcodeScanner'])) {
    $vSession->SetSession(oWorkManagerQuality::_CurrentBarcode, $_POST['TextboxBarcodeScanner']);
    $vSession->SetSession(oWorkManagerQuality::_CurrentStartDateTimeNow, $CurrentRecordDateTime);
    $vSession->SetSession(oWorkManagerQuality::_CurrentRecordTimeNow, $CurrentRecordTimeNow);

}

$CurrentCheckBarcode = !empty($vSession->GetSession(oWorkManagerQuality::_CurrentBarcode)) ? $vSession->GetSession(oWorkManagerQuality::_CurrentBarcode) : null;
$ArrayBarcode = $fBuildString->ArrayBarcode($CurrentCheckBarcode);


$TableQualityResult = array();

if (count($ArrayBarcode) < 6) {
    $vSession->DelSession(oWorkManagerQuality::_CurrentBarcode);
} else {
/*    $TemptQtyAndVersion = !empty($ArrayBarcode[3]) ? $ArrayBarcode[3] : null;
    $TemptArrayQtyAndVersion = explode('/', $TemptQtyAndVersion);
    $TemptVersionNo = !empty($TemptArrayQtyAndVersion[1]) ? $TemptArrayQtyAndVersion[1] : null;
    $ParametersBarcodeResult = array('@BarcodeValue', '@VersionNo');
    $ValuesBarcodeResult = array($ArrayBarcode[2], $TemptVersionNo);*/
    $TableQualityResult = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scBarcodeQualityResult, '@BarcodeValue', $ArrayBarcode[2]);
}
//---
$CurrentQualityTypeID = null;
$CurrentCommandAID = null;

if (!empty($TableQualityResult)) {
    $CurrentQualityStatus = "Successful!";

/*    $CurrentCommandAID = $TableQualityResult[0][oWorkManagerQuality::coCommandAID];
    $TemptQtyAndVersion = !empty($ArrayBarcode[3]) ? $ArrayBarcode[3] : null;
    $TemptArrayQtyAndVersion = explode('/', $TemptQtyAndVersion);
    $TemptVersionNo = !empty($TemptArrayQtyAndVersion[1]) ? $TemptArrayQtyAndVersion[1] : null;*/
    /*$TableQualityInput = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scQualityInput, '@CommandAID', $CurrentCommandAID);*/

    /*$TableQualityInput = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scBarcodeStatus, array('@CommandAID', '@VersionNo'), array($CurrentCommandAID, $TemptVersionNo));*/

    $vSession->SetSession(oWorkManagerQuality::_Barcode, $CurrentCheckBarcode);

    if (isset($_POST['TextboxBarcodeScanner'])) {
        $vSession->DelSession(oWorkManagerQuality::_CurrentIsShowNg);
        $vSession->DelSession(oWorkManagerQuality::_CurrentIsOK);
    }

} else {
    $CurrentQualityStatus = "Error!";
    $vSession->DelSession(oWorkManagerQuality::_CurrentIsShowNg);
    $vSession->DelSession(oWorkManagerQuality::_CurrentIsOK);
}

$CurrentCheckDate = $CurrentRecordDate;
$CurrentProductAID = !empty($TableQualityResult) ? $TableQualityResult[0][oWorkManagerQuality::coProductAID] : null;
$CurrentCommandAID = !empty($TableQualityResult) ? $TableQualityResult[0][oWorkManagerQuality::coCommandAID] : null;
$CurrentStartDateTime = !empty($_SESSION[oWorkManagerQuality::_CurrentStartDateTimeNow]) ? $_SESSION[oWorkManagerQuality::_CurrentStartDateTimeNow] : $CurrentRecordDateTime;

$CurrentStartTimeNow = !empty($_SESSION[oWorkManagerQuality::_CurrentRecordTimeNow]) ? $_SESSION[oWorkManagerQuality::_CurrentRecordTimeNow] : null;

$CurrentEndDateTime = $CurrentRecordDateTime;

$CurrentCheckOperationID = "";

$CurrentBarcode = !empty($vSession->GetSession(oWorkManagerQuality::_Barcode)) ? $vSession->GetSession(oWorkManagerQuality::_Barcode) : null;
$ArraySuccessfulBarcode = $fBuildString->ArrayBarcode($CurrentBarcode);

$CurrentProductID = (Count($ArraySuccessfulBarcode) === 6) ? $ArraySuccessfulBarcode[0] : null;
$CurrentSerialNo = !empty($ArraySuccessfulBarcode[1]) ? $ArraySuccessfulBarcode[1] : null;
$CurrentCommandID = !empty($ArraySuccessfulBarcode[2]) ? $ArraySuccessfulBarcode[2] : null;
$DoubleQtyAndVersion = !empty($ArraySuccessfulBarcode[3]) ? $ArraySuccessfulBarcode[3] : null;
$ArrayQtyAndVersion = explode('/', $DoubleQtyAndVersion);
$CurrentCommandQty = !empty($ArrayQtyAndVersion[0]) ? $ArrayQtyAndVersion[0] : null;
$CurrentVersionNo = !empty($ArrayQtyAndVersion[1]) ? $ArrayQtyAndVersion[1] : null;

$TableProductInfo = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scProductInfo, array('@Language', '@ProductAID'), array($CurrentLanguage, $CurrentProductAID));
$CurrentProductName = !empty($TableProductInfo) ? $TableProductInfo[0][oWorkManagerQuality::coProductName] : null;

$TableQualityBarcodeStatus = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scBarcodeStatus, array('@CommandAID', '@VersionNo'), array($CurrentCommandAID, $CurrentVersionNo));

$CurrentBarcodeIsCheckNo2 = !empty($TableQualityBarcodeStatus) ? $TableQualityBarcodeStatus[0][oWorkManagerQuality::coIsCheckNo2] : null;

$CurrentQualityTypeID = !empty($TableQualityBarcodeStatus) ? $TableQualityBarcodeStatus[0][oWorkManagerQuality::coCheckResultID] : null;


$CurrentReportItemAID = fBuilder::BuilderAID();

$ParametersQualityResult = array('@CommandAID', '@VersionNo', '@Language');
$ValuesQualityResult = array($CurrentCommandAID, $CurrentVersionNo, $CurrentLanguage);

$TableQualityInputResult = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scGetQualityInputResult, $ParametersQualityResult, $ValuesQualityResult);

$CurrentIsFinish = false;

if (isset($_POST['ButtonOK'])) {
    $vSession->SetSession(oWorkManagerQuality::_CurrentIsOK, 1);

    if (empty($TableQualityInputResult)) {
        $CurrentCheckResultID = "01";
        $CurrentIsFinish = true;
        $InsertTableInput = new pSqlTable(false);
        $InsertTableInput->SetTableName(oWorkManagerQuality::tbQualityInput);
        $InsertTableInput->SetValue(oWorkManagerQuality::coReportItemAID, $CurrentReportItemAID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCommandAID, $CurrentCommandAID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCheckDate, $CurrentCheckDate);
        $InsertTableInput->SetValue(oWorkManagerQuality::coWorkShiftID, $CurrentWorkShiftID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coMachineID, $CurrentMachineID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coProductAID, $CurrentProductAID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCheckVersionNo, $CurrentVersionNo);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCheckSerialNo, $CurrentSerialNo);
        $InsertTableInput->SetValue(oWorkManagerQuality::coEmployeeCheck01AID, $CurrentEmployeeCheck01AID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coEmployeeCheck02AID, $CurrentEmployeeCheck02AID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coStartDateTime, $CurrentStartDateTime);
        $InsertTableInput->SetValue(oWorkManagerQuality::coEndDateTime, $CurrentEndDateTime);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCheckResultID, $CurrentCheckResultID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCheckOperationID, $CurrentCheckOperationID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coIsFinish, $CurrentIsFinish);

        $InsertTableInput->TableInsert();
    }

} else if (isset($_POST['ButtonNG'])) {
    $vSession->SetSession(oWorkManagerQuality::_CurrentIsShowNg, 1);
    if (empty($TableQualityInputResult)) {
        $CurrentCheckResultID = "02";
        $InsertTableInput = new pSqlTable(false);
        $InsertTableInput->SetTableName(oWorkManagerQuality::tbQualityInput);
        $InsertTableInput->SetValue(oWorkManagerQuality::coReportItemAID, $CurrentReportItemAID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCommandAID, $CurrentCommandAID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCheckDate, $CurrentCheckDate);
        $InsertTableInput->SetValue(oWorkManagerQuality::coWorkShiftID, $CurrentWorkShiftID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coMachineID, $CurrentMachineID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coProductAID, $CurrentProductAID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCheckVersionNo, $CurrentVersionNo);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCheckSerialNo, $CurrentSerialNo);
        $InsertTableInput->SetValue(oWorkManagerQuality::coEmployeeCheck01AID, $CurrentEmployeeCheck01AID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coEmployeeCheck02AID, $CurrentEmployeeCheck02AID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coStartDateTime, $CurrentStartDateTime);
        $InsertTableInput->SetValue(oWorkManagerQuality::coEndDateTime, $CurrentEndDateTime);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCheckResultID, $CurrentCheckResultID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coCheckOperationID, $CurrentCheckOperationID);
        $InsertTableInput->SetValue(oWorkManagerQuality::coIsFinish, $CurrentIsFinish);

        $InsertTableInput->TableInsert();
    }
}

$CurrentCheckOperationID = '01';

$ParametersQualityResult = array('@CommandAID', '@VersionNo', '@Language');
$ValuesQualityResult = array($CurrentCommandAID, $CurrentVersionNo, $CurrentLanguage);
$TableQualityInputResult = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scGetQualityInputResult, $ParametersQualityResult, $ValuesQualityResult);
//--
$CurrentSqlCommandID = !empty($TableQualityInputResult) ? $TableQualityInputResult[0][oWorkManagerQuality::coCommandID] : null;
$CurrentSqlCheckSerialNo = !empty($TableQualityInputResult) ? $TableQualityInputResult[0][oWorkManagerQuality::coCheckSerialNo] : null;
$CurrentSqlCheckDate = !empty($TableQualityInputResult) ? $TableQualityInputResult[0][oWorkManagerQuality::coCheckDate] : null;
$CurrentSqlStartDateTime = !empty($TableQualityInputResult) ? $TableQualityInputResult[0][oWorkManagerQuality::coStartDateTime] : null;
$CurrentSqlEndDateTime = !empty($TableQualityInputResult) ? $TableQualityInputResult[0][oWorkManagerQuality::coEndDateTime] : null;
$CurrentSqlTotalTime = !empty($TableQualityInputResult) ? $TableQualityInputResult[0][oWorkManagerQuality::coTotalTime] : null;
$CurrentSqlQualityTypeID = !empty($TableQualityInputResult) ? $TableQualityInputResult[0][oWorkManagerQuality::coResultName] : null;
$CurrentCheckSqlOperationID = !empty($TableQualityInputResult) ? $TableQualityInputResult[0][oWorkManagerQuality::coOperationName] : null;

if (isset($_POST['TextboxErrorID'])) {
    $vSession->SetSession(oWorkManagerQuality::_CurrentErrorID, $_POST['TextboxErrorID']);
}
$CurrentErrorID = !empty($_SESSION[oWorkManagerQuality::_CurrentErrorID]) ? $_SESSION[oWorkManagerQuality::_CurrentErrorID] : null;

if (isset($_POST['TextboxErrorPositionID'])) {
    $vSession->SetSession(oWorkManagerQuality::_CurrentErrorPositionID, $_POST['TextboxErrorPositionID']);
}
$CurrentErrorPositionID = !empty($_SESSION[oWorkManagerQuality::_CurrentErrorPositionID]) ? $_SESSION[oWorkManagerQuality::_CurrentErrorPositionID] : null;

$CurrentReportItemAID = !empty($TableQualityInputResult) ? $TableQualityInputResult[0][oWorkManagerQuality::coReportItemAID] : null;
$CurrentNgItemAID = fBuilder::BuilderAID();
$CurrentCiritLoop01ID = $_POST['TextboxCiritLoop01ID'] ?? null;
$CurrentCiritLoop02ID = $_POST['TextboxCiritLoop02ID'] ?? null;
$CurrentCiritLoop03ID = $_POST['TextboxCiritLoop03ID'] ?? null;
$CurrentCiritLoop04ID = $_POST['TextboxCiritLoop04ID'] ?? null;
$CurrentCiritLoop05ID = $_POST['TextboxCiritLoop05ID'] ?? null;
$CurrentCiritLoop06ID = $_POST['TextboxCiritLoop06ID'] ?? null;
$CurrentCiritLoop07ID = $_POST['TextboxCiritLoop07ID'] ?? null;
$CurrentCiritLoop08ID = $_POST['TextboxCiritLoop08ID'] ?? null;

if (isset($_POST['ButtonSaveError'])) {

    $vSession->SetSession(oWorkManagerQuality::_CurrentIsSaveError, 1);
    $InsertTableInputNG = new pSqlTable(false);
    $InsertTableInputNG->SetTableName(oWorkManagerQuality::tbQualityInputNG);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coNgItemAID, $CurrentNgItemAID);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coReportItemAID, $CurrentReportItemAID);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coCheckErrorID, $CurrentErrorID);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coCheckErrorPositionID, $CurrentErrorPositionID);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coCiritLoop01ID, $CurrentCiritLoop01ID);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coCiritLoop02ID, $CurrentCiritLoop02ID);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coCiritLoop03ID, $CurrentCiritLoop03ID);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coCiritLoop04ID, $CurrentCiritLoop04ID);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coCiritLoop05ID, $CurrentCiritLoop05ID);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coCiritLoop06ID, $CurrentCiritLoop06ID);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coCiritLoop07ID, $CurrentCiritLoop07ID);
    $InsertTableInputNG->SetValue(oWorkManagerQuality::coCiritLoop08ID, $CurrentCiritLoop08ID);
    $InsertTableInputNG->TableInsert();
} elseif (isset($_POST['ButtonRefreshError'])) {
    $vSession->SetSession(oWorkManagerQuality::_CurrentIsRefreshError, 1);
    $vSession->DelSession(oWorkManagerQuality::_CurrentIsSaveError);
    $vSession->DelSession(oWorkManagerQuality::_CurrentErrorID);
    $vSession->DelSession(oWorkManagerQuality::_CurrentErrorPositionID);

}

if (isset($_POST['TextboxEmployeeQuickRepair'])){
    $vSession->SetSession(oWorkManagerQuality::_CurrentEmployeeQuickRepairID, $_POST['TextboxEmployeeQuickRepair']);
}

if (isset($_POST['CheckboxReturnRepair'])){
    $vSession->SetSession(oWorkManagerQuality::_CurrentIsReturnRepair, true);
}

$CurrentIsReturnRepair = !empty($_SESSION[oWorkManagerQuality::_CurrentIsReturnRepair]) ? $_SESSION[oWorkManagerQuality::_CurrentIsReturnRepair] : false;
$CurrentEmployeeQuickRepairID = !empty($_SESSION[oWorkManagerQuality::_CurrentEmployeeQuickRepairID]) ? $_SESSION[oWorkManagerQuality::_CurrentEmployeeQuickRepairID] : null;
$TableEmployeeQuickRepair = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scEmployeeCheck, array('@Language', '@EmployeeID'), array($CurrentLanguage, $CurrentEmployeeQuickRepairID));
$CurrentEmployeeNameQuickRepair = !empty($TableEmployeeQuickRepair) ? $TableEmployeeQuickRepair[0]['EmployeeName'] : null;
$CurrentEmployeeQuickRepairAID = !empty($TableEmployeeQuickRepair) ? $TableEmployeeQuickRepair[0]['EmployeeAID'] : null;

if (isset($_POST['ButtonSaveCheckQuality'])){
    $CurrentIsFinish = true;
    $UpdateTableQualityInput = new pSqlTable(false);
    $UpdateTableQualityInput->SetTableName(oWorkManagerQuality::tbQualityInput);
    $UpdateTableQualityInput->SetValue(oWorkManagerQuality::coIsFinish, $CurrentIsFinish);
    $UpdateTableQualityInput->SetValue(oWorkManagerQuality::coEmployeeQuickRepairAID, $CurrentEmployeeQuickRepairAID);
    $UpdateTableQualityInput->SetValue(oWorkManagerQuality::coIsReturnRepair, $CurrentIsReturnRepair);
    $WhereQualityInput = oWorkManagerQuality::coReportItemAID . '=' . "'$CurrentReportItemAID'";
    $UpdateTableQualityInput->TableUpdate($WhereQualityInput);

    $vSession->DelSession(oWorkManagerQuality::_CurrentEmployeeQuickRepairID);
    $vSession->DelSession(oWorkManagerQuality::_CurrentIsShowNg);
}

if (isset($_POST['ButtonEndCheckQuality'])){
    $CurrentIsFinish = true;
    $UpdateTableQualityInput = new pSqlTable(false);
    $UpdateTableQualityInput->SetTableName(oWorkManagerQuality::tbQualityInput);
    $UpdateTableQualityInput->SetValue(oWorkManagerQuality::coIsFinish, $CurrentIsFinish);
    $WhereQualityInput = oWorkManagerQuality::coReportItemAID . '=' . "'$CurrentReportItemAID'";
    $UpdateTableQualityInput->TableUpdate($WhereQualityInput);
    $vSession->DelSession(oWorkManagerQuality::_CurrentEmployeeQuickRepairID);
    $vSession->DelSession(oWorkManagerQuality::_CurrentIsShowNg);
}

$TableQualityInputNG = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scQualityInputNG, '@ReportItemAID', $CurrentReportItemAID);
$CurrentErrorID = !empty($_SESSION[oWorkManagerQuality::_CurrentErrorID]) ? $_SESSION[oWorkManagerQuality::_CurrentErrorID] : null;
$TableBasQualityError = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scBasQualityError, array('@Language', '@ErrorID'), array($CurrentLanguage, $CurrentErrorID));
$CurrentErrorPositionID = !empty($_SESSION[oWorkManagerQuality::_CurrentErrorPositionID]) ? $_SESSION[oWorkManagerQuality::_CurrentErrorPositionID] : null;
$TableBasQualityErrorPosition = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scBasQualityErrorPosition, array('@Language', '@ErrorPositionID'), array($CurrentLanguage, $CurrentErrorPositionID));
$CurrentErrorName = !empty($TableBasQualityError) ? $TableBasQualityError[0][oWorkManagerQuality::coErrorName] : null;
$CurrentErrorPositionName = !empty($TableBasQualityErrorPosition) ? $TableBasQualityErrorPosition[0][oWorkManagerQuality::coErrorPositionName] : null;
$CurrentMachineID = !empty($_SESSION[oWorkManager::_MachineID]) ? $_SESSION[oWorkManager::_MachineID] : null;
$CurrentEmployeeCheck01Name = !empty($_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck1Name]) ? $_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck1Name] : null;
$CurrentEmployeeCheck02Name = !empty($_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck2Name]) ? $_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck2Name] : null;

$TableQualityInput = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scQualityInput, '@ReportItemAID', $CurrentReportItemAID);

$CurrentIsCheckNo2 = !empty($TableQualityInput) ? $TableQualityInput[0][oWorkManagerQuality::coIsCheckNo2] : null;

echo "Barcode: 240144CN0D 7A   1A0010C     0200/0008 210405 EC211";

