<?php
    require_once '../libs/database.php';
    require_once '../libs/bootstrap.php';
    require_once '../libs/functions.php';

    sec_session_start();

    if ($dbh -> login_check()) {
        $risultati = $dbh -> get_anni_economici();

        foreach ($risultati as $risultato) {
            $entrate_data[] = array("label" => $risultato["AnnoRiferimento"], "y" => $risultato["Entrate"]);
            $uscite_data[] = array("label" => $risultato["AnnoRiferimento"], "y" => $risultato["Uscite"]);
        }
    } 
?>