//thể hiện kiểu tác động vào là gì -> Đưa ra action đó và sẽ hiển thị thông tin chính xác
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    Name: <input type="text" name="fname">
</form>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
   <input type="submit" name="SubmitOK" value="Sav">
</form>

<div class="row" style="margin-top: 0">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <input style="width: 165px;height: 30px;float: right; background-color: #FFFFCC; font-size: 16px;font-weight: bold;text-align: center;"
               type="text" name="TextBoxBarcodeScanner" tabindex="1"
               id="TextBoxBarcodeScanner" autofocus autocomplete="off" required>
    </form>
</div>

<?php
include_once ("../../eBOSS/LoadLibrabry.php");
echo '<br>';
$PostHtml = new ucRequestHtml();
echo $PostHtml->PostHtml('SubmitOK');
echo '<br>';
echo $PostHtml->PostHtml('fname');
echo '<br>';
echo $PostHtml->PostHtml('TextBoxBarcodeScanner');

$vProcessForm = new ProcessForm('NameVietnamese');
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
