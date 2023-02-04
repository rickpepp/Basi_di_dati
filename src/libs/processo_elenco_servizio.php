<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Elenco Servizi di Post Produzione
    if ($dbh -> login_check()) {
        echo '<div>
                <table>
                    <tr>
                        <th>Servizio Post Produzione</th>
                        <th>Costo Servizio</th>
                        <th>Disponibilità</th>
                        <th>Operaio</th>
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
                </tr>';
        }
        
        echo '</table>
            <input type="button" value="Aggiungi" onclick="location.href=\'../views/inserimento_dati.php?action=6\';"/><br/>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
        </div>';
        
    }

?>