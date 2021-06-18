<?php

namespace eBOSS\Functions;

class fString
{
    /**
     * @param $Language: Ngôn ngữ sẽ hiển thị (Ex: NameVietnamese)
     * @param $NameChinese: Ngôn ngữ tiếng Trung (NameChinese)
     * @param $NameVietnamese: Ngôn ngữ tiếng Việt (NameVietnamese)
     * @param $NameEnglish: Ngôn ngữ tiếng Anh (NameEnglish)
     * @param $NameOther: Ngôn ngữ khác (NameOther)
     * @return mixed
     */
    public static function SwitchLanguage($Language, $NameChinese, $NameVietnamese, $NameEnglish, $NameOther)
    {
        switch ($Language) {
            case 'NameChinese':
                return $NameChinese;
            case 'NameEnglish':
                return $NameEnglish;
            case 'NameOther':
                return $NameOther;
            default:
                return $NameVietnamese;
        }
    }


    /**
     * @param $SelectCommand: Câu truy vấn có biến cần thay đổi
     * @param $Parameter: Tên biến cần thay đổi
     * @param $ParameterValue: Gía trị biến
     * @return array|string|string[]
     */
    public static function SelectCommandBuilder($SelectCommand, $Parameter, $ParameterValue)
    {
        return str_replace($Parameter, $ParameterValue, $SelectCommand);
    }


    /**
     * @param $BarcodeValue : Chuỗi cần phân tích
     * @return string
     */
    public function BuildBarcode($BarcodeValue): string
    {
        $ArrayBarcode = explode(" ", $BarcodeValue);
        $ArrayDiff = array("");

        $ArrayCompare = array_diff($ArrayBarcode, $ArrayDiff);

        return implode(' ', $ArrayCompare);
    }

    /**
     * @param $BarcodeValue: Chuỗi cần tách thành mảng
     * @return array
     */
    public function ArrayBarcode($BarcodeValue): array
    {
        return explode(' ', $this->BuildBarcode($BarcodeValue));
    }

}