<?php session_start();
    require_once('../app/php/db.php');

    if (isset($_COOKIE['tokenCID']) && !isset($_SESSION['CID'])) {
        $req = $bdd->prepare("SELECT * FROM users WHERE token=?");
        $req->execute(array($_COOKIE['tokenCID']));
        $userexist = $req->rowCount();
        if ($userexist == 1) {
            $requser = $req->fetch();
            $_SESSION['CID'] = $requser['idUser'];
            setcookie("tokenCID", $_COOKIE['tokenCID'], time()+3600*24*7, "/");
        }
    }
    // verification de l'authentification de l'utilisateur
    if (!isset($_SESSION['CID'])) {
        header('Location: index.php');
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
<body>
    <header>
        <div class="loading">
            <div class="yellow"></div>
            <div class="red"></div>
            <div class="blue"></div>
            <div class="violet"></div>
        </div>

        <nav class="nav">
            <div class="hamburger-btn" onclick="showNav()">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="nav-title">
                <h1>Panel Administrateur</h1>
                <hr>
            </div>
            <div class="links">
                <div class="link <?= $_GET['action'] == "dashboard" ? "active" : "" ?>">
                    <a href="manage.php?action=dashboard"><i class="fas fa-home"></i> Dashboard</a>
                </div>
                <div class="link <?= $_GET['action'] == "photos" ? "active" : "" ?>">
                    <a href="manage.php?action=photos"><i class="fas fa-images"></i> Photographies</a>
                </div>
                <div class="link <?= $_GET['action'] == "feedbacks" ? "active" : "" ?>">
                    <a href="manage.php?action=feedbacks"><i class="fas fa-comments"></i> Avis & Questions</a>
                </div>
                <div class="link <?= $_GET['action'] == "prestations" ? "active" : "" ?>">
                    <a href="manage.php?action=prestations"><i class="fas fa-tags"></i> Prestations</a>
                </div>
                <div class="link <?= $_GET['action'] == "contacts" ? "active" : "" ?>">
                    <a href="manage.php?action=contacts"><i class="fas fa-envelope"></i>Demandes de contact</a>
                </div>
                <div class="link <?= $_GET['action'] == "stats" ? "active" : "" ?>">
                    <a href="manage.php?action=stats"><i class="fas fa-chart-line"></i> Statistiques</a>
                </div>
                <div class="link">
                    <a href="../"><i class="fas fa-camera"></i> Site web</a>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <?php
            if (isset($_GET['action']) && !empty($_GET['action'])) {
                if ($_GET['action'] == "dashboard") {
                    $date = date("d-m-Y");
                    echo $date;
                    $select = $bdd->prepare('SELECT
                                                ( -- nombre de photo online
                                                    SELECT COUNT(*) 
                                                    FROM photos 
                                                    WHERE visible = 1
                                                ) as nbPhotos,
                                                ( -- nombre d avis en attente
                                                    SELECT COUNT(*) 
                                                    FROM avis 
                                                    WHERE valide = 0
                                                ) as nbAvis,
                                                ( -- nombre de questions en attente
                                                    SELECT count(*) 
                                                    FROM questions 
                                                    WHERE valide = 0
                                                ) as nbQuestions,
                                                ( -- nombre de demande de contact en attente
                                                    SELECT COUNT(*)
                                                    FROM contacts
                                                    WHERE valide = 0
                                                ) as nbContacts,
                                                ( -- nombre de visite aujourd hui
                                                    SELECT COUNT(*)
                                                    FROM visits
                                                    WHERE dateV = :dateAUJD
                                                ) as nbVisit
                    ');
                    $select->execute(array(':dateAUJD' => $date));
                    $data = $select->fetch();
                    ?>
                    <section class="dashboard">
                        <div class="page-title">dashboard</div>
                        <div class="dashboard-item">
                            <a href="?action=photos">
                                <div class="dashboard-title">Photos online</div>
                                <div class="dashboard-number"><?= isset($data['nbPhotos']) ? $data['nbPhotos'] : "0" ?></div>
                            </a>
                        </div>
                        <div class="dashboard-item">
                            <a href="?action=feedbacks">
                                <div class="dashboard-title">Avis en attente</div>
                                <div class="dashboard-number"><?= isset($data['nbAvis']) ? $data['nbAvis'] : "0" ?></div>
                            </a>
                        </div>
                        <div class="dashboard-item">
                            <a href="?action=feedbacks">
                                <div class="dashboard-title">Question en attente</div>
                                <div class="dashboard-number"><?= isset($data['nbQuestions']) ? $data['nbQuestions'] : "0" ?></div>
                            </a>
                        </div>
                        <div class="dashboard-item">
                            <a href="?action=contacts">
                                <div class="dashboard-title">Contact en attente</div>
                                <div class="dashboard-number"><?= isset($data['nbContacts']) ? $data['nbContacts'] : "0" ?></div>
                            </a>
                        </div>
                        <div class="dashboard-item">
                            <a href="?action=stats">
                                <div class="dashboard-title">Visiteur aujourd'hui</div>
                                <div class="dashboard-number"><?= isset($data['nbVisit']) ? $data['nbVisit'] : "0" ?></div>
                            </a>
                        </div>
                    </section>
                    <?php
                }
                else if ($_GET['action'] == "photos") {
                    
                }
                else if ($_GET['action'] == "feedbacks") {

                }
                else if ($_GET['action'] == "prestations") {

                }
                else if ($_GET['action'] == "contacts") {

                }
                else if ($_GET['action'] == "stats") {

                } else {
                    header('Location: index.php');
                }
            } else {
                header('Location: index.php');
            }
        ?>
        
    </main>
    <script src="../app/js/app.js"></script>
</body>
</html>