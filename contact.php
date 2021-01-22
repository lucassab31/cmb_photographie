<!-- HEADER -->
<?php
    require_once('includes/header.php');
?>

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

                <form onsubmit="return false">
                    <h3 class="title">Contact</h3>
                    <div class="input-container">
                        <input class="input" type="text" name="name" id="name">
                        <label for="name">Nom et prénom</label>
                        <span>Nom et prénom</span>
                    </div>
                    <div class="input-container">
                        <input class="input" type="email" name="mail" id="mail">
                        <label for="mail">Adresse mail</label>
                        <span>Adresse mail</span>
                    </div>
                    <div class="input-container">
                        <input class="input" type="text" name="subject" id="subject">
                        <label for="subject">Sujet</label>
                        <span>Sujet</span>
                    </div>
                    <div class="input-container textarea">
                        <textarea class="input" name="message" id="message"></textarea>
                        <label for="name">Message</label>
                        <span>Message</span>
                    </div>
                    <input class="btn-contact" type="submit" value="Envoyer">
                </form>
            </div>
        </div>
    </section>
</main>
<script src="app/js/contact.js"></script>
<!-- FOOTER -->
<?php
    require_once('includes/footer.html');
?>