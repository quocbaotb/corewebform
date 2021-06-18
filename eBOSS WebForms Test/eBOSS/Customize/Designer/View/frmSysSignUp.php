<?php
session_start();
include_once('../../../LoadLibrabry.php');
include_once('../../../Core/Core.php');
?>
<link rel="stylesheet" type="text/css" href="../CSS/frmSysDatabaseSetting.css">
<?php
$Core = new Core();
$fGetLanguage = $Core->fGetLanguage();
$vLanguage = $fGetLanguage->GetLanguage();

$UserName = fString::SwitchLanguage($vLanguage, "用戶名", "Tài khoản", "UserName", "UserName");
$Password = fString::SwitchLanguage($vLanguage, "密碼", "Mật khẩu", "Password", "Password");
$Cancel = fString::SwitchLanguage($vLanguage, "取消", "Trở lại", "Cancel", "Cancel");
$Click = fString::SwitchLanguage($vLanguage, "連接", "Đăng ký", "SignUp", "SignUp");
$DatabaseSetting = fString::SwitchLanguage($vLanguage, "Thiết lập tài khoản", "Thiết lập tài khoản", "Sign Up", "Sign Up");
if (isset($_POST['ButtonConnect'])) {
    $vMd5Password = new fCheckLogin();
    $UserID = $_POST['TextBoxUserName'];
    $WebPassword = $_POST['TextBoxPassword'];
    $vMd5Password->SignUpPassword($UserID, $WebPassword);
    if ($vMd5Password->CheckUser($UserID) === true){
        $vSession = new Session();
        $_SESSION[oWorkManager::_CurrentUserName] = $UserID;
        $_SESSION[oWorkManager::_CurrentWebPassword] = $WebPassword;
        echo "<script>alert('Đăng ký thành công');</script>";
        header('Location: ../../../../index.php');
    }else if (empty($WebPassword)){
        echo "<script>alert('Đăng ký thất bại. Password không được để trống!');</script>";
    }else{
        echo "<script>alert('Đăng ký thất bại. Không tìm thấy User!');</script>";
    }
}

if (isset($_POST['ButtonCancel'])) {
    header('Location: ../../../../index.php');
}
?>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<div class="main">
    <div class="full">
        <div class="row">
            <h2 style="font-size: 20px;"><?php echo $DatabaseSetting ?></h2>
        </div>
        <form action="" method="post">
            <div class="row">
                <label for="TextBoxUserName"> <?php echo $UserName ?></label>
                <input type="text" id="TextBoxUserName" name="TextBoxUserName" maxlength="10" autofocus>
            </div>

            <div class="row">
                <label for="TextBoxPassword"> <?php echo $Password ?></label>
                <input type="password" id="TextBoxPassword" name="TextBoxPassword">
            </div>

            <div class="row">
                <input type="submit" name="ButtonCancel" value="<?php echo $Cancel ?>"
                       style="width: 100px;float: right;">
                <input type="submit" name="ButtonConnect" id="ButtonConnect" value="<?php echo $Click ?>"
                       style="width: 100px;float: right;margin-right: 25px;">
            </div>
        </form>
    </div>
</div>

<script>
    $('#TextBoxUserName').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#TextBoxPassword').focus();
            event.preventDefault();
        }
    });
    $('#TextBoxPassword').keypress(function (event) {
        if (event.keyCode === 13 || event.which === 13) {
            $('#ButtonConnect').click();
            event.preventDefault();
        }
    });


/*    document.addEventListener("keydown", keyDownTextField, false);

    function keyDownTextField(e) {
        var keyCode = e.keyCode;
        if (keyCode === 13) {
            document.getElementById('ButtonConnect').click();
        }
    }*/
</script>
