<?php

include_once "../../../../vendor/autoload.php";

use eBOSS\Functions\fSqlConnect;
use eBOSS\Functions\fSqlTable;
use eBOSS\Functions\fString;

$fSqlConnect = new fSqlConnect("192.168.44.216", "sa", "168149", "eBOSS_ING");
if ($fSqlConnect)
    echo "1";
else
    echo "2";

$fSqlTable = new fSqlTable("192.168.44.216", "sa", "168149", "eBOSS_ING", false);

$SelectCommand = "SELECT * FROM tblBasObjectInfo";

$TableTest = $fSqlTable->TableSelect($SelectCommand, "");

var_export($TableTest);


