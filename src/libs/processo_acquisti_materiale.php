<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check() && isset($_GET['id'])) {
        echo '<div>
                <table>
                    <tr>
                        <th>Data Acquisto</th>
                        <th>Prezzo Acquisto</th>
                        <th>Quantità</th>
                        <th>Venditore</th>
                    </tr>';
        
        $risultati = $dbh -> get_acquisti_materiale($_GET['id']);

        foreach ($risultati as $result) {
            echo '<tr>
                <td>'.$result["DataAcquisto"].'</td>
                <td>'.$result["PrezzoAcquisto"].' €</td>
                <td>'.$result["Quantità"].'</td>
                <td>'.$result["Nome"].' '.$result["Cognome"].'</td>
            </tr>';
        }
        
        echo '</table>
            <input type="button" value="Acquista" onclick="location.href=\'../views/inserimento_dati.php?action=13&id='.$_GET['id'].'\';"><br>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
        </div>';
        
    }

?>