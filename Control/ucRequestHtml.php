<?php

namespace eBOSS\Control;


class ucRequestHtml
{

    /**
     * @param $ElementByID: Tên của biến cần xem hiệu ứng
     * @return string|null
     */
    public function RequestHtml($ElementByID)
    {
        $Result = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // collect value of input field
            $Name = htmlspecialchars($_REQUEST[$ElementByID]);
            if (!empty($name)) {
                $Result = $Name;
            } else {
                $Result = null;
            }

        }
        return $Result;
    }

    public function PostHtml($ElementByID)
    {
        $Result = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // collect value of input field
            $Method = $_POST[$ElementByID] ?? null;
            if (empty($Method)) {
                $Result = null;
            } else {
                $Result = $Method;
            }
        }

        return $Result;
    }


}