<?php
class ucRequestHtml
{
    private $vActionRequest;

        public function RequestHtml($ElementByID){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // collect value of input field
            $name = htmlspecialchars($_REQUEST[$ElementByID]);
            if (!empty($name)) {
                RETURN $name;
            } else {
                RETURN null;
            }
        }
    }

    public function PostHtml($ElementByID){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // collect value of input field
            $Result = isset ($_POST[$ElementByID]) ? $_POST[$ElementByID] : null;
            if (empty($Result)) {
                RETURN null;
            } else {
                echo $Result;
            }
        }
    }



}