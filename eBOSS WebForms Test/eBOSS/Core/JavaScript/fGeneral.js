function isNumberKey(evt, element,max) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57) && !(charCode === 46 || charCode === 8))
        return false;
    else {
        var len = $(element).val().length;
        var index = $(element).val().indexOf('.');
        if (index > 0 && charCode === 46) {
            return false;
        }
        if (index > 0) {
            var CharAfterdot = (len + 1) - index;
            if (CharAfterdot > max) {
                return false;
            }
        }
    }
    return true;
}

function currencyFormat(fld, decSep, e) {
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode === 13) return true;  // Enter
    key = String.fromCharCode(whichCode);  // Get key value from key code
    if (strCheck.indexOf(key) === -1) return false;  // Not a valid key
    len = fld.value.length;
    for(i = 0; i < len; i++){
        if ((fld.value.charAt(i) !== '0') && (fld.value.charAt(i) !== decSep)) break;
    }
    if (len === 5) return false;

    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(fld.value.charAt(i))!==-1) aux += fld.value.charAt(i);
    aux += key;
    len = aux.length;

    if (len === 0) fld.value = '';
    if (len === 1) fld.value = '0'+ decSep + '0' + aux;
    if (len === 2) fld.value = '0'+ decSep + aux;

    if (len > 2 && len<5) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            aux2 += aux.charAt(i);
            j++;
        }
        fld.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
            fld.value += aux2.charAt(i);
        fld.value += decSep + aux.substr(len - 2, len);
    }
    return false;
}
