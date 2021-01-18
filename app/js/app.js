function showNav() {
    document.getElementsByClassName("nav")[0].classList.toggle("active");
}

window.addEventListener('load', function () {
    document.body.classList.add('loaded');
});

function activateBtn(id) {
    var btnActive = document.getElementById("selector").getElementsByClassName("active");
    btnActive[0].classList.remove("active");
    var btn = document.getElementById(id);
    btn.classList.toggle("active");
}

document.addEventListener("click", x=>0)