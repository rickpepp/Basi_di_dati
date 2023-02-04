<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Scelta dipendente esistente per nuovo contratto
    //Controlla siano passati correttamente in POST i valori necessari
    if(isset($_GET['nome']) && isset($_GET['cognome']) && $dbh -> login_check()) {
        $ruoli = array("AddettoRisorseUmane", "Operaio", "Progettista", "Venditore");
        
        echo '<div>
                <form style="width:90%;" type="get" action="../views/inserimento_dati.php">
                <h2>Scegli Ex Dipendente</h2>
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
                        <th>Seleziona</th>
                    </tr>';

        $i=0;
        $lenght = 100;
        foreach ($ruoli as $ruolo) {
            $result = $dbh -> get_dipendente_licenziato($_GET['nome'], $_GET['cognome'], $ruolo);
            foreach ($result as $single_result) {
                $i++;
                if ($i > 5) {
                    $lenght += 20;
                    echo '<script>
                        document.getElementById(\'menu\').style.height = \''.$lenght.'%\';
                    </script>';
                    $i=0;
                }
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
                        '<td>'.$single_result["CostoDipendente"].'€</td>'.
                        '<td>'.$single_result["LivelloContrattuale"].'</td>'.
                        '<td>'.$single_result["NomeAddetto"].' '.$single_result["CognomeAddetto"].'</td>'.
                        '<td><input type="radio" name="persona" value="'.$ruolo.' '.$single_result["id"].'"/></td>'.
                    '</tr>';
            }
        }
        

        echo '  <table>
            <input type="hidden" name="action" value="21"/>
            <input type="submit" value="Seleziona"><br>
            <input type="button" value="Nuovo" onclick="location.href=\'../views/inserimento_dati.php?action=0\'"><br>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
            </form>
            <div>';
    } else {
        //Elementi POST non settati
        header('Location: ../views/menu.php?r=1&msg=Elementi POST non settati');
    }
?>