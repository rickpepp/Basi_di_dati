<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Controlla siano passati correttamente in POST i valori necessari
    if(isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['email']) && isset($_POST['codiceFiscale']) && isset($_POST['indirizzo']) && isset($_POST['numeroCivico']) && isset($_POST['cap']) && isset($_POST['città']) && $dbh -> login_check()) {

        if($dbh -> aggiungi_cliente($_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['codiceFiscale'], $_POST['indirizzo'], $_POST['numeroCivico'], $_POST['cap'], $_POST['città'])) {
            //Pagina informativa di avvenuta registrazione
            header("Location: ../views/inserimento_dati.php?cliente=".($dbh -> get_max_cliente())."&action=15");
        } else {
            //Pagina informativa NON avvenuta registrazione
            header('Location: ../views/menu.php?r=1&msg=Errore Inserimento');
        }
    } else {
        //Elementi POST non settati
        header('Location: ../views/menu.php?r=1&msg=Elementi POST non settati');
    }
?>