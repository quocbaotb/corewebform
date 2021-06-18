<?php
// Database configuration
$docXML = new DOMDocument('1.0', 'utf-8');
$docXML ->load('../../Core/Xml/Databases.xml');
$databases = $docXML->getElementsByTagName ("Database");
foreach ( $databases as $data ) {
   $servers = $data->getElementsByTagName ("ServerName");
   $ucServerName = $servers->item ( 0 )->nodeValue;
   $users = $data->getElementsByTagName ("UserName");
   $ucUserName = $users->item ( 0 )->nodeValue;
   $passwords = $data->getElementsByTagName ("Password");
   $ucPassword = $passwords->item ( 0 )->nodeValue;
   $dataBNS = $data->getElementsByTagName ( "DatabaseName" );
   $ucDatabase = $dataBNS->item ( 0 )->nodeValue;
}
	$connectionInfo = array("Database"=>$ucDatabase,"UID"=>$ucUserName, "PWD"=>$ucPassword,"CharacterSet" => "UTF-8");
	$conn = sqlsrv_connect($ucServerName, $connectionInfo);

// Fetch matched data from the database
$search = $_GET['term']; 
$getMold = "SELECT MoldID FROM dbo.tblBasProduceMold WHERE MoldID like '%$search%';";
$query = sqlsrv_query($conn,$getMold);
// Generate array with skills data 
$skillData = array(); 
    while ($row = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC)) {
        $dulieu['MoldID'] = $row['MoldID'];
        $dulieu['value'] = $row['MoldID']; 
        array_push($skillData, $dulieu); 
    }  
 
// Return results as json encoded array 
echo json_encode($skillData); 
?>