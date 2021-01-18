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
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/1.jpg" alt="img1">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">Titre de la photo</h3>
                        <h4 class="content-subtitle"><i class="fas fa-map-marker-alt"></i> Lieu</h4>
                        <p class="content-text">Desc</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/2.jpg" alt="img2">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">This is a title</h3>
                        <p class="content-text">This is a short description</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/3.jpg" alt="img3">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">This is a title</h3>
                        <p class="content-text">This is a short description</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/4.jpg" alt="img4">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">This is a title</h3>
                        <p class="content-text">This is a short description</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/5.jpg" alt="img5">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">This is a title</h3>
                        <p class="content-text">This is a short description</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/6.jpg" alt="img6">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">This is a title</h3>
                        <p class="content-text">This is a short description</p>
                    </div>
                </div>
            </div>
        </div>
</main>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script src="app/js/grid.js"></script>
<!-- FOOTER -->
<?php
    require_once('includes/footer.html');
?>