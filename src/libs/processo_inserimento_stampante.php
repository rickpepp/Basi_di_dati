<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Controlla siano passati correttamente in POST i valori necessari
    if(isset($_POST['produttore']) && isset($_POST['modello']) && isset($_POST['seriale']) && isset($_POST['tipologia']) && isset($_POST['data']) && isset($_POST['prezzo']) && $dbh -> login_check()) {

        if($dbh -> aggiungi_stampante($_POST['produttore'], $_POST['modello'], $_POST['seriale'], $_POST['tipologia'], $_POST['data'], $_POST['prezzo'], $_SESSION['user_id'])) {
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