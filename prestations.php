<?php require_once('includes/header.php') ?>

<!-- MAIN -->
<main>
    <div class="page-title">
        <h1>Prestations</h1>
    </div>

    <section class="prestations">
        <?php
            $select = bddSelectOrderR($bdd, "prestations", "ordre");
            if ($select->rowCount() > 0) {
                while ($data = $select->fetch()) {
                    ?>
                    <div class="prestation">
                        <div class="prestation-header">
                            <div class="prestation-title"><?= $data['titre'] ?></div>
                            <div class="prestation-price">à partir de <?= $data['prix'] ?>€</div>
                        </div>
                        <div class="prestation-desc">
                            <?= $data['description'] ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="erreur">Aucune prestation disponible ...</p>';
            }
        ?>
        
    </section>
</main>

<!-- FOOTER -->
<?php
    require_once('includes/footer.html');
?>