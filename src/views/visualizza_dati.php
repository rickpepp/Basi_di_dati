<?php 
    if ($_GET['action'] == 11) {
        include '../libs/grafico_dettagli_anno_economico1.php';
    } else if ($_GET['action'] == 10) {
        include '../libs/grafico_elenco_anni_economici1.php';
    }
?>
<!DOCTYPE html>
<html lang="it" id="menu">
    <head>
        <title>Printing Farm</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="icon" type="img/png" href="#" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script type="text/javascript" src="../js/sha512.js"></script>
        <script type="text/javascript" src="../js/forms_registrazione.js"></script>
        <?php 
            if ($_GET['action'] == 11) {
                include '../libs/grafico_dettagli_anno_economico2.php';
            } else if ($_GET['action'] == 10) {
                include '../libs/grafico_elenco_anni_economici2.php';
            }
        ?>
    </head>
    <body class="centered">
        <header>
            <h1>Printing Farm</h1>
        </header>
        <main>
            <?php
                switch ($_GET['action']) {
                    case 0:
                        include '../libs/processo_riepilogo_dipendente.php';
                        break;
                    case 1:
                        include '../libs/processo_costo_per_settore.php';
                        break;
                    case 2:
                        include '../libs/processo_elenco_stampante.php';
                        break;
                    case 3:
                        include '../libs/processo_elenco_manutenzione.php';
                        break;
                    case 4:
                        include '../libs/processo_elenco_servizio.php';
                        break;
                    case 5:
                        include '../libs/processo_cerca_ordine.php';
                        break;
                    case 6:
                        include '../libs/processo_ordini.php';
                        break;
                    case 7:
                        include '../libs/processo_elenco_corriere.php';
                        break;
                    case 8:
                        include '../libs/processo_elenco_materiali.php';
                        break;
                    case 9:
                        include '../libs/processo_acquisti_materiale.php';
                        break;
                    case 10:
                        include '../libs/processo_elenco_anni_economici.php';
                        break;
                    case 11:
                        include '../libs/processo_dettagli_anno_economico.php';
                        break;
                    case 12:
                        include '../libs/processo_cerca_cliente.php';
                        break;
                    case 13:
                        include '../libs/processo_cerca_ordine_stampante.php';
                        break;
                    case 14:
                        include '../libs/processo_cerca_ordine_materiale.php';
                        break;
                    case 15:
                        include '../libs/processo_cerca_ordine_servizi.php';
                        break;
                    case 16:
                        include '../libs/processo_elenco_progettisti.php';
                        break;
                    case 17:
                        include '../libs/processo_elenco_nuovo_contratto.php';
                        break;
                }
            ?>
        </main>
    </body>
</html>