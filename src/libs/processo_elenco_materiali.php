<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check()) {
        echo '<div>
                <table>
                    <tr>
                        <th>Nome Materiale</th>
                        <th>Marchio Produttore</th>
                        <th>Peso Unità</th>
                        <th>Unità in Magazzino</th>
                        <th>Tipologia</th>
                        <th>Acquisti</th>
                    </tr>';
        
        $risultati = $dbh -> get_materiali($_GET['materiale']);

        foreach ($risultati as $result) {
            echo '<tr>
                <td>'.$result["NomeMateriale"].'</td>
                <td>'.$result["MarchioProduttore"].'</td>
                <td>'.$result["PesoUnità"].' g</td>
                <td>'.$result["UnitàMagazzino"].'</td>
                <td>'.$result["Tipologia"].'</td>
                <td><img src="../img/modifica.png" alt="icona modifica" onclick="location.href=\'../views/visualizza_dati.php?action=9&id='.$result["CodiceMateriale"].'\'"/></td>
                </tr>';
        }
        
        echo '</table>
            <input type="button" value="Aggiungi" onclick="location.href=\'../views/inserimento_dati.php?action=12\';"/><br/>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
        </div>';
        
    }

?>