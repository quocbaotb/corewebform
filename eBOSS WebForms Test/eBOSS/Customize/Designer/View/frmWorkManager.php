<link rel="stylesheet" type="text/css" href="../CSS/frmWorkManager.css">
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
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
include_once('../../../Core/Core.php');
include_once('../../../Customize/Customize.php');
include_once ('../ProcessForms/pWorkManager.php');
if (empty($_SESSION['WorkManagerMachineID'])) {
    echo("<script>alert('Please Login and Setting Database');window.location='../../../../index.php';</script>");
} else {
    include_once ('vwProcessWorkManager.php');
    ?>

    <DIV CLASS="main">
        <div class="full">
            <?php include_once ('vwHeaderWorkManager.php');?>
            <?php include_once ('vwFooterWorkManager.php');?>
        </div>
    </DIV>
    <?php
}
include_once ('vwScriptWorkManager.php');
?>


