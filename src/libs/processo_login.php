<?php
    require_once 'database.php';
    require_once 'functions.php';
    require_once 'bootstrap.php';

    sec_session_start();

    if(isset($_POST['email_accesso'], $_POST['password_accesso'], $_POST['r'])) { 
      $email = $_POST['email_accesso'];
      $password = $_POST['password_accesso']; // Recupero la password criptata.

      //Seleziona il menù in base al ruolo
      switch ($_POST['r']) {
         case "1":
            $ruolo = 'addettorisorseumane';
            $nomeidentificatore = 'CodiceARU';
            break;
         case "2":
            $ruolo = 'operaio';
            $nomeidentificatore = 'CodiceOperaio';
            break;
         case "3":
            $ruolo = 'venditore';
            $nomeidentificatore = 'CodiceVenditore';
            break;
      }

        if($dbh -> login($email, $password, $ruolo, $nomeidentificatore) == true) {
           // Login eseguito
           header('Location: ../views/menu.php');
        } else {
           // Login fallito
           header('Location: ../views/index.php');
        }
     } else { 
        // Le variabili corrette non sono state inviate a questa pagina dal metodo POST.
        header('Location: ../views/index.php');
     }
?>