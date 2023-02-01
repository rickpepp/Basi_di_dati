<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Controlla siano passati correttamente in POST i valori necessari
    if(isset($_GET['nome']) && isset($_GET['cognome']) && $dbh -> login_check()) {
        $ruoli = array("AddettoRisorseUmane", "Operaio", "Progettista", "Venditore");
        
        echo '<div>
                <table>
                    <tr>
                        <th>Nome e Cognome</th>
                        <th>Ruolo</th>
                        <th>Email</th>
                        <th>Codice Fiscale</th>
                        <th>Numero Telefono</th>
                        <th>Data Assunzione</th>
                        <th>Data Licenziamento</th>
                        <th>Costo Dipendente</th>
                        <th>Livello Contrattuale</th>
                        <th>Addetto Inserimento</th>
                    </tr>';

        foreach ($ruoli as $ruolo) {
            $result = $dbh -> get_dipendente($_GET['nome'], $_GET['cognome'], $ruolo);
            foreach ($result as $single_result) {
                echo '<tr>
                        <td>'.$single_result["Nome"].' '.$single_result["Cognome"].'</td>'.
                        '<td>'.$ruolo.'</td>'.
                        '<td>'.$single_result["Email"].'</td>'.
                        '<td>'.$single_result["CodiceFiscale"].'</td>'.
                        '<td>';
                        $result_telefono = $dbh -> get_numero_telefono($single_result["id"], $ruolo);

                        foreach ($result_telefono as $result_telefono_singolo) {
                            echo $result_telefono_singolo["NumeroTelefono"].'<br/>';
                        }
                        
                        echo '</td>'.
                        '<td>'.$single_result["DataAssunzione"].'</td>'.
                        '<td>'.$single_result["DataLicenziamento"].'</td>'.
                        '<td>'.$single_result["CostoDipendente"].'</td>'.
                        '<td>'.$single_result["LivelloContrattuale"].'</td>'.
                        '<td>'.$single_result["NomeAddetto"].' '.$single_result["CognomeAddetto"].'</td>'.
                    '</tr>';
            }
        }
        

        echo '  <table>
            <input type="button" value="Indietro" onclick="location.href=\'menu.php?r=1\';"><br>
            <div>';
    } else {
        //Elementi POST non settati
        header('Location: ../views/menu.php?r=1&msg=Elementi POST non settati');
    }
?>