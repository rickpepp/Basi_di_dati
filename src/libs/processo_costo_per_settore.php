<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    if ($dbh -> login_check()) {
        echo '<div>
                <table>
                    <tr>
                        <th>Anno di Riferimento</th>
                        <th>Costo Operai</th>
                        <th>Costo Venditori</th>
                        <th>Costo Progettisti</th>
                        <th>Costo ARU</th>
                    </tr>';
        
        $risultati = $dbh -> costo_per_settore();

        foreach ($risultati as $result) {
            echo '<tr>
                <td>'.$result["AnnoRiferimento"].'</td>
                <td>'.$result["CostoOperai"].'</td>
                <td>'.$result["CostoVenditori"].'</td>
                <td>'.$result["CostoProgettisti"].'</td>
                <td>'.$result["CostoARU"].'</td>
            </tr>';
        }
        
        echo '</table>
            <input type="button" value="Indietro" onclick="location.href=\'menu.php?r=1\';"><br>
        </div>';
        
    }

?>