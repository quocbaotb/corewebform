<?php
include_once ('pSqlTable.php');

class fCheckLogin
{
    private $vSqlTable;
    private $vUserName;
    private $vWebPassword;
    private $vEmployeeAID;
    public function __construct()
    {
        $this->vSqlTable = new pSqlTable(false);
    }

    /**
     * @param $UserID: Tên đăng nhập
     * @param $WebPassword: Mật khẩu
     * @return false|resource: Cập nhập tài khoảng vào Sql
     */
    public function SignUpPassword($UserID, $WebPassword){
        $pSqlTable = new pSqlTable(false);
        $pSqlTable->SetTableName(oWorkManager::tbUserInfo);
        $pSqlTable->SetValue(oWorkManager::coWebPassword, $this->Md5PassWord($WebPassword));
        $Where = 'UserID' . '=' . "'$UserID'";
        RETURN $pSqlTable->TableUpdate($Where);
    }

    /**
     * @param $WebPassword: Mật khẩu cần mã hóa
     * @return false|string
     */
    private function Md5PassWord($WebPassword){
        return hash('sha1', $WebPassword);
    }

    /**
     * @param $UserID: Tài khoản
     */
    private function GetUser($UserID){
        $this->vUserName = !empty($TableUser) ? $TableUser[0]['UserID'] : null;
        $this->vWebPassword = !empty($TableUser) ? $TableUser[0]['WebPassword'] : null;
        $this->vEmployeeAID = !empty($TableUser) ? $TableUser[0]['EmployeeAID'] : null;
    }

    /**
     * @param $UserID: Tài khoản cần kiểm tra
     * @return bool
     */
    public function CheckUser($UserID){
        $pSqlTable = new pSqlTable(false);
        $TableUser = $pSqlTable->TableSelectParmeter(oWorkManager::scUserInfo, '@UserID', $UserID);
        $CheckUserID = !empty($TableUser) ? $TableUser[0]['UserID'] : null;
        if (empty($CheckUserID))
            RETURN false;
        else
            RETURN true;
    }

    /**
     * @param $UserID: Tài khoản
     * @param $WebPassword: Mật khẩu
     * @return bool
     */
    public function CheckLogin($UserID, $WebPassword){
        $TableUser = $this->vSqlTable->TableSelectParmeter(oWorkManager::scUserInfo, '@UserID', $UserID);
        $SqlPassword = !empty($TableUser) ? $TableUser[0]['WebPassword'] : null;
        $SqlWebPassword = empty($SqlPassword) ? 'PasswordError' : $SqlPassword ;
        $EmployeeAID = !empty($TableUser) ? $TableUser[0]['EmployeeAID'] : null;
        $CheckPassword = hash_equals($SqlWebPassword, $this->Md5PassWord($WebPassword));
        if ($CheckPassword === false || empty($EmployeeAID)){
            RETURN false;
        }else{
            RETURN true;
        }
    }

    /**
     * @param $UserID: Tài khoản
     * @return mixed|null: Lấy mã EmployeeAID
     */
    public function GetEmployeeAID($UserID){
        $TableUser = $this->vSqlTable->TableSelectParmeter(oWorkManager::scUserInfo, '@UserID', $UserID);
        RETURN !empty($TableUser) ? $TableUser[0]['EmployeeAID'] : null;
    }

}

