<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check()) {
        echo '<div>
                <form style="width:90%;" type="get" action="../views/inserimento_dati.php">
                <h2>Inserimento Ordine - Seleziona il materiale</h2>
                <table>
                    <tr>
                        <th>Nominativo</th>
                        <th>Email</th>
                        <th>Codice Fiscale</th>
                        <th>Seleziona</th>
                    </tr>';
        
        $risultati = $dbh -> get_progettisti();

        foreach ($risultati as $result) {
            echo '<tr>
                <td>'.$result["Nome"].' '.$result['Cognome'].'</td>
                <td>'.$result["Email"].'</td>
                <td>'.$result["CodiceFiscale"].' g</td>
                <td><input type="radio" name="progettista" value="'.$result["CodiceProgettista"].'"/></td>
                </tr>';
        }
        
        echo '</table>
            <input type="hidden" name="ordine" value="'.$_GET['id'].'"/>
            <input type="hidden" name="action" value="18"/>
            <input type="submit" value="Aggiungi"/><br/>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
            </form>
        </div>';
        
    }

?>