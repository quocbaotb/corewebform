<?php
namespace eBOSS\Session;

class Session
{
    function SetSession($KeyID, $Value){
        $_SESSION[$KeyID] = strtoupper($Value);
    }

    function GetSession($KeyID){
        return (isset($_SESSION[$KeyID])) ? $_SESSION[$KeyID] : false;
    }

    function DelSession($KeyID){
        if (isset($_SESSION[$KeyID])){
            unset($_SESSION[$KeyID]);
        }
    }
}