<?php
    function dateFormatage($date) {
        list($y, $m, $d) = explode("-", $date);
        return "$d/$m/$y";
    }

    // BDD

    function bddSelectId($bdd, $table, $nameId, $id) {
        $select = $bdd->prepare("SELECT * FROM $table WHERE $nameId=?");
        $select->execute(array($id));
        return $select;
        $select->closeCursor();
    }

    function bddSelect($bdd, $table) {
        $select = $bdd->prepare("SELECT * FROM $table");
        $select->execute();
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

    // function bddInsert($bdd, $table, $data) {
    //     foreach ($data as $column => $value) {
    //         $insert = $bdd->prepare("INSERT INTO $table($column) VALUES(?)");
    //         $insert->execute(array($value));
    //     }
    // }
?>