<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check()) {
        echo '<div>
                <table>
                    <tr>
                        <th>Anno</th>
                        <th>Entrate</th>
                        <th>Uscite</th>
                        <th>Differenza</th>
                        <th>Dettagli</th>
                    </tr>';
        
        $risultati = $dbh -> get_anni_economici();

        foreach ($risultati as $result) {
            echo '<tr>
                <td>'.$result["AnnoRiferimento"].'</td>
                <td>'.$result["Entrate"].' €</td>
                <td>'.$result["Uscite"].' €</td>
                <td>'.($result["Entrate"] - $result["Uscite"]).' €</td>
                <td><img src="../img/modifica.png" alt="icona modifica" onclick="location.href=\'../views/visualizza_dati.php?action=9&id='.$result["AnnoRiferimento"].'\'"/></td>
                </tr>';
        }
        
        echo '</table>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
        </div>';
        
    }

?>