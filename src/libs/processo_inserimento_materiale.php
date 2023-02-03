<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';
    
    sec_session_start();
    
    //Controlla siano passati correttamente in POST i valori necessari
    if(isset($_POST['nome']) && isset($_POST['produttore']) && isset($_POST['peso']) && isset($_POST['tipologia']) && $dbh -> login_check()) {
        if($dbh -> aggiungi_nuovo_materiale($_POST['nome'], $_POST['produttore'], $_POST['peso'], $_POST['tipologia'])) {
            //Pagina informativa di avvenuta registrazione
            header('Location: ../views/menu.php?r=1&msg=Inserimento Avvenuto Correttamente');
        } else {
            //Pagina informativa NON avvenuta registrazione
            header('Location: ../views/menu.php?r=1&msg=Errore Inserimento');
        }
    } else {
        //Elementi POST non settati
        header('Location: ../views/menu.php?r=1&msg=Elementi POST non settati');
    }
?>