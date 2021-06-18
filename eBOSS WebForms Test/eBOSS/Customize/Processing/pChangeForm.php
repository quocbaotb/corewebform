<?php
class pChangeForm
{

    function ChangeForm($TypeForm){
        switch ($TypeForm){
            case 'A': header('Location:frmWorkManager.php'); exit();
            break;
            case 'B': header('Location:frmWorkManager-ver2.php'); exit();
            break;
            case 'C': header('Location:frmWorkManagerHand.php'); exit();
            break;
            case 'D': header('Location:frmSysLoginEmployeeCheck.php'); exit();
            break;
            case 'E': header('Location:frmWorkManagerTrans.php'); exit();
            break;
            case 'F': header('Location:frmWorkManagerPrink.php'); exit();
            break;
            case 'G': header('Location:test.php'); 
            exit();
            break;
            default: header('Location:frmSysProgress.php'); exit();
            break;
        }

    }

}