<?php
namespace eBOSS\Functions;
class fPagination
{
    public $vData;
    public $vRowInPage;

    /**
     * @return false|float|int: Lấy giá trị trang lơn nhất
     */
    private function getMaxPage(): int
    {
        return !empty($this->vData) ? (($this->vData % $this->vRowInPage > 0) ? floor(count($this->vData) / $this->vRowInPage) + 1 : $this->vData / $this->vRowInPage) : 1;
    }

    /**
     * @param int $CurrentPage : Trang hiện tại
     * @param bool $IsPrevious : Bấm vào trang trước
     * @param bool $IsNext : Bấm trang tiếp theo
     * @return int
     */
    public function getPage(int $CurrentPage = 1, bool $IsPrevious = false, bool $IsNext = false): int
    {
        $Result = $CurrentPage;
        $CurrentMaxPage = $this->getMaxPage();
        if ($IsNext) {
            if ($CurrentPage < $CurrentMaxPage)
                $Result += 1;
            else {
                $Result = $CurrentMaxPage;
            }
        } else if ($IsPrevious) {
            if ($CurrentPage > 1)
                $Result -= 1;
            else
                $Result = 1;
        }
        return $Result;
    }

    /**
     * @param int $CurrentPage: Trang hiện tại
     * @param bool $IsRowStart: Lấy trang bắt đầu
     * @param bool $IsRowEnd: Lấy trang kết thúc
     * @return int
     */
    public function getRowStartAndEnd(int $CurrentPage = 1, bool $IsRowStart = false, bool $IsRowEnd = false): int
    {
        $CurrentMaxRow = !empty($this->vData) ? count($this->vData) : 1;
        $CurrentMaxPage = $this->getMaxPage();
        if (($CurrentPage * 15) <= $CurrentMaxRow) {
            $CurrentRowEnd = $CurrentPage * 15;
            $CurrentRowStart = $CurrentRowEnd - 15;
        } else {
            $CurrentRowEnd = $CurrentMaxRow;
            $CurrentRowStart = ($CurrentMaxPage - 1) * 15;
        }

        if ($IsRowStart) {
            return $CurrentRowStart;
        } elseif ($IsRowEnd) {
            return $CurrentRowEnd;
        } else
            return 1;
    }
}