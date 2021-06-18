<?php
namespace eBOSS\Functions;

class fSqlConnect
{
    private $vServerName;
    private $vUserName;
    private $vPassword;
    private $vDatabaseName;
    protected $vIsConnected;

    /**
     * fSqlConnect constructor.
     * @param $ServerName: Tên Server
     * @param $UserName: Tài khoản đăng nhập Server
     * @param $Password: Mật khẩu đăng nhập Server
     * @param $DatabaseName: Tên Database
     * @param false $IsSystem: Dữ liệu System
     */
    public function __construct($ServerName, $UserName, $Password, $DatabaseName, $IsSystem = false)
    {
        $this->vServerName = $ServerName;
        $this->vUserName = $UserName;
        $this->vPassword = $Password;
        if ($IsSystem = true)
            $this->vDatabaseName = $DatabaseName.'_System';
        else
            $this->vDatabaseName = $DatabaseName;
    }

    private function Connect()
    {
        $ConnectionInfo = array("Database" => (string)$this->vDatabaseName, "UID" => (string)$this->vUserName, "PWD" => (string)$this->vPassword, "CharacterSet" => "UTF-8");
        $this->vIsConnected = sqlsrv_connect((string)$this->vServerName, $ConnectionInfo);
        return $this->vIsConnected;
    }

    /**
     * Ngắt kết nối Sql Server
     */
    public function Disconnect(){
        sqlsrv_close($this->vIsConnected);
    }
}