<!-- HEADER -->
<?php
    require_once('includes/header.php');
?>

<!-- MAIN -->
<main>
    <div class="page-title">
        <h1>Avis & questions</h1>
    </div>

    <div class="page-selector">
        <a href="?page=avis" class="<?= (isset($_GET['page']) && $_GET['page'] == "avis") ? "active" : "" ?>">Avis</a>
        <a href="?page=questions" class="<?= (isset($_GET['page']) && $_GET['page'] == "questions") ? "active" : "" ?>">Questions</a>
        <a href="?page=<?= $_GET['page'] ?>&action=add" class="round <?= (isset($_GET['action']) && $_GET['action'] == "add") ? "active" : "" ?>"><i class="fas fa-plus fa-fw" style=""></i></a>

    </div>

    
    <?php
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            if ($_GET['page'] == "avis") {
                if (isset($_GET['action']) && $_GET['action'] == "add") {
                    ?>
                    <form method="post">
                        <div class="title">
                            <h1>Ajout d'un avis</h1>
                        </div>
                        <input type="text" name="nom" placeholder="Nom">
                        <input type="text" name="prenom" placeholder="Prénom" required>
                        <input type="number" min="0" max="5" name="note" placeholder="Note/5" required>
                        <textarea name="commentaire" placeholder="Commentaire" required></textarea>
                        <input type="submit" name="submitA" value="Ajouter">
                    </form>
                    <?php
                    if (isset($_POST['submitA'])) {
                        $insert = $bdd->prepare("INSERT INTO avis(nom, prenom, note, commentaire, dateAvis) VALUES(?, ?, ?, ?, ?)");
                        $insert->execute(array($_POST['nom'], $_POST['prenom'], $_POST['note'], $_POST['commentaire'], Date("Y-m-d")));
                        header("Location: ?page=avis");
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
            }
            else if ($_GET['page'] == "questions") {
                if (isset($_GET['action']) && $_GET['action'] == "add") {
                    ?>
                    <form method="post">
                        <div class="title">
                            <h1>Poser une question</h1>
                        </div>
                        <input type="text" name="nom" placeholder="Nom">
                        <input type="text" name="prenom" placeholder="Prénom" required>
                        <textarea name="question" placeholder="Question" required></textarea>
                        <input type="submit" name="submitQ" value="Demander">
                    </form>
                    <?php
                    if (isset($_POST['submitQ'])) {
                        $insert = $bdd->prepare("INSERT INTO questions(nom, prenom, question, dateQuestion) VALUES(?, ?, ?, ?)");
                        $insert->execute(array($_POST['nom'], $_POST['prenom'], $_POST['question'], Date("Y-m-d")));
                        header("Location: ?page=questions");
                    }
                } else {
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
                } 
            } 
            else {
                header('Location: index.php');
            }
        } else {
            header('Location: index.php');
        }
    ?>
    
</main>

<!-- FOOTER -->
<?php
    require_once('includes/footer.html');
?>