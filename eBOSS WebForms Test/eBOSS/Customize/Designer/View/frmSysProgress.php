<?php
session_start();
include_once('../../../LoadLibrabry.php');
include_once ('../../../Core/Core.php');

$Core = new Core();
$GetLanguage = $Core->fGetLanguage();
$vLanguage = $GetLanguage->GetLanguage();
$vProgress = new pSysProgress($vLanguage);
$vProgress->GetProgress();
?>
<link rel="stylesheet" type="text/css" href="../CSS/frmSysProgress.css">

<meta charset="utf-8">
<DIV CLASS="main">

    <div class="LayoutHeader">
        <div class="row">
            <div style="float: right;">
                <div style="color: #f3f006; font-size: 3vw;" id="TimerClock"></div>
            </div>
            <div class="Timer" style=" float: left; ">
                <input style=" border: none; font-size: 1.5vw; height: 1.5vw; width: 50px; color: #f5f503; text-align: right"
                       type="text" id="RefreshTimer" disabled hidden>
            </div>
            <h1 style="margin-bottom: 0;"><?php echo $vProgress->vDesignerTitle ?></h1>
        </div>
        <div class="row">
            <?php echo $vProgress->vDesignerHeader; ?>
        </div>
    </div>

    <div class="LayoutBottom">
        <div class="row">
            <table>
                <tbody>
                <?php
                $vProgress->GetDesignerFooter();
                ?>
                </tbody>
            </table>
        </div>
    </div>
</DIV>
<script>
    function TimerClock() {
        var time = new Date();
        var gio = time.getHours();
        var phut = time.getMinutes();
        var giay = time.getSeconds();

        if (gio < 10)
            gio = "0" + gio;
        if (phut < 10)
            phut = "0" + phut;
        if (giay < 10)
            giay = "0" + giay;

        document.getElementById("TimerClock").innerHTML = gio + ":" + phut + ":" + giay;
        setTimeout("TimerClock()", 1000);
    }

    TimerClock();
</script>
<script>
    function scroll_to(div) {
        if (div.scrollTop < div.scrollHeight - div.clientHeight)
            div.scrollTop += 10; // move down

    }

    function scrollTo(hash) {
        location.hash = "#" + hash;
    }

    var refresh_rate = 2;
    var last_user_action = 0;
    var CountCrolling = 0;
    var EndCrolling = "<?php echo count($vProgress->vTableView) ?>";


    function reset() {
        last_user_action = 0;
        if (CountCrolling + 9 > EndCrolling) {
            CountCrolling = 0;
        } else {
            CountCrolling += 1;
        }
        updateVisualTimer('Reset Timer');
    }

    function updateVisualTimer(value) {
        var element = document.getElementById('RefreshTimer');
        if (value) {
            element.value = value;
        } else if (last_user_action === 0) {
            element.value = 0;
        } else {
            element.value = (refresh_rate - last_user_action);
        }
    }

    setInterval(function () {
        last_user_action++;
        refreshCheck();
        updateVisualTimer();
    }, 1000)

    function refreshCheck() {
        var focus = window.onfocus;
        if ((last_user_action >= refresh_rate && document.readyState == "complete")) {
            if (CountCrolling + 10 > EndCrolling) {
                window.location.reload();
                reset();
            } else {
                reset();
                scrollTo(CountCrolling);
            }
        }
    }

</script>

