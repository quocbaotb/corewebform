document.addEventListener("keydown", keyDownTextField, false);
function keyDownTextField(e) {
    var keyCode = e.keyCode;
    if (keyCode === 113) {
        document.getElementById('CheckboxMoldTermialA').click();
        document.getElementById('CheckboxMoldTermialA').focus();
    }
    if (keyCode === 115) {
        document.getElementById('CheckboxMoldTermialB').click();
        document.getElementById('CheckboxMoldTermialB').focus();
    }
    if (keyCode === 118) {
        document.getElementById('ButtonChange').click();
    }

    if (keyCode === 120) {
        document.getElementById('ButtonContinue').click();
    }
}


var buttons = document.getElementsByClassName('tablinks');
var contents = document.getElementsByClassName('tabcontent');

function showContent(id) {
    for (var i = 0; i < contents.length; i++) {
        contents[i].style.display = 'none';
    }
    var content = document.getElementById(id);
    content.style.display = 'block';
}

for (var i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", function () {
        var id = this.textContent;
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove("active");
        }
        this.className += " active";
        showContent(id);
    });
}