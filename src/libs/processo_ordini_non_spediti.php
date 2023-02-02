<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check()) {
        echo '<div>
                <table>
                    <tr>
                        <th>Codice Ordine</th>
                        <th>Nome File</th>
                        <th>Data Ordine</th>
                        <th>Cliente</th>
                        <th>Ulteriori Informazioni</th>
                    </tr>';
        
        $ordini = $dbh -> get_ordini_da_spedire();

        foreach ($ordini as $ordine) {
            echo '<tr>
                    <td>'.$ordine['CodiceOrdine'].'</td>
                    <td>'.$ordine['NomeFile'].'</td>
                    <td>'.$ordine['DataOrdine'].'</td>
                    <td>'.$ordine['NomeCliente'].' '.$ordine['CognomeCliente'].'</td>
                    <td><img src="../img/modifica.png" alt="icona modifica" onclick="location.href=\'../views/visualizza_dati.php?action=5&id='.$ordine["CodiceOrdine"].'\'"/></td>
                </tr>';
        }
        
        
        echo '</table>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
        </div>';
        
    }

?>