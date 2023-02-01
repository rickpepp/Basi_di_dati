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

      //Inserimento nuovo dipendente
      public function sign_up($nome, $cognome, $email, $codice_fiscale, $numero_telefono, $ruolo, $data_assunzione, $costo_registrazione, $livello_registrazione, $password, $random_salt_password, $ARU) {
         //Seleziona tabella e attributi dove inserire record
         switch ($ruolo) {
            case 'Venditore':
               $ruolo = 'venditore';
               $ruolo_telefono = 'numerotelefonovenditore';
               $nomeidentificatore = 'CodiceVenditore';
               $contratto = 'Venditore';
               $costo = 'CostoVenditori';
               break;
            case 'Addetto Risorse Umane':
               $ruolo = 'addettorisorseumane';
               $ruolo_telefono = 'numerotelefonoaru';
               $nomeidentificatore = 'CodiceARU';
               $contratto = 'ARU';
               $costo = 'CostoARU';
               break;
            case 'Operaio':
               $ruolo = 'operaio';
               $ruolo_telefono = 'numerotelefonooperaio';
               $nomeidentificatore = 'CodiceOperaio';
               $contratto = 'Operaio';
               $costo = 'CostoOperai';
               break;
         }
         
         //Dato che il progettista non richiede inserimento password si controlla se il caso è questo (altrimenti query diversa)
         if ($ruolo != 'Progettista') {
            //Controllo che la mail inserita non sia già presente nel DB
            if ($stmt = $this->db->prepare("SELECT $nomeidentificatore FROM $ruolo WHERE Email = ? LIMIT 1")) {
               $stmt->bind_param('s', $email);
               $stmt->execute();
               $stmt->store_result();
            
               if($stmt->num_rows != 0) {
                  //Caso già presente
                  return false;
               } else {
                  //Caso non presente
                  //Inserisce il dipendete nella rispettiva tabella
                  if ($insert_stmt = $this -> db -> prepare("INSERT INTO $ruolo (Nome, cognome, Email, CodiceFiscale, password, salt) VALUES (?, ?, ?, ?, ?, ?)")) {
                     $insert_stmt -> bind_param('ssssss', $nome, $cognome, $email, $codice_fiscale, $password, $random_salt_password);
                     $insert_stmt -> execute();
                     //Seleziona identificatore appena inserito
                     if ($stmt = $this -> db -> prepare("SELECT MAX($nomeidentificatore) FROM $ruolo")) {
                        $stmt -> execute();
                        $stmt -> store_result();
                        $stmt -> bind_result($user_id);
                        $stmt -> fetch();
                        //Inserisce il relativo numero di telefono
                        if ($stmt1 = $this -> db -> prepare("INSERT INTO $ruolo_telefono ($nomeidentificatore, NumeroTelefono) VALUES (?, ?)")) {
                           $stmt1 -> bind_param('ii', $user_id, $numero_telefono);
                           $stmt1 -> execute();
                           //Inserisce il contratto di lavoro
                           if ($stmt2 = $this -> db -> prepare("INSERT INTO contrattolavoro (DataAssunzione, CostoDipendente, LivelloContrattuale, $contratto, ARU_inserimento) VALUES (?, ?, ?, ?, ?)")) {
                              $stmt2 -> bind_param('siiii', $data_assunzione, $costo_registrazione, $livello_registrazione, $user_id, $ARU);
                              $stmt2 -> execute();
                              //Aggiunge Costo All'anno Economico
                              if ($stmt = $this -> db -> prepare("SELECT * FROM AnnoEconomico WHERE AnnoRiferimento = ?;")) {
                                 $stmt -> bind_param('i', date("Y"));
                                 $stmt -> execute();
                                 $stmt->store_result();
                                 if ($stmt -> num_rows == 0) {
                                    if ($stmt = $this -> db -> prepare("INSERT INTO AnnoEconomico (AnnoRiferimento) VALUES (?)")) {
                                       $stmt -> bind_param('i', date("Y"));
                                       $stmt -> execute();
                                    }
                                 }
                                 if ($stmt = $this -> db -> prepare("UPDATE AnnoEconomico SET $costo = $costo + ? WHERE AnnoRiferimento = ?;")) {
                                    $stmt -> bind_param('ii', $costo_registrazione, date("Y"));
                                    $stmt -> execute();
                                    return true;
                                 }
                              }

                           } else {
                              //Inserimento dipendente fallito
                              return false;
                           }
                        } else {
                           //Inserimento dipendente fallito
                           return false;
                        }
                     } else {
                        //Inserimento dipendente fallito
                        return false;
                     }
                  } else {
                     //Inserimento dipendente fallito
                     return false;
                  }
               }
            } else {
               //Inserimento dipendente fallito
               return false;
            }
         } else {
            //Nel caso progettista controlla se già presente la mail
            if ($stmt = $this->db->prepare("SELECT CodiceProgettista FROM progettista WHERE Email = ? LIMIT 1")) {
               $stmt->bind_param('s', $email);
               $stmt->execute();
               $stmt->store_result();
            
               if($stmt->num_rows != 0) {
                  //Caso già presente
                  return false;
               } else {
                  //Caso non presente
                  //Aggiunge record a progettista
                  if ($insert_stmt = $this -> db -> prepare("INSERT INTO progettista (Nome, cognome, Email, CodiceFiscale) VALUES (?, ?, ?, ?)")) {
                     $insert_stmt -> bind_param('ssss', $nome, $cognome, $email, $codice_fiscale);
                     $insert_stmt -> execute();
                     //Seleziona id record appena creato
                     if ($stmt = $this -> db -> prepare("SELECT MAX(CodiceProgettista) FROM progettista")) {
                        $stmt -> execute();
                        $stmt -> store_result();
                        $stmt -> bind_result($user_id);
                        $stmt -> fetch();
                        //Aggiunge numero di telefono
                        if ($stmt1 = $this -> db -> prepare("INSERT INTO numerotelefonoprogettista (CodiceProgettista, NumeroTelefono) VALUES (?, ?)")) {
                           $stmt1 -> bind_param('ii', $user_id, $numero_telefono);
                           $stmt1 -> execute();
                           //Aggiugne contratto di lavoro
                           if ($stmt2 = $this -> db -> prepare("INSERT INTO contrattolavoro (DataAssunzione, CostoDipendente, LivelloContrattuale, Progettista, ARU_inserimento) VALUES (?, ?, ?, ?, ?)")) {
                              $stmt2 -> bind_param('siiii', $data_assunzione, $costo_registrazione, $livello_registrazione, $user_id, $ARU);
                              $stmt2 -> execute();
                              //Aggiunge Costo ad Anno Economico
                              if ($stmt = $this -> db -> prepare("SELECT * FROM AnnoEconomico WHERE AnnoRiferimento = ?;")) {
                                 $stmt -> bind_param('i', date("Y"));
                                 $stmt -> execute();
                                 $stmt->store_result();
                                 if ($stmt -> num_rows == 0) {
                                    if ($stmt = $this -> db -> prepare("INSERT INTO AnnoEconomico (AnnoRiferimento) VALUES (?)")) {
                                       $stmt -> bind_param('i', date("Y"));
                                       $stmt -> execute();
                                    }
                                 }
                                 if ($stmt = $this -> db -> prepare("UPDATE AnnoEconomico SET CostoProgettisti = CostoProgettisti + ? WHERE AnnoRiferimento = ?;")) {
                                    $stmt -> bind_param('ii', $costo_registrazione, date("Y"));
                                    $stmt -> execute();
                                    return true;
                                 }
                              }
                              
                           } else {
                              //Inserimento progettista fallito
                              return false;
                           }
                        } else {
                           //Inserimento progettista fallito
                           return false;
                        }
                     } else {
                        //Inserimento progettista fallito
                        return false;
                     }
                  } else {
                     //Inserimento progettista fallito
                     return false;
                  }
               }
            } else {
               //Inserimento progettista fallito
               return false;
            }
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
      
      //Restituisce Dati Principali Dipendente in base al nome, cognome e ruolo
      public function get_dipendente($nome, $cognome, $ruolo) {
         if ($ruolo == 'AddettoRisorseUmane') {
            $id = 'CodiceARU';
            $contratto = 'ARU';
         } else if ($ruolo == 'Operaio') {
            $id = 'CodiceOperaio';
            $contratto = $ruolo;
         } else if ($ruolo == 'Progettista') {
            $id = 'CodiceProgettista';
            $contratto = $ruolo;
         } else if ($ruolo == 'Venditore') {
            $id = 'CodiceVenditore';
            $contratto = $ruolo;
         } else {
            return NULL;
         }
         
         if ($stmt = $this->db->prepare("SELECT dipendente.$id AS id, dipendente.Nome, dipendente.Cognome, dipendente.Email, dipendente.CodiceFiscale, DataAssunzione, CostoDipendente, DataLicenziamento, LivelloContrattuale, addetto.Nome AS NomeAddetto, addetto.Cognome AS CognomeAddetto FROM $ruolo dipendente, addettorisorseumane addetto, contrattolavoro WHERE dipendente.Nome = ? AND dipendente.Cognome = ? AND addetto.CodiceARU = ARU_inserimento AND contrattolavoro.$contratto = dipendente.$id;")) {
            $stmt->bind_param('ss', $nome, $cognome);
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
         }
         return $result;
      }

      //Restituisce Numeri di Telefono selezionando id dipendente ed il ruolo
      public function get_numero_telefono($id, $ruolo) {
         if ($ruolo == 'AddettoRisorseUmane') {
            $ruolo = 'NumeroTelefonoARU';
            $nome_id = 'CodiceARU';
         } else if ($ruolo == 'Operaio') {
            $ruolo = 'NumeroTelefonoOperaio';
            $nome_id = 'CodiceOperaio';
         } else if ($ruolo == 'Progettista') {
            $ruolo = 'NumeroTelefonoProgettista';
            $nome_id = 'CodiceProgettista';
         } else if ($ruolo == 'Venditore') {
            $ruolo = 'NumeroTelefonoVenditore';
            $nome_id = 'CodiceVenditore';
         } 

         if ($stmt = $this->db->prepare("SELECT NumeroTelefono FROM $ruolo WHERE $nome_id = ?")) {
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
         }
         return $result;
      }

      //Costo Per Settore
      public function costo_per_settore() {
         if($stmt = $this->db->prepare("SELECT AnnoRiferimento, CostoProgettisti, CostoVenditori, CostoOperai, CostoARU FROM AnnoEconomico ORDER BY AnnoRiferimento DESC")) {
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }

      }

    }
?>