<?php
    function dateFormatage($date) {
        list($y, $m, $d) = explode("-", $date);
        return "$d/$m/$y";
    }
?>