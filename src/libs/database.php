<?php
   //Classe che gestisce i rapport con il DB
   class DatabaseHelper{
      //Puntatore al DB
      private $db;

      //Costruttore
      public function __construct($servername, $username, $password, $dbname, $port){
         $this->db = new mysqli($servername, $username, $password, $dbname, $port);
         //Gestione eccezione
         if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
         }        
      }

    //Login utente
    public function login($email, $password, $ruolo, $nomeidentificatore) {
        // Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
        if ($stmt = $this->db->prepare("SELECT $nomeidentificatore, email, password, salt FROM $ruolo WHERE email = ? LIMIT 1")) { 
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($user_id, $username, $db_password, $salt);
            $stmt->fetch();

            $password = hash('sha512', $password.$salt); // codifica la password usando una chiave univoca.      

            if($stmt->num_rows == 1) { // se l'utente esiste
                if($db_password == $password) { // Verifica che la password memorizzata nel database corrisponda alla password fornita dall'utente.
                    // Password corretta!            
                    $user_browser = $_SERVER['HTTP_USER_AGENT']; // Recupero il parametro 'user-agent' relativo all'utente corrente.
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id); // ci proteggiamo da un attacco XSS
                    $_SESSION['user_id'] = $user_id; 
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // ci proteggiamo da un attacco XSS
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
                    $_SESSION['ruolo'] = $ruolo;
                    $_SESSION['nome_identificatore'] = $nomeidentificatore;
                    // Login eseguito con successo.
                    return true;    
                } else {
                    // Password incorretta.
                    return false;
                }
            }
        } else {
            // L'utente inserito non esiste.
            return false;
        }
    }
      

      //Controllo che l'utente abbia prima fatto il login
      public function login_check() {
         // Verifica che tutte le variabili di sessione siano impostate correttamente
         if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'], $_SESSION['nome_identificatore'], $_SESSION['ruolo'])) {
            $user_id = $_SESSION['user_id'];
            $login_string = $_SESSION['login_string'];
            $username = $_SESSION['username'];     
            $user_browser = $_SERVER['HTTP_USER_AGENT']; // reperisce la stringa 'user-agent' dell'utente.
            $nomeidentificatore = $_SESSION['nome_identificatore'];
            $ruolo = $_SESSION['ruolo'];
            if ($stmt = $this->db->prepare("SELECT password FROM $ruolo WHERE $nomeidentificatore = ? LIMIT 1")) { 
               $stmt->bind_param('i' , $user_id); // esegue il bind del parametro '$user_id'.
               $stmt->execute(); // Esegue la query creata.
               $stmt->store_result();
      
               if($stmt->num_rows == 1) { // se l'utente esiste
                  $stmt->bind_result($password); // recupera le variabili dal risultato ottenuto.
                  $stmt->fetch();
                  $login_check = hash('sha512', $password.$user_browser);
                  if($login_check == $login_string) {
                     // Login eseguito!!!!
                     return true;
                  } else {
                     //  Login non eseguito
                     return false;
                  }
               } else {
                  // Login non eseguito
                  return false;
               }
            } else {
               // Login non eseguito
               return false;
            }
         } else {
            // Login non eseguito
            return false;
         }
      }

    }
?>