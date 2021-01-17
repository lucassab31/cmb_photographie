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
</head>
<body>
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
                    <a href="#">avis & questions</a>
                </div>
                <div class="link">
                    <a href="#">prestations</a>
                </div>
                <div class="link">
                    <a href="#">a propos</a>
                </div>
                <div class="link">
                    <a href="#">contact</a>
                </div>
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
    <script src="app/js/nav.js"></script>
    <div class="loading">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
</body>
</html>