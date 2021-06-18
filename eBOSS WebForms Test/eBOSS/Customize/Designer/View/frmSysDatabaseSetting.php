<?php
session_start();

// Đang kết nối vào core bỏ di sau đó sử dụng core mới

// cái nào sử dụng xml -> thay thế thành lưu trữ cookie
include_once('../../../LoadLibrabry.php');
if (isset($_POST['ButtonCancel'])){
    header('Location:../../../../index.php');
    exit();
}

if (isset($_POST['ButtonClick'])) {
    $TextBoxServerName = $_POST['TextBoxServerName'];
    $TextBoxUserName = $_POST['TextBoxUserName'];
    $TextBoxPassword = $_POST['TextBoxPassword'];
}
//Khởi tạo XML mới để Update dữ liệu vào
$xml = new DOMDocument('1.0', 'utf-8');
$xml->formatOutput = true;
$xml->preserveWhiteSpace = false;
$xml->load('../../../Core/Xml/Databases.xml');
//Get item Element
$element = $xml->getElementsByTagName('Database')->item(0);
//Load child elements
$language = $element->getElementsByTagName('Language')->item(0);
$CurrentServerName = $element->getElementsByTagName('ServerName')->item(0);
$CurrentUserName = $element->getElementsByTagName('UserName')->item(0);
$CurrentPassword = $element->getElementsByTagName('Password')->item(0);
$CurrentDatabase = $element->getElementsByTagName('DatabaseName')->item(0);

$vConnect = new pSqlTable(false);
$vXml = new fXml('../../../Core/Xml/Databases.xml');
$servernameError = $UserNameError = $passwordError = $databaseError = "";

$TextBoxServerName = $vXml->GetXmlDatabase('Database', 'ServerName');
$TextBoxUserName = $vXml->GetXmlDatabase('Database', 'UserName');
$TextBoxPassword = $vXml->GetXmlDatabase('Database', 'Password');
$TextBoxDatabase = $vXml->GetXmlDatabase('Database', 'DatabaseName');

if (isset($_POST['ButtonConnect'])) {
    $connectionInfo = array("Database" => "", "UID" => $_POST['TextBoxUserName'], "PWD" => $_POST['TextBoxPassword'], "CharacterSet" => "UTF-8");
    $conn = sqlsrv_connect($_POST['TextBoxServerName'], $connectionInfo);
    if ($conn) {
        $CurrentServerName->nodeValue = $_POST['TextBoxServerName'];
        $CurrentUserName->nodeValue = $_POST['TextBoxUserName'];
        $CurrentPassword->nodeValue = $_POST['TextBoxPassword'];
        $CurrentDatabase->nodeValue = $_POST['TextBoxDatabase'];
        $language->nodeValue = $_SESSION[oWorkManager::_Language];
        htmlentities($xml->save('../../../Core/Xml/Databases.xml'));//lưu thành cookie
        header('Location:../../../../index.php');
        exit();
    } else {
        echo "<script>alert('DatabaseError');</script>";
    }
}

?>
<link rel="stylesheet" type="text/css" href="../CSS/frmSysDatabaseSetting.css">
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
    $vLanguage = 'NameEnglish';
}
$ServerName = fString::SwitchLanguage($vLanguage, "服務器名稱", "Máy chủ", "ServerIP", "ServerIP");
$UserName = fString::SwitchLanguage($vLanguage, "用戶名", "Tài khoản", "UserName", "UserName");
$Database = fString::SwitchLanguage($vLanguage, "數據庫", "Tên CSDL", "Database", "Database");
$Password = fString::SwitchLanguage($vLanguage, "密碼", "Mật khẩu", "Password", "Password");
$Connect = fString::SwitchLanguage($vLanguage, "連接", "Kết nối", "Connect", "Connect");
$Cancel = fString::SwitchLanguage($vLanguage, "取消", "Trở lại", "Cancel", "Cancel");
$Click = fString::SwitchLanguage($vLanguage, "連接", "Chọn", "Click", "Click");
$DatabaseSetting = fString::SwitchLanguage($vLanguage, "數據庫設定", "Thiết lập Database", "DatabaseSetting", "DatabaseSetting");

?>

<div class="main">
    <div class="full">
        <div class="row">
            <h2 style="font-size: 20px;"><?php echo $DatabaseSetting ?></h2>
        </div>
        <form action="" method="post">
            <div class="row">
                <label><?php echo $ServerName ?></label>
                <input type="text" name="TextBoxServerName" value="<?php echo($TextBoxServerName); ?>"
                       id="TextBoxServerName" title="Example: 192.168.1.1" >
            </div>
            <div class="row">
                <label><?php echo $UserName ?></label>
                <input type="text" id="TextBoxUserName" name="TextBoxUserName" value="<?php echo($TextBoxUserName); ?>"
                       >
            </div>

            <div class="row">
                <label for="password"><?php echo $Password ?></label>
                <input type="password" id="TextBoxPassword" name="TextBoxPassword"
                       value="<?php echo($TextBoxPassword); ?>">
            </div>
            <div class="row">
                <div class="column">
                    <label><?php echo $Database ?></label>
                    <select name="TextBoxDatabase" style="width: 250px;" id="TextBoxDatabase">
                        <?php
                            if ($TextBoxDatabase <> '') {
                                ?>
                                <option value="<?php echo $TextBoxDatabase ?>"><?php echo $TextBoxDatabase ?></option>
                                <?php
                            }
                        ?>
                        <?php
                        if (isset($_POST['ButtonClick'])) {
                            $connectionInfo = array("Database" => "", "UID" => $_POST['TextBoxUserName'], "PWD" => $_POST['TextBoxPassword'], "CharacterSet" => "UTF-8");
                            $conn = sqlsrv_connect($_POST['TextBoxServerName'], $connectionInfo);
                            if ($conn) {
                                $Database = "SELECT name FROM master..SYSdatabases WHERE name like 'eBOSS%' and name not  like 'eBOSS%_System';";
                                $getDatabase = sqlsrv_query($conn, $Database);
                                while ($row = sqlsrv_fetch_array($getDatabase, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?= $row["name"]; ?>"><?= $row["name"]; ?></option>
                                    <?php
                                }
                            } else {
                                echo "<script>alert('DatabaseError');window.location='frmSysDatabaseSetting.php';</script>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="columData">
                    <input type="submit" name="ButtonClick" id="SubmitClick" value="<?php echo($Click) ?>"
                           style="width: 0px; height: 1px"
                           hidden>
                </div>
            </div>
            <div class="row">
                <input type="submit" name="ButtonCancel" value="<?php echo $Cancel ?>"
                       style="width: 100px;float: right;">
                <input type="submit" name="ButtonConnect" id="ButtonConnect" value="<?php echo $Connect ?>"
                       style="width: 100px;float: right;margin-right: 25px;">

            </div>
        </form>
    </div>
</div>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<!-- jQuery UI library -->
<link rel="stylesheet"
      href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    $('#TextBoxServerName').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#TextBoxUserName').focus();
            event.preventDefault();
        }
    });

    $('#TextBoxUserName').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#TextBoxPassword').focus();
            event.preventDefault();
        }
    });

    document.addEventListener("keydown", keyDownTextField, false);

    function keyDownTextField(e) {
        var keyCode = e.keyCode;
        if (keyCode === 13) {
            document.getElementById('ButtonConnect').click();
        }
    }

</script>
