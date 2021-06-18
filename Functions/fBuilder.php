<?php
namespace eBOSS\Functions;

class fBuilder
{
    public static function BuilderAID()
    {
        $SqlTable = new pSqlTable( false);
        $SetUniqueAID = $SqlTable->TableSelect('SELECT dbo.fBuildAID() AS AID','');
        return $SetUniqueAID[0]['AID'];
    }

}


