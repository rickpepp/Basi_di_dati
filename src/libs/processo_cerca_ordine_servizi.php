<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check()) {
        echo '<div>
                <form style="width:90%;" type="get" action="../views/inserimento_dati.php">
                <h2>Inserimento Ordine - Seleziona il Servizio</h2>
                <table>
                    <tr>
                        <th>Servizio Post Produzione</th>
                        <th>Costo Servizio</th>
                        <th>Disponibilità</th>
                        <th>Operaio</th>
                        <th>Seleziona</th>
                    </tr>';
        
        $risultati = $dbh -> get_servizio();

        foreach ($risultati as $result) {
            echo '<tr>
                <td>'.$result["NomeServizio"].'</td>
                <td>'.$result["CostoServizio"].'€</td>
                <td>';
                if($result["Disponibilità"]) {
                    echo 'Sì';
                } else {
                    echo 'No';
                }
                echo '</td>
                <td>';
                $risultati_operaio = $dbh -> get_operaio_servizio($result["CodiceServizio"]);
                foreach ($risultati_operaio as $operaio) {
                    echo $operaio["Nome"].' '.$operaio["Cognome"].'<br/>';
                }
            echo '</td>
                    <td><input type="checkbox" name="servizio[]" value="'.$result["CodiceServizio"].'"/></td>
                </tr>';
        }
        
        echo '</table>
            <input type="hidden" name="cliente" value="'.$_GET['cliente'].'"/>
            <input type="hidden" name="stampante" value="'.$_GET['stampante'].'"/>
            <input type="hidden" name="materiale" value="'.$_GET['materiale'].'"/>
            <input type="hidden" name="action" value="17"/>
            <input type="submit" value="Seleziona"/><br/>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
            </form>
        </div>';
        
    }

?>