<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';
    
    sec_session_start();
    
    //Controlla siano passati correttamente in POST i valori necessari
    if(isset($_POST['quantità']) && isset($_POST['data']) && isset($_POST['prezzo']) && isset($_POST['materiale']) && $dbh -> login_check()) {
        if($dbh -> aggiungi_acquisto_materiale($_POST['quantità'], $_POST['data'], $_POST['prezzo'], $_POST['materiale'], $_SESSION['user_id'])) {
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