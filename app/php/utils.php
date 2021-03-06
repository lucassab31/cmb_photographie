<?php
    function dateFormatage($date) {
        list($y, $m, $d) = explode("-", $date);
        return "$d/$m/$y";
    }

    function TailleDossier($Rep) {
        $Racine=opendir($Rep);
        $Taille=0;
        while($Dossier = readdir($Racine)) {
          if ( $Dossier != '..' And $Dossier !='.' ) {
            //Ajoute la taille du sous dossier
            if(is_dir($Rep.'/'.$Dossier)) $Taille += TailleDossier($Rep.'/'.$Dossier);
            //Ajoute la taille du fichier
            else $Taille += filesize($Rep.'/'.$Dossier);

          }
        }
        closedir($Racine);
        return $Taille;
    }

    // BDD

    function bddSelectId($bdd, $table, $nameId, $id) {
        $select = $bdd->prepare("SELECT * FROM $table WHERE $nameId=?");
        $select->execute(array($id));
        return $select;
        $select->closeCursor();
    }

    function bddSelectOrder($bdd, $table, $order) {
        $select = $bdd->prepare("SELECT * FROM $table ORDER BY $order DESC");
        $select->execute();
        return $select;
        $select->closeCursor();
    }

    function bddSelectOrderR($bdd, $table, $order) {
        $select = $bdd->prepare("SELECT * FROM $table ORDER BY $order");
        $select->execute();
        return $select;
        $select->closeCursor();
    }

    function bddSelect($bdd, $table) {
        $select = $bdd->prepare("SELECT * FROM $table");
        $select->execute();
        return $select;
        $select->closeCursor();
    }

    function bddSearch($bdd, $table, $name, $search) {
        $select = $bdd->prepare("SELECT * FROM $table WHERE $name LIKE ? LIMIT 50");
        $select->execute(array("%$search%"));
        return $select;
        $select->closeCursor();
    }

    function bddDelete($bdd, $table, $nameId, $id) {
        $delete = $bdd->prepare("DELETE FROM $table WHERE $nameId=? ");
        $delete->execute(array($id));
        $delete->closeCursor();
    }
    
    function bddUpdate($bdd, $table, $data, $nameId, $id) {
        foreach ($data as $column => $value) {
            $update = $bdd->prepare("UPDATE $table SET $column=? WHERE $nameId=$id");
            $update->execute(array($value));
        }
    }
?>