function TimerClock(){
    var GetDate = new Date();
    var GetHour = GetDate.getHours();
    var GetMinute = GetDate.getMinutes();
    var GetSecond = GetDate.getSeconds();

    if (GetHour < 10)
        GetHour = "0" + GetHour;
    if (GetMinute < 10)
        GetMinute = "0" + GetMinute;
    if (GetSecond < 10)
        GetSecond = "0" + GetSecond;

    document.getElementById("TimerClock").innerHTML = GetHour + ":" + GetMinute + ":" + GetSecond;
    setTimeout("TimerClock()", 1000);
}

TimerClock();
