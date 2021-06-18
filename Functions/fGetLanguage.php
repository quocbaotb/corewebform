<?php

namespace eBOSS\Functions;

class fGetLanguage
{

    public function GetLanguage($ServerLang): string
    {
        switch ($ServerLang) {
            case 'lang=cn' :
                RETURN 'NameChinese';
            default :
                RETURN 'NameVietnamese';
        }
    }

}