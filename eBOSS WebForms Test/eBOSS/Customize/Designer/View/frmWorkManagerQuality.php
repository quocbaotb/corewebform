<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="../CSS/style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="../../../Core/JavaScript/fGeneral.js"></script>
<script src="../../JavaScript/fJavaScript.js"></script>

<?php

include_once("vwProcessWorkManagerQuality.php");
?>

<section id="quality">
    <DIV CLASS="main">
        <div class="full">

            <div class="row"
                 style="border-bottom: solid; border-color: #E6E6E6; border-width: 0.5px; margin: 10px 0px 0px;">
                <h2 style="font-size: 20px"
                    value="WorkManagerQuality"><?php echo $WorkManagerQuality; ?></h2>
                <form method="post">
                    <input style="width: 80px;height: 38px;float: right; margin-top: -40px; margin-right: 20px;"
                           type="submit" id="ButtonLogOut" name="ButtonLogOut"
                           value="<?php echo $LogOut ?>">
                    <input style="width: 1px;height: 1px;float: right;" type="submit" id="ButtonHiddenLogOut"
                           name="ButtonHiddenLogOut"
                           value="ButtonHiddenLogOut" hidden>
                </form>
            </div>


            <div class="row">
                <fieldset class="top-quality-left">
                    <legend><?php echo $GroupLastQuality ?></legend>

                    <div class="quality-left">
                        <div class="row">
                            <label><?php echo $CheckBarcodeScanner ?></label>
                            <div class="up-size-2">
                                <form method="post">
                                    <input type="text" name="TextboxBarcodeScanner" id="TextboxBarcodeScanner"
                                           autocomplete="off" autofocus>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <label><?php echo $CheckCommand ?></label>
                            <input name="TextboxCommandID" type="text" value="<?php echo $CurrentCommandID ?>" disabled>
                        </div>

                        <div class="row">
                            <label><?php echo $CheckSerial ?></label>
                            <input type="text" name="TextboxSerialNo" value="<?php echo $CurrentSerialNo ?>" disabled>
                            <div class="checkbox-input">
                                <input type="checkbox" name="CheckboxCheckNo2" <?php if ($CurrentBarcodeIsCheckNo2 === 1) echo 'checked';?> disabled><?php echo $CheckNumberTwo ?>
                            </div>
                        </div>

                        <div class="row">
                            <label><?php echo $CheckProduct ?></label>
                            <div class="down-size">
                                <input type="text" name="TextboxProductID" value="<?php echo $CurrentProductID ?>"
                                       disabled>
                            </div>

                            <div class="Tabcolumn">
                                <div class="up-size-1">
                                    <input type="text" name="TextboxProductName"
                                           value="<?php echo $CurrentProductName ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="quality-left">
                                <label><?php echo $CheckQty ?></label>
                                <input type="text" name="TextboxCheckQty" value="<?php echo $CurrentCommandQty ?>"
                                       disabled>

                            </div>

                            <div class="quality-right">
                                <div class="down-size-1">
                                    <label><?php echo $CheckVersion ?></label>

                                    <input type="text" name="TextboxVersionNo" value="<?php echo $CurrentVersionNo ?>"
                                           disabled>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label><?php echo $CheckType ?></label>
                            <div class="up-size-2">
                                <select name="TextboxCheckType" disabled>
                                    <option value="<?php echo $CurrentQualityTypeID ?>">
                                        <?php echo $CurrentQualityTypeID ?>
                                    </option>

                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="quality-right">
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row"></div>
                        <div class="row">
                            <label><?php echo $AutoCheckTime ?></label>

                            <div class="up-size">
                                <input type="text" name="TextboxAutoTime" id="TextboxAutoTime" value="<?php echo $CurrentStartTimeNow ?>" disabled>
                            </div>

                            <div id="TimerCount"></div>

                        </div>
                        <div class="row">
                            <form method="post">
                                <input type="submit" value="OK" name="ButtonOK" id="ButtonOK">
                            </form>
                            <form method="post">
                                <input type="submit" value="NG" name="ButtonNG" id="ButtonNG">
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <input style="width: 100%; background-color: #FFFFCC; color: crimson"
                               name="TextboxQualityStatus" value="<?php echo $CurrentQualityStatus ?>" disabled>

                    </div>

                </fieldset>


                <fieldset class="top-quality-right">
                    <legend>Group 2</legend>

                    <div class="row">
                        <label><?php echo $CheckMachine ?></label>
                        <input type="text" name="TextboxMachineID" id="TextboxMachineID" value="<?php echo $CurrentMachineID ?>" disabled>
                    </div>

                    <div class="row">
                        <label><?php echo $CheckDate ?></label>
                        <input type="text" name="TextboxDateNow" value="<?php echo $CurrentRecordDate ?>" disabled>
                    </div>

                    <div class="row">
                        <label><?php echo $EmployeeCheck1 ?></label>
                        <input type="text" name="TextboxEmployeeCheck1" value="<?php echo $CurrentEmployeeCheck01Name ?>" disabled>
                    </div>

                    <div class="row">
                        <label><?php echo $EmployeeCheck2 ?></label>
                        <input type="text" name="TextboxEmployeeCheck2" value="<?php echo $CurrentEmployeeCheck02Name ?>" disabled>
                    </div>

                    <div class="row">
                        <div style="float: right; margin-right: 6px; text-align: center; padding: 10px ;font-size: 20px; color: blue; border-style: solid; border-width: 1px"
                             id="TimerClock"></div>
                    </div>
                </fieldset>

            </div>

            <div class="row">
                <fieldset class="mid-quality-left">
                    <legend>Group 3</legend>
                    <div class="row">
                        <label><?php echo $CheckCommand ?></label>
                        <input type="text" name="TextboxSqlCommandID" value="<?php echo $CurrentSqlCommandID ?>"
                               disabled>
                    </div>

                    <div class="row">
                        <label><?php echo $CheckSerial ?></label>
                        <div class="input-minion">
                            <input type="text" name="TextboxSqlSerialNo" value="<?php echo $CurrentSqlCheckSerialNo ?>"
                                   disabled>
                        </div>

                        <div class="checkbox-input">
                            <input type="checkbox" name="CheckboxSqlIsNo2" <?php if ($CurrentIsCheckNo2 === 1) echo 'checked';?> value="<?php echo $CurrentIsCheckNo2 ?>" title="Checked" disabled>KT lần 2

                        </div>
                    </div>

                    <div class="row">
                        <label><?php echo $CheckDate ?></label>
                        <input type="text" name="TextboxSqlCheckDate" value="<?php echo $CurrentSqlCheckDate ?>"
                               disabled>
                    </div>

                    <div class="row">
                        <label><?php echo $StartDateTimeCheck ?></label>
                        <input type="text" name="TextboxSqlStartDateTime" value="<?php echo $CurrentSqlStartDateTime ?>"
                               disabled>
                    </div>

                    <div class="row">
                        <label><?php echo $EndDateTimeCheck ?></label>
                        <input type="text" name="TextboxSqlEndDateTime" value="<?php echo $CurrentSqlEndDateTime ?>"
                               disabled>
                    </div>

                    <div class="row">
                        <label><?php echo $TotalCheckTime ?></label>
                        <input type="text" name="TextboxSqlTotalTime" value="<?php echo $CurrentSqlTotalTime ?>"
                               disabled>
                    </div>

                    <div class="row">
                        <label><?php echo $CheckType ?></label>
                        <!--<input type="text" name="TextboxSqlCheckType" disabled>-->
                        <select name="TextboxSqlCheckType" disabled>
                            <option value="<?php echo $CurrentSqlQualityTypeID ?>">
                                <?php echo $CurrentSqlQualityTypeID ?>
                            </option>

                        </select>
                    </div>

                    <div class="row">
                        <label><?php echo $CheckOperation ?></label>
                        <!--<input type="text" name="TextboxSqlOperationID" disabled>-->
                        <select name="TextboxSqlOperationID" disabled>
                            <option value="<?php echo $CurrentCheckSqlOperationID ?>">
                                <?php echo $CurrentCheckSqlOperationID ?>
                            </option>

                        </select>
                    </div>

                </fieldset>

                <fieldset class="mid-quality-right">
                    <legend>Group 4</legend>
                    <div id="mid-quality-top">
                        <div class="row">

                            <label><?php echo $ErrorID ?></label>
                            <div class="Tabcolumn">
                                <form method="post">
                                    <input type="text" name="TextboxErrorID" id="TextboxErrorID"
                                           value="<?php echo $CurrentErrorID ?>">
                                </form>

                            </div>
                            <div class="Tabcolumn">
                                <select name="ComboboxErrorID" disabled>
                                    <option value="<?php echo $CurrentErrorName ?>">
                                        <?php echo $CurrentErrorName ?>
                                    </option>
                                </select>
                                <!--<input style="width: 150px">-->
                            </div>

                        </div>

                        <div class="row">
                            <label><?php echo $ErrorPosition ?></label>

                            <div class="Tabcolumn">
                                <form method="post">
                                    <input type="text" name="TextboxErrorPositionID" id="TextboxErrorPositionID"
                                           value="<?php echo $CurrentErrorPositionID ?>">
                                </form>
                            </div>

                            <div class="Tabcolumn">
                                <select name="ComboxboxErrorPositionID" disabled>
                                    <option value="<?php echo $CurrentErrorPositionName ?>">
                                        <?php echo $CurrentErrorPositionName ?>
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label><?php echo $ErrorCiritLoop ?></label>
                            <form method="post">
                                <div class="Tabrow">
                                    <div class="Tabcolumn">
                                        <input type="text" name="TextboxCiritLoop01ID" id="TextboxCiritLoop01ID"
                                               value="">
                                    </div>

                                    <div class="Tabcolumn">
                                        <input type="text" name="TextboxCiritLoop02ID" id="TextboxCiritLoop02ID"
                                               value="">
                                    </div>

                                    <div class="Tabcolumn">
                                        <input type="text" name="TextboxCiritLoop03ID" id="TextboxCiritLoop03ID"
                                               value="">
                                    </div>

                                    <div class="Tabcolumn">
                                        <input type="text" name="TextboxCiritLoop04ID" id="TextboxCiritLoop04ID"
                                               value="">
                                    </div>
                                    <div class="Tabcolumn">
                                        <input type="submit" name="ButtonRefreshError" id="ButtonRefreshError"
                                               value="Làm mới" disabled>
                                    </div>


                                </div>

                                <label></label>
                                <div class="Tabrow">
                                    <div class="Tabcolumn">
                                        <input type="text" name="TextboxCiritLoop05ID" id="TextboxCiritLoop05ID"
                                               value="">
                                    </div>

                                    <div class="Tabcolumn">
                                        <input type="text" name="TextboxCiritLoop06ID" id="TextboxCiritLoop06ID"
                                               value="">
                                    </div>

                                    <div class="Tabcolumn">
                                        <input type="text" name="TextboxCiritLoop07ID" id="TextboxCiritLoop07ID"
                                               value="">
                                    </div>

                                    <div class="Tabcolumn">
                                        <input type="text" name="TextboxCiritLoop08ID" id="TextboxCiritLoop08ID"
                                               value="">
                                    </div>

                                    <div class="Tabcolumn">
                                        <input type="submit" name="ButtonSaveError" id="ButtonSaveError" value="Lưu">
                                    </div>

                                </div>
                            </form>

                        </div>

                        <div id="mid-quality-mid">
                            <div class="row">
                                <table border="1">
                                    <tr>
                                        <th>Mã</th>
                                        <th><?php echo $ErrorID ?></th>
                                        <th><?php echo $ErrorPosition ?></th>
                                        <th>Tên vị trí lỗi</th>
                                        <th><?php echo $ErrorCiritLoop . ' 1' ?></th>
                                        <th><?php echo $ErrorCiritLoop . ' 2' ?></th>
                                        <th><?php echo $ErrorCiritLoop . ' 3' ?></th>
                                    </tr>
                                    <?php
                                    if (!empty($TableQualityInputNG)) {
                                        for ($i = 0; $i < count($TableQualityInputNG); $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo "" ?></td>
                                                <td><?php echo $TableQualityInputNG[$i][oWorkManagerQuality::coCheckErrorID]; ?></td>
                                                <td><?php echo $TableQualityInputNG[$i][oWorkManagerQuality::coCheckErrorPositionID] ?></td>
                                                <td><?php echo "" ?></td>
                                                <td><?php echo $TableQualityInputNG[$i][oWorkManagerQuality::coCiritLoop01ID] ?></td>
                                                <td><?php echo $TableQualityInputNG[$i][oWorkManagerQuality::coCiritLoop02ID] ?></td>
                                                <td><?php echo $TableQualityInputNG[$i][oWorkManagerQuality::coCiritLoop03ID] ?></td>
                                            </tr>

                                            <?php
                                        }
                                    }
                                    ?>

                                </table>
                            </div>

                        </div>

                        <div class="row">
                            <div class="quality-left">
                                <label><?php echo $EmployeeQuickRepair ?></label>
                                <form method="post">
                                    <input type="text" name="TextboxEmployeeQuickRepair" value="<?php echo $CurrentEmployeeQuickRepairID?>">
                                </form>
                                <div class="up-size">
                                    <select style="width: 145px; margin-left: 5px" name="ComboboxEmployeeNameQuickRepair" disabled>
                                        <option value="<?php echo $CurrentEmployeeNameQuickRepair ?>">
                                            <?php echo $CurrentEmployeeNameQuickRepair ?>
                                        </option>
                                    </select>

                                </div>

                                <div class="checkbox-input">
                                    <input type="checkbox" name="CheckboxReturnRepair" id="CheckboxReturnRepair"><?php echo $IsEmployeeQuickRepair ?>
                                </div>
                            </div>

                            <div class="quality-right">
                                <form method="post">
                                    <input type="submit" name="ButtonSaveCheckQuality" id="ButtonSaveCheckQuality" value="Lưu">
                                </form>
                                <form method="post">
                                    <input type="submit" name="ButtonEndCheckQuality" id="ButtonEndCheckQuality" value="Kết thúc">
                                </form>

                            </div>


                        </div>
                    </div>


                </fieldset>
            </div>

            <div class="row">
                <fieldset class="footer-quality">
                    <legend>Group Footer</legend>
                    <div class="Tabcolumn">
                        <div class="Tabrow">
                            <label><?php echo $CheckCommand ?></label>
                            <input type="text" name="TextboxBarcodeCommandID" disabled>
                        </div>
                    </div>

                    <div class="Tabcolumn">
                        <div class="Tabrow">
                            <label><?php echo $CheckQtyBatch ?></label>
                            <input type="text" name="TextboxBarcodeQtyBatch" disabled>
                        </div>

                        <div class="Tabrow">
                            <label><?php echo $CheckFinishDate ?></label>
                            <input type="text" name="TextboxBarcodeFinishDate" disabled>
                        </div>

                    </div>

                    <div class="Tabcolumn">
                        <div class="Tabrow">
                            <label><?php echo $CheckNeedQty ?></label>
                            <input type="text" name="TextboxBarcodeNeedQty" disabled>
                        </div>

                        <div class="Tabrow">
                            <label><?php echo $CheckGoodQty ?></label>
                            <input type="text" name="TextboxBarcodeGoodQty" disabled>
                        </div>

                    </div>

                    <div class="Tabcolumn">
                        <div class="Tabrow">
                            <label><?php echo $CheckRealQty ?></label>
                            <input type="text" name="TextboxBarcodeRealQty" disabled>
                        </div>

                        <div class="Tabrow">
                            <label><?php echo $CheckNgQty ?></label>
                            <input type="text" name="TextboxBarcodeNgQty" disabled>
                        </div>
                    </div>

                    <div class="Tabcolumn">
                        <div class="Tabrow">
                            <label><?php echo $CheckRate ?></label>
                            <input type="text" name="TextboxBarcodeRate" disabled>
                        </div>

                    </div>

                    <div class="Tabcolumn" style="width: 20%">
                        <div class="Tabrow">
                            <label style="width: 80px"><?php echo $CheckRec ?></label>
                            <input style="width: 90px" type="text" name="TextboxBarcodeRec" disabled>
                        </div>

                        <div class="Tabrow">
                            <label style="width: 80px"><?php echo $CheckTotalTime ?></label>
                            <input style="width: 90px" type="text" name="TextboxBarcodeTotalTime" disabled>
                        </div>

                    </div>

                </fieldset>
            </div>
        </div>
    </DIV>
</section>

<?php
include_once("vwScriptWorkManagerQuality.php");
?>


