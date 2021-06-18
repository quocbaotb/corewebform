var refresh_rate = 20;
var last_user_action = 0;

function reset() {
    last_user_action = 0;
    updateVisualTimer('Reset Timer');
}

function updateVisualTimer(value) {
    var element = document.getElementById('RefreshTimer');
    if (value) {
        element.value = value;
    }else if (last_user_action === 0) {
        element.value = 0;
    }else{
        element.value = (refresh_rate - last_user_action);
    }
}

setInterval(function() {
    last_user_action++;
    refreshCheck();
    updateVisualTimer();
}, 1000)
function refreshCheck() {
    var focus = window.onfocus;
    if ((last_user_action >= refresh_rate && document.readyState == "complete")) {
        window.location.reload();
        reset();
    }
}


