<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Controlla siano passati correttamente in POST i valori necessari
    if(isset($_POST['id']) && isset($_POST['ruolo']) && isset($_POST['data_assunzione']) && isset($_POST['costo_registrazione']) && isset($_POST['livello_registrazione']) && $dbh -> login_check() && $_SESSION['ruolo'] == 'addettorisorseumane') {

        if($dbh -> registrazione_contratto_esistente($_POST['id'], $_POST['ruolo'], $_POST['data_assunzione'], $_POST['costo_registrazione'], $_POST['livello_registrazione'], $_SESSION['user_id'])) {
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