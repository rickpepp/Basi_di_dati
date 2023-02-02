<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check() && isset($_GET['id'])) {
        echo '<div>
                <table>';
        
        $ordini = $dbh -> get_ordine($_GET['id']);

        foreach ($ordini as $ordine) {
            echo '<tr>
                <th>Nome File</th>
                <td>'.$ordine["NomeFile"].'</td>
            </tr>
            <tr>
                <th>Tempo Richiesto</th>
                <td>'.$ordine["TempoRichiesto"].'</td>
            </tr>
            <tr>
                <th>Data Ordine</th>
                <td>'.$ordine["DataOrdine"].'</td>
            </tr>
            <tr>
                <th>Quantità Materiale</th>
                <td>'.$ordine["QuantitàMateriale"].' g</td>
            </tr>
            <tr>
                <th>Costo</th>
                <td>'.$ordine["Costo"].' €</td>
            </tr>
            <tr>
                <th>Materiale</th>
                <td>'.$ordine["NomeMateriale"].' ('.$ordine["MaterialeProduttore"].')</td>
            </tr>
            <tr>
                <th>Venditore</th>
                <td>'.$ordine["NomeVenditore"].' '.$ordine["CognomeVenditore"].'</td>
            </tr>
            <tr>
                <th>Stampante</th>
                <td>'.$ordine["MarchioStampante"].' '.$ordine["Modello"].'<br/>'.$ordine["NumeroSeriale"].'</td>
            </tr>
            <tr>
                <th>Cliente</th>
                <td><strong>Nominativo</strong>: '.$ordine["NomeCliente"].' '.$ordine["CognomeCliente"].'<br/><strong>Email</strong>: '.$ordine["Email"].'<br/><strong>Codice Fiscale</strong>: '.$ordine["CodiceFiscale"].'<br/><strong>Indirizzo</strong>: '.$ordine["Via"].' '.$ordine["NumeroCivico"].' '.$ordine["CAP"].' '.$ordine["Città"].'</td>
            </tr>
            <tr>
                <th>Servizi Post Produzione Richiesti</th>
                <td>';
                $servizi = $dbh -> get_servizi_ordine($ordine['CodiceOrdine']);
                foreach($servizi as $servizio) {
                    echo $servizio['NomeServizio'].'<br/>';
                }
                echo '</td>
            </tr>
            <tr>
                <th>Spedizione</th>
                <td>';
                $spedizioni = $dbh -> get_spedizione_ordine($ordine['CodiceOrdine']);
                foreach($spedizioni as $spedizione) {
                    echo '<strong>Codice Spedizione</strong>: '.$spedizione['CodiceSpedizione'].'<br/><strong>Data Spedizione</strong>: '.$spedizione['DataSpedizione'].'<br/><strong>Corriere</strong>: '.$spedizione['NomeCorriere'];
                }
                echo '</td>
            </tr>';
        }
        
        
        echo '</table>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
        </div>';
        
    }

?>