<?php

        echo '
            <div>
            <h2>Dettaglio Anno Economico</h2>
                <table>
                    <tr>
                        <th>Anno Riferimento</th>
                        <td><strong>'.$anno_riferimento["AnnoRiferimento"].'</strong></td>
                    </tr>
                    <tr>
                        <th>Costo Progettisti</th>
                        <td>'.$anno_riferimento["CostoProgettisti"].' €</td>
                    </tr>
                    <tr>
                        <th>Costo Venditori</th>
                        <td>'.$anno_riferimento["CostoVenditori"].' €</td>
                    </tr>
                    <tr>
                        <th>Costo Operai</th>
                        <td>'.$anno_riferimento["CostoOperai"].' €</td>
                    </tr>
                    <tr>
                        <th>Costo ARU</th>
                        <td>'.$anno_riferimento["CostoARU"].' €</td>
                    </tr>
                    <tr>
                        <th>Costo Stampanti</th>
                        <td>'.$anno_riferimento["CostoStampanti"].' €</td>
                    </tr>
                    <tr>
                        <th>Costo Materiale</th>
                        <td>'.$anno_riferimento["CostoMateriale"].' €</td>
                    </tr>
                    <tr>
                        <th>Entrate Progettazione</th>
                        <td>'.$anno_riferimento["EntrateProgettazione"].' €</td>
                    </tr>
                    <tr>
                        <th>Entrate Produzione</th>
                        <td>'.$anno_riferimento["EntrateProduzione"].' €</td>
                    </tr>
                    <tr>
                        <th>Entrate Servizi</th>
                        <td>'.$anno_riferimento["EntrateServizi"].' €</td>
                    </tr>
                    <tr>
                        <th>Entrate Totali</th>
                        <td><strong>'.$anno_riferimento["Entrate"].' €</strong></td>
                    </tr>
                    <tr>
                        <th>Uscite Totali</th>
                        <td><strong>'.$anno_riferimento["Uscite"].' €</strong></td>
                    </tr>
                    <tr>
                        <th>Differenza</th>
                        <td><strong>'.($anno_riferimento["Entrate"] - $anno_riferimento["Uscite"]).' €</strong></td>
                    </tr>
                </table>
                <div id="chartContainerUscite" style="height: 370px; width: 49%; margin-top: 40px; margin-bottom: 40px;display: inline-block;"></div>
                <div id="chartContainerEntrate" style="height: 370px; width: 49%; margin-top: 40px; margin-bottom: 40px;display: inline-block;"></div>
                <script src="../js/canvasjs.min.js"></script>
                <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
                <script>
                    document.getElementById(\'menu\').style.height = \'160%\';
                </script>
            </div>';
?>