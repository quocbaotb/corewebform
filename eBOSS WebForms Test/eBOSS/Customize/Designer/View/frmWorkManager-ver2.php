<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="../CSS/frmWorkManager.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="../../../Core/JavaScript/fGeneral.js"></script>
<script src="../../JavaScript/fJavaScript.js"></script>
<script type="text/javascript">
    $(function () {
        $("#MoldTerimalA").autocomplete({
            source: "../../Ajax/Search.php",
        });
        $("#MoldTerimalB").autocomplete({
            source: "../../Ajax/Search.php",
        });
    });
</script>
<?php
session_start();

require_once('../../../UserControl.php');
$vOperationInfo = new UserControl('NameVietnamese');
$oWorkManager = $vOperationInfo->oWorkManager();
if (empty($_SESSION[oWorkManager::_MachineID])) {
    echo("<script>alert('Please Login and Setting Database');window.location='../../../../index.php';</script>");
} else {

    $vSession = $vOperationInfo->vSession();
    $vSqlTable = $vOperationInfo->pSqlTable();

    #Ngôn ngữ hiển thị WebForm
    switch ($_SESSION[oWorkManager::_Language]) {
        case 'lang=vi':
            $CurrentLanguage = 'NameVietnamese';
            break;
        case 'lang=cn' :
            $CurrentLanguage = 'NameChinese';
            break;
        default :
            $CurrentLanguage = 'NameVietnamese';
    }

    $vProcessForm = $vOperationInfo->pProcessForm();
    $vStatus = $vOperationInfo->pStatus();

    $TableEmployeeInfo = $vSqlTable->TableSelect(oWorkManager::scBasEmployeeInfo, $CurrentLanguage);
    $TableMachineMold = $vSqlTable->TableSelect(oWorkManager::scBasMoldInfo, $CurrentLanguage);
    $TableMachine = $vSqlTable->TableSelect(oWorkManager::scBasMachineInfo, $CurrentLanguage);
    $TableOperation = $vSqlTable->TableSelect(oWorkManager::scBasOperation, $CurrentLanguage);
    $TableCommandStage = $vSqlTable->TableSelect(oWorkManager::scCommandStage, $CurrentLanguage);
    $TableListMold = $vSqlTable->TableSelect(oWorkManager::scListMold, $CurrentLanguage);
    $TableQualityControl = $vSqlTable->TableSelect(oWorkManager::scQualityControl, $CurrentLanguage);
    $TableStatus = $vSqlTable->TableSelect(oWorkManager::scStatus, $CurrentLanguage);

    #@Khởi tạo biến chạy Web
    $TemptBarcodeScanner = '';
    $CurrentEmployeeID = $CurrentOperationID = $CurrentLisMoldTerminalA = $CurrentLisMoldTerminalB = $CurrentPlanAID = $TextBoxSetCut = $TextBoxSetTerminalA = $TextBoxSetTerminalB = ' ';
    $CurrentDate = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
    $CurrentRecordDate = $CurrentDate->format('yy/m/d H:i:s');

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
    ?>

    <DIV CLASS="main">
        <div class="full">

            <div class="row"
                 style="border-bottom: solid; border-color: #E6E6E6; border-width: 0.5px; margin: 10px 0px 0px;">
                <h2 style="font-size: 20px"
                    value="MachineWorkManager"><?php echo $MachineWorkManager; ?></h2>
                <form method="post">
                    <input style="width: 80px;height: 38px;float: right; margin-top: -40px; margin-right: 20px;"
                           type="submit" id="ButtonLogOut" name="ButtonLogOut"
                           value="<?php echo $LogOut ?>">
                    <input style="width: 1px;height: 1px;float: right;" type="submit" id="ButtonHiddenLogOut"
                           name="ButtonHiddenLogOut"
                           value="ButtonHiddenLogOut" hidden>
                </form>
            </div>
            <DIV class="left" style="margin-left: 10px">
                <form method="post">
                    <div class="row" style="margin:10px 5px 5px 50px">
                        <label style="margin-left: -25px;width: 125px;height: 20px; text-align: center;"><?php echo $BarcodeScanner; ?></label>
                    </div>
                    <div class="row" style="margin-top: 0px">
                        <input style="width: 165px;height: 30px;float: right; background-color: #FFFFCC; font-size: 16px;font-weight: bold;text-align: center;"
                               type="text" name="TextBoxBarcodeScanner" tabindex="1"
                               id="TextBoxBarcodeScanner" autofocus autocomplete="off" required>
                    </div>
                </form>
            </DIV>
            <DIV class="mid">
                <div class="row">
                    <div class="column" style="margin-left: 0px">
                        <label style="width: 100px;text-align: center;"
                               title="<?php echo $CurrentTarget; ?>"><?php echo $CurrentTarget ?></label>
                        <br>
                        <input style="width: 100px;height: 30px;float: right;" type="text" name="DataCurrentTarget"
                               id="DataCurrentTarget" disabled>
                    </div>
                    <div class="column">
                        <label style="width: 100px;text-align: center;"
                               title="<?php echo $CurrentCount; ?>"><?php echo $CurrentCount ?></label>
                        <br>
                        <input style="width: 100px;height: 30px;float: right;" type="text" name="DataCurrentCount"
                               disabled>
                    </div>
                    <div class="column">
                        <label style="width: 100px;text-align: center;"
                               title="<?php echo $Different; ?>"><?php echo $Different ?></label>
                        <br>
                        <input style="width: 100px;height: 30px;float: right;" type="text" name="DataDifferent"
                               disabled>
                    </div>
                    <div class="column">
                        <label style="width: 100px;text-align: center;"
                               title="<?php echo $KnefCutCount; ?>"><?php echo $KnefCutCount ?></label>
                        <br>
                        <input style="width: 100px;height: 30px;float: right;" type="text" name="DataKnefCutCount"
                               disabled>
                    </div>
                </div>
                <div class="row" style="margin-top: -5px">
                    <input id="Status" name="Status" disabled
                           style="background-color: #FFFFCC;margin-left: -206px;text-align: left; width: 635px;border: none;color: crimson"
                           value="<?php echo $vStatus->vStatus ?>">
                    <div id="Continue">
                        <form method="post" style="margin-left: 250px">
                            <input type="submit" id="ButtonContinue" name="ButtonContinue"
                                   value="<?php echo $Continue ?>"
                                   style="width: 1px; border: none" hidden>
                        </form>
                    </div>
                </div>
            </DIV>
            <DIV class="right">
                <div class="row">
                    <label style="width: 70px; margin-top: 5px;"><?php echo $MachineID; ?></label>
                    <input style="text-align: center;width: 100px;height: 30px;float: right;" type="text"
                           name="ucMachineID"
                           value="<?php echo $CurrentMachineID ?>" disabled>
                </div>
                <div class="row">
                    <label style="width: 70px;margin-top: 5px"><?php echo $TitleDate; ?></label>
                    <input style="text-align: center;width: 100px;height: 30px;float: right;" type="textbox"
                           name="ucDate"
                           value="<?php echo $CurrentDate->format('yy/m/d') ?>" disabled>
                </div>
                <div class="row">
                    <label style="width: 70px; margin-top: 5px"><?php echo $Employee; ?></label>
                    <input style="text-align: center;width: 100px;height: 30px;float: right;" type="text"
                           name="ucEmployee"
                           value="<?php echo($TextBoxNameEmployee); ?>" disabled>
                </div>
            </DIV>
            <DIV class="footer">
                <div class="container">

                    <div class="tab">
                        <button id="button1"
                                class="tablinks"><?php echo $TabControlMachineOperation; ?></button>
                        <button id="button2"
                                class="tablinks"><?php echo $TabControlRemoveMold; ?></button>
                        <button id="button3"
                                class="tablinks"><?php echo $TabControlQualityControl; ?></button>
                        <button id="button4"
                                class="tablinks"><?php echo $TabControlRepairMachine; ?></button>
                    </div>

                    <div id="<?php echo $TabControlMachineOperation; ?>" class="tabcontent">
                        <DIV CLASS="Tabfull">
                            <div class="Tabrow" style="margin: 0;">
                                <div class="Tableft"
                                     style="width: 60%; border-style: solid;border-width: 0.5px;border-color: #E6E6E6;height: 322px;">
                                    <div class="Tabrow">
                                        <div class="Tabcolumn" style="width: 320px;margin-left: 0px;">
                                            <label> <?php echo $Operation; ?></label>
                                            <input type="textbox" name="TextBoxOperationID" id="TextBoxOperationID"
                                                   size="7px"

                                                   style="width: 50px" value="<?php echo $CurrentOperationID ?>"
                                                   disabled>
                                            <input type="textbox" name="TextBoxNameOperationID" size="7px"
                                                   style="width: 145px;margin-left: 5px;"
                                                   value="<?php echo($TextBoxNameOperationID) ?>"
                                                   title="<?php echo($TextBoxNameOperationID) ?>" disabled>
                                        </div>
                                        <div class="Tabcolumn" style="width:185px;margin-left: 0px;">
                                            <label style="width: 100px">SetTerminal</label>
                                            <input type="textbox" name="TextBoxSetCut"
                                                   style="width: 40px;" value="<?php echo $TextBoxSetTerminalA ?>"
                                                   disabled>
                                            <input type="textbox" name="TextBoxSetCut"
                                                   style="width: 40px; margin-left: 5px"
                                                   value="<?php echo $TextBoxSetTerminalB ?>"
                                                   disabled>
                                        </div>

                                    </div>

                                    <div class="Tabrow">
                                        <div class="Tabcolumn" style="width: 320px;margin-left: 0px;">
                                            <label> <?php echo $HandlerAID; ?></label>
                                            <input type="textbox" name="TextBoxHandlerAID" size="7px"
                                                   style="width: 50px"
                                                   value="<?php echo($TextBoxEmployeeID) ?>" disabled>
                                            <input type="textbox" name="TextBoxNameHandlerAID"
                                                   style="width: 145px;margin-left: 5px;"
                                                   value="<?php echo($TextBoxNameEmployee) ?>"
                                                   title="<?php echo($TextBoxNameEmployee) ?>" disabled>
                                        </div>
                                        <div class="Tabcolumn" style="width:185px;margin-left: 0px;">
                                            <label style="width: 100px"><?php echo $ProductQty ?></label>
                                            <input type="textbox" name="TextBoxProductQty"
                                                   style="width: 85px;"
                                                   value="<?php if ($TextBoxProductQty > 0) echo number_format($TextBoxProductQty); else echo 0 ?>"
                                                   disabled>
                                        </div>

                                    </div>
                                    <div class="Tabrow">
                                        <div class="Tabcolumn" style="width: 320px;margin-left: 0px;">
                                            <label><?php echo $CommandID ?></label>
                                            <input type="text" name="TextBoxCommandID" size="7px"
                                                   value="<?php echo $TextBoxCommandID ?>" disabled>
                                        </div>
                                        <div class="Tabcolumn" style="width:185px;margin-left: 0px;">
                                            <label style="width: 100px"><?php echo $ProducedQty ?></label>
                                            <input type="textbox" name="TextBoxProducedQty"
                                                   style="width: 85px;"
                                                   value="<?php echo number_format($TextBoxProducedQty) ?>"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="Tabrow">
                                        <div class="Tabcolumn" style="width: 320px;margin-left: 0px;">
                                            <label><?php echo $LoopID; ?></label>
                                            <input style="width: 200px" type="textbox" name="TextBoxLoopID"
                                                   value="<?php echo $TextBoxLoopID ?>"
                                                   disabled>
                                        </div>
                                        <div class="Tabcolumn" style="width:185px;margin-left: 0px;">
                                            <label style="width: 100px"><?php echo $UnProduceQty; ?></label>
                                            <input type="textbox" name="TextBoxUnProduceQty"
                                                   style="width: 85px;"
                                                   value="<?php echo number_format($TextBoxUnProduceQty) ?>"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="Tabrow">
                                        <form method="post">
                                            <div class="Tabcolumn" style="width: 300px;margin-left: 0px;">
                                                <label><?php echo $MoldTerimalA; ?></label>
                                                <input type="text" id="MoldTerimalA" name="TextBoxMoldTerminalA"
                                                       value="<?php echo $TextBoxMoldTerminalA; ?>" tabindex='1'/>
                                            </div>
                                        </form>
                                        <div class="Tabcolumn" style="width: 185px;margin-left: 20px;">
                                            <label><?php echo $TerminalA; ?></label>
                                            <input type="textbox" name="TextBoxTerminalA"
                                                   style="width: 85px;"
                                                   value="<?php echo $TextBoxTerminalA ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="Tabrow">
                                        <form method="post">
                                            <div class="Tabcolumn" style="width: 300px;;margin-left: 0px;">
                                                <label><?php echo $MoldTerimalB; ?></label>
                                                <input type="text" id="MoldTerimalB" name="TextBoxMoldTerminalB"
                                                       value="<?php echo $TextBoxMoldTerminalB; ?>" tabindex='2'/>
                                            </div>
                                        </form>
                                        <div class="Tabcolumn" style="width: 185px;;margin-left: 20px;">
                                            <label><?php echo $TerminalB; ?></label>
                                            <input type="textbox" name="TextBoxTerminalB" style="width: 85px;"
                                                   value="<?php echo $TextBoxTerminalB ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="Produce">
                                            <form method="post">
                                                <label style="margin-left: -10px"
                                                       id="LabelCurrentProduceQty"><?php echo $ProducedQty ?></label>
                                                <input id="CurrentProduceQty" name="CurrentProduceQty"
                                                       value="<?php echo $CurrentProduceQty ?>"
                                                       placeholder="0"
                                                       onkeypress="return(event.charCode >= 48 && event.charCode <= 57)">
                                                <input type="submit" id="ButtonUpdateProduced"
                                                       name="ButtonUpdateProduced" hidden>
                                            </form>
                                        </div>
                                    </div>


                                </div>
                                <div class="Tableft"
                                     style="width: 39%; margin-left: 5px;border: none">

                                    <fieldset style="margin-top: 5px;">
                                        <legend><?php echo $MoldAndTermial; ?></legend>
                                        <div class="Tabrow">
                                            <label title="<?php echo $MachineMoldTerimalA; ?>"><?php echo $MachineMoldTerimalA ?></label>
                                            <input type="textbox" name="TextBoxMachineMoldTerminalA" size="7px"
                                                   disabled style="width: 100px"
                                                   value="<?php echo $TextBoxMoldTerminalA ?>">
                                            <input type="textbox" name="TextBoxNameMachineMoldTerminalA" size="7px"
                                                   style="width: 115px;margin-left: 5px;"
                                                   value="<?php if ($TextBoxMoldTerminalA <> '') echo($TextBoxTerminalA) ?>"
                                                   disabled>
                                        </div>
                                        <div class="Tabrow">
                                            <label title="<?php echo $MachineMoldTerimalB; ?>"><?php echo $MachineMoldTerimalB ?></label>
                                            <input type="textbox" name="TextBoxMachineMoldTerminalB" size="7px"
                                                   style="width: 100px"
                                                   value="<?php echo $TextBoxMoldTerminalB ?>" disabled>
                                            <input type="textbox" name="TextBoxNameMachineMoldTerminalB" size="7px"
                                                   style="width: 115px;margin-left: 5px;"
                                                   value="<?php if ($TextBoxMoldTerminalB <> '') echo($TextBoxTerminalB) ?>"
                                                   disabled>
                                        </div>
                                    </fieldset>

                                    <fieldset style="margin-top: 5px;">
                                        <legend><?php echo $GroupMoldOfTermial; ?></legend>
                                        <div class="Tabrow">
                                            <label><?php echo $TerminalA ?></label>
                                            <input type="textbox" name="TextBoxTerminalA"
                                                   value="<?php echo $TextBoxTerminalA ?>"
                                                   size="7px" style="width: 220px" disabled>
                                        </div>
                                        <div class="Tabrow">
                                        <textarea name="ucNoteTerminalA"
                                                  disabled><?php echo $CurrentLisMoldTerminalA ?></textarea>
                                        </div>
                                        <div class="Tabrow">
                                            <label><?php echo $TerminalB ?></label>
                                            <input type="text" name="TextBoxTerminalB" size="7px"
                                                   style="width: 220px"
                                                   value="<?php echo $TextBoxTerminalB ?>" disabled>
                                        </div>
                                        <div class="Tabrow">
                                        <textarea name="ucNoteTerminalB"
                                                  disabled><?php echo $CurrentLisMoldTerminalB ?></textarea>
                                        </div>
                                    </fieldset>
                                </div>

                            </div>
                        </DIV>
                    </div>

                    <div id="<?php echo $TabControlRemoveMold ?>" class="tabcontent" style="height: 250px;">
                        <DIV CLASS="Tabfull">
                            <form method="post">
                                <div class="Tabrow" style="margin: 0;">

                                    <div class="Tabrow">
                                        <label> <?php echo $Operation ?></label>
                                        <input type="textbox" name="TextBoxOperationID" id="TextBoxOperationID"
                                               size="7px"

                                               style="width: 80px" value="<?php echo $CurrentOperationID ?>"
                                               disabled>
                                        <input type="textbox" name="TextBoxNameOperationID" size="7px"
                                               style="width: 200px;margin-left: 5px;"
                                               value="<?php echo($TextBoxNameOperationID) ?>"
                                               title="<?php echo($TextBoxNameOperationID) ?>" disabled>
                                    </div>

                                    <div class="Tabrow">
                                        <label> <?php echo $HandlerAID ?></label>
                                        <input type="textbox" name="TextBoxHandlerAID" size="7px"
                                               style="width: 80px"
                                               value="<?php echo($TextBoxEmployeeID) ?>" disabled>
                                        <input type="textbox" name="TextBoxNameHandlerAID"
                                               style="width: 200px;margin-left: 5px;"
                                               value="<?php echo($TextBoxNameEmployee) ?>"
                                               title="<?php echo($TextBoxNameEmployee) ?>" disabled>
                                    </div>

                                    <div class="Tabrow">
                                        <div class="Tabcolumn" style="width: 400px; margin: 0">
                                            <label><?php echo $MoldTerimalA ?></label>
                                            <input style="width: 285px" type="text"
                                                   name="TextBoxMoldTerminalA"
                                                   value="<?php echo $TextBoxMoldTerminalA; ?>" disabled/>
                                        </div>
                                        <div class="Tabcolumn" style="width: 300px; margin-top: 2px">
                                            <input style="width: 50px;height: 15px" type="Checkbox"
                                                   name="CheckboxMoldTermialA"
                                                   id="CheckboxMoldTermialA"> <?php echo $RemoveMoldA; ?>
                                        </div>

                                    </div>

                                    <div class="Tabrow">
                                        <label><?php echo $TerminalA ?></label>
                                        <input type="textbox" name="TextBoxTerminalA"
                                               style="width: 285px;"
                                               value="<?php if ($TextBoxMoldTerminalA <> '') echo $TextBoxTerminalA ?>"
                                               disabled>

                                    </div>

                                    <div class="Tabrow">
                                        <div class="Tabcolumn" style="width: 400px; margin: 0">
                                            <label><?php echo $MoldTerimalB ?></label>
                                            <input style="width: 285px" type="text" id="MoldTerimalB"
                                                   name="TextBoxMoldTerminalB"
                                                   value="<?php echo $TextBoxMoldTerminalB; ?>" disabled/>
                                        </div>
                                        <div class="Tabcolumn" style="width: 300px; margin-top: 2px">
                                            <input style="width: 50px;height: 15px" type="Checkbox"
                                                   name="CheckboxMoldTermialB"
                                                   id="CheckboxMoldTermialB"> <?php echo $RemoveMoldB; ?>
                                        </div>
                                    </div>

                                    <div class="Tabrow">
                                        <label><?php echo $TerminalB ?></label>
                                        <input type="textbox" name="TextBoxTerminalB" style="width: 285px;"
                                               value="<?php if ($TextBoxMoldTerminalB <> '') echo $TextBoxTerminalB ?>"
                                               disabled>
                                    </div>
                                    <div class="Tabrow">
                                        <input style="margin-left: 450px;width: 100px;" type="Submit"
                                               name="ButtonChangeMold" id="ButtonChangeMold"
                                               value="<?php echo $Remove; ?>">
                                    </div>

                                </div>
                            </form>
                        </DIV>
                    </div>

                    <div id="<?php echo $TabControlQualityControl; ?>" class="tabcontent">
                        <DIV CLASS="Tabfull">
                            <div class="Tabrow" style="margin: 0;">
                                <div class="Tableft"
                                     style="width: 60%; border-style: solid;border-width: 0.5px;border-color: #E6E6E6; height: 322px;">
                                    <div class="Tabrow">
                                        <label> <?php echo $Operation ?></label>
                                        <input type="textbox" name="TextBoxOperationID" id="TextBoxOperationID"
                                               size="7px"

                                               style="width: 50px" value="<?php echo $CurrentOperationID ?>"
                                               disabled>
                                        <input type="textbox" name="TextBoxNameOperationID" size="7px"
                                               style="width: 145px;margin-left: 5px;"
                                               value="<?php echo($TextBoxNameOperationID) ?>"
                                               title="<?php echo($TextBoxNameOperationID) ?>" disabled>
                                    </div>

                                    <div class="Tabrow">
                                        <div class="Tabcolumn" style="width: 320px;margin-left: 0px;">
                                            <label> <?php echo $HandlerAID; ?></label>
                                            <input type="textbox" name="TextBoxHandlerAID" size="7px"
                                                   style="width: 50px"
                                                   value="<?php echo($TextBoxEmployeeID) ?>" disabled>
                                            <input type="textbox" name="TextBoxNameHandlerAID"
                                                   style="width: 145px;margin-left: 5px;"
                                                   value="<?php echo($TextBoxNameEmployee) ?>"
                                                   title="<?php echo($TextBoxNameEmployee) ?>" disabled>
                                        </div>
                                        <div class="Tabcolumn" style="width:185px;margin-left: 0px;">
                                            <label style="width: 100px"><?php echo $ProductQty ?></label>
                                            <input type="textbox" name="TextBoxProductQty"
                                                   style="width: 85px;"
                                                   value="<?php if ($TextBoxProductQty > 0) echo number_format($TextBoxProductQty); else echo 0 ?>"
                                                   disabled>
                                        </div>

                                    </div>
                                    <div class="Tabrow">
                                        <div class="Tabcolumn" style="width: 320px;margin-left: 0px;">
                                            <label><?php echo $CommandID ?></label>
                                            <input type="text" name="TextBoxCommandID" size="7px"
                                                   value="<?php echo $TextBoxCommandID ?>" disabled>
                                        </div>
                                        <div class="Tabcolumn" style="width:185px;margin-left: 0px;">
                                            <label style="width: 100px"><?php echo $ProducedQty ?></label>
                                            <input type="textbox" name="TextBoxProducedQty"
                                                   style="width: 85px;"
                                                   value="<?php echo number_format($TextBoxProducedQty) ?>"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="Tabrow">
                                        <div class="Tabcolumn" style="width: 320px;margin-left: 0px;">
                                            <label><?php echo $LoopID; ?></label>
                                            <input style="width: 200px" type="textbox" name="TextBoxLoopID"
                                                   value="<?php echo $TextBoxLoopID ?>"
                                                   disabled>
                                        </div>
                                        <div class="Tabcolumn" style="width:185px;margin-left: 0px;">
                                            <label style="width: 100px"><?php echo $UnProduceQty; ?></label>
                                            <input type="textbox" name="TextBoxUnProduceQty"
                                                   style="width: 85px;"
                                                   value="<?php echo number_format($TextBoxUnProduceQty) ?>"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="Tabrow">
                                        <form method="post">
                                            <div class="Tabcolumn" style="width: 300px;margin-left: 0px;">
                                                <label><?php echo $MoldTerimalA ?></label>
                                                <input type="text" name="TextBoxMoldTerminalA"
                                                       value="<?php echo $TextBoxMoldTerminalA; ?>" disabled/>
                                            </div>
                                        </form>
                                        <div class="Tabcolumn" style="width: 185px;margin-left: 20px;">
                                            <label><?php echo $TerminalA ?></label>
                                            <input type="textbox" name="TextBoxTerminalA"
                                                   style="width: 85px;"
                                                   value="<?php echo $TextBoxTerminalA ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="Tabrow">
                                        <form method="post">
                                            <div class="Tabcolumn" style="width: 300px;;margin-left: 0px;">
                                                <label><?php echo $MoldTerimalB ?></label>
                                                <input type="text" id="MoldTerimalB" name="TextBoxMoldTerminalB"

                                                       value="<?php echo $TextBoxMoldTerminalB; ?>" disabled/>
                                            </div>
                                        </form>
                                        <div class="Tabcolumn" style="width: 185px;;margin-left: 20px;">
                                            <label><?php echo $TerminalB ?></label>
                                            <input type="text" name="TextBoxTerminalB" style="width: 85px;"
                                                   value="<?php echo $TextBoxTerminalB ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: -5px; margin-left: 5px; margin-right: 5px"
                                         id="QualityControl4--">
                                        <table border="1">
                                            <tr>
                                                <th width="80px"><?php if ($CurrentOperationID == '4--') echo '4++'; else echo '4--'; ?></th>
                                                <th><?php echo $Length ?></th>
                                                <th><?php echo $PeeledA ?></th>
                                                <th><?php echo $Pressing ?></th>
                                                <th><?php echo $FHeight ?></th>
                                                <th><?php echo $FWidth ?></th>
                                                <th><?php echo $BHeight ?></th>
                                                <th><?php echo $BWidth ?></th>
                                            </tr>
                                            <tr>
                                                <th>Đầu A</th>
                                                <td rowspan="2"><?php echo $ShowLength ?></td>
                                                <td><?php echo $ShowPeeledA ?></td>
                                                <td><?php echo $ShowPressingA ?></td>
                                                <td><?php echo $ShowFHeightA ?></td>
                                                <td><?php echo $ShowFWidthA ?></td>
                                                <td><?php echo $ShowBHeightA ?></td>
                                                <td><?php echo $ShowBWidthA ?></td>
                                            </tr>
                                            <tr>
                                                <th>Đầu B</th>
                                                <td><?php echo $ShowPeeledB ?></td>
                                                <td><?php echo $ShowPressingB ?></td>
                                                <td><?php echo $ShowFHeightB ?></td>
                                                <td><?php echo $ShowFWidthB ?></td>
                                                <td><?php echo $ShowBHeightB ?></td>
                                                <td><?php echo $ShowBWidthB ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="Tableft"
                                     style="width: 39%; margin-left: 5px;border: none">

                                    <fieldset style="margin-top: 5px;">
                                        <legend><?php echo $MoldAndTermial ?></legend>
                                        <div class="Tabrow">
                                            <label title="<?php echo $MachineMoldTerimalA ?>"><?php echo $MachineMoldTerimalA ?></label>
                                            <input type="textbox" name="TextBoxMachineMoldTerminalA" size="7px"
                                                   disabled style="width: 100px"
                                                   value="<?php echo $TextBoxMoldTerminalA ?>">
                                            <input type="textbox" name="TextBoxNameMachineMoldTerminalA" size="7px"
                                                   style="width: 115px;margin-left: 5px;"
                                                   value="<?php if ($TextBoxMoldTerminalA <> '') echo($TextBoxTerminalA) ?>"
                                                   disabled>
                                        </div>
                                        <div class="Tabrow">
                                            <label title="<?php echo $MachineMoldTerimalB ?>"><?php echo $MachineMoldTerimalB ?></label>
                                            <input type="textbox" name="TextBoxMachineMoldTerminalB" size="7px"
                                                   style="width: 100px"
                                                   value="<?php echo $TextBoxMoldTerminalB ?>" disabled>
                                            <input type="textbox" name="TextBoxNameMachineMoldTerminalB" size="7px"
                                                   style="width: 115px;margin-left: 5px;"
                                                   value="<?php if ($TextBoxMoldTerminalB <> '') echo($TextBoxTerminalB) ?>"
                                                   disabled>
                                        </div>
                                    </fieldset>


                                    <fieldset style="margin-top: 5px;">
                                        <legend><?php echo $GroupMoldOfTermial ?></legend>
                                        <div class="Tabrow">
                                            <label><?php echo $TerminalA ?></label>
                                            <input type="textbox" name="TextBoxTerminalA"
                                                   value="<?php echo $TextBoxTerminalA ?>"
                                                   size="7px" style="width: 220px" disabled>
                                        </div>
                                        <div class="Tabrow">
                                        <textarea name="ucNoteTerminalA"
                                                  disabled><?php echo $CurrentLisMoldTerminalA ?></textarea>
                                        </div>
                                        <div class="Tabrow">
                                            <label><?php echo $TerminalB ?></label>
                                            <input type="text" name="TextBoxTerminalB" size="7px"
                                                   style="width: 220px"
                                                   value="<?php echo $TextBoxTerminalB ?>" disabled>
                                        </div>
                                        <div class="Tabrow">
                                        <textarea name="ucNoteTerminalB"
                                                  disabled><?php echo $CurrentLisMoldTerminalB ?></textarea>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="Tabrow" style="margin: 0px">
                                <form method="post">
                                    <div class="Tableft">
                                        <div class="Tabrow">
                                            <h2 style="font-style: unset;font-size: 18px;text-align: left; padding-top: 10px;"><?php echo $GroupQC; ?></h2>
                                        </div>
                                        <div class="Tabrow" style="margin-top: 15px">
                                            <label style="width: 80px; margin-left: 25px"><?php echo $Length; ?></label>
                                            <input type="text" name="NumberLength" id="NumberLength"
                                                   value="<?php echo $NumberLengths ?>"
                                                   style="width: 80px;text-align: center" tabindex="1"
                                                   autocomplete="off" step="any" placeholder="0"
                                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                   maxlength="4">
                                        </div>
                                    </div>
                                    <div class="Tabmid">
                                        <div class="Tabrow">
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"><?php echo $PeeledA; ?></label>
                                                <input type="text" value="<?php echo $NumberPeeledA ?>"
                                                       name="NumberPeeledA"
                                                       id="NumberPeeledA" style="width: 70px;text-align: center"
                                                       tabindex="2" autocomplete="off" placeholder="0.0"
                                                       onkeypress="return( currencyFormat(this,'.',event))">
                                            </div>
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"><?php echo $Pressing; ?></label>
                                                <input type="textbox" value="<?php echo $NumberPressingA ?>"
                                                       name="NumberPressingA" id="NumberPressingA"
                                                       style="width: 70px;text-align: center" tabindex="3"
                                                       autocomplete="off" step="any" placeholder="0.00"
                                                       onkeypress="return(currencyFormat(this,'.',event))">
                                            </div>
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"><?php echo $FHeight; ?></label>
                                                <input type="textbox" value="<?php echo $NumberFHeight ?>"
                                                       name="NumberFHeight" id="NumberFHeight"
                                                       style="width: 70px;text-align: center" tabindex="4"
                                                       autocomplete="off" step="any" placeholder="0.00"
                                                       onkeypress="return(currencyFormat(this,'.',event))">
                                            </div>
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"><?php echo $FWidth; ?></label>
                                                <input type="textbox" value="<?php echo $NumberFWidthA ?>"
                                                       name="NumberFWidthA"
                                                       id="NumberFWidthA" style="width: 70px;text-align: center"
                                                       tabindex="5" autocomplete="off" step="any" placeholder="0.00"
                                                       onkeypress="return(currencyFormat(this,'.',event))">
                                            </div>
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"><?php echo $BHeight; ?></label>
                                                <input type="textbox" name="NumberBHeightA"
                                                       style="width: 70px;text-align: center" id="NumberBHeightA"
                                                       tabindex="6" value="<?php echo $NumberBHeightA ?>"
                                                       autocomplete="off" step="any" placeholder="0.00"
                                                       onkeypress="return(currencyFormat(this,'.',event))">
                                            </div>
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"><?php echo $BWidth; ?></label>
                                                <input type="textbox" name="NumberBWidthA"
                                                       style="width: 70px;text-align: center" id="NumberBWidthA"
                                                       tabindex="7" value="<?php echo $NumberBWidthA ?>"
                                                       autocomplete="off"
                                                       step="any" placeholder="0.00"
                                                       onkeypress="return(currencyFormat(this,'.',event))">
                                            </div>
                                        </div>
                                        <div class="Tabrow">
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"><?php echo $PeeledB; ?></label>
                                                <input type="textbox" name="NumberPeeledB"
                                                       style="width: 70px;text-align: center" id="NumberPeeledB"
                                                       tabindex="8" value="<?php echo $NumberPeeledB ?>"
                                                       autocomplete="off"
                                                       step="any" placeholder="0.0"
                                                       onkeypress="return(currencyFormat(this,'.',event))">
                                            </div>
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"> <?php echo $Pressing ?></label>
                                                <input type="textbox" name="NumberPressingB"
                                                       style="width: 70px;text-align: center" id="NumberPressingB"
                                                       tabindex="9" value="<?php echo $NumberPressingB ?>"
                                                       autocomplete="off" step="any" placeholder="0.00"
                                                       onkeypress="return(currencyFormat(this,'.',event))">
                                            </div>
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"><?php echo $FHeight ?></label>
                                                <input type="textbox" name="NumberFHeightB"
                                                       style="width: 70px;text-align: center" id="NumberFHeightB"
                                                       tabindex="10" value="<?php echo $NumberFHeightB ?>"
                                                       autocomplete="off" step="any" placeholder="0.00"
                                                       onkeypress="return(currencyFormat(this,'.',event))">
                                            </div>
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"><?php echo $FWidth ?></label>
                                                <input type="textbox" name="NumberFWidthB"
                                                       style="width: 70px;text-align: center" id="NumberFWidthB"
                                                       tabindex="11" value="<?php echo $NumberFWidthB ?>"
                                                       autocomplete="off" step="any" placeholder="0.00"
                                                       onkeypress="return(currencyFormat(this,'.',event))">
                                            </div>
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"><?php echo $BHeight ?></label>
                                                <input type="textbox" name="NumberBHeightB"
                                                       style="width: 70px;text-align: center" id="NumberBHeightB"
                                                       tabindex="12" value="<?php echo $NumberBHeightB ?>"
                                                       autocomplete="off" step="any" placeholder="0.00"
                                                       onkeypress="return(currencyFormat(this,'.',event))">
                                            </div>
                                            <div class="Tabcolumn">
                                                <label style="margin-bottom: 5px;margin-left: -13px"><?php echo $BWidth ?></label>
                                                <input type="textbox" name="NumberBWidthB"
                                                       style="width: 70px;text-align: center" id="NumberBWidthB"
                                                       tabindex="13" value="<?php echo $NumberBWidthB ?>"
                                                       autocomplete="off" step="any" placeholder="0.00"
                                                       onkeypress="return(currencyFormat(this,'.',event))">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Tabright">
                                        <input type="submit" tabindex="14"
                                               value="<?php echo $Save; ?>"
                                               name="ButtonSave" id="ButtonSave" style="width: 80px;">
                                    </div>
                                </form>
                            </div>
                        </DIV>
                    </div>

                    <div id="<?php echo $TabControlRepairMachine; ?>" class="tabcontent" style="height:200px">
                        <DIV CLASS="Tabfull">
                            <form method="post">
                                <div CLASS="Tabrow">
                                    <div class="Tabrow">
                                        <label> <?php echo $Operation ?></label>
                                        <input type="textbox" name="TextBoxOperationID" id="TextBoxOperationID"
                                               size="7px"

                                               style="width: 80px" value="<?php echo $CurrentOperationID ?>"
                                               disabled>
                                        <input type="textbox" name="TextBoxNameOperationID" size="7px"
                                               style="width: 200px;margin-left: 5px;"
                                               value="<?php echo($TextBoxNameOperationID) ?>"
                                               title="<?php echo($TextBoxNameOperationID) ?>" disabled>
                                    </div>

                                    <div class="Tabrow">
                                        <label> <?php echo $Remodeler; ?></label>
                                        <select style="width: 285px;height: 25px;float: left;" name="ucRemodeler">
                                            <option></option>
                                            <?php
                                            for ($i = 0; $i < count($TableEmployeeInfo); $i++) {
                                                ?>
                                                <option value="<?= $TableEmployeeInfo[$i]['EmployeeAID'] ?>">
                                                    <?= $TableEmployeeInfo[$i]['EmployeeID'] . '( ' . $TableEmployeeInfo[$i][oWorkManager::coEmployeeName] . ' )' ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="Tabrow">
                                        <label> <?php echo $HandlerAID ?></label>
                                        <input type="textbox" name="TextBoxHandlerAID" size="7px"
                                               style="width: 80px"
                                               value="<?php echo($TextBoxEmployeeID) ?>" disabled>
                                        <input type="textbox" name="TextBoxNameHandlerAID"
                                               style="width: 200px;margin-left: 5px;"
                                               value="<?php echo($TextBoxNameEmployee) ?>"
                                               title="<?php echo($TextBoxNameEmployee) ?>" disabled>
                                    </div>

                                    <div class="Tabrow">
                                        <label title="<?php echo $RemodelingTime; ?>"><?php echo $RemodelingTime ?></label>
                                        <input type="date" name="TextBoxRemodelingTime"
                                               style="width: 285px;">
                                    </div>

                                    <div>
                                        <input style="margin-left: 500px; width: 60px; margin-top: -15px;"
                                               type="submit"
                                               name="ButtonSubmitRepair" id="ButtonSubmitRepair" value="Save">
                                    </div>

                                </div>
                            </form>
                        </DIV>
                    </div>
                </div>
            </DIV>
        </div>
    </DIV>
    <?php
}
?>
<script type="text/javascript">

    showContent('<?php echo $TabControlMachineOperation ?>');
    var TerminalA = '<?php echo $TextBoxTerminalA ?>';
    var TerminalB = '<?php echo $TextBoxTerminalB?>';
    var Length = "<?php echo $NumberLengths?>";
    var ucMoldA = "<?php echo $TextBoxMoldTerminalA?>";
    var ucMoldB = "<?php echo $TextBoxMoldTerminalB?>";
    var ucFocus = "<?php echo $CurrentOperationID?>";
    var ucTab = "<?php echo $CurrentGroupOperation?>";
    var FocusTerminalA = "<?php echo $CheckSetTerminalA?>";
    var FocusTerminalB = "<?php echo $CheckSetTerminalB?>";
    if (ucTab === "1") {
        showContent('<?php echo $TabControlMachineOperation ?>');
        document.getElementById('button1').style.background = "gray";
        if (ucFocus === '1AA') {
            if (FocusTerminalA === '6W' && FocusTerminalB === '6W') {
                if (ucMoldA === "") {
                    $('#MoldTerimalA').focus();
                } else if (ucMoldB === "") {
                    $('#MoldTerimalB').focus();
                }
            } else if (FocusTerminalA === '8S') {
                if (ucMoldA === "") {
                    $('#MoldTerimalA').focus();
                }
            } else if (FocusTerminalB === '8S') {
                if (ucMoldB === "") {
                    $('#MoldTerimalB').focus();
                }
            }
        }

    } else if (ucTab === "2") {
        showContent('<?php echo $TabControlRemoveMold ?>');
        document.getElementById('button2').style.background = "gray";
    } else if (ucTab === "3") {
        showContent('<?php echo $TabControlQualityControl; ?>');
        document.getElementById('button3').style.background = "gray";
        if (((ucFocus === "4--") || (ucFocus === "4++")) && (Length === '')) {
            $('#NumberLength').focus();
        }
    } else if (ucTab === "4") {
        showContent('<?php echo $TabControlRepairMachine; ?>');
        document.getElementById('button4').style.background = "gray";
    }

    var Barcode = '<?php echo $CurrentOperationID?>';
    var CurrentProduceQty = '<?php echo $CurrentProduceQty ?>';
    if (Barcode === '2AA' || Barcode === '2WW') {
        document.getElementById("Produce").style.display = 'block';
        if (CurrentProduceQty === '')
            document.getElementById('CurrentProduceQty').focus();
    } else {
        document.getElementById("Produce").style.display = 'none';
    }

    var GroupOperation = "<?php echo $CurrentGroupOperation?>";
    var BarcodeContine = '<?php if (isset($_POST['TextBoxBarcodeScanner'])) echo $_POST['TextBoxBarcodeScanner'] ?>';
    var CommandStage = '<?php if (isset($_SESSION[oWorkManager::_CurrentCirictLoopItemAID])) echo 1?>';
    var ShowBarcode = '<?php echo $vStatus->vShowButtonContinue?>';
    var Operation = '<?php echo $CurrentOperationID?>';
    var ShowDialog = '<?php $vStatus->vShowDialog;?>';

    if (ShowBarcode === '1') {
        if (window.confirm(ShowDialog)) {
            document.getElementById('ButtonContinue').click();
        }
    }

    if (Operation === '1AA') {
        if (FocusTerminalA === 'P') {
            document.getElementById('MoldTerimalA').disabled = true;
        } else if (FocusTerminalB === 'P') {
            document.getElementById('MoldTerimalB').disabled = true;
        } else {
            document.getElementById('MoldTerimalA').disabled = false;
            document.getElementById('MoldTerimalB').disabled = false;
        }
    } else {
        document.getElementById('MoldTerimalA').disabled = true;
        document.getElementById('MoldTerimalB').disabled = true;
    }


    if (BarcodeContine === '4--' || BarcodeContine === '4++') {
        document.getElementById('ButtonSave').disabled = false;
        document.getElementById('NumberLength').disabled = false;
        document.getElementById('NumberPeeledA').disabled = false;
        document.getElementById('NumberPressingA').disabled = false;
        document.getElementById('NumberFHeight').disabled = false;
        document.getElementById('NumberFWidthA').disabled = false;
        document.getElementById('NumberBHeightA').disabled = false;
        document.getElementById('NumberBWidthA').disabled = false;
        document.getElementById('NumberPeeledB').disabled = false;
        document.getElementById('NumberPressingB').disabled = false;
        document.getElementById('NumberFHeightB').disabled = false;
        document.getElementById('NumberFWidthB').disabled = false;
        document.getElementById('NumberBHeightB').disabled = false;
        document.getElementById('NumberBWidthB').disabled = false;

    } else {
        document.getElementById('ButtonSave').disabled = true;
        document.getElementById('NumberLength').disabled = true;
        document.getElementById('NumberPeeledA').disabled = true;
        document.getElementById('NumberPressingA').disabled = true;
        document.getElementById('NumberFHeight').disabled = true;
        document.getElementById('NumberFWidthA').disabled = true;
        document.getElementById('NumberBHeightA').disabled = true;
        document.getElementById('NumberBWidthA').disabled = true;
        document.getElementById('NumberPeeledB').disabled = true;
        document.getElementById('NumberPressingB').disabled = true;
        document.getElementById('NumberFHeightB').disabled = true;
        document.getElementById('NumberFWidthB').disabled = true;
        document.getElementById('NumberBHeightB').disabled = true;
        document.getElementById('NumberBWidthB').disabled = true;
    }
    if (BarcodeContine === '4++') {
        document.getElementById('QualityControl4--').style.display = 'block';
    } else {
        document.getElementById('QualityControl4--').style.display = 'none';
    }

    var QC = "<?php if (isset($_POST['ButtonSave'])) echo '1'?>";
    if (QC === '1') {
        document.getElementById('TextBoxBarcodeScanner').disabled = false;
        document.getElementById('TextBoxBarcodeScanner').focus();
    }

    $('#NumberLength').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberPeeledA').focus();
            event.preventDefault();
        }
    });
    $('#NumberPeeledA').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberPressingA').focus();
            event.preventDefault();
        }
    });
    $('#NumberPressingA').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberFHeight').focus();
            event.preventDefault();
        }
    });
    $('#NumberFHeight').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberFWidthA').focus();
            event.preventDefault();
        }
    });
    $('#NumberFWidthA').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberBHeightA').focus();
            event.preventDefault();
        }
    });
    $('#NumberBHeightA').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberBWidthA').focus();
            event.preventDefault();
        }
    });
    $('#NumberBWidthA').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberPeeledB').focus();
            event.preventDefault();
        }
    });
    $('#NumberPeeledB').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberPressingB').focus();
            event.preventDefault();
        }
    });
    $('#NumberPressingB').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberFHeightB').focus();
            event.preventDefault();
        }
    });
    $('#NumberFHeightB').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberFWidthB').focus();
            event.preventDefault();
        }
    });
    $('#NumberFWidthB').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberBHeightB').focus();
            event.preventDefault();
        }
    });
    $('#NumberBHeightB').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#NumberBWidthB').focus();
            event.preventDefault();
        }
    });
    $('#NumberBWidthB').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('ButtonSave').click();
        }
    });
    $('#CurrentProduceQty').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#ButtonUpdateProduced').click();
        }
    });
</script>

<?php
if (isset($_POST['ButtonHiddenLogOut'])) {
    session_unset();
    echo "<script>window.location = '../../../../index.php'</script>";
}
if (isset($_POST['ButtonLogOut'])) {
    $TBLogOut = $vProcessForm->Translate('TBLogout');
    echo "
           <script> 
              if (confirm('$TBLogOut') === true)
                 document.getElementById('ButtonHiddenLogOut').click();
           </script>
           ";
}
