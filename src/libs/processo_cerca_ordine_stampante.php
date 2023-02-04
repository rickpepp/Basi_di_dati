<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Elenco stampanti utile per selezionare stampante per nuovo ordine
    if ($dbh -> login_check() && isset($_GET['marchio']) && isset($_GET['modello'])) {
        echo '<div>
                <form style="width:90%;" type="get" action="../views/inserimento_dati.php">
                <h2>Inserimento Ordine - Seleziona la Stampante</h2>
                <table>
                    <tr>
                        <th>Marchio Produttore</th>
                        <th>modello</th>
                        <th>Numero Seriale</th>
                        <th>Ore di Stampa</th>
                        <th>Tipologia Stampa</th>
                        <th>Dati di Acquisto</th>
                        <th>Seleziona</th>
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
                <td><input type="radio" name="stampante" value="'.$result["CodiceStampante"].'"/></td>
            </tr>';
        }
        
        echo '</table>';

           
        echo '<input type="hidden" name="cliente" value="'.$_GET['cliente'].'"/>
            <input type="hidden" name="action" value="16"/>';
            if ($risultati -> num_rows != 0) {
                echo '<input type="submit" value="Seleziona"><br>';
            }
            
            echo '<input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
            </form>
        </div>';
        
    }

?>