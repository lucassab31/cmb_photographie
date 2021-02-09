<?php require_once('includes/header.php') ?>

<!-- MAIN -->
<main>
    <section class="contact">
        <div class="form">
            <div class="contact-info">
                <h3 class="title">Contactez-moi</h3>
                <p class="text">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi recusandae tempore ipsa? Ea non praesentium quod rerum eum quidem fugit, sed laborum velit unde, consequuntur deleniti dignissimos voluptatibus architecto odit!
                </p>
                <div class="info">
                    <div class="information">
                        <i class="fas fa-phone"></i>
                        <p>06 11 11 11 11</p>
                    </div>
                    <div class="information">
                        <i class="far fa-envelope"></i>
                        <p>abcd@gmail.com</p>
                    </div>
                    <div class="information">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Région Toulousaine, France</p>
                    </div>
                </div>
                <div class="social-media">
                    <p>Réseaux sociaux :</p>
                    <div class="socials">
                        <a href="https://www.instagram.com/cmb__photographie/" target="_blank" rel="noopener noreferrer">
                            <div class="social insta">
                                    <i class="fab fa-instagram"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="contact-form">
                <span class="circle one"></span>
                <span class="circle two"></span>

                <form method="post">
                    <h3 class="title">Contact</h3>
                    <div class="input-container">
                        <input class="input" type="text" name="nom" id="name" required>
                        <label for="name">Nom et prénom</label>
                        <span>Nom et prénom</span>
                    </div>
                    <div class="input-container">
                        <input class="input" type="email" name="mail" id="mail" required>
                        <label for="mail">Adresse mail</label>
                        <span>Adresse mail</span>
                    </div>
                    <div class="input-container">
                        <input class="input" type="text" name="subject" id="subject" required>
                        <label for="subject">Sujet</label>
                        <span>Sujet</span>
                    </div>
                    <div class="input-container textarea">
                        <textarea class="input" name="message" id="message" required></textarea>
                        <label for="name">Message</label>
                        <span>Message</span>
                    </div>
                    <input class="btn-contact" type="submit" name="submitC" value="Envoyer">
                </form>
            </div>
        </div>
    </section>
    <?php
        if (isset($_POST['submitC'])) {
            $date = date("Y-m-d");
            $insert = $bdd->prepare("INSERT INTO contacts(nom, mail, sujet, message, dateContact) VALUES(?,?,?,?,?)");
            $insert->execute(array($_POST['nom'], $_POST['mail'], $_POST['subject'], $_POST['message'], $date));
        }
    ?>
</main>
<script src="app/js/contact.js"></script>
<!-- FOOTER -->
<?php
    require_once('includes/footer.html');
?>