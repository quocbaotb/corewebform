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


if (isset($_POST['ButtonCancel'])) {
    header('Location:../../../../index.php');
    exit();
}

?>
<link rel="stylesheet" type="text/css" href="../CSS/style.css">
<?php

if (isset($_SESSION[oWorkManager::_Language])) {
    switch ($_SESSION[oWorkManager::_Language]) {
        case "lang=vi":
            $vLanguage = 'NameVietnamese';
            break;
        case "lang=cn":
            $vLanguage = 'NameChinese';
            break;
        default:
            $vLanguage = 'NameEnglish';
            break;
    }
} else {
    $vLanguage = 'NameVietnamese';
}

$Customize = new Customize($vLanguage);
$Customize->oWorkManagerQuality();
$Customize->oWorkManager();
$vProcessForm = $Customize->pForm();

$Connect = fString::SwitchLanguage($vLanguage, "連接", "Kết nối", "Connect", "Connect");
$Cancel = fString::SwitchLanguage($vLanguage, "取消", "Trở lại", "Cancel", "Cancel");
$Click = fString::SwitchLanguage($vLanguage, "連接", "Chọn", "Click", "Click");

if (isset($_POST['TextBoxEmployeeCheck1'])){
    $vSession->SetSession(oWorkManagerQuality::_CurrentEmployeeCheck1ID, $_POST['TextBoxEmployeeCheck1']);
}

if (isset($_POST['TextBoxEmployeeCheck2'])){
    $vSession->SetSession(oWorkManagerQuality::_CurrentEmployeeCheck2ID, $_POST['TextBoxEmployeeCheck2']);

}

$CurrentEmployeeCheck1ID = !empty($_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck1ID]) ? $_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck1ID] : null;
$CurrentEmployeeCheck2ID = !empty($_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck2ID]) ? $_SESSION[oWorkManagerQuality::_CurrentEmployeeCheck2ID] : null;

$TableEmployeeCheck1 = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scEmployeeCheck, array('@Language', '@EmployeeID'), array($vLanguage, $CurrentEmployeeCheck1ID));
$TableEmployeeCheck2 = $vSqlTable->TableSelectParmeter(oWorkManagerQuality::scEmployeeCheck, array('@Language', '@EmployeeID'), array($vLanguage, $CurrentEmployeeCheck2ID));

$CurrentEmployeeCheck1Name = !empty($TableEmployeeCheck1) ? $TableEmployeeCheck1[0]['EmployeeName'] : null;
$CurrentEmployeeCheck2Name = !empty($TableEmployeeCheck2) ? $TableEmployeeCheck2[0]['EmployeeName'] : null;

$CurrentEmployeeCheck1AID = !empty($TableEmployeeCheck1) ? $TableEmployeeCheck1[0]['EmployeeAID'] : null;
$CurrentEmployeeCheck2AID = !empty($TableEmployeeCheck2) ? $TableEmployeeCheck2[0]['EmployeeAID'] : null;

if (isset($_POST['ButtonConnect'])){

    $vSession->SetSession(oWorkManagerQuality::_CurrentEmployeeCheck1AID, $CurrentEmployeeCheck1AID);
    $vSession->SetSession(oWorkManagerQuality::_CurrentEmployeeCheck2AID, $CurrentEmployeeCheck2AID);
    $vSession->SetSession(oWorkManagerQuality::_CurrentEmployeeCheck1Name, $CurrentEmployeeCheck1Name);
    $vSession->SetSession(oWorkManagerQuality::_CurrentEmployeeCheck2Name, $CurrentEmployeeCheck2Name);

    header('Location:frmWorkManagerQuality.php');
    exit();
}
?>

<div class="main">
    <div class="full" style="width: 400px">
        <div class="row">
            <h2 style="font-size: 20px;"><?php echo 'Nhân viên kiểm nghiệm' ?></h2>
        </div>

            <div class="row">
                <label><?php echo 'Nhân viên 1' ?></label>
                <form method="post">
                    <div style="float: left; width: 25%">
                        <input style="width: 100%" type="text" name="TextBoxEmployeeCheck1" value="<?php echo $CurrentEmployeeCheck1ID ?>" required>
                    </div>

                    <div style="float: right;">
                        <select style="width: 165px; float: left; height: 25px" name="ComboboxEmployeeCheck1" disabled>
                            <option value="<?php echo $CurrentEmployeeCheck1ID ?>">
                                <?php echo $CurrentEmployeeCheck1Name ?>
                            </option>
                        </select>
                    </div>
                </form>


            </div>
            <div class="row">
                <label><?php echo 'Nhân viên 2' ?></label>
                <form method="post">
                    <div style="float: left; width: 25%">
                        <input style="width: 100%" type="text" name="TextBoxEmployeeCheck2" value="<?php echo $CurrentEmployeeCheck2ID ?>" required>
                    </div>

                    <div style="float: right;">
                        <select style="width: 165px; float: left; height: 25px" name="ComboboxEmployeeCheck2" disabled>
                            <option value="<?php echo $CurrentEmployeeCheck2ID ?>">
                                <?php echo $CurrentEmployeeCheck2Name ?>
                            </option>
                        </select>
                    </div>
                </form>

            </div>

            <div class="row">
                <form method="post">
                    <input type="submit" name="ButtonCancel" value="<?php echo $Cancel ?>"
                           style="width: 80px;float: right;">
                    <input type="submit" name="ButtonConnect" id="ButtonConnect" value="<?php echo $Connect ?>"
                           style="width: 80px;float: right;margin-right: 5px;">
                </form>

            </div>
    </div>
</div>