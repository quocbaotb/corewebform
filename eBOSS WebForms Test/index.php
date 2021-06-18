<?php
$docXML = new DOMDocument('1.0', 'utf-8');
$docXML ->load('eBOSS/Core/Xml/Databases.xml');
$databases = $docXML->getElementsByTagName ("Database");
foreach ( $databases as $data ) {
    $language = $data->getElementsByTagName ("Language");
    $Language = $language->item ( 0 )->nodeValue;
    $servers = $data->getElementsByTagName ("ServerName");
    $ucServerName = $servers->item ( 0 )->nodeValue;
    $users = $data->getElementsByTagName ("UserName");
    $ucUserName = $users->item ( 0 )->nodeValue;
    $passwords = $data->getElementsByTagName ("Password");
    $ucPassword = $passwords->item ( 0 )->nodeValue;
    $dataBNS = $data->getElementsByTagName ( "DatabaseName" );
    $ucDatabase = $dataBNS->item ( 0 )->nodeValue;
}
if ($Language == 'lang=vi')
    if (!$ucUserName){
        echo "<script>window.location='eBOSS/Customize/Designer/View/frmSysDatabaseSetting?lang=vi'</script>";
    }else
        echo "<script>window.location='eBOSS/Customize/Designer/View/frmSysLogin.php?lang=vi'</script>";
else if ($Language == 'lang=cn'){
    if (!$ucUserName){
        echo "<script>window.location='eBOSS/Customize/Designer/View/frmSysDatabaseSetting?lang=cn'</script>";
    }else
        echo "<script>window.location='eBOSS/Customize/Designer/View/frmSysLogin.php?lang=cn'</script>";
}else{
    if (!$ucUserName){
        echo "<script>window.location='eBOSS/Customize/Designer/View/frmSysDatabaseSetting?lang=en'</script>";
    }else
        echo "<script>window.location='eBOSS/Customize/Designer/View/frmSysLogin.php?lang=en'</script>";
}

?>