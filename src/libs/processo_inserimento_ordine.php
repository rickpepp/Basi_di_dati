<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Controlla siano passati correttamente in POST i valori necessari
    if(isset($_POST['cliente']) && isset($_POST['stampante']) && isset($_POST['materiale']) && isset($_POST['nome']) && isset($_POST['tempo']) && isset($_POST['data']) && isset($_POST['quantità']) && isset($_POST['costo']) && $dbh -> login_check()) {

        if($dbh -> aggiungi_ordine($_POST['cliente'], $_POST['stampante'], $_POST['materiale'], $_POST['nome'], $_POST['tempo'], $_POST['data'], $_POST['quantità'], $_POST['costo'], $_POST['servizio'], $_SESSION['user_id'])) {
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