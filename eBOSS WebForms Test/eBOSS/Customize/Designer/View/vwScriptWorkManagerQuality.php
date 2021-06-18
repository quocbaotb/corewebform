<?php
$IsShowNG = !empty($_SESSION[oWorkManagerQuality::_CurrentIsShowNg]) ? 1 : 0;
$IsOK = !empty($_SESSION[oWorkManagerQuality::_CurrentIsOK]) ? 1 : 0;

$IsBarcode = !empty($TableQualityResult) ? 1 : 0;
$IsDisableButtonCheck = !empty($TableQualityInput) ? $TableQualityInput[0][oWorkManagerQuality::coIsFinish] : 0;

$IsSavError = !empty($_SESSION[oWorkManagerQuality::_CurrentIsSaveError]) ? 1 : 0;
$IsRefreshError = !empty($_SESSION[oWorkManagerQuality::_CurrentIsRefreshError]) ? 1 : 0;
$IsClickNG = !empty($TableQualityInputNG) ? 1 : 0;
$IsShowButtonReturn = !empty($_SESSION[oWorkManagerQuality::_CurrentEmployeeQuickRepairID]) ? 1 : 0;

$IsFocusErrorID = !empty($CurrentErrorID) ? 0 : 1;
$IsFocusErrorPositionID = !empty($CurrentErrorPositionID) ? 0 : 1;

/*$IsClickSaveCheck = isset($_POST[''])
$IsClickEndCheck =*/

?>
    <script>
        var IsShowNg = '<?php echo $IsShowNG ?>';
        var IsOK = '<?php echo $IsOK ?>';
        var IsDisableButtonCheck = '<?php echo $IsDisableButtonCheck ?>';
        var IsBarcode = '<?php echo $IsBarcode ?>';

        var IsSaveError = '<?php echo $IsSavError ?>';
        var IsRefreshError = '<?php echo $IsRefreshError ?>';

        var IsClickNG = '<?php echo $IsClickNG?>';
        var IsShowCheckboxReturn = '<?php echo $IsShowButtonReturn ?>';


        var IsFocusErrorID = '<?php echo $IsFocusErrorID ?>';
        var IsFocusErrorPositionID = '<?php echo $IsFocusErrorPositionID ?>';

        if (IsShowNg === '1'){
            if (IsFocusErrorID === '1'){
                $('#TextboxErrorID').focus();
            }else if (IsFocusErrorPositionID === '1'){
                $('#TextboxErrorPositionID').focus();
            }else{
                $('#TextboxCiritLoop01ID').focus();
            }
        }else{
            $('#TextboxBarcodeScanner').focus();
        }

        if (IsShowCheckboxReturn === '1') {
            document.getElementById('CheckboxReturnRepair').disabled = true;
        } else {
            document.getElementById('CheckboxReturnRepair').disabled = false;

        }
        if (IsClickNG === '0') {
            document.getElementById('ButtonSaveError').disabled = false;
            document.getElementById('ButtonRefreshError').disabled = true;
            document.getElementById('TextboxErrorPositionID').disabled = false;
            document.getElementById('TextboxErrorID').disabled = false;
            document.getElementById('TextboxCiritLoop01ID').disabled = false;
            document.getElementById('TextboxCiritLoop02ID').disabled = false;
            document.getElementById('TextboxCiritLoop03ID').disabled = false;
            document.getElementById('TextboxCiritLoop04ID').disabled = false;
            document.getElementById('TextboxCiritLoop05ID').disabled = false;
            document.getElementById('TextboxCiritLoop06ID').disabled = false;
            document.getElementById('TextboxCiritLoop07ID').disabled = false;
            document.getElementById('TextboxCiritLoop08ID').disabled = false;
        } else {
            if (IsSaveError === '1' || IsRefreshError === '0') {
                document.getElementById('ButtonSaveError').disabled = true;
                document.getElementById('ButtonRefreshError').disabled = false;
                document.getElementById('TextboxErrorPositionID').disabled = true;
                document.getElementById('TextboxErrorID').disabled = true;
                document.getElementById('TextboxCiritLoop01ID').disabled = true;
                document.getElementById('TextboxCiritLoop02ID').disabled = true;
                document.getElementById('TextboxCiritLoop03ID').disabled = true;
                document.getElementById('TextboxCiritLoop04ID').disabled = true;
                document.getElementById('TextboxCiritLoop05ID').disabled = true;
                document.getElementById('TextboxCiritLoop06ID').disabled = true;
                document.getElementById('TextboxCiritLoop07ID').disabled = true;
                document.getElementById('TextboxCiritLoop08ID').disabled = true;


            } else {
                document.getElementById('ButtonSaveError').disabled = false;
                document.getElementById('ButtonRefreshError').disabled = true;
                document.getElementById('TextboxErrorPositionID').disabled = false;
                document.getElementById('TextboxErrorID').disabled = false;
                document.getElementById('TextboxCiritLoop01ID').disabled = false;
                document.getElementById('TextboxCiritLoop02ID').disabled = false;
                document.getElementById('TextboxCiritLoop03ID').disabled = false;
                document.getElementById('TextboxCiritLoop04ID').disabled = false;
                document.getElementById('TextboxCiritLoop05ID').disabled = false;
                document.getElementById('TextboxCiritLoop06ID').disabled = false;
                document.getElementById('TextboxCiritLoop07ID').disabled = false;
                document.getElementById('TextboxCiritLoop08ID').disabled = false;
            }
        }


        if (IsBarcode === '1') {
            if (IsDisableButtonCheck === '1') {
                document.getElementById('ButtonNG').disabled = true;
                document.getElementById('ButtonOK').disabled = true;
                document.getElementById('mid-quality-top').style.display = 'none';
            } else {
                if (IsShowNg === '1' || IsOK === '1') {
                    document.getElementById('ButtonNG').disabled = true;
                    document.getElementById('ButtonOK').disabled = true;
                    if (IsShowNg === '1') {
                        document.getElementById('mid-quality-top').style.display = 'block';
                    } else {
                        document.getElementById('mid-quality-top').style.display = 'none';
                    }
                } else {
                    document.getElementById('ButtonNG').disabled = false;
                    document.getElementById('ButtonOK').disabled = false;
                    document.getElementById('mid-quality-top').style.display = 'none';
                }
            }
        } else {
            document.getElementById('ButtonNG').disabled = true;
            document.getElementById('ButtonOK').disabled = true;
            document.getElementById('mid-quality-top').style.display = 'none';
        }

    </script>

    <script>
        function TimerClock() {
            var time = new Date();
            var gio = time.getHours();
            var phut = time.getMinutes();
            var giay = time.getSeconds();

            if (gio < 10)
                gio = "0" + gio;
            if (phut < 10)
                phut = "0" + phut;
            if (giay < 10)
                giay = "0" + giay;

            document.getElementById("TimerClock").innerHTML = gio + ":" + phut + ":" + giay;
            setTimeout("TimerClock()", 1000);
        }

        TimerClock();

        function TimerCount() {
            var giay = 0;
            if (giay < 10)
                giay = "0" + giay;

            document.getElementById("TimerCount").innerHTML = giay;
            setTimeout("TimerCount()", 1000);
        }

        TimerCount();

    </script>


<?php

if (isset($_POST['ButtonLogOut'])) {
    $TBLogOut = 'Bạn có thật sự muốn kết thúc phiên làm việc?';
    echo "
           <script> 
              if (confirm('$TBLogOut') === true)
                 document.getElementById('ButtonHiddenLogOut').click();
           </script>
           ";
}
?>

