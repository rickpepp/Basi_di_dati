<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Elenco materiali utile per selezionare materiale per nuovo ordine
    if ($dbh -> login_check()) {
        echo '<div>
                <form style="width:90%;" type="get" action="../views/visualizza_dati.php">
                <h2>Inserimento Ordine - Seleziona il materiale</h2>
                <table>
                    <tr>
                        <th>Nome Materiale</th>
                        <th>Marchio Produttore</th>
                        <th>Peso Unità</th>
                        <th>Unità in Magazzino</th>
                        <th>Tipologia</th>
                        <th>Seleziona</th>
                    </tr>';
        
        $risultati = $dbh -> get_materiali($_GET['materiale']);

        foreach ($risultati as $result) {
            echo '<tr>
                <td>'.$result["NomeMateriale"].'</td>
                <td>'.$result["MarchioProduttore"].'</td>
                <td>'.$result["PesoUnità"].' g</td>
                <td>'.$result["UnitàMagazzino"].'</td>
                <td>'.$result["Tipologia"].'</td>
                <td><input type="radio" name="materiale" value="'.$result["CodiceMateriale"].'"/></td>
                </tr>';
        }
        
        echo '</table>
            <input type="hidden" name="cliente" value="'.$_GET['cliente'].'"/>
            <input type="hidden" name="stampante" value="'.$_GET['stampante'].'"/>
            <input type="hidden" name="action" value="15"/>';
            if ($risultati -> num_rows != 0) {
                echo '<input type="submit" value="Seleziona"><br>';
            }
            
            echo '<input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
            </form>
        </div>';
        
    }

?>