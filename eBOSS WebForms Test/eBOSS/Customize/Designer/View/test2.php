<div class="row"
     style="border-bottom: solid; border-color: #E6E6E6; border-width: 0.5px; margin: 10px 0 0;">
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
        <div class="row" style="margin-top: 0">
            <input style="width: 165px;height: 30px;float: right; background-color: #FFFFCC; font-size: 16px;font-weight: bold;text-align: center;"
                   type="text" name="TextBoxBarcodeScanner" tabindex="1"
                   id="TextBoxBarcodeScanner" autofocus autocomplete="off" required>
        </div>
    </form>
</DIV>
<DIV class="mid">
    <div class="row">
        <div class="column" style="margin-left: 0">
            <label style="width: 100px;text-align: center;"><?php echo $CurrentTarget ?></label>
            <br>
            <input style="width: 100px;height: 30px;float: right; margin-top: 10px" type="text" name="DataCurrentTarget"
                   id="DataCurrentTarget" disabled>
        </div>
        <div class="column">
            <label style="width: 100px;text-align: center;"><?php echo $CurrentCount ?></label>
            <br>
            <input style="width: 100px;height: 30px;float: right; margin-top: 10px" type="text" name="DataCurrentCount"
                   disabled>
        </div>
        <div class="column">
            <label style="width: 100px;text-align: center;"><?php echo $Different ?></label>
            <br>
            <input style="width: 100px;height: 30px;float: right; margin-top: 10px" type="text" name="DataDifferent"
                   disabled>
        </div>
        <div class="column">
            <label style="width: 100px;text-align: center;"><?php echo $KnefCutCount ?></label>
            <br>
            <input style="width: 100px;height: 30px;float: right; margin-top: 10px" type="text" name="DataKnefCutCount"
                   disabled>
        </div>
    </div>
    <div class="row" style="margin-top: -15px">
        <input id="Status" name="Status" disabled
               style="background-color: #FFFFCC;margin-left: -206px;text-align: left; width: 635px;border: none;color: crimson"
               value="<?php echo $CurrentStatus ?>">
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
        <input style="text-align: center;width: 100px;height: 30px;float: right;" type="text"
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