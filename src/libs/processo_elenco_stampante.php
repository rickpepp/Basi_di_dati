<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check() && isset($_GET['marchio']) && isset($_GET['modello'])) {
        echo '<div>
                <table>
                    <tr>
                        <th>Marchio Produttore</th>
                        <th>modello</th>
                        <th>Numero Seriale</th>
                        <th>Ore di Stampa</th>
                        <th>Tipologia Stampa</th>
                        <th>Dati di Acquisto</th>
                        <th>Manutenzione</th>
                    </tr>';
        
        $risultati = $dbh -> get_stampanti($_GET['marchio'], $_GET['modello'], $_GET['seriale']);

        foreach ($risultati as $result) {
            echo '<tr>
                <td>'.$result["MarchioProduzione"].'</td>
                <td>'.$result["Modello"].'</td>
                <td>'.$result["NumeroSeriale"].'</td>
                <td>'.$result["OreStampa"].'</td>
                <td>'.$result["TipologiaStampa"].'</td>
                <td>'.$result["DataAcquisto"].'<br/>'.$result["PrezzoAcquisto"].' €<br/>'.$result["Nome"].' '.$result["Cognome"].'</td>
                <td><img src="../img/modifica.png" alt="icona modifica" onclick="location.href=\'../views/visualizza_dati.php?action=3&id='.$result["CodiceStampante"].'\'"/></td>
            </tr>';
        }
        
        echo '</table>';
        if ($_SESSION['ruolo'] == 'venditore') {
            echo ' <input type="button" value="Aggiungi" onclick="location.href=\'../views/inserimento_dati.php?action=9\';"/><br/>';
        }
           
        echo '<input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
        </div>';
        
    }

?>