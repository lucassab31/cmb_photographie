function showNav() {
    document.getElementsByClassName("nav")[0].classList.toggle("active");
}

window.addEventListener('load', function () {
    document.body.classList.add('loaded');
});