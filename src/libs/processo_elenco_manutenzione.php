<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check() && isset($_GET['id'])) {
        echo '<div>
                <table>
                    <tr>
                        <th>Data Manutenzione</th>
                        <th>Descrizione</th>
                        <th>Operaio</th>
                    </tr>';
        
        $risultati = $dbh -> get_manutenzione($_GET['id']);

        foreach ($risultati as $result) {
            echo '<tr>
                <td>'.$result["DataManutenzione"].'</td>
                <td>'.$result["Descrizione"].'</td>
                <td>'.$result["Nome"].' '.$result["Cognome"].'</td>
            </tr>';
        }
        
        echo '</table>
            <input type="button" value="Aggiungi" onclick="location.href=\'../views/inserimento_dati.php?action=5&id='.$_GET['id'].'\'"/><br/>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
        </div>';
        
    }

?>