<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Controlla siano passati correttamente in POST i valori necessari
    if(isset($_POST['nome_registrazione']) && isset($_POST['cognome_registrazione']) && isset($_POST['email_registrazione']) && isset($_POST['codice_fiscale_registrazione']) && isset($_POST['numero_telefono_registrazione']) && isset($_POST['ruolo']) && isset($_POST['data_assunzione']) && isset($_POST['costo_registrazione']) && isset($_POST['livello_registrazione']) && $dbh -> login_check() && $_SESSION['ruolo'] == 'addettorisorseumane') {
        $nome= $_POST['nome_registrazione']; 
        $cognome= $_POST['cognome_registrazione']; 
        $email = $_POST['email_registrazione']; 
        $codice_fiscale = $_POST['codice_fiscale_registrazione'];
        $numero_telefono = $_POST['numero_telefono_registrazione'];
        $ruolo = $_POST['ruolo'];
        $data_assunzione = $_POST['data_assunzione'];
        $costo_registrazione = $_POST['costo_registrazione'];
        $livello_registrazione = $_POST['livello_registrazione'];

        //Recupero la password criptata dal form di inserimento.
        $password = $_POST['password_registrazione']; 

        //Crea una chiave casuale
        $random_salt_password = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));

        //Crea una password usando la chiave appena creata.
        $password = hash('sha512', $password.$random_salt_password);

        if($dbh -> sign_up($nome, $cognome, $email, $codice_fiscale, $numero_telefono, $ruolo, $data_assunzione, $costo_registrazione, $livello_registrazione, $password, $random_salt_password, $_SESSION['user_id'])) {
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