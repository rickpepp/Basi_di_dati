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
                        <th>Modifica</th>
                    </tr>';

        $i=0;
        $lenght = 100;
        foreach ($ruoli as $ruolo) {
            $result = $dbh -> get_dipendente($_GET['nome'], $_GET['cognome'], $ruolo);
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
                        '<td><img src="../img/modifica.png" alt="icona modifica" onclick="location.href=\'../views/menu_modifica_contratto.php?id='.$single_result["id"].'&ruolo_id='.$ruolo.'&CodiceContratto='.$single_result["CodiceContratto"].'\'"/></td>'.
                    '</tr>';
            }
        }
        

        echo '  <table>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
            <div>';
    } else {
        //Elementi POST non settati
        header('Location: ../views/menu.php?r=1&msg=Elementi POST non settati');
    }
?>