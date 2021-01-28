<!-- HEADER -->
<?php
    require_once('includes/header.php');
?>

<!-- MAIN -->
<main>
    <div class="page-title">
        <h1>Avis & questions</h1>
    </div>

    <div class="page-selector" id="selector">
        <a href="?" class="<?= !isset($_GET['action']) ? "active" : "" ?>">Avis</a>
        <a href="?action=questions" class="<?= (isset($_GET['action']) && $_GET['action'] == "questions") ? "active" : "" ?>">Questions</a>
    </div>

    
    <?php
        if (isset($_GET['action']) && !empty($_GET['action'])) {
            if ($_GET['action'] == "questions") {
                $selectQ = bddSelectId($bdd, "questions", "visible", "1");
                ?>
                <section class="questions">
                    <?php
                    if ($selectQ->rowCount() > 0) {
                        while ($data = $selectQ->fetch()) {
                            ?>
                            <div class="item">
                                <div class="item-header">
                                    <div class="item-title center"><?= $data['prenom'] . " " . $data['nom'] ?></div>
                                </div>
                                <div class="item-content">
                                    <?= $data['question'] ?>
                                </div>
                                <div class="item-header not-rounded">
                                    <div class="item-title center">CMB_Photographie</div>
                                </div>
                                <div class="item-content">
                                    <?= $data['reponse'] ?>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="erreur">Aucune question trouvée ...</p>';
                    }
                        
                    ?>
                </section>
                <?php
            } else {
                header('Location: feedbacks.php');
            }
        } else {
            $selectA = bddSelectId($bdd, "avis", "visible", "1");
            ?>
            <section class="avis">
                <?php
                    if ($selectA->rowCount() > 0) {
                        while ($data = $selectA->fetch()) {
                            ?>
                            <div class="item">
                                <div class="item-header">
                                    <div class="item-title"><?= $data['prenom'] . " " . $data['nom'] ?></div>
                                    <div class="item-note">
                                        <?php
                                            for ($i=0; $i<$data['note']; $i++) {
                                                ?><i class="fas fa-star"></i><?php
                                            }
                                            for ($i=0; $i<(5-$data['note']); $i++) {
                                                ?><i class="far fa-star"></i><?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <?= $data['commentaire'] ?>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="erreur">Aucun avis trouvé ...</p>';
                    }
                ?>
            </section>
            <?php
        }
    ?>
    
</main>

<!-- FOOTER -->
<?php
    require_once('includes/footer.html');
?>