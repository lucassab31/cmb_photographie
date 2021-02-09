<?php
    require_once('app/php/db.php');

    $path = explode("/", $_SERVER['PHP_SELF']);
    $page = explode(".", end($path))[0];
    switch ($page) {
        case 'index':
            $lettre = 'i';
            break;
        case 'photographies':
            $lettre = 'p';
            break;
        case 'feedbacks':
            $lettre = 'f';
            break;
        case 'prestations':
            $lettre = 't';
            break;
        case 'about':
            $lettre = 'a';
            break;
        case 'contact':
            $lettre = 'c';
            break;
        
        default:
            break;
    }
    if (isset($_COOKIE['vtd']) && !empty($_COOKIE['vtd'])) {      
        if (strpos($_COOKIE['vtd'], $lettre) === false) {
            setcookie("vtd", $_COOKIE['vtd'] . $lettre, time()+3600*24, "/");
            $up = true;
        }
    } else {
        setcookie("vtd", $lettre, time()+3600*24, "/");
        $up = true;
    }
    $date = date("Y-m-d");
    $select = $bdd->prepare("SELECT * FROM visits WHERE dateVisit=? AND page=?");
    $select->execute(array($date, $page));
    if ($select->rowCount() == 0) {
        $insert = $bdd->prepare("INSERT INTO visits(dateVisit, page, nombre) VALUES(?,?,?)");
        $insert->execute(array($date, $page, "1"));
    } else if (isset($up) && $up) {
        $update = $bdd->prepare("UPDATE visits SET nombre=nombre+1 WHERE dateVisit=? AND page=?");
        $update->execute(array($date, $page));
        $up = false;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMB_Photographie</title>
    <link rel="icon" type="image/png" href="includes/favicon.png" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="app/css/style.css">
    <link rel="stylesheet" href="app/css/index.css">
    <link rel="stylesheet" href="app/css/photographies.css">
    <link rel="stylesheet" href="app/css/feedbacks.css">
    <link rel="stylesheet" href="app/css/prestations.css">
    <link rel="stylesheet" href="app/css/about.css">
    <link rel="stylesheet" href="app/css/contact.css">
</head>
<body>
    <div class="loading">
        <div class="loader">
            <span>Loading...</span>
        </div>
    </div>
    
    <header>
        <div class="header-logo">
            <a href="index.php">
                <img src="includes/logo.jpg" alt="">
            </a>
        </div>

        <nav class="nav">
            <div class="hamburger-btn" onclick="showNav()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="links">
                <div class="link">
                    <a href="index.php">accueil</a>
                </div>
                <div class="link">
                    <a href="photographies.php">photographies</a>
                </div>
                <div class="link">
                    <a href="feedbacks.php?page=avis">avis & questions</a>
                </div>
                <div class="link">
                    <a href="prestations.php">prestations</a>
                </div>
                <div class="link">
                    <a href="about.php">a propos</a>
                </div>
                <div class="link">
                    <a href="contact.php">contact</a>
                </div>
                <?php
                    if (isset($_SESSION['CID'])) {
                        ?>
                        <div class="link">
                            <a href="gestion/">admin</a>
                        </div>
                        <?php
                    }
                ?>
            </div>
            <div class="nav-footer">
                <div class="socials">
                    <a href="https://www.instagram.com/cmb__photographie/" target="_blank" rel="noopener noreferrer">
                        <div class="social insta">
                                <i class="fab fa-instagram"></i>
                        </div>
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <script src="app/js/app.js"></script>