<?php require_once('includes/header.php') ?>
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'mail/Exception.php';
    require 'mail/PHPMailer.php';
    require 'mail/SMTP.php';
?>

<!-- MAIN -->
<main>
    <section class="contact">
        <div class="form">
            <div class="contact-info">
                <h3 class="title">Contactez-moi</h3>
                <p class="text">
                    <p>
                        N'hésitez pas à me contacter pour tout renseignement supplémentaire ou pour connaître davantage de détails à propos de mes prestations photos.
                        Également et surtout par rapport aux prises de rendez-vous pour un shoot, vous êtes au bon endroit !
                    </p>
                    <br/>
                    <p>
                        PS : la rubrique « Avis et Questions » comporte peut-être les réponses à vos questionnements, allez jeter un coup d'œil !
                    </p>
                    <br/>
                    <p>
                        Merci pour votre visite. 
                        A bientôt:)
                    </p>
                </p>
                <div class="info">
                    <div class="information">
                        <i class="fas fa-phone"></i>
                        <p>06 95 46 13 16</p>
                    </div>
                    <div class="information">
                        <i class="far fa-envelope"></i>
                        <p>cloem31@gmail.com</p>
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

            $mail = new PHPMailer;
            $mail->isSMTP(); 
            $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
            $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
            $mail->Port = 587; // TLS only
            $mail->SMTPSecure = 'tls'; // ssl is deprecated
            $mail->SMTPAuth = true;
            $mail->Username = 'lucsab05@gmail.com'; // email
            $mail->Password = 'lucas3131'; // password
            $mail->setFrom('cloem31@gmail.com', 'CMB_Photographie Website'); // From email and name
            // $mail->addAddress('cloem31@gmail.com', 'Cloé'); // to email and name
            $mail->addAddress('luqui31@gmail.com', 'Lucas'); // to email and name
            $mail->Subject = "Nouvelle demande de contact - " . $_POST['nom'];
            $mail->msgHTML("Vous avez une nouvelle demande de contact en attente : https://cmb-photographie.000webhostapp.com/gestion/manage.php?page=contacts&action=validation"); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
            $mail->AltBody = 'HTML messaging not supported'; // If html emails is not supported by the receiver, show this body
            // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
            $mail->SMTPOptions = array(
                                'ssl' => array(
                                    'verify_peer' => false,
                                    'verify_peer_name' => false,
                                    'allow_self_signed' => true
                                )
                            );
            if(!$mail->send()){
                echo "Mailer Error: " . $mail->ErrorInfo;
            }else{
                echo '<script>openPopUp("popup1", "Demande de contact","Votre message a bien été envoyé");</script>';
            }
        }
    ?>
    
</main>
<script src="app/js/contact.js"></script>
<!-- FOOTER -->
<?php
    require_once('includes/footer.html');
?>