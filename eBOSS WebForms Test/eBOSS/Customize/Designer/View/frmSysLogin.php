<link rel="stylesheet" type="text/css" href="../CSS/frmSysLogin.css">
<script>
    function changeValue(val) {
        if (val === "en")
            window.location.href = "?lang=en";
        else if (val === "vi")
            window.location.href = "?lang=vi";
        else
            window.location.href = "?lang=cn";
    }
</script>

<?php
session_start();
include_once('../../../Core/Core.php');
include_once('../../../LoadLibrabry.php');
$vXml = new fXml('../../../Core/Xml/Databases.xml');
$CurrentLanguage = $vXml->GetXmlDatabase('Database', 'Language');
$CurrentServerName = $vXml->GetXmlDatabase('Database', 'ServerName');
$CurrentDatabaseName = $vXml->GetXmlDatabase('Database', 'DatabaseName');
$CurrentUserName = $vXml->GetXmlDatabase('Database', 'UserName');
$CurrentPassword = $vXml->GetXmlDatabase('Database', 'Password');
$SqlTable = new pSqlTable(false);
$vSession = new Session();
$Language = '';
#Cài đặt Default ngôn ngữ từ lần Login thứ 2
switch ($CurrentLanguage) {
    case 'lang=vi':
        $vLanguage = 'NameVietnamese';
        break;
    case 'lang=cn' :
        $vLanguage = 'NameChinese';
        break;
    default :
        $vLanguage = 'NameVietnamese';

}
#Cài đặt ngôn ngữ khi lựa chọn ngôn ngữ trong Combobox Language
$_SESSION[oWorkManager::_Language] = $_SERVER['QUERY_STRING'];
switch ($_SESSION[oWorkManager::_Language]) {
    case 'lang=vi':
        $vLanguage = 'NameVietnamese';
        break;
    case 'lang=cn' :
        $vLanguage = 'NameChinese';
        break;
    default :
        $vLanguage = 'NameVietnamese';

}

$xml = new DOMDocument('1.0', 'utf-8');
$xml->formatOutput = true;
$xml->preserveWhiteSpace = false;
$xml->load('../../../Core/Xml/Databases.xml');
//Get item Element
$element = $xml->getElementsByTagName('Database')->item(0);
//Load child elements
$language = $element->getElementsByTagName('Language')->item(0);
#@Setup SESSION
$fCheckLogin = new fCheckLogin();

if (isset($_POST['ButtonSubmitOK'])) {
    $TempUserName = $_POST['TextboxUserName'];
    $TempPassword = $_POST['TextboxPassword'];
    if ($fCheckLogin->CheckLogin($TempUserName, $TempPassword) === true) {
        $_SESSION[oWorkManager::_MachineID] = $_POST['ComboBoxMachineID'];
        $_SESSION[oWorkManager::_CurrentWorkShiftID] = $_POST['ComboBoxWorkShift'];
        $_SESSION[oWorkManager::_CurrentEmployeeAID] = $fCheckLogin->GetEmployeeAID($TempUserName);
        $language->nodeValue = $_SESSION[oWorkManager::_Language];
        htmlentities($xml->save('../../../Core/Xml/Databases.xml'));
        $CheckOperationID = $_POST['ComboBoxOperation'];
        $vSession->SetSession(oWorkManager::_CurrentTypeProgress, $CheckOperationID);
        $vChangeForm = new pChangeForm();
        $vChangeForm->ChangeForm($CheckOperationID);
    } else {
        echo "<script> alert('Đăng nhập thất bại. Vui lòng kiểm tra lại tài khoản và mật khẩu');</script>";
    }
}

#@Setup Translate Language
$Language = fString::SwitchLanguage($vLanguage, "語言", "Ngôn ngữ", "Language", "Language");
$Login = fString::SwitchLanguage($vLanguage, "登入", "Đăng nhập", "Login", "Login");
$Operation = fString::SwitchLanguage($vLanguage, "作業", "Tác nghiệp", "Operation", "Operation");
$MachineID = fString::SwitchLanguage($vLanguage, "工作站別", "Mã máy", "MachineID", "MachineID");
$WorkShift = fString::SwitchLanguage($vLanguage, "作業班次", "Ca làm việc", "WorkShift", "WorkShift");
$Employee = fString::SwitchLanguage($vLanguage, "作業人員", "Nhân viên", "Employee", "Employee");
$DatabaseSetting = fString::SwitchLanguage($vLanguage, "數據庫設定", "Thiết lập Database", "DatabaseSetting", "DatabaseSetting");
$OK = fString::SwitchLanguage($vLanguage, "登入", "Đăng nhập", "Connect", "Login");
$UserName = fString::SwitchLanguage($vLanguage, "用戶名", "Tài khoản", "UserName", "UserName");
$Password = fString::SwitchLanguage($vLanguage, "密碼", "Mật khẩu", "Password", "Password");
$SignUp = fString::SwitchLanguage($vLanguage, "注冊", "Đăng ký", "Sign Up", "Sign Up");

