<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check() && isset($_GET['CodiceContratto'])) {
        if($dbh -> cancella_contratto($_GET['CodiceContratto'])) {
            //Pagina informativa di avvenuta cancellazione
            header('Location: ../views/menu.php?r=1&msg=Cancellazione Avvenuta Correttamente');
        } else {
            //Pagina informativa NON avvenuta cancellazione
            header('Location: ../views/menu.php?r=1&msg=Errore Cancellazione');
        }
    } else {
        //Elementi POST non settati
        header('Location: ../views/menu.php?r=1&msg=Elementi POST non settati');
    }

?>