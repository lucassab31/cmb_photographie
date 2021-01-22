<?php session_start();
    require_once('../app/php/db.php');

    // verification de l'authentification de l'utilisateur
    if (isset($_SESSION['CID'])) {
        header('Location: manage.php?action=dashboard');
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrateur</title>
    <link rel="icon" type="image/png" href="../includes/favicon.png" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="../app/css/admin.css">
</head>
<body class="connexion-background">
    <main style="padding: 0; display: flex; justify-content: center; align-items: center">
    <?php
            if (isset($_POST['connexion'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = sha1($_POST['password']);
                $requser = $bdd->prepare("SELECT * FROM users WHERE username=? AND pass=?");
                $requser->execute(array($username, $password));

                // $requser->debugDumpParams();

                $userexist = $requser->rowCount();
                if ($userexist == 1) {
                    $userinfo = $requser -> fetch();
                    $_SESSION['CID'] = $userinfo['idUser'];

                    if (empty($userinfo['token'])) {
                        $id = $userinfo['idUser'];
                        $token = sha1($userinfo['id']);
                        $update = $bdd->prepare("UPDATE users SET token=? WHERE idUser=$id");
                        $update->execute(array($token));
                        setcookie("tokenCID", $token, time()+3600*24*7, "/");
                    } else {
                        setcookie("tokenCID", $userinfo['token'], time()+3600*24*7, "/");
                    }
                    header('Location: manage.php?action=dashboard');
                } else {
                    $error = "Nom d'utilisateur ou mot de passe incorrect";
                }
            }
        ?>
        <section class="connexion">
            <h1 class="section-title">CMB_Photographie</h1>
            <h2 class="section-title">Connexion</h2>
            <form method="post">
                <input type="text" name="username" placeholder="Nom d'utilisateur" required><br/>
                <input type="password" name="password" placeholder="Mot de passe" required><br/>
                <input type="submit" name="connexion" value="Connexion">
            </form>
            <p><?php echo (isset($error) ? $error : ""); ?></p>
        </section>
    </main>
</body>
</html>