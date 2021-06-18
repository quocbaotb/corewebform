<script type="text/javascript">

    showContent('<?php echo $TabControlMachineOperation ?>');
    var Length = '<?php echo $NumberLengths?>';
    var ucMoldA = '<?php echo $TextBoxMoldTerminalA?>';
    var ucMoldB = '<?php echo $TextBoxMoldTerminalB?>';
    var ucFocus = '<?php echo $CurrentOperationID?>';
    var ucTab = '<?php echo $CurrentGroupOperation?>';
    var FocusTerminalA = '<?php echo $CheckSetTerminalA?>';
    var FocusTerminalB = '<?php echo $CheckSetTerminalB?>';
    if (ucTab === "1") {
        showContent('<?php echo $TabControlMachineOperation ?>');
        document.getElementById('button1').style.background = "gray";
        if (ucFocus === 'A01') {
            if (FocusTerminalA === '6W' && FocusTerminalB === '6W') {
                if (ucMoldA === '') {
                    $('#MoldTerimalA').focus();
                } else if (ucMoldB === '') {
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
        if (((ucFocus === "A10") || (ucFocus === "A11")) && (Length === '')) {
            $('#NumberLength').focus();
        }
    } else if (ucTab === "4") {
        showContent('<?php echo $TabControlRepairMachine; ?>');
        document.getElementById('button4').style.background = "gray";
    }

    var Barcode = '<?php echo $CurrentOperationID?>';
    var CurrentProduceQty = '<?php echo $CurrentProduceQty ?>';
    if (Barcode === 'A12' || Barcode === 'A13') {
        document.getElementById("Produce").style.display = 'block';
        if (CurrentProduceQty === '' || CurrentProduceQty === 0)
            document.getElementById('CurrentProduceQty').focus();
    } else {
        document.getElementById("Produce").style.display = 'none';
    }

    var ShowBarcode = '<?php echo $IsNeedConfirmed?>';
    var Operation = '<?php echo $CurrentOperationID?>';
    var ShowDialog = '<?php echo $DialogConfirmed?>';

    if (ShowBarcode === '1') {
        if (window.confirm(ShowDialog)) {
            document.getElementById('ButtonContinue').click();
        }
    }

    if (Operation === 'A01') {
        if (ucMoldA !== '') {
            document.getElementById('MoldTerimalA').disabled = true;
        }
        if (ucMoldB !== '') {
            document.getElementById('MoldTerimalB').disabled = true;
        }
/*        document.getElementById('MoldTerimalA').disabled = false;
        document.getElementById('MoldTerimalB').disabled = false;*/
    } else {
        document.getElementById('MoldTerimalA').disabled = true;
        document.getElementById('MoldTerimalB').disabled = true;
    }


    if (ucFocus === 'A10' || ucFocus === 'A11') {
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

if (isset($_POST['ButtonLogOut'])) {
    $TBLogOut = $vProcessForm->Translate('TBLogout');
    echo "
           <script> 
              if (confirm('$TBLogOut') === true)
                 document.getElementById('ButtonHiddenLogOut').click();
           </script>
           ";
}
