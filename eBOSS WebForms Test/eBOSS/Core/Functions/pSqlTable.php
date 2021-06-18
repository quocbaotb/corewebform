﻿<?php
class pSqlTable
{
    private $vIsSystem;
    private $vIsConnected;
    public $Columns = array();
    public $Values = array();
    public $TableName;

    public function __construct($IsSystem)
    {
        $this->vIsSystem = $IsSystem;
    }

    /**
     * @return false|resource: Kết nối với Database
     */
    private function Connect()
    {
        $Core = new Core();
        $vXml = $Core->fXml('../../../Core/Xml/Databases.xml');
        $ServerName = $vXml->GetXmlDatabase('Database', 'ServerName');
        if ($this->vIsSystem == true) {
            $DatabaseName = $vXml->GetXmlDatabase('Database', 'DatabaseName')."_System";
        } else
            $DatabaseName = $vXml->GetXmlDatabase('Database', 'DatabaseName');
        $UserName = $vXml->GetXmlDatabase('Database', 'UserName');
        $Password = $vXml->GetXmlDatabase('Database', 'Password');
        $ConnectionInfo = array("Database" => (string)$DatabaseName, "UID" => (string)$UserName, "PWD" => (string)$Password, "CharacterSet" => "UTF-8");
        $this->vIsConnected = sqlsrv_connect((string)$ServerName, $ConnectionInfo);
        if ($this->vIsConnected) {
            return $this->vIsConnected;
        } else{
           echo "<script>alert ('Please Setting Database!');window.location='frmSysDatabaseSetting.php';</script>";
           exit();
        }
    }

    /**
     * Ngắt kết nối Sql Server
     */
    private function Disconnect(){
        sqlsrv_close($this->Connect());
    }

    /**
     * @param $SelectCommand: Câu truy vấn để xem
     * @param $Language: Ngôn ngữ cần hiển thị
     * @return array
     */
    public function TableSelect($SelectCommand, $Language)
    {
        $Core = new Core();
        $Core->fString();
        //RebuildString
        $Result = sqlsrv_query($this->Connect(), fString::SelectCommandBuilder($SelectCommand,'Language',$Language));
        if (!$Result){
            die ('Vui lòng kiểm tra lại hệ thống mạng và nhấn F5');
        }
        $return = array();
        while ($row = sqlsrv_fetch_array($Result)){
            $return[] = $row;
        }
        sqlsrv_free_stmt($Result);
        $this->Disconnect();
        return $return;
    }

    /**
     * @param $SelectCommand: Câu truy vấn
     * @param $Parameters: Mảng biến cần thay đổi giá trị
     * @param $Vales: Mảng giá trị tương ứng
     * @return array
     */
    public function TableSelectParmeter($SelectCommand, $Parameters, $Vales)
    {
        $Core = new Core();
        $Core->fString();
        //RebuildString
        $Result = sqlsrv_query($this->Connect(), fString::SelectCommandBuilder($SelectCommand,$Parameters ,$Vales));
        if (!$Result){         
		die ('Vui lòng kiểm tra lại hệ thống mạng và nhấn F5');
        }
        $return = array();
        while ($row = sqlsrv_fetch_array($Result)){
            $return[] = $row;
        }
        sqlsrv_free_stmt($Result);
        $this->Disconnect();
        return $return;
    }


    /**
     * @param $Table: Giá trị bảng table
     * @param $CheckColumnName: Tên cột cần kiểm tra
     * @param $CheckValue: Giá trị cột cần kiểm tra
     * @param $ResultColumnName: Tên cột cần lấy giá trị
     * @return mixed
     */
    public function GetValue($Table, $CheckColumnName, $CheckValue, $ResultColumnName){
        for ($i = 0; $i < count($Table); $i++) {
            if (strtoupper($Table[$i][$CheckColumnName]) === strtoupper($CheckValue))
                return $Table[$i][$ResultColumnName];
        }
    }

    /**
     * @param $Table: Giá trị bảng Table
     * @param $CheckColumnNames: Mảng tên cột cần kiểm tra
     * @param $CheckValues: Mảng giá trị cần kiểm tra
     * @param $ResultColumnName: Tên cột cần lấy giá trị
     * @return mixed
     */
    public function GetValues($Table,$CheckColumnNames, $CheckValues, $ResultColumnName)
    {
        for ($i = 0; $i < count($Table); $i++) {
            if (strtoupper($Table[$i][$CheckColumnNames[0]]) == strtoupper($CheckValues[0]) && strtoupper($Table[$i][$CheckColumnNames[1]]) == strtoupper($CheckValues[1]))
                return $Table[$i][$ResultColumnName];
        }
    }

    /**
     * @param $Column: Tên cột
     * @param $Value: Giá trị
     */
    public function SetValue($Column, $Value){
        $Key = count($this->Columns) -1;
        $this->Columns[$Key+1] = $Column;
        $this->Values[$Key+1] = $Value;
    }

    /**
     * @param $TableName: Tên Table
     */
    public function SetTableName($TableName){
        $this->TableName = $TableName;
    }

    /**
     * @return false|resource: Thêm mới giá trị vào Sql
     */
    public function TableInsert(){
        $Data = array_combine($this->Columns,$this->Values);
        $Columns = '';
        $Values = '';

        foreach ($Data as $Key => $Value) {
            $Columns .= ",$Key";
            $Values .= ",'" . ($Value) . "'";
        }
        $sql = 'INSERT INTO ' . $this->TableName . '(' . trim($Columns, ',') . ') VALUES (' . trim($Values, ',') . ')';
        return  sqlsrv_query($this->Connect(), $sql);
    }

    /**
     * @param $Where: Điều kiện cập nhật
     * @return false|resource: Cập nhật dữ liệu vào Sql
     */
    public function TableUpdate($Where)
    {
        $Data = array_combine($this->Columns,$this->Values);
        $data = '';
        foreach ($Data as $Key => $Value){
            if ($Value == 'NULL'){
                $data .= "$Key = ".($Value).",";
            }elseif (empty($Value)){
                $Value = 'NULL';
                $data .= "$Key = ".$Value.",";
            }else{
                $data .= "$Key = '".($Value)."',";
            }

        }
        $sql = ' UPDATE '.$this->TableName. ' SET '.trim($data, ",").' WHERE '.$Where;

        return sqlsrv_query($this->Connect(), $sql);
    }

    /**
     * @param $Where: Điều kiện xóa dòng
     * @return false|resource: Xóa dòng dữ liệu giá trị vào Sql
     */
    public function TableDelete($Where)
    {
        $sql = 'DELETE FROM'. $this->TableName. 'WHERE'. $Where;
        return sqlsrv_query($this->Connect(), $sql);
    }
}