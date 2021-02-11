function showNav() {
    document.getElementsByClassName("nav")[0].classList.toggle("active");
}

window.addEventListener('load', function () {
    document.body.classList.add('loaded');
});

function openPopUp(popup, title, message) {
    document.getElementById(popup).classList.toggle("active");
    document.getElementById(popup + "Title").innerHTML = title;
    document.getElementById(popup + "Message").innerHTML = message;
}

function closePopUp(popup) {
    document.getElementById(popup).classList.toggle("active");
}