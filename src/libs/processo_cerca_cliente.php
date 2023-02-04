<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check()) {
        echo '<div>
                <form style="width:90%;" type="get" action="../views/inserimento_dati.php">
                <h2>Inserimento Ordine - Seleziona il Cliente</h2>
                <table>
                    <tr>
                        <th>Nominativo</th>
                        <th>Email</th>
                        <th>Codice Fiscale</th>
                        <th>Indirizzo</th>
                        <th>Selezionato</th>
                    </tr>';
        
        $risultati = $dbh -> get_cliente($_GET['nome'], $_GET['cognome']);

        foreach ($risultati as $result) {
            echo '<tr>
                <td>'.$result["Nome"].' '.$result["Cognome"].'</td>
                <td>'.$result["Email"].'</td>
                <td>'.$result["CodiceFiscale"].'</td>
                <td>'.$result["Via"].' '.$result["NumeroCivico"].' '.$result["CAP"].' '.$result["Città"].'</td>
                <td><input type="radio" name="cliente" value="'.$result["CodiceCliente"].'"/></td>
            </tr>';
        }
        
        echo '</table>
            <input type="hidden" value="15" name="action"/>
            <input type="submit" value="Seleziona"><br>
            <input type="button" value="Nuovo" onclick="location.href= \'../views/inserimento_dati.php?action=19\'"><br>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
            </form>
        </div>';
        
    }

?>