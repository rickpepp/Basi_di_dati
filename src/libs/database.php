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
                                 $anno = substr($data_assunzione,0,4);
                                 $stmt -> bind_param('s', $anno);
                                 $stmt -> execute();
                                 $stmt->store_result();
                                 if ($stmt -> num_rows == 0) {
                                    if ($stmt = $this -> db -> prepare("INSERT INTO AnnoEconomico (AnnoRiferimento) VALUES (?)")) {
                                       $stmt -> bind_param('s', $anno);
                                       $stmt -> execute();
                                    }
                                 }
                                 if ($stmt = $this -> db -> prepare("UPDATE AnnoEconomico SET $costo = $costo + ? WHERE AnnoRiferimento = ?;")) {
                                    $stmt -> bind_param('is', $costo_registrazione, $anno);
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
                           if ($stmt2 = $this -> db -> prepare("INSERT INTO contrattolavoro (DataAssunzione, CostoDipendente, LivelloContrattuale, Progettista, ARU_inserimento) VALUES (?,  ?, ?, ?, ?)")) {
                              $stmt2 -> bind_param('siiii', $data_assunzione, $costo_registrazione, $livello_registrazione, $user_id, $ARU);
                              $stmt2 -> execute();
                              //Aggiunge Costo ad Anno Economico
                              if ($stmt = $this -> db -> prepare("SELECT * FROM AnnoEconomico WHERE AnnoRiferimento = ?;")) {
                                 $anno = substr($data_assunzione,0,4);
                                 $stmt -> bind_param('s', $anno);
                                 $stmt -> execute();
                                 $stmt->store_result();
                                 if ($stmt -> num_rows == 0) {
                                    if ($stmt = $this -> db -> prepare("INSERT INTO AnnoEconomico (AnnoRiferimento) VALUES (?)")) {
                                       $stmt -> bind_param('s', $anno);
                                       $stmt -> execute();
                                    }
                                 }
                                 if ($stmt = $this -> db -> prepare("UPDATE AnnoEconomico SET CostoProgettisti = CostoProgettisti + ? WHERE AnnoRiferimento = ?;")) {
                                    $stmt -> bind_param('is', $costo_registrazione, $anno);
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
         
         //La query cambia in base al tipo di ricerca effettuata, generale, per nome, per cognome, per nome e cognome
         if ($nome == '' && $cognome == '') {
            if ($stmt = $this->db->prepare("SELECT dipendente.$id AS id, CodiceContratto, dipendente.Nome, dipendente.Cognome, dipendente.Email, dipendente.CodiceFiscale, DataAssunzione, CostoDipendente, DataLicenziamento, LivelloContrattuale, addetto.Nome AS NomeAddetto, addetto.Cognome AS CognomeAddetto FROM $ruolo dipendente, addettorisorseumane addetto, contrattolavoro WHERE addetto.CodiceARU = ARU_inserimento AND contrattolavoro.$contratto = dipendente.$id;")) {
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else if ($nome != '' && $cognome == '') {
            if ($stmt = $this->db->prepare("SELECT dipendente.$id AS id, CodiceContratto, dipendente.Nome, dipendente.Cognome, dipendente.Email, dipendente.CodiceFiscale, DataAssunzione, CostoDipendente, DataLicenziamento, LivelloContrattuale, addetto.Nome AS NomeAddetto, addetto.Cognome AS CognomeAddetto FROM $ruolo dipendente, addettorisorseumane addetto, contrattolavoro WHERE dipendente.Nome = ? AND addetto.CodiceARU = ARU_inserimento AND contrattolavoro.$contratto = dipendente.$id;")) {
               $stmt->bind_param('s', $nome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else if ($nome == '' && $cognome != '') {
            if ($stmt = $this->db->prepare("SELECT dipendente.$id AS id, CodiceContratto, dipendente.Nome, dipendente.Cognome, dipendente.Email, dipendente.CodiceFiscale, DataAssunzione, CostoDipendente, DataLicenziamento, LivelloContrattuale, addetto.Nome AS NomeAddetto, addetto.Cognome AS CognomeAddetto FROM $ruolo dipendente, addettorisorseumane addetto, contrattolavoro WHERE dipendente.Cognome = ? AND addetto.CodiceARU = ARU_inserimento AND contrattolavoro.$contratto = dipendente.$id;")) {
               $stmt->bind_param('s', $cognome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else {
            if ($stmt = $this->db->prepare("SELECT dipendente.$id AS id, CodiceContratto, dipendente.Nome, dipendente.Cognome, dipendente.Email, dipendente.CodiceFiscale, DataAssunzione, CostoDipendente, DataLicenziamento, LivelloContrattuale, addetto.Nome AS NomeAddetto, addetto.Cognome AS CognomeAddetto FROM $ruolo dipendente, addettorisorseumane addetto, contrattolavoro WHERE dipendente.Nome = ? AND dipendente.Cognome = ? AND addetto.CodiceARU = ARU_inserimento AND contrattolavoro.$contratto = dipendente.$id;")) {
               $stmt->bind_param('ss', $nome, $cognome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         }
      }

      //Restituisce solo i contratti di dipendenti con una data di licenziamento (che quindi possono essere riassunti)
      public function get_dipendente_licenziato($nome, $cognome, $ruolo) {
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
         
         //La query cambia in base al tipo di ricerca effettuata, generale, per nome, per cognome, per nome e cognome
         if ($nome == '' && $cognome == '') {
            if ($stmt = $this->db->prepare("SELECT dipendente.$id AS id, CodiceContratto, dipendente.Nome, dipendente.Cognome, dipendente.Email, dipendente.CodiceFiscale, DataAssunzione, CostoDipendente, DataLicenziamento, LivelloContrattuale, addetto.Nome AS NomeAddetto, addetto.Cognome AS CognomeAddetto FROM $ruolo dipendente, addettorisorseumane addetto, contrattolavoro WHERE addetto.CodiceARU = ARU_inserimento AND contrattolavoro.$contratto = dipendente.$id AND DataLicenziamento IS NOT NULL;")) {
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else if ($nome != '' && $cognome == '') {
            if ($stmt = $this->db->prepare("SELECT dipendente.$id AS id, CodiceContratto, dipendente.Nome, dipendente.Cognome, dipendente.Email, dipendente.CodiceFiscale, DataAssunzione, CostoDipendente, DataLicenziamento, LivelloContrattuale, addetto.Nome AS NomeAddetto, addetto.Cognome AS CognomeAddetto FROM $ruolo dipendente, addettorisorseumane addetto, contrattolavoro WHERE dipendente.Nome = ? AND addetto.CodiceARU = ARU_inserimento AND contrattolavoro.$contratto = dipendente.$id AND DataLicenziamento IS NOT NULL;")) {
               $stmt->bind_param('s', $nome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else if ($nome == '' && $cognome != '') {
            if ($stmt = $this->db->prepare("SELECT dipendente.$id AS id, CodiceContratto, dipendente.Nome, dipendente.Cognome, dipendente.Email, dipendente.CodiceFiscale, DataAssunzione, CostoDipendente, DataLicenziamento, LivelloContrattuale, addetto.Nome AS NomeAddetto, addetto.Cognome AS CognomeAddetto FROM $ruolo dipendente, addettorisorseumane addetto, contrattolavoro WHERE dipendente.Cognome = ? AND addetto.CodiceARU = ARU_inserimento AND contrattolavoro.$contratto = dipendente.$id AND DataLicenziamento IS NOT NULL;")) {
               $stmt->bind_param('s', $cognome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else {
            if ($stmt = $this->db->prepare("SELECT dipendente.$id AS id, CodiceContratto, dipendente.Nome, dipendente.Cognome, dipendente.Email, dipendente.CodiceFiscale, DataAssunzione, CostoDipendente, DataLicenziamento, LivelloContrattuale, addetto.Nome AS NomeAddetto, addetto.Cognome AS CognomeAddetto FROM $ruolo dipendente, addettorisorseumane addetto, contrattolavoro WHERE dipendente.Nome = ? AND dipendente.Cognome = ? AND addetto.CodiceARU = ARU_inserimento AND contrattolavoro.$contratto = dipendente.$id AND DataLicenziamento IS NOT NULL;")) {
               $stmt->bind_param('ss', $nome, $cognome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         }
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

      //Aggiungi Numero Telefono
      public function aggiungi_numero($numero_telefono,$ruolo,$id) {
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

         if ($stmt = $this->db->prepare("INSERT $ruolo ($nome_id, NumeroTelefono) VALUES (?,?)")) {
            $stmt->bind_param('ii', $id, $numero_telefono);
            $stmt->execute();
            return true;
         } else {
            return false;
         }
      }

      //Cancella Contratto
      public function cancella_contratto($id) {
         if($stmt = $this->db->prepare("DELETE FROM ContrattoLavoro WHERE CodiceContratto = ?")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return true;
         } else {
            return false;
         }
      }

      //Aggiungi Data Licenziamento
      public function aggiungi_licenziamento($id, $data) {
         if($stmt = $this->db->prepare("UPDATE ContrattoLavoro SET DataLicenziamento = ? WHERE CodiceContratto = ?")) {
            $stmt->bind_param('si', $data, $id);
            $stmt->execute();
            return true;
         } else {
            return false;
         }
      }

      //Cerca Stampanti
      public function get_stampanti($marchio, $modello, $seriale) {
         //Il tipo di query cambia in base alle parole chiave inserite
         if ($modello == '' && $marchio != '' && $seriale == '') {
            if($stmt = $this->db->prepare("SELECT CodiceStampante, MarchioProduzione, Modello, NumeroSeriale, OreStampa, TipologiaStampa, DataAcquisto, PrezzoAcquisto, Nome, Cognome FROM Stampante_3d, Acquisto, Venditore WHERE MarchioProduzione = ? AND Acquisto.Stampante = Stampante_3d.CodiceStampante AND Venditore.CodiceVenditore = Acquisto.Venditore")) {
               $stmt->bind_param('s', $marchio);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else if ($seriale == '' && $modello != '' && $marchio != '') {
            if($stmt = $this->db->prepare("SELECT CodiceStampante, MarchioProduzione, Modello, NumeroSeriale, OreStampa, TipologiaStampa, DataAcquisto, PrezzoAcquisto, Nome, Cognome FROM Stampante_3d, Acquisto, Venditore WHERE MarchioProduzione = ? AND Acquisto.Stampante = Stampante_3d.CodiceStampante AND Venditore.CodiceVenditore = Acquisto.Venditore AND Modello = ?")) {
               $stmt->bind_param('ss', $marchio, $modello);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else if ($modello != '' && $marchio == '' && $seriale == '') {
            if($stmt = $this->db->prepare("SELECT CodiceStampante, MarchioProduzione, Modello, NumeroSeriale, OreStampa, TipologiaStampa, DataAcquisto, PrezzoAcquisto, Nome, Cognome FROM Stampante_3d, Acquisto, Venditore WHERE Modello = ? AND Acquisto.Stampante = Stampante_3d.CodiceStampante AND Venditore.CodiceVenditore = Acquisto.Venditore")) {
               $stmt->bind_param('s',$modello);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else if ($marchio == '' && $modello == '' && $seriale == '') {
            if($stmt = $this->db->prepare("SELECT CodiceStampante, MarchioProduzione, Modello, NumeroSeriale, OreStampa, TipologiaStampa, DataAcquisto, PrezzoAcquisto, Nome, Cognome FROM Stampante_3d, Acquisto, Venditore WHERE Acquisto.Stampante = Stampante_3d.CodiceStampante AND Venditore.CodiceVenditore = Acquisto.Venditore")) {
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else {
            if($stmt = $this->db->prepare("SELECT CodiceStampante, MarchioProduzione, Modello, NumeroSeriale, OreStampa, TipologiaStampa, DataAcquisto, PrezzoAcquisto, Nome, Cognome FROM Stampante_3d, Acquisto, Venditore WHERE Acquisto.Stampante = Stampante_3d.CodiceStampante AND Venditore.CodiceVenditore = Acquisto.Venditore AND NumeroSeriale = ?")) {
               $stmt->bind_param('s', $seriale);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         }
      }

      //Elenco manutenzione stampante
      public function get_manutenzione($id) {
         if($stmt = $this->db->prepare("SELECT DataManutenzione, Descrizione, Nome, Cognome FROM Manutenzione, Operaio WHERE Operaio.CodiceOperaio = Manutenzione.Operaio AND Stampante = ?")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Aggiungi manutenzione stampante
      public function aggiungi_manutenzione($data, $descrizione, $id, $user_id) {
         if ($stmt = $this->db->prepare("INSERT Manutenzione (Stampante, DataManutenzione, Descrizione, Operaio) VALUES (?, ?, ?, ?)")) {
            $stmt->bind_param('issi', $id, $data, $descrizione, $user_id);
            $stmt->execute();
            return true;
         } else {
            return false;
         }
      }

      //Elenco Servizi Post Produzione
      public function get_servizio() {
         if($stmt = $this->db->prepare("SELECT * FROM ServizioPostProduzione")) {
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Elenco Operai Addetti al Servizio
      public function get_operaio_servizio($id) {
         if($stmt = $this->db->prepare("SELECT Nome, Cognome FROM Compimento, Operaio WHERE Operaio.CodiceOperaio = Compimento.Operaio AND Servizio = ?")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Elenco Completo Operai
      public function get_operai() {
         if($stmt = $this->db->prepare("SELECT * FROM Operaio")) {
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Aggiungi un Servizio di Post Produzione ad una serie di Operai
      public function aggiungi_servizio($nome, $costo, $disp, $operai) {
         if($disp == 'Sì') {
            $disp = 1;
         } else {
            $disp = 0;
         }

         //Crea il servizio
         if($stmt = $this->db->prepare("INSERT ServizioPostProduzione (NomeServizio, CostoServizio, Disponibilità) VALUES (?, ?, ?)")) {
            $stmt->bind_param('sii', $nome, $costo, $disp);
            $stmt->execute();
            //Seleziona l'indice del servizio appena creato
            if ($stmt = $this -> db -> prepare("SELECT MAX(CodiceServizio) FROM ServizioPostProduzione")) {
               $stmt -> execute();
               $stmt -> store_result();
               $stmt -> bind_result($id_servizio);
               $stmt -> fetch();
               //Collega ad ogni operaio il nuovo servizio
               foreach ($operai as $operaio) {
                  $this -> aggiungi_operaio_servizio($operaio,$id_servizio);
               }
               return true;
            } else {
               return false;
            }
         } else {
            return false;
         }
      }

      //Aggiunge un servizio ad un singolo operaio
      private function aggiungi_operaio_servizio($id_operaio, $id_servizio) {
         if($stmt = $this->db->prepare("INSERT compimento (Operaio, Servizio) VALUES (?, ?)")) {
            $stmt->bind_param('ii', $id_operaio, $id_servizio);
            $stmt->execute();
            return true;
         } else {
            return false;
         }
      }

      //Restituisce ordini in base alle parole chiave inserite
      public function get_ordine($id, $nome, $cognome) {
         if ($id == '' && $nome == '' && $cognome == '') {
            return $this -> get_ordini();
         } else if ($id != '') {
            if ($stmt = $this->db->prepare("SELECT CodiceOrdine, NomeFile, TempoRichiesto, DataOrdine, QuantitàMateriale, Costo, Materiale.NomeMateriale, Materiale.MarchioProduttore AS MaterialeProduttore, Venditore.Nome AS NomeVenditore, Venditore.Cognome AS CognomeVenditore, Stampante_3d.MarchioProduzione AS MarchioStampante, Stampante_3d.Modello, Stampante_3d.NumeroSeriale, Cliente.Nome AS NomeCliente, Cliente.Cognome AS CognomeCliente, Cliente.Email, Cliente.CodiceFiscale, Cliente.Via, Cliente.NumeroCivico, Cliente.CAP, Cliente.Città FROM Ordine, Cliente, Materiale, Stampante_3d, Venditore WHERE Materiale.CodiceMateriale = Ordine.Materiale AND Venditore.CodiceVenditore = Ordine.Venditore AND Stampante_3d.CodiceStampante = Ordine.Stampante AND Cliente.CodiceCliente = Ordine.Cliente AND CodiceOrdine = ?")) {
               $stmt->bind_param('i', $id);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else if ($nome != '' && $cognome == '') {
            if ($stmt = $this->db->prepare("SELECT CodiceOrdine, NomeFile, TempoRichiesto, DataOrdine, QuantitàMateriale, Costo, Materiale.NomeMateriale, Materiale.MarchioProduttore AS MaterialeProduttore, Venditore.Nome AS NomeVenditore, Venditore.Cognome AS CognomeVenditore, Stampante_3d.MarchioProduzione AS MarchioStampante, Stampante_3d.Modello, Stampante_3d.NumeroSeriale, Cliente.Nome AS NomeCliente, Cliente.Cognome AS CognomeCliente, Cliente.Email, Cliente.CodiceFiscale, Cliente.Via, Cliente.NumeroCivico, Cliente.CAP, Cliente.Città FROM Ordine, Cliente, Materiale, Stampante_3d, Venditore WHERE Materiale.CodiceMateriale = Ordine.Materiale AND Venditore.CodiceVenditore = Ordine.Venditore AND Stampante_3d.CodiceStampante = Ordine.Stampante AND Cliente.CodiceCliente = Ordine.Cliente AND Cliente.Nome = ?")) {
               $stmt->bind_param('s', $nome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else if ($nome == '' && $cognome != '') {
            if ($stmt = $this->db->prepare("SELECT CodiceOrdine, NomeFile, TempoRichiesto, DataOrdine, QuantitàMateriale, Costo, Materiale.NomeMateriale, Materiale.MarchioProduttore AS MaterialeProduttore, Venditore.Nome AS NomeVenditore, Venditore.Cognome AS CognomeVenditore, Stampante_3d.MarchioProduzione AS MarchioStampante, Stampante_3d.Modello, Stampante_3d.NumeroSeriale, Cliente.Nome AS NomeCliente, Cliente.Cognome AS CognomeCliente, Cliente.Email, Cliente.CodiceFiscale, Cliente.Via, Cliente.NumeroCivico, Cliente.CAP, Cliente.Città FROM Ordine, Cliente, Materiale, Stampante_3d, Venditore WHERE Materiale.CodiceMateriale = Ordine.Materiale AND Venditore.CodiceVenditore = Ordine.Venditore AND Stampante_3d.CodiceStampante = Ordine.Stampante AND Cliente.CodiceCliente = Ordine.Cliente AND Cliente.Cognome = ?")) {
               $stmt->bind_param('s', $cognome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else {
            if ($stmt = $this->db->prepare("SELECT CodiceOrdine, NomeFile, TempoRichiesto, DataOrdine, QuantitàMateriale, Costo, Materiale.NomeMateriale, Materiale.MarchioProduttore AS MaterialeProduttore, Venditore.Nome AS NomeVenditore, Venditore.Cognome AS CognomeVenditore, Stampante_3d.MarchioProduzione AS MarchioStampante, Stampante_3d.Modello, Stampante_3d.NumeroSeriale, Cliente.Nome AS NomeCliente, Cliente.Cognome AS CognomeCliente, Cliente.Email, Cliente.CodiceFiscale, Cliente.Via, Cliente.NumeroCivico, Cliente.CAP, Cliente.Città FROM Ordine, Cliente, Materiale, Stampante_3d, Venditore WHERE Materiale.CodiceMateriale = Ordine.Materiale AND Venditore.CodiceVenditore = Ordine.Venditore AND Stampante_3d.CodiceStampante = Ordine.Stampante AND Cliente.CodiceCliente = Ordine.Cliente AND Cliente.Cognome = ? AND Cliente.Nome = ?")) {
               $stmt->bind_param('ss', $cognome, $nome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         }
      }

      //Restituisce tutti i servizi richiesti da un determinato ordine
      public function get_servizi_ordine($id) {
         if($stmt = $this->db->prepare("SELECT NomeServizio FROM ServizioPostProduzione, Richiesta WHERE CodiceServizio = Servizio AND Ordine = ?")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Restituisce tutti gli ordini in ordine decrescente di inserimento
      public function get_ordini() {
         if($stmt = $this->db->prepare("SELECT CodiceOrdine, NomeFile, DataOrdine, Cliente.Nome AS NomeCliente, Cliente.Cognome AS CognomeCliente FROM Ordine, Cliente, Materiale, Stampante_3d, Venditore WHERE Materiale.CodiceMateriale = Ordine.Materiale AND Venditore.CodiceVenditore = Ordine.Venditore AND Stampante_3d.CodiceStampante = Ordine.Stampante AND Cliente.CodiceCliente = Ordine.Cliente ORDER BY DataOrdine DESC")) {
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Restituisce le informazioni di spedizione collegate con un determinato ordine
      public function get_spedizione_ordine($id) {
         if($stmt = $this->db->prepare("SELECT CodiceTracciamento, DataSpedizione, NomeCorriere FROM Ordine, Spedizione, Corriere WHERE Spedizione.CodiceSpedizione = Ordine.Spedizione AND Corriere.CodiceCorriere = Spedizione.Corriere AND Ordine.CodiceOrdine = ?")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Restituisce elenco corrieri
      public function get_corrieri() {
         if($stmt = $this->db->prepare("SELECT * FROM Corriere")) {
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Aggiunge un corriere
      public function aggiungi_corriere($nome) {
         if($stmt = $this->db->prepare("INSERT Corriere (NomeCorriere) VALUES (?)")) {
            $stmt->bind_param('s', $nome);
            $stmt->execute();
            return true;
         } else {
            return false;
         }
      }

      //Aggiunge una stampante
      public function aggiungi_stampante($produttore, $modello, $seriale, $tipologia, $data, $prezzo, $venditore) {
         //Aggiunge la stampante
         if($stmt = $this->db->prepare("INSERT Stampante_3d (MarchioProduzione, Modello, NumeroSeriale, TipologiaStampa) VALUES (?, ?, ?, ?)")) {
            $stmt->bind_param('ssss', $produttore, $modello, $seriale, $tipologia);
            $stmt->execute();
            //Seleziona indice stampante appena inserita
            if ($stmt = $this -> db -> prepare("SELECT MAX(CodiceStampante) FROM Stampante_3d")) {
               $stmt -> execute();
               $stmt -> store_result();
               $stmt -> bind_result($id_stampante);
               $stmt -> fetch();
               //Registra acquisto stampante
               if ($stmt = $this->db->prepare("INSERT Acquisto (Stampante, DataAcquisto, PrezzoAcquisto, Venditore) VALUES (?, ?, ?, ?)")) {
                  $stmt->bind_param('isss', $id_stampante, $data, $prezzo, $venditore);
                  $stmt->execute();
                  //Aggiunge Costo All'anno Economico
                  if ($stmt = $this -> db -> prepare("SELECT * FROM AnnoEconomico WHERE AnnoRiferimento = ?;")) {
                     $anno = substr($data,0,4);
                     $stmt -> bind_param('s', $anno);
                     $stmt -> execute();
                     $stmt->store_result();
                     if ($stmt -> num_rows == 0) {
                        if ($stmt = $this -> db -> prepare("INSERT INTO AnnoEconomico (AnnoRiferimento) VALUES (?)")) {
                           $stmt -> bind_param('s', $anno);
                           $stmt -> execute();
                        } else {
                           return false;
                        }
                     }
                     if ($stmt = $this -> db -> prepare("UPDATE AnnoEconomico SET CostoStampanti = CostoStampanti + ? WHERE AnnoRiferimento = ?;")) {
                        $stmt -> bind_param('is', $prezzo, $anno);
                        $stmt -> execute();
                        return true;
                     } else {
                        return false;
                     }
                  } else {
                     return false;
                  }
               } else {
                  return false;
               }
            } else {
               return false;
            }
         } else {
            return false;
         }
      }

      //Restituisce i materiali in base alla parola inserita in input
      public function get_materiali($materiale) {
         if ($materiale == '') {
            if($stmt = $this->db->prepare("SELECT * FROM Materiale")) {
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else {
            if($stmt = $this->db->prepare("SELECT * FROM Materiale WHERE NomeMateriale = ?")) {
               $stmt->bind_param('s', $materiale);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         }
      }

      //Restituisce gli acquisti del materiale effettuati
      public function get_acquisti_materiale($materiale) {
         if($stmt = $this->db->prepare("SELECT DataAcquisto, PrezzoAcquisto, Quantità, Venditore.Nome, Venditore.Cognome FROM AcquistoMateriale, Venditore WHERE AcquistoMateriale.Materiale = ? AND Venditore.CodiceVenditore = AcquistoMateriale.Venditore")) {
            $stmt->bind_param('s', $materiale);
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Restituisce informazioni generiche su tutti gli anni economici inseriti
      public function get_anni_economici() {
         if($stmt = $this->db->prepare("SELECT AnnoRiferimento, (CostoProgettisti + CostoVenditori + CostoOperai + CostoARU + CostoStampanti + CostoMateriale) AS Uscite, (EntrateProgettazione + EntrateProduzione + EntrateServizi) AS Entrate FROM AnnoEconomico ORDER BY AnnoRiferimento DESC")) {
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Restituisce informazioni dettagliat sull'anno economico inserito in input
      public function get_anno_economico($anno) {
         if($stmt = $this->db->prepare("SELECT *, (CostoProgettisti + CostoVenditori + CostoOperai + CostoARU + CostoStampanti + CostoMateriale) AS Uscite, (EntrateProgettazione + EntrateProduzione + EntrateServizi) AS Entrate FROM AnnoEconomico WHERE AnnoRiferimento = ?")) {
            $stmt->bind_param('s', $anno);
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Aggiunge spedizione ad ordine
      public function aggiungi_spedizione($tracciamento, $corriere, $data, $id_ordine, $id_venditore) {
         if($stmt = $this->db->prepare("INSERT Spedizione (CodiceTracciamento, DataSpedizione, Venditore, corriere) VALUES (?, ?, ?, ?)")) {
            $stmt->bind_param('ssii', $tracciamento, $data, $id_venditore, $corriere);
            $stmt->execute();
            if ($stmt = $this -> db -> prepare("SELECT MAX(CodiceSpedizione) FROM Spedizione")) {
               $stmt -> execute();
               $stmt -> store_result();
               $stmt -> bind_result($id_spedizione);
               $stmt -> fetch();
               if ($stmt = $this -> db -> prepare("UPDATE Ordine SET Spedizione = ? WHERE CodiceOrdine = ?;")) {
                  $stmt -> bind_param('ii', $id_spedizione, $id_ordine);
                  $stmt -> execute();
                  return true;
               } else {
                  return false;
               }
            } else {
               return false;
            }
         } else {
            return false;
         }
      }

      //Inserisce un nuovo materiale
      public function aggiungi_nuovo_materiale($nome, $produttore, $peso, $tipologia) {
         if($stmt = $this->db->prepare("INSERT Materiale (NomeMateriale, MarchioProduttore, PesoUnità, Tipologia) VALUES (?, ?, ?, ?)")) {
            $stmt->bind_param('ssis', $nome, $produttore, $peso, $tipologia);
            $stmt->execute();
            return true;
         } else {
            return false;
         }
      }

      //Acquisto materiale esistente
      public function aggiungi_acquisto_materiale($quantità, $data, $prezzo, $materiale, $venditore) {
         if($stmt = $this->db->prepare("INSERT AcquistoMateriale (DataAcquisto, Venditore, PrezzoAcquisto, Materiale, Quantità) VALUES (?, ?, ?, ?, ?)")) {
            $stmt->bind_param('siiii', $data, $venditore, $prezzo, $materiale, $quantità);
            $stmt->execute();
            //Incrementa scorte magazzino
            if ($stmt = $this -> db -> prepare("UPDATE Materiale SET UnitàMagazzino = UnitàMagazzino + ? WHERE CodiceMateriale = ?;")) {
               $stmt -> bind_param('ii', $quantità, $materiale);
               $stmt -> execute();
               //Seleziona anno riferimento dell'acquisto
               if ($stmt = $this -> db -> prepare("SELECT * FROM AnnoEconomico WHERE AnnoRiferimento = ?;")) {
                  $anno = substr($data,0,4);
                  $stmt -> bind_param('s', $anno);
                  $stmt -> execute();
                  $stmt->store_result();
                  if ($stmt -> num_rows == 0) {
                     if ($stmt = $this -> db -> prepare("INSERT INTO AnnoEconomico (AnnoRiferimento) VALUES (?)")) {
                        $stmt -> bind_param('s', $anno);
                        $stmt -> execute();
                     } else {
                        return false;
                     }
                  }
                  //Aggiunge costi all'anno economico di riferimento
                  if ($stmt = $this -> db -> prepare("UPDATE AnnoEconomico SET CostoMateriale = CostoMateriale + (? * ?) WHERE AnnoRiferimento = ?;")) {
                     $stmt -> bind_param('iis', $prezzo, $quantità, $anno);
                     $stmt -> execute();
                     return true;
                  } else {
                     return false;
                  }
               } else {
                  return false;
               }
            } else {
               return false;
            }
         } else {
            return false;
         }
      }

      //Restituisce informazioni cliente in base alle parole inserite in input
      public function get_cliente($nome, $cognome) {
         if ($cognome == '' && $nome == '') {
            if($stmt = $this->db->prepare("SELECT * FROM Cliente")) {
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else if ($cognome == '') {
            if($stmt = $this->db->prepare("SELECT * FROM Cliente WHERE Cognome = ?")) {
               $stmt->bind_param('s', $cognome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else if ($nome == '') {
            if($stmt = $this->db->prepare("SELECT * FROM Cliente WHERE Nome = ?")) {
               $stmt->bind_param('s', $nome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         } else {
            if($stmt = $this->db->prepare("SELECT * FROM Cliente WHERE Nome = ? AND Cognome = ?")) {
               $stmt->bind_param('ss', $nome, $cognome);
               $stmt->execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               return $result;
            }
         }
      }

      //Aggiunge nuovo ordine
      public function aggiungi_ordine($cliente, $stampante, $materiale, $nome_file, $tempo, $data, $quantità, $costo, $servizi, $venditore) {
         //Crea Ordine
         if($stmt = $this->db->prepare("INSERT Ordine (NomeFile, TempoRichiesto, DataOrdine, QuantitàMateriale, Costo, Materiale, Venditore, Stampante, Cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
            $stmt->bind_param('sssiiiiii', $nome_file, $tempo, $data, $quantità, $costo, $materiale, $venditore, $stampante, $cliente);
            $stmt->execute();
            //Decrementa scorte di magazzino
            if ($stmt = $this -> db -> prepare("UPDATE Materiale SET UnitàMagazzino = UnitàMagazzino - (? / PesoUnità) WHERE CodiceMateriale = ?;")) {
               $stmt -> bind_param('ii', $quantità, $materiale);
               $stmt -> execute();
               //Seleziona indice ordine
               if ($stmt = $this -> db -> prepare("SELECT MAX(CodiceOrdine) FROM Ordine")) {
                  $stmt -> execute();
                  $stmt -> store_result();
                  $stmt -> bind_result($ordine);
                  $stmt -> fetch();
                  //Per ogni servizio di post produzione aggiunge la relativa associazione
                  foreach ($servizi as $servizio) {
                     $this -> aggiungi_servizio_ordine($servizio, $ordine, $data);
                  }
                  if ($stmt = $this -> db -> prepare("SELECT * FROM AnnoEconomico WHERE AnnoRiferimento = ?;")) {
                     $anno = substr($data,0,4);
                     $stmt -> bind_param('s', $anno);
                     $stmt -> execute();
                     $stmt->store_result();
                     if ($stmt -> num_rows == 0) {
                        if ($stmt = $this -> db -> prepare("INSERT INTO AnnoEconomico (AnnoRiferimento) VALUES (?)")) {
                           $stmt -> bind_param('s', $anno);
                           $stmt -> execute();
                        } else {
                           return false;
                        }
                     }
                     //Incrementa entrate produzione
                     if ($stmt = $this -> db -> prepare("UPDATE AnnoEconomico SET EntrateProduzione = EntrateProduzione + ? WHERE AnnoRiferimento = ?;")) {
                        $stmt -> bind_param('is', $costo, $anno);
                        $stmt -> execute();
                        //Incrementa Ore stampa
                        if ($stmt = $this -> db -> prepare("UPDATE Stampante_3d SET OreStampa = OreStampa + (? / 60) WHERE CodiceStampante = ?;")) {
                           $stmt -> bind_param('ii', $tempo, $stampante);
                           $stmt -> execute();
                           return true;
                        } else {
                           return false;
                        }
                     } else {
                        return false;
                     }
                  } else {
                     return false;
                  }
               } else {
                  return false;
               }
            }
         }
      }
      
      //Aggiunge Servizio ad Ordine
      private function aggiungi_servizio_ordine($servizio, $ordine, $data) {
         if ($stmt = $this -> db -> prepare("INSERT Richiesta (Ordine, Servizio) VALUES (?,?)")) {
            $stmt -> bind_param('ii', $ordine, $servizio);
            $stmt -> execute();
            if ($stmt = $this -> db -> prepare("SELECT * FROM AnnoEconomico WHERE AnnoRiferimento = ?;")) {
               $anno = substr($data,0,4);
               $stmt -> bind_param('s', $anno);
               $stmt -> execute();
               $stmt->store_result();
               if ($stmt -> num_rows == 0) {
                  if ($stmt = $this -> db -> prepare("INSERT INTO AnnoEconomico (AnnoRiferimento) VALUES (?)")) {
                     $stmt -> bind_param('s', $anno);
                     $stmt -> execute();
                  } else {
                     return false;
                  }
               }
               if ($stmt = $this -> db -> prepare("SELECT CostoServizio FROM ServizioPostProduzione WHERE CodiceServizio = ?;")) {
                  $stmt -> bind_param('i', $servizio);
                  $stmt -> execute();
                  $stmt -> store_result();
                  $stmt -> bind_result($costo);
                  $stmt -> fetch();
                  //Aggiunge alle entrate il guadagno derivante dai servizi
                  if ($stmt = $this -> db -> prepare("UPDATE AnnoEconomico SET EntrateServizi = EntrateServizi + ? WHERE AnnoRiferimento = ?;")) {
                     $stmt -> bind_param('is', $costo, $anno);
                     $stmt -> execute();
                     return true;
                  } else {
                     return false;
                  }
               } else {
                  return false;
               }
            } else {
               return false;
            }
         } else {
            return false;
         }
      }

      //Recupera informazioni eventuale progettazione ordine
      public function get_progettazioni_ordine($ordine) {
         if($stmt = $this->db->prepare("SELECT CostoProgettazione, DataProgettazione, Nome, Cognome FROM Progettazione, Progettista WHERE Ordine = ? AND Progettista.CodiceProgettista = Progettazione.Progettista")) {
            $stmt -> bind_param('i', $ordine);
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Elenco Progettisti
      public function get_progettisti() {
         if($stmt = $this->db->prepare("SELECT * FROM Progettista")) {
            $stmt->execute();
            $result=$stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            return $result;
         }
      }

      //Aggiunge ad ordine progettazione
      public function aggiungi_progettazione($ordine, $progettista, $data, $costo) {
         if ($stmt = $this -> db -> prepare("INSERT INTO Progettazione (Ordine, Progettista, CostoProgettazione, DataProgettazione) VALUES (?, ?, ?, ?)")) {
            $stmt -> bind_param('iiis', $ordine, $progettista, $costo, $data);
            $stmt -> execute();
            if ($stmt = $this -> db -> prepare("SELECT * FROM AnnoEconomico WHERE AnnoRiferimento = ?;")) {
               $anno = substr($data,0,4);
               $stmt -> bind_param('s', $anno);
               $stmt -> execute();
               $stmt->store_result();
               if ($stmt -> num_rows == 0) {
                  if ($stmt = $this -> db -> prepare("INSERT INTO AnnoEconomico (AnnoRiferimento) VALUES (?)")) {
                     $stmt -> bind_param('s', $anno);
                     $stmt -> execute();
                  } else {
                     return false;
                  }
               }
               //Incrementa entrate derivanti dalla fase di progettazione
               if ($stmt = $this -> db -> prepare("UPDATE AnnoEconomico SET EntrateProgettazione = EntrateProgettazione + ? WHERE AnnoRiferimento = ?;")) {
                  $stmt -> bind_param('is', $costo, $anno);
                  $stmt -> execute();
                  return true;
               } else {
                  return false;
               }
            } else {
               return false;
            }
         } else {
            return false;
         }
      }

      //Aggiunge nuovo cliente
      public function aggiungi_cliente($nome, $cognome, $email, $codice_fiscale, $indirizzo, $numero_civico, $cap, $città) {
         if($stmt = $this->db->prepare("INSERT Cliente (Nome, Cognome, Email, CodiceFiscale, Via, NumeroCivico, CAP, Città) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
            $stmt->bind_param('sssssiis', $nome, $cognome, $email, $codice_fiscale, $indirizzo, $numero_civico, $cap, $città);
            $stmt->execute();
            return true;
         } else {
            return false;
         }
      }

      //Restituisce indice massimo cliente
      public function get_max_cliente() {
         if ($stmt = $this -> db -> prepare("SELECT MAX(CodiceCliente) FROM Cliente")) {
            $stmt -> execute();
            $stmt -> store_result();
            $stmt -> bind_result($id);
            $stmt -> fetch();
         }
         return $id;
      }

      //Registrazione nuovo contratto di persona già esistente
      public function registrazione_contratto_esistente($id, $ruolo, $data_assunzione, $costo_registrazione, $livello, $aru) {
         switch ($ruolo) {
            case 'Venditore':
               $costo = 'CostoVenditori';
               break;
            case 'AddettoRisorseUmane':
               $ruolo = 'ARU';
               $costo = 'CostoARU';
               break;
            case 'Operaio':
               $costo = 'CostoOperai';
               break;
            case 'Progettista':
               $costo = 'CostoProgettisti';
               break;
         }
         if($stmt = $this->db->prepare("INSERT ContrattoLavoro (DataAssunzione, CostoDipendente, LivelloContrattuale, $ruolo, ARU_inserimento) VALUES (?, ?, ?, ?, ?)")) {
            $stmt->bind_param('siiii', $data_assunzione, $costo_registrazione, $livello, $id, $aru);
            $stmt->execute();
            //Aggiunge Costo All'anno Economico
            if ($stmt = $this -> db -> prepare("SELECT * FROM AnnoEconomico WHERE AnnoRiferimento = ?;")) {
               $anno = substr($data_assunzione,0,4);
               $stmt -> bind_param('s', $anno);
               $stmt -> execute();
               $stmt->store_result();
               if ($stmt -> num_rows == 0) {
                  if ($stmt = $this -> db -> prepare("INSERT INTO AnnoEconomico (AnnoRiferimento) VALUES (?)")) {
                     $stmt -> bind_param('s', $anno);
                     $stmt -> execute();
                  }
               }
               if ($stmt = $this -> db -> prepare("UPDATE AnnoEconomico SET $costo = $costo + ? WHERE AnnoRiferimento = ?;")) {
                  $stmt -> bind_param('is', $costo_registrazione, $anno);
                  $stmt -> execute();
                  return true;
               }
            }
         } else {
            return false;
         }
      }

      //Controlla se un determinato contratto presenta una data di licenziamento
      public function is_contratto_concluso($id) {
         if ($stmt = $this -> db -> prepare("SELECT CodiceContratto FROM ContrattoLavoro WHERE CodiceContratto = ? AND DataLicenziamento IS NULL")) {
               $stmt -> bind_param('i', $id);
               $stmt -> execute();
               $result=$stmt->get_result();
               $result->fetch_all(MYSQLI_ASSOC);
               if ($result -> num_rows == 0) {
                  return true;
               } else {
                  return false;
               }
         }
      }

    }
?>