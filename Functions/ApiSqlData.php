<?php
namespace eBOSS\Functions;

class ApiSqlData
{

    public $vIpApiServer;

    /**
     * @param $SelectCommandView: Câu truy vấn
     * @return array|string|string[]
     */
    private function GetSelectCommandView($SelectCommandView)
    {
        $ParameterOut = array(' ');
        $ParameterValue = array('%20');
        return str_replace($ParameterOut, $ParameterValue, $SelectCommandView);
    }


    /**
     * @param $SelectCommandView: Câu truy vấn
     * @return mixed
     */

    public function GetData($SelectCommandView)
    {
        $LinkApi = $this->vIpApiServer . $this->GetSelectCommandView($SelectCommandView);
        $ch = curl_init();
        $timeout = 5; // set to zero for no timeout
        curl_setopt($ch, CURLOPT_URL, $LinkApi);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $Response = curl_exec($ch);
        curl_close($ch);
        return json_decode($Response, true);

    }

    /**
     * @param $Table: Danh sách dữ liệu
     * @param $CheckColumnName: Tên cột cần kiểm tra
     * @param $CheckValue: Giá trị tương ứng cột cần kiểm tra
     * @param $ResultColumnName: Cột cần trả về kết quả
     * @return mixed|string
     */
    public function GetValue($Table, $CheckColumnName, $CheckValue, $ResultColumnName)
    {
        $Result = "";
        for ($i = 0; $i < count($Table); $i++) {
            if (strtoupper($Table[$i][$CheckColumnName]) === strtoupper($CheckValue))
                $Result = $Table[$i][$ResultColumnName];
        }
        return $Result;
    }

    /**
     * @param $Table: Danh sách dữ liệu dạng Table
     * @param $CheckColumnNames: Mảng cột cần kiểm tra
     * @param $CheckValues: Mảng dữ liệu cần kiểm tra
     * @param $ResultColumnName: Tên cột cần trả về kết quả
     * @return mixed|string
     */
    public function GetValues($Table, $CheckColumnNames, $CheckValues, $ResultColumnName)
    {
        $Result = "";
        for ($i = 0; $i < count($Table); $i++) {
            if (strtoupper($Table[$i][$CheckColumnNames[0]]) == strtoupper($CheckValues[0]) && strtoupper($Table[$i][$CheckColumnNames[1]]) == strtoupper($CheckValues[1]))
                $Result = $Table[$i][$ResultColumnName];
        }
        return $Result;
    }

    public function Translate($SelectCommandView, $ItemID, $Language = null)
    {
        $TableFunctionComponent = $this->GetData($SelectCommandView);

        return $this->GetValue($TableFunctionComponent, 'ItemID', $ItemID, 'TranslateNameVietnamese');

    }

}