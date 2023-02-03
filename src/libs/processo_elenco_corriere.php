<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check()) {
        echo '<div>
                <table>
                    <tr>
                        <th>Nome Corriere</th>
                    </tr>';
        
        $risultati = $dbh -> get_corrieri();

        foreach ($risultati as $result) {
            echo '<tr>
                <td>'.$result["NomeCorriere"].'</td>
            </tr>';
        }
        
        echo '</table>
        <style>table {width: 50%}</style>
            <input type="button" value="Aggiungi" onclick="location.href=\'../views/inserimento_dati.php?action=8\';"/><br/>
            <input type="button" value="Indietro" onclick="location.href=\'../views/menu.php\';"><br>
        </div>';
        
    }

?>