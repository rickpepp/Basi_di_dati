<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Controlla siano passati correttamente in POST i valori necessari
    if(isset($_POST['nome']) && isset($_POST['costo']) && isset($_POST['disp']) && $dbh -> login_check()) {
        $risultati = $dbh -> get_operai();

        foreach ($risultati as $result) {
            if(isset($_POST[$result['CodiceOperaio']])) {
                $operai[] = $result['CodiceOperaio'];
            }
        }

        if($dbh -> aggiungi_servizio($_POST['nome'], $_POST['costo'], $_POST['disp'], $operai)) {
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