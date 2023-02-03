<?php

        echo '<div>
                <h2>Riepilogo Anni Precedenti</h2>
                <table>
                    <tr>
                        <th>Anno</th>
                        <th>Entrate</th>
                        <th>Uscite</th>
                        <th>Differenza</th>
                        <th>Dettagli</th>
                    </tr>';

        foreach ($risultati as $result) {
            echo '<tr>
                    <td>'.$result["AnnoRiferimento"].'</td>
                    <td>'.$result["Entrate"].' €</td>
                    <td>'.$result["Uscite"].' €</td>
                    <td>'.($result["Entrate"] - $result["Uscite"]).' €</td>
                    <td><img src="../img/modifica.png" alt="icona modifica" onclick="location.href=\'../views/visualizza_dati.php?action=11&id='.$result["AnnoRiferimento"].'\'"/></td>
                </tr>';
        }

        echo '</table>
            <div id="chartContainerAnniEconomici" style="height: 370px; width: 100%; margin-top: 40px; margin-bottom: 40px;"></div>
            <script src="../js/canvasjs.min.js"></script>
            <script>
                document.getElementById(\'menu\').style.height = \'140%\';
            </script>
            <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
        </div>';
        


?>