#@Khởi tạo Table
$TableMachine = $SqlTable->TableSelect(oWorkManager::scBasMachineInfo, $vLanguage);
$TableWorkShift = $SqlTable->TableSelect(oWorkManager::scBasWorkShift, $vLanguage);
$TableMachineOperationRef = $SqlTable->TableSelect(oWorkManager::scBasProduceMachineOperationRef, $vLanguage);

$EmployeeUserName = !empty($_SESSION[oWorkManager::_CurrentUserName]) ? $_SESSION[oWorkManager::_CurrentUserName] : null;
$EmployeePassword = !empty($_SESSION[oWorkManager::_CurrentWebPassword]) ? $_SESSION[oWorkManager::_CurrentWebPassword] : null;
?>

<DIV CLASS="main">
    <div class="full">
        <div class="row">
            <h2><?php echo $Login ?></h2>
        </div>
        <div class="row" style="margin:0px;">
            <form action="" method="post">
                <div class="row">
                    <label><?php echo $UserName ?></label>
                    <input style="width: 250px" type="text" name="TextboxUserName"
                           value="<?php echo $EmployeeUserName ?>"
                           id="TextboxUserName" required>
                </div>

                <div class="row">
                    <label><?php echo $Password ?></label>
                    <input style="width: 250px" type="password" name="TextboxPassword"
                           value="<?php echo $EmployeePassword ?>"
                           id="TextboxPassword" required>
                </div>

                <div class="row">
                    <label><?php echo $Operation ?></label>
                    <select name="ComboBoxOperation">
                        <?php
                        for ($i = 0; $i < count($TableMachineOperationRef); $i++) {
                            ?>
                            <option
                                    value="<?= $TableMachineOperationRef[$i][oWorkManager::coOperationRefID] ?>"><?= $TableMachineOperationRef[$i][oWorkManager::coOperationRefName] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <label><?php echo $MachineID ?></label>
                    <select name="ComboBoxMachineID">
                        <?php
                        for ($i = 0; $i < count($TableMachine); $i++) {
                            ?>
                            <option
                                    value="<?= $TableMachine[$i]['MachineID'] ?>"><?= $TableMachine[$i]['MachineID'] . " (" . $TableMachine[$i][oWorkManager::coMachineName] . ")" ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <label><?php echo $WorkShift ?></label>
                    <select name="ComboBoxWorkShift">
                        <?php
                        for ($i = 0; $i < count($TableWorkShift); $i++) {
                            ?>
                            <option
                                    value="<?= $TableWorkShift[$i][oWorkManager::coWorkShiftID] ?>"><?= $TableWorkShift[$i][oWorkManager::coWorkShiftName] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="row">
                    <input type="submit" name="ButtonSubmitOK" id="ButtonSubmitOK" value="<?php echo $OK ?>">
                    <a style="float: left" href="frmSysSignUp.php"><?php echo $SignUp ?></a>
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin: 10px 10px 10px">
        <div class="column">
            <form>
                <select name="lang" onchange="changeValue(this.value)" style="width:90px; border:none;height:20px;">
                    <?php
                    if (isset($_SESSION[oWorkManager::_Language])){
                    $ucLangUrl = $_SESSION[oWorkManager::_Language];
                    if ($ucLangUrl == "lang=cn") {
                        ?>
                        <option value="en">English</option>
                        <option value="vi">Tiếng Việt</option>
                        <option value="cn" selected="selected">中文</option>
                        <?php
                    } else if ($ucLangUrl == "lang=vi") {
                        ?>
                        <option value="en">English</option>
                        <option value="vi" selected="selected">Tiếng Việt</option>
                        <option value="cn">中文</option>
                        <?php
                    } else {
                        ?>
                        <option value="en" selected="selected">English</option>
                        <option value="vi">Tiếng Việt</option>
                        <option value="cn">中文</option>
                        <?php
                    }
                    ?>
                </select>
            </form>
            <?php
            }
            else {
                ?>
                <option value="en" selected="selected">English</option>
                <option value="vi">Tiếng Việt</option>
                <option value="cn">中文</option>
                <?php
            }
            ?>
            </select>
            </form>
        </div>
        <div class="columnData">
            <a href="frmSysDatabaseSetting.php"><?php echo $DatabaseSetting ?></a>
        </div>
    </div>
</DIV>

<script>
    document.addEventListener("keydown", keyDownTextField, false);

    function keyDownTextField(e) {
        var keyCode = e.keyCode;
        if (keyCode === 13) {
            document.getElementById('ButtonSubmitOK').click();
        }
    }
</script>
