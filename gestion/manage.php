<?php
    require_once('../app/php/db.php');

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
                <div class="link <?= $_GET['page'] == "dashboard" ? "active" : "" ?>">
                    <a href="manage.php?page=dashboard"><i class="fas fa-home"></i> Dashboard</a>
                </div>
                <div class="link <?= $_GET['page'] == "photos" ? "active" : "" ?>">
                    <a href="manage.php?page=photos"><i class="fas fa-images"></i> Photographies</a>
                </div>
                <div class="link <?= $_GET['page'] == "feedbacks" ? "active" : "" ?>">
                    <a href="manage.php?page=feedbacks"><i class="fas fa-comment-dots"></i></i> Avis</a>
                </div>
                <div class="link <?= $_GET['page'] == "questions" ? "active" : "" ?>">
                    <a href="manage.php?page=questions"><i class="fas fa-comments"></i> Questions</a>
                </div>
                <div class="link <?= $_GET['page'] == "prestations" ? "active" : "" ?>">
                    <a href="manage.php?page=prestations"><i class="fas fa-tags"></i> Prestations</a>
                </div>
                <div class="link <?= $_GET['page'] == "contacts" ? "active" : "" ?>">
                    <a href="manage.php?page=contacts"><i class="fas fa-envelope"></i>Demandes de contact</a>
                </div>
                <div class="link <?= $_GET['page'] == "stats" ? "active" : "" ?>">
                    <a href="manage.php?page=stats"><i class="fas fa-chart-line"></i> Statistiques</a>
                </div>
                <div class="link">
                    <a href="../"><i class="fas fa-camera"></i> Site web</a>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <?php
            if (isset($_GET['page']) && !empty($_GET['page'])) {
                if ($_GET['page'] == "dashboard") {
                    $date = date("Y-m-d");
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
                                                    SELECT  MAX(nombre)
                                                    FROM visits
                                                    WHERE dateVisit = :dateAUJD
                                                ) as nbVisit
                    ');
                    $select->execute(array(':dateAUJD' => $date));
                    $data = $select->fetch();
                    ?>
                    <section class="dashboard">
                        <div class="dashboard-item">
                            <a href="?page=photos">
                                <div class="dashboard-title">Photos online</div>
                                <div class="dashboard-number"><?= isset($data['nbPhotos']) ? $data['nbPhotos'] : "0" ?></div>
                            </a>
                        </div>
                        <div class="dashboard-item">
                            <a href="?page=feedbacks&action=validation">
                                <div class="dashboard-title">Avis en attente</div>
                                <div class="dashboard-number"><?= isset($data['nbAvis']) ? $data['nbAvis'] : "0" ?></div>
                            </a>
                        </div>
                        <div class="dashboard-item">
                            <a href="?page=questions&action=validation">
                                <div class="dashboard-title">Question en attente</div>
                                <div class="dashboard-number"><?= isset($data['nbQuestions']) ? $data['nbQuestions'] : "0" ?></div>
                            </a>
                        </div>
                        <div class="dashboard-item">
                            <a href="?page=contacts&action=validation">
                                <div class="dashboard-title">Contact en attente</div>
                                <div class="dashboard-number"><?= isset($data['nbContacts']) ? $data['nbContacts'] : "0" ?></div>
                            </a>
                        </div>
                        <div class="dashboard-item">
                            <a href="?page=stats">
                                <div class="dashboard-title">Visiteur aujourd'hui</div>
                                <div class="dashboard-number"><?= isset($data['nbVisit']) ? $data['nbVisit'] : "0" ?></div>
                            </a>
                        </div>
                    </section>
                    <?php
                }
                else if ($_GET['page'] == "photos") {
                    $table = "photos";
                    $nameId = "idPhoto";
                    $location = "photos";
                    ?>
                    <section class="photos">
                        <div class="page-title">
                            <h1>Photographies</h1>
                        </div>
                        <?php
                            if (isset($_GET['action']) && !empty($_GET['action'])) {
                                if (isset($_GET['id']) && !empty($_GET['id'])) {
                                    $id = $_GET['id'];
                                    if ($_GET['action'] == "details") {
                                        $data = bddSelectId($bdd, $table, $nameId, $id)->fetch();
                                        ?>
                                        <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                        <?php
                                    }
                                    if ($_GET['action'] == "modify") {
                                        $data = bddSelectId($bdd, $table, $nameId, $id)->fetch();
                                        ?>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="title">
                                                <h1>Modification d'une photo</h1>
                                            </div>
                                            <input type="text" name="titre" placeholder="Titre" value="<?= $data['titre'] ?>">
                                            <input type="text" name="lieu" placeholder="Lieu" value="<?= $data['lieu'] ?>">
                                            <textarea name="description" placeholder="Description"><?= $data['description'] ?></textarea>
                                            <input type="date" name="datePhoto" placeholder="Date" value="<?= $data['datePhoto'] ?>" required>
                                            <select name="type">
                                                <option value="<?= $data['type'] ?>"><?= $data['type'] ?></option>
                                                <option value="Professionnelle">Professionnelle</option>
                                                <option value="Personnelle">Personnelle</option>
                                            </select>
                                            <input type="file" name="photo">
                                            <div class="image"><img src="../<?= $data['chemin'] ?>" alt="<?= $data['titre'] ?>" height="50"></div>
                                            <input type="submit" name="submitM" value="Modifier">
                                        </form>
                                        <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                        <?php
                                        if (isset($_POST['submitM'])) {
                                            $newData = array("titre"=>$_POST['titre'], "lieu"=>$_POST['lieu'], "description"=>$_POST['description'], "type"=>$_POST['type'],"datePhoto"=>$_POST['datePhoto']);
                                            bddUpdate($bdd, $table, $newData, $nameId, $id);

                                            if(!empty($_FILES['photo']['name'])){
                                                unlink("../" . $data['chemin']);
                                                $img = $_FILES['photo']['name'];
                                                $img_tmp = $_FILES['photo']['tmp_name'];
                            
                                                $image = explode('.', $img);
                                                $image_ext = end($image);
                            
                                                if (in_array(strtolower($image_ext), array('png','jpg','jpeg')) === false)
                                                {
                                                    echo "Veuillez rentrer une image ayant pour extension : png, jpg, jpg";
                                                }
                                                else
                                                {
                                                    $image_size = getimagesize($img_tmp);
                                                    if ($image_size['mime'] == 'image/jpeg')
                                                    {
                                                        $image_src = imagecreatefromjpeg($img_tmp);
                                                    }
                                                    elseif ($image_size['mime'] == 'image/png')
                                                    {
                                                        $image_src = imagecreatefrompng($img_tmp);
                                                    }
                                                    else
                                                    {
                                                        $image_src = false;
                                                        echo "Veuillez entrer une image valide";
                                                    }
                            
                                                    if ($image_src !== false)
                                                    {
                                                        $data = bddSelectId($bdd, $table, $nameId, $id)->fetch();
                                                        $path = 'img/' . sha1($id . reset($image)) . '.jpg';
                                                        bddUpdate($bdd, $table, array("chemin"=>$path), $nameId, $id);
                                                        imagejpeg($image_src,'../'.$path);
                                                    }
                                                }
                                            }

                                            header("Location: ?page=$location");
                                        }
                                    }
                                    if ($_GET['action'] == "unvisi") {
                                        bddUpdate($bdd, $table, array("visible" => "0"), $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                    if ($_GET['action'] == "visi") {
                                        bddUpdate($bdd, $table, array("visible" => "1"), $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                    if ($_GET['action'] == "delete") {
                                        $data = bddSelectId($bdd, $table, $nameId, $id)->fetch();
                                        unlink("../" . $data['chemin']);
                                        bddDelete($bdd, $table, $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                } else if ($_GET['action'] == "add") {
                                    ?>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="title">
                                            <h1>Ajout d'une photo</h1>
                                        </div>
                                        <input type="text" name="titre" placeholder="Titre">
                                        <input type="text" name="lieu" placeholder="Lieu">
                                        <textarea name="description" placeholder="Description"></textarea>
                                        <input type="date" name="datePhoto" placeholder="Date" required>
                                        <select name="type">
                                            <option value="Professionnelle">Professionnelle</option>
                                            <option value="Personnelle">Personnelle</option>
                                        </select>
                                        <input type="file" name="photo" required>
                                        <input type="submit" name="submitA" value="Ajouter">
                                    </form>
                                    <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                    <?php
                                    if (isset($_POST['submitA'])) {
                                        $insert = $bdd->prepare("INSERT INTO photos(titre, lieu, description, type, datePhoto) VALUES(?, ?, ?, ?, ?)");
                                        $insert->execute(array($_POST['titre'], $_POST['lieu'], $_POST['description'], $_POST['type'], $_POST['datePhoto']));

                                        $img = $_FILES['photo']['name'];
                                        $img_tmp = $_FILES['photo']['tmp_name'];

                                        $image = explode('.', $img);
                                        $image_ext = end($image);

                                        if (in_array(strtolower($image_ext), array('png','jpg','jpeg')) === false)
                                        {
                                            echo "Veuillez rentrer une image ayant pour extension : png, jpg, jpg";
                                        }
                                        else
                                        {
                                            $image_size = getimagesize($img_tmp);
                                            if ($image_size['mime'] == 'image/jpeg')
                                            {
                                                $image_src = imagecreatefromjpeg($img_tmp);
                                            }
                                            elseif ($image_size['mime'] == 'image/png')
                                            {
                                                $image_src = imagecreatefrompng($img_tmp);
                                            }
                                            else
                                            {
                                                $image_src = false;
                                                echo "Veuillez entrer une image valide";
                                            }

                                            if ($image_src !== false)
                                            {
                                                $select = $bdd->prepare("SELECT * FROM $table ORDER BY $nameId DESC LIMIT 1");
                                                $select->execute();
                                                $data = $select->fetch();
                                                $path = 'img/' . sha1($data['idPhoto'] . reset($image)) . '.jpg';
                                                bddUpdate($bdd, $table, array("chemin"=>$path), $nameId, $data['idPhoto']);
                                                imagejpeg($image_src,'../'.$path);
                                            }
                                        }
                                        header("Location: ?page=$location");
                                    }
                                }
                            } else {
                                ?>
                                <div class="list">
                                    <div class="list-header">
                                        <div class="list-title">Ajouter une photo -> <a href="?page=photos&action=add"><i class="fas fa-plus fa-fw" style="background-color:green;"></i></a></div>
                                        <div class="list-search">
                                            <form class="search" method="post">
                                                <input type="text" name="recherche" placeholder="Rechercher par titre">
                                                <button name="search" type="submit"><i class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="list-content">
                                        <table>
                                            <tr>
                                                <th>Photo</th>
                                                <th>Titre</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php
                                                if (isset($_POST['search']) && !empty($_POST['recherche'])) {
                                                    $select = bddSearch($bdd, $table, "titre", $_POST['recherche']);
                                                } else {
                                                    $select = bddSelectOrder($bdd, $table, "datePhoto");
                                                }
                                                
                                                while ($data = $select->fetch()) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <img src="../<?= $data['chemin'] ?>" alt="<?= $data['titre'] ?>">
                                                        </td>
                                                        <td><?= $data['titre'] ?></td>
                                                        <td><?= $data['type'] ?></td>
                                                        <td><?= dateFormatage($data['datePhoto']) ?></td>
                                                        <td>
                                                            <a href="?page=<?= $location ?>&action=details&id=<?= $data['idPhoto'] ?>"><i style="background-color:blue;" class="fas fa-search"></i></a>
                                                            <a href="?page=<?= $location ?>&action=modify&id=<?= $data['idPhoto'] ?>"><i style="background-color:orange;" class="fas fa-pen"></i></a>
                                                            <?php if ($data['visible'] == 1) { ?>
                                                                <a href="?page=<?= $location ?>&action=unvisi&id=<?= $data['idPhoto'] ?>"><i style="background-color:#0033cc;" class="fas fa-eye"></i></a> 
                                                            <?php } else { ?>
                                                                <a href="?page=<?= $location ?>&action=visi&id=<?= $data['idPhoto'] ?>"><i style="background-color:#668cff;" class="fas fa-eye-slash"></i></a>
                                                            <?php } ?>
                                                            <a href="?page=<?= $location ?>&action=delete&id=<?= $data['idPhoto'] ?>" onclick="Supp(this.href); return(false)"><i style="background-color:red;" class="fas fa-times"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    
                                                }
                                            ?>
                                            
                                        </table>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </section>
                    <?php
                }
                else if ($_GET['page'] == "feedbacks") {
                    $table = "avis";
                    $nameId = "idAvis";
                    $location = "feedbacks";
                    ?>
                    <section class="feedbacks">
                        <div class="page-title">
                            <h1>Avis</h1>
                        </div>
                        <?php
                            if (isset($_GET['action']) && !empty($_GET['action'])) {
                                if (isset($_GET['id']) && !empty($_GET['id'])) {
                                    $id = $_GET['id'];
                                    if ($_GET['action'] == "details") {
                                        $data = bddSelectId($bdd, $table, $nameId, $id)->fetch();
                                        ?>
                                        <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                        <?php
                                    }
                                    if ($_GET['action'] == "modify") {
                                        $data = bddSelectId($bdd, $table, $nameId, $id)->fetch();
                                        ?>
                                        <form method="post">
                                            <div class="title">
                                                <h1>Modification d'un avis</h1>
                                            </div>
                                            <input type="text" name="nom" placeholder="Nom" value="<?= $data['nom'] ?>">
                                            <input type="text" name="prenom" placeholder="Prenom" value="<?= $data['prenom'] ?>" required>
                                            <input type="number" max="5" name="note" placeholder="Note" value="<?= $data['note'] ?>" required>
                                            <textarea name="commentaire" placeholder="Commentaire"><?= $data['commentaire'] ?></textarea>
                                            <input type="submit" name="submitA" value="Modifier">
                                        </form>
                                        <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                        <?php
                                        if (isset($_POST['submitA'])) {
                                            $newData = array("nom"=>$_POST['nom'], "prenom"=>$_POST['prenom'], "note"=>$_POST['note'], "commentaire"=>$_POST['commentaire']);
                                            bddUpdate($bdd, $table, $newData, $nameId, $id);
                                            header("Location: ?page=$location");
                                        }
                                    }
                                    if ($_GET['action'] == "unvisi") {
                                        bddUpdate($bdd, $table, array("visible" => "0"), $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                    if ($_GET['action'] == "visi") {
                                        bddUpdate($bdd, $table, array("visible" => "1"), $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                    if ($_GET['action'] == "delete") {
                                        bddDelete($bdd, $table, $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                } else if ($_GET['action'] == "validation") {
                                    ?>
                                    <div class="list-title">Attente de validation</div>
                                        <table>
                                            <tr>
                                                <th>Nom & Prénom</th>
                                                <th>Note</th>
                                                <th>Commentaire</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php
                                                $select = $bdd->prepare("SELECT * FROM $table WHERE valide = '0' ORDER BY dateAvis DESC");
                                                $select->execute();
                                                
                                                while ($data = $select->fetch()) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $data['nom'] . " " . $data['prenom'] ?></td>
                                                        <td>
                                                            <?php
                                                                for ($i=0; $i<$data['note']; $i++) {
                                                                    ?><i style="color:#0700D0;" class="fas fa-star"></i><?php
                                                                }
                                                                for ($i=0; $i<(5-$data['note']); $i++) {
                                                                    ?><i style="color:#0700D0;" class="far fa-star"></i><?php
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?= $data['commentaire'] ?></td>
                                                        <td><?= dateFormatage($data['dateAvis']) ?></td>
                                                        <td>
                                                            <a href="?page=<?= $location ?>&action=validation&sub=valide&idsb=<?= $data['idAvis'] ?>"><i style="background-color:green;" class="fas fa-check"></i></a> 
                                                            <a href="?page=<?= $location ?>&action=validation&sub=unvalide&idsb=<?= $data['idAvis'] ?>" onclick="Supp(this.href); return(false)"><i style="background-color:red;" class="fas fa-times"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    if (isset($_GET['sub']) && !empty($_GET['sub'])) {
                                                        if (isset($_GET['idsb']) && !empty($_GET['idsb'])) {
                                                            $id = $_GET['idsb'];
                                                            if ($_GET['sub'] == "valide") {
                                                                bddUpdate($bdd, $table, array("valide" => "1", "visible"=>"1"), $nameId, $id);
                                                                header("Location: ?page=$location&action=validation");
                                                            } else if ($_GET['sub'] == "unvalide") {
                                                                bddDelete($bdd, $table, $nameId, $id);
                                                                header("Location: ?page=$location&action=validation");
                                                            }
                                                        }
                                                    }
                                                }

                                                
                                            ?>
                                        </table>
                                        <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="list">
                                    <div class="list-header">
                                        <div class="list-title">Avis en attente de validation -> <a href="?page=<?= $location ?>&action=validation"><i class="fas fa-check-circle" style="background-color:green;"></i></a></div>
                                        <div class="list-search">
                                            <form class="search" method="post">
                                                <input type="text" name="recherche" placeholder="Rechercher par prénom">
                                                <button name="search" type="submit"><i class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="list-content">
                                        <table>
                                            <tr>
                                                <th>Nom & Prénom</th>
                                                <th>Note</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php
                                                if (isset($_POST['search']) && !empty($_POST['recherche'])) {
                                                    $select = bddSearch($bdd, $table, "prenom", $_POST['recherche']);
                                                } else {
                                                    $select = $bdd->prepare("SELECT * FROM $table WHERE valide = '1' ORDER BY dateAvis DESC");
                                                    $select->execute();
                                                }
                                                
                                                while ($data = $select->fetch()) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $data['nom'] . " " . $data['prenom'] ?></td>
                                                        <td>
                                                            <?php
                                                                for ($i=0; $i<$data['note']; $i++) {
                                                                    ?><i style="color:#0700D0;" class="fas fa-star"></i><?php
                                                                }
                                                                for ($i=0; $i<(5-$data['note']); $i++) {
                                                                    ?><i style="color:#0700D0;" class="far fa-star"></i><?php
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?= dateFormatage($data['dateAvis']) ?></td>
                                                        <td>
                                                            <a href="?page=<?= $location ?>&action=details&id=<?= $data['idAvis'] ?>"><i style="background-color:blue;" class="fas fa-search"></i></a>
                                                            <a href="?page=<?= $location ?>&action=modify&id=<?= $data['idAvis'] ?>"><i style="background-color:orange;" class="fas fa-pen"></i></a>
                                                            <?php if ($data['visible'] == 1) { ?>
                                                                <a href="?page=<?= $location ?>&action=unvisi&id=<?= $data['idAvis'] ?>"><i style="background-color:#0033cc;" class="fas fa-eye"></i></a> 
                                                            <?php } else { ?>
                                                                <a href="?page=<?= $location ?>&action=visi&id=<?= $data['idAvis'] ?>"><i style="background-color:#668cff;" class="fas fa-eye-slash"></i></a>
                                                            <?php } ?>
                                                            <a href="?page=<?= $location ?>&action=delete&id=<?= $data['idAvis'] ?>" onclick="Supp(this.href); return(false)"><i style="background-color:red;" class="fas fa-times"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    
                                                }
                                            ?>
                                            
                                        </table>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </section>
                    <?php
                }
                else if ($_GET['page'] == "questions") {
                    $table = "questions";
                    $nameId = "idQuestion";
                    $location = "questions";
                    ?>
                    <section class="questions">
                        <div class="page-title">
                            <h1>Questions</h1>
                        </div>
                        <?php
                            if (isset($_GET['action']) && !empty($_GET['action'])) {
                                if (isset($_GET['id']) && !empty($_GET['id'])) {
                                    $id = $_GET['id'];
                                    if ($_GET['action'] == "details") {
                                        $data = bddSelectId($bdd, $table, $nameId, $id)->fetch();
                                        ?>
                                        <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                        <?php
                                    }
                                    if ($_GET['action'] == "modify") {
                                        $data = bddSelectId($bdd, $table, $nameId, $id)->fetch();
                                        ?>
                                        <form method="post">
                                            <div class="title">
                                                <h1>Modification d'une question</h1>
                                            </div>
                                            <input type="text" name="nom" placeholder="Nom" value="<?= $data['nom'] ?>">
                                            <input type="text" name="prenom" placeholder="Prenom" value="<?= $data['prenom'] ?>">
                                            <textarea name="question" placeholder="Question"><?= $data['question'] ?></textarea>
                                            <textarea name="reponse" placeholder="Réponse"><?= $data['reponse'] ?></textarea>
                                            <input type="submit" name="submitQ" value="Modifier">
                                        </form>
                                        <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                        <?php
                                        if (isset($_POST['submitQ'])) {
                                            $newData = array("nom"=>$_POST['nom'], "prenom"=>$_POST['prenom'], "question"=>$_POST['question'], "reponse"=>$_POST['reponse']);
                                            bddUpdate($bdd, $table, $newData, $nameId, $id);
                                            header("Location: ?page=$location");
                                        }
                                    }
                                    if ($_GET['action'] == "unvisi") {
                                        bddUpdate($bdd, $table, array("visible" => "0"), $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                    if ($_GET['action'] == "visi") {
                                        bddUpdate($bdd, $table, array("visible" => "1"), $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                    if ($_GET['action'] == "delete") {
                                        bddDelete($bdd, $table, $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                } else if ($_GET['action'] == "validation") {
                                    ?>
                                    <div class="list-title">Attente de validation</div>
                                    <table>
                                            <tr>
                                                <th>Nom & Prénom</th>
                                                <th>Question</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php
                                                $select = $bdd->prepare("SELECT * FROM $table WHERE valide = '0' ORDER BY dateQuestion DESC");
                                                $select->execute();
                                                
                                                while ($data = $select->fetch()) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $data['nom'] . " " . $data['prenom'] ?></td>
                                                        <td><?= $data['question'] ?></td>
                                                        <td><?= dateFormatage($data['dateQuestion']) ?></td>
                                                        <td>
                                                            <a href="?page=<?= $location ?>&action=validation&sub=valide&idsb=<?= $data['idQuestion'] ?>"><i style="background-color:green;" class="fas fa-check"></i></a> 
                                                            <a href="?page=<?= $location ?>&action=validation&sub=unvalide&idsb=<?= $data['idQuestion'] ?>" onclick="Supp(this.href); return(false)"><i style="background-color:red;" class="fas fa-times"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    if (isset($_GET['sub']) && !empty($_GET['sub'])) {
                                                        if (isset($_GET['idsb']) && !empty($_GET['idsb'])) {
                                                            $id = $_GET['idsb'];
                                                            if ($_GET['sub'] == "valide") {
                                                                bddUpdate($bdd, $table, array("valide" => "1"), $nameId, $id);
                                                                header("Location: ?page=$location&action=validation");
                                                            } else if ($_GET['sub'] == "unvalide") {
                                                                bddDelete($bdd, $table, $nameId, $id);
                                                                header("Location: ?page=$location&action=validation");
                                                            }
                                                        }
                                                    }
                                                }

                                                
                                            ?>
                                        </table>
                                    <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="list">
                                    <div class="list-header">
                                        <div class="list-title">Questions en attente de validation -> <a href="?page=<?= $location ?>&action=validation"><i class="fas fa-check-circle" style="background-color:green;"></i></a></div>
                                        <div class="list-search">
                                            <form class="search" method="post">
                                                <input type="text" name="recherche" placeholder="Rechercher par prénom">
                                                <button name="search" type="submit"><i class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="list-content">
                                        <table>
                                            <tr>
                                                <th>Nom & Prénom</th>
                                                <th>Question</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php
                                                if (isset($_POST['search']) && !empty($_POST['recherche'])) {
                                                    $select = bddSearch($bdd, $table, "prenom", $_POST['recherche']);
                                                } else {
                                                    $select = $bdd->prepare("SELECT * FROM $table WHERE valide = '1' ORDER BY dateQuestion DESC");
                                                    $select->execute();
                                                }
                                                
                                                while ($data = $select->fetch()) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $data['nom'] . " " . $data['prenom'] ?></td>
                                                        <td><?= $data['question'] ?></td>
                                                        <td><?= dateFormatage($data['dateQuestion']) ?></td>
                                                        <td>
                                                            <a href="?page=<?= $location ?>&action=details&id=<?= $data['idQuestion'] ?>"><i style="background-color:blue;" class="fas fa-search"></i></a>
                                                            <a href="?page=<?= $location ?>&action=modify&id=<?= $data['idQuestion'] ?>"><i style="background-color:orange;" class="fas fa-pen"></i></a>
                                                            <?php if ($data['visible'] == 1) { ?>
                                                                <a href="?page=<?= $location ?>&action=unvisi&id=<?= $data['idQuestion'] ?>"><i style="background-color:#0033cc;" class="fas fa-eye"></i></a> 
                                                            <?php } else { ?>
                                                                <a href="?page=<?= $location ?>&action=visi&id=<?= $data['idQuestion'] ?>"><i style="background-color:#668cff;" class="fas fa-eye-slash"></i></a>
                                                            <?php } ?>
                                                            <a href="?page=<?= $location ?>&action=delete&id=<?= $data['idQuestion'] ?>" onclick="Supp(this.href); return(false)"><i style="background-color:red;" class="fas fa-times"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    
                                                }
                                            ?>
                                            
                                        </table>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </section>
                    <?php
                }
                else if ($_GET['page'] == "prestations") {
                    $table = "prestations";
                    $nameId = "idPrestation";
                    $location = "prestations";
                    ?>
                    <section class="questions">
                        <div class="page-title">
                            <h1>Prestations</h1>
                        </div>
                        <?php
                            if (isset($_GET['action']) && !empty($_GET['action'])) {
                                if (isset($_GET['id']) && !empty($_GET['id'])) {
                                    $id = $_GET['id'];
                                    if ($_GET['action'] == "details") {
                                        $data = bddSelectId($bdd, $table, $nameId, $id)->fetch();
                                        ?>
                                        <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                        <?php
                                    }
                                    if ($_GET['action'] == "modify") {
                                        $data = bddSelectId($bdd, $table, $nameId, $id)->fetch();
                                        ?>
                                        <form method="post">
                                            <div class="title">
                                                <h1>Modification d'une prestation</h1>
                                            </div>
                                            <input type="text" name="titre" placeholder="Titre" value="<?= $data['titre'] ?>" required>
                                            <input type="number" name="prix" placeholder="Prix" value="<?= $data['prix'] ?>" required>
                                            <textarea name="description" placeholder="Description" required><?= $data['description'] ?></textarea>
                                            <input type="number" name="ordre" placeholder="Ordre" value="<?= $data['ordre'] ?>" required>
                                            <input type="submit" name="submitP" value="Modifier">
                                        </form>
                                        <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                        <?php
                                        if (isset($_POST['submitP'])) {
                                            $newData = array("titre"=>$_POST['titre'], "prix"=>$_POST['prix'], "description"=>$_POST['description'], "ordre"=>$_POST['ordre']);
                                            bddUpdate($bdd, $table, $newData, $nameId, $id);
                                            header("Location: ?page=$location");
                                        }
                                    }
                                    if ($_GET['action'] == "unvisi") {
                                        bddUpdate($bdd, $table, array("visible" => "0"), $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                    if ($_GET['action'] == "visi") {
                                        bddUpdate($bdd, $table, array("visible" => "1"), $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                    if ($_GET['action'] == "delete") {
                                        bddDelete($bdd, $table, $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                } else if ($_GET['action'] == "add") {
                                    ?>
                                    <form method="post">
                                        <div class="title">
                                            <h1>Ajout d'une prestation</h1>
                                        </div>
                                        <input type="text" name="titre" placeholder="Titre" required>
                                        <input type="number" name="prix" placeholder="Prix" required>
                                        <textarea name="description" placeholder="Description" required></textarea>
                                        <input type="number" name="ordre" placeholder="Ordre" required>
                                        <input type="submit" name="submitP" value="Ajouter">
                                    </form>
                                    <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                    <?php
                                    if (isset($_POST['submitP'])) {
                                        $insert = $bdd->prepare("INSERT INTO prestations(titre, prix, description, ordre) VALUES(?, ?, ?, ?)");
                                        $insert->execute(array($_POST['titre'], $_POST['prix'], $_POST['description'], $_POST['ordre']));
                                        header("Location: ?page=$location");
                                    }
                                }
                            } else {
                                ?>
                                <div class="list">
                                    <div class="list-header">
                                        <div class="list-title">Ajouter une prestation -> <a href="?page=<?= $location ?>&action=add"><i class="fas fa-plus fa-fw" style="background-color:green;"></i></a></div>
                                        <div class="list-search">
                                            <form class="search" method="post">
                                                <input type="text" name="recherche" placeholder="Rechercher par titre">
                                                <button name="search" type="submit"><i class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="list-content">
                                        <table>
                                            <tr>
                                                <th>Titre</th>
                                                <th>Prix</th>
                                                <th>Ordre</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php
                                                if (isset($_POST['search']) && !empty($_POST['recherche'])) {
                                                    $select = bddSearch($bdd, $table, "titre", $_POST['recherche']);
                                                } else {
                                                    $select = bddSelectOrderR($bdd, $table, "ordre");
                                                }
                                                
                                                while ($data = $select->fetch()) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $data['titre'] ?></td>
                                                        <td><?= $data['prix'] ?>€</td>
                                                        <td><?= $data['ordre'] ?></td>
                                                        <td>
                                                            <a href="?page=<?= $location ?>&action=details&id=<?= $data['idPrestation'] ?>"><i style="background-color:blue;" class="fas fa-search"></i></a>
                                                            <a href="?page=<?= $location ?>&action=modify&id=<?= $data['idPrestation'] ?>"><i style="background-color:orange;" class="fas fa-pen"></i></a>
                                                            <?php if ($data['visible'] == 1) { ?>
                                                                <a href="?page=<?= $location ?>&action=unvisi&id=<?= $data['idPrestation'] ?>"><i style="background-color:#0033cc;" class="fas fa-eye"></i></a> 
                                                            <?php } else { ?>
                                                                <a href="?page=<?= $location ?>&action=visi&id=<?= $data['idPrestation'] ?>"><i style="background-color:#668cff;" class="fas fa-eye-slash"></i></a>
                                                            <?php } ?>
                                                            <a href="?page=<?= $location ?>&action=delete&id=<?= $data['idPrestation'] ?>" onclick="Supp(this.href); return(false)"><i style="background-color:red;" class="fas fa-times"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    
                                                }
                                            ?>
                                            
                                        </table>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </section>
                    <?php
                }
                else if ($_GET['page'] == "contacts") {
                    $table = "contacts";
                    $nameId = "idContact";
                    $location = "contacts";
                    ?>
                    <section class="contact">
                        <div class="page-title">
                            <h1>Contact</h1>
                        </div>
                        <?php
                            if (isset($_GET['action']) && !empty($_GET['action'])) {
                                if (isset($_GET['id']) && !empty($_GET['id'])) {
                                    $id = $_GET['id'];
                                    if ($_GET['action'] == "details") {
                                        $data = bddSelectId($bdd, $table, $nameId, $id)->fetch();
                                        ?>
                                        <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                        <?php
                                    }
                                    if ($_GET['action'] == "delete") {
                                        bddDelete($bdd, $table, $nameId, $id);
                                        header("Location: ?page=$location");
                                    }
                                } else if ($_GET['action'] == "validation") {
                                    ?>
                                    <div class="list-title">Attente de validation</div>
                                        <table>
                                            <tr>
                                                <th>Nom & Prénom</th>
                                                <th>Mail</th>
                                                <th>Sujet</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php
                                                $select = $bdd->prepare("SELECT * FROM $table WHERE valide = '0' ORDER BY dateContact DESC");
                                                $select->execute();
                                                
                                                while ($data = $select->fetch()) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $data['nom'] ?></td>
                                                        <td><?= $data['mail'] ?></td>
                                                        <td><?= $data['sujet'] ?></td>
                                                        <td><?= dateFormatage($data['dateContact']) ?></td>
                                                        <td>
                                                            <a href="?page=<?= $location ?>&action=validation&sub=valide&idsb=<?= $data['idContact'] ?>"><i style="background-color:green;" class="fas fa-check"></i></a> 
                                                            <a href="?page=<?= $location ?>&action=validation&sub=unvalide&idsb=<?= $data['idContact'] ?>" onclick="Supp(this.href); return(false)"><i style="background-color:red;" class="fas fa-times"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    if (isset($_GET['sub']) && !empty($_GET['sub'])) {
                                                        if (isset($_GET['idsb']) && !empty($_GET['idsb'])) {
                                                            $id = $_GET['idsb'];
                                                            if ($_GET['sub'] == "valide") {
                                                                bddUpdate($bdd, $table, array("valide" => "1"), $nameId, $id);
                                                                header("Location: ?page=$location&action=validation");
                                                            } else if ($_GET['sub'] == "unvalide") {
                                                                bddDelete($bdd, $table, $nameId, $id);
                                                                header("Location: ?page=$location&action=validation");
                                                            }
                                                        }
                                                    }
                                                }

                                                
                                            ?>
                                        </table>
                                        <a href="?page=<?= $location ?>"><i style="background-color:grey;" class="fas fa-arrow-left"></i></a>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="list">
                                    <div class="list-header">
                                        <div class="list-title">Demande de contact -> <a href="?page=<?= $location ?>&action=validation"><i class="fas fa-check-circle" style="background-color:green;"></i></a></div>
                                        <div class="list-search">
                                            <form class="search" method="post">
                                                <input type="text" name="recherche" placeholder="Rechercher par sujet">
                                                <button name="search" type="submit"><i class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="list-content">
                                        <table>
                                            <tr>
                                                <th>Nom & Prénom</th>
                                                <th>Sujet</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php
                                                if (isset($_POST['search']) && !empty($_POST['recherche'])) {
                                                    $select = bddSearch($bdd, $table, "sujet", $_POST['recherche']);
                                                } else {
                                                    $select = $bdd->prepare("SELECT * FROM $table WHERE valide = '1' ORDER BY dateContact DESC");
                                                    $select->execute();
                                                }
                                                
                                                while ($data = $select->fetch()) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $data['nom'] ?></td>
                                                        <td><?= $data['sujet'] ?></td>
                                                        <td><?= dateFormatage($data['dateContact']) ?></td>
                                                        <td>
                                                            <a href="?page=<?= $location ?>&action=details&id=<?= $data['idContact'] ?>"><i style="background-color:blue;" class="fas fa-search"></i></a>
                                                            <a href="?page=<?= $location ?>&action=delete&id=<?= $data['idContact'] ?>" onclick="Supp(this.href); return(false)"><i style="background-color:red;" class="fas fa-times"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    
                                                }
                                            ?>
                                            
                                        </table>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </section>
                    <?php
                }
                else if ($_GET['page'] == "stats") {
                    
                } else {
                    header('Location: index.php');
                }
            } else {
                header('Location: index.php');
            }
            ob_end_flush();
        ?>
        
    </main>
    <script src="../app/js/app.js"></script>
    <script>
        function Supp(link){
            if(confirm('Confirmer la suppression ?')){
            document.location.href = link;
            }
        };
    </script>
</body>
</html>