<!-- HEADER -->
<?php
    require_once('includes/header.php');
?>

<!-- MAIN -->
<main>
    <div class="page-title">
        <h1>Photographies</h1>
    </div>
    <div class="page-selector" id="selector">
        <button id="toutes" onclick="activateBtn('toutes')" class="active">Toutes</button>
        <button id="pro" onclick="activateBtn('pro')">Professionnelles</button>
        <button id="perso" onclick="activateBtn('perso')">Personnelles</button>
    </div>

    <div class="grid">
        <div class="item">
            <div class="item-content">
                <img src="img/1.jpg" alt="img1">

            </div>
        </div>
        <div class="item">
            <div class="item-content">
                <img src="img/2.jpg" alt="img2">
            </div>
        </div>
        <div class="item">
            <div class="item-content">
                <img src="img/3.jpg" alt="img3">
            </div>
        </div>
        <div class="item">
            <div class="item-content">
                <img src="img/4.jpg" alt="img4">
            </div>
        </div>
        <div class="item">
            <div class="item-content">
                <img src="img/5.jpg" alt="img5">
            </div>
        </div>
        <div class="item">
            <div class="item-content">
                <img src="img/6.jpg" alt="img6">
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/muuri@0.9.3/dist/muuri.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/web-animations-js@2.3.2/web-animations.min.js"></script>
<script>
    var grid = new Muuri('.grid', {
        dragEnabled: false,
        layout: {
            fillGaps: true
        }
    });

    // When all items have loaded refresh their
    // dimensions and layout the grid.
    window.addEventListener('load', function () {
        grid.refreshItems().layout();
    });

    function activateBtn(id) {
        var btnActive = document.getElementById("selector").getElementsByClassName("active");
        btnActive[0].classList.remove("active");
        var btn = document.getElementById(id);
        btn.classList.toggle("active");
    }
</script>
<!-- FOOTER -->