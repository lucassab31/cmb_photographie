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
        <a href="?" id="toutes" class="<?= !isset($_GET['action']) ? "active" : "" ?>">Toutes</a>
        <a href="?action=pro" class="<?= (isset($_GET['action']) && $_GET['action'] == "pro") ? "active" : "" ?>">Professionnelles</button>
        <a href="?action=perso" class="<?= (isset($_GET['action']) && $_GET['action'] == "perso") ? "active" : "" ?>">Personnelles</button>
    </div>

    <div class="grid">
        <?php
            if (isset($_GET['action']) && !empty($_GET['action'])) {
                if ($_GET['action'] == "pro") {
                    $select = bddSelectId($bdd, "photos", "type", "Professionnelle");
                } else if ($_GET['action'] == "perso") {
                    $select = bddSelectId($bdd, "photos", "type", "Personnelle");
                } else {
                    header('Location: photographies.php');
                }
            } else {
                $select = $bdd->prepare("SELECT * FROM photos WHERE visible='1' ORDER BY datePhoto DESC");
                $select->execute();
            }
            if ($select->rowCount() > 0) {
                while ($data = $select->fetch()) {
                    ?>
                    <div class="item" onclick="showDesc(this)">
                        <div class="content">
                            <div class="content-overlay"></div>
                            <img src="<?= $data['chemin'] ?>" alt="<?= $data['titre'] ?>">
                            <div class="content-details fadeIn-bottom">
                                <h3 class="content-title"><?= $data['titre'] ?></h3>
                                <?php
                                    if (!empty($data['lieu'])) {
                                        ?><h4 class="content-subtitle"><i class="fas fa-map-marker-alt"></i> <?= $data['lieu'] ?></h4><?php
                                    }
                                ?>
                                <p class="content-text"><?= $data['description'] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="erreur">Aucune photo trouvée ...</p>';
            }
            
        ?>
        </div>
</main>
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script src="app/js/grid.js"></script>
<!-- FOOTER -->
<?php
    require_once('includes/footer.html');
?>