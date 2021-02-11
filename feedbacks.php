<?php require_once('includes/header.php') ?>

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
                    <div class="form-container">
                        <div class="title">
                            <h2>Ajouter un avis</h2>
                        </div>
                        <form onsubmit="validateAvis(this); return false;" method="post" class="form" id="feedback-form" name="feedback-form" >
                            <div class="form-control">
                                <!-- <label for="nom">Nom :</label> -->
                                <input type="text" name="nom" id="nom" placeholder="Nom">
                                <i class="fas fa-check-circle"></i>
                                <i class="fas fa-exclamation-circle"></i>
                                <small>Error message</small>
                            </div>
                            <div class="form-control">
                                <!-- <label for="prenom">Prénom :</label> -->
                                <input type="text" name="prenom" id="prenom" placeholder="Prénom">
                                <i class="fas fa-check-circle"></i>
                                <i class="fas fa-exclamation-circle"></i>
                                <small>Error message</small>
                            </div>
                            <div class="form-control">
                                <!-- <label for="note">Note :</label> -->
                                <input type="number" min="0" max="5" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="note" id="note" placeholder="Note/5">
                                <i class="fas fa-check-circle"></i>
                                <i class="fas fa-exclamation-circle"></i>
                                <small>Error message</small>
                            </div>
                            <div class="form-control">
                                <!-- <label for="commentaire">Commentaire :</label> -->
                                <textarea name="commentaire" id="commentaire" placeholder="Commentaire"></textarea>
                                <i class="fas fa-check-circle"></i>
                                <i class="fas fa-exclamation-circle"></i>
                                <small>Error message</small>
                            </div>
                            <button type="submit" name="submitF">Envoyer</button>
                        </form>
                    </div>
                    <?php
                    if (isset($_POST['submitF'])) {
                        $insert = $bdd->prepare("INSERT INTO avis(nom, prenom, note, commentaire, dateAvis) VALUES(?, ?, ?, ?, ?)");
                        $insert->execute(array($_POST['nom'], $_POST['prenom'], $_POST['note'], $_POST['commentaire'], Date("Y-m-d")));
                        echo '<script>openPopUp("popup1", "Avis","Votre avis a bien été envoyé, il est en attente de validation et sera affiché d\'ici peu");</script>';
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
                                echo '<p class="data">Aucun avis trouvé ...</p>';
                            }
                        ?>
                    </section>
                    <?php
                }
            }
            else if ($_GET['page'] == "questions") {
                if (isset($_GET['action']) && $_GET['action'] == "add") {
                    ?>
                    <div class="form-container">
                        <div class="title">
                            <h2>Poser une question</h2>
                        </div>
                        <form onsubmit="validateQuestion(this); return false;" method="post" class="form" id="feedback-form" name="feedback-form" >
                            <div class="form-control">
                                <!-- <label for="nom">Nom :</label> -->
                                <input type="text" name="nom" id="nom" placeholder="Nom">
                                <i class="fas fa-check-circle"></i>
                                <i class="fas fa-exclamation-circle"></i>
                                <small>Error message</small>
                            </div>
                            <div class="form-control">
                                <!-- <label for="prenom">Prénom :</label> -->
                                <input type="text" name="prenom" id="prenom" placeholder="Prénom">
                                <i class="fas fa-check-circle"></i>
                                <i class="fas fa-exclamation-circle"></i>
                                <small>Error message</small>
                            </div>
                            <div class="form-control">
                                <!-- <label for="question">Question :</label> -->
                                <textarea name="question" id="question" placeholder="Question"></textarea>
                                <i class="fas fa-check-circle"></i>
                                <i class="fas fa-exclamation-circle"></i>
                                <small>Error message</small>
                            </div>
                            <button type="submit" name="submitQ">Envoyer</button>
                        </form>
                    <?php
                    if (isset($_POST['submitQ'])) {
                        $insert = $bdd->prepare("INSERT INTO questions(nom, prenom, question, dateQuestion) VALUES(?, ?, ?, ?)");
                        $insert->execute(array($_POST['nom'], $_POST['prenom'], $_POST['question'], Date("Y-m-d")));
                        echo '<script>openPopUp("popup1", "Question","Votre question a bien été envoyée, elle est en attente de validation et sera affichée avec la réponse d\'ici peu");</script>';
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
                                        <strong> Q : </strong>
                                        <?= $data['question'] ?>
                                    </div>
                                    <div class="item-header not-rounded">
                                        <div class="item-title center">CMB_Photographie <i class="fas fa-reply"></i></div>
                                    </div>
                                    <div class="item-content">
                                        <strong> R : </strong>
                                        <?= $data['reponse'] ?>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<p class="data">Aucune question trouvée ...</p>';
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
<script src="app/js/feedbacks.js"></script>

<!-- FOOTER -->
<?php
    require_once('includes/footer.html');
?>