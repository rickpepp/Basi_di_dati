<?php 
    //Caricamento dati da db per disegnare gradico anno economico
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
        <!-- script php utile per creare grafico anno economico -->
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
                    //Riepilogo contratti dipendenti
                    case 0:
                        include '../libs/processo_riepilogo_dipendente.php';
                        break;
                    //Costo dipendenti per settori
                    case 1:
                        include '../libs/processo_costo_per_settore.php';
                        break;
                    //Elenco stampanti
                    case 2:
                        include '../libs/processo_elenco_stampante.php';
                        break;
                    //Elenco Manutenzione singola stampante
                    case 3:
                        include '../libs/processo_elenco_manutenzione.php';
                        break;
                    //Elenco Servizi di Post Produzione
                    case 4:
                        include '../libs/processo_elenco_servizio.php';
                        break;
                    //Dettaglio Ordine
                    case 5:
                        include '../libs/processo_cerca_ordine.php';
                        break;
                    //Elenco Ordini
                    case 6:
                        include '../libs/processo_ordini.php';
                        break;
                    //Elenco Corrieri
                    case 7:
                        include '../libs/processo_elenco_corriere.php';
                        break;
                    //Elenco Materiali
                    case 8:
                        include '../libs/processo_elenco_materiali.php';
                        break;
                    //Cronologia Acquisti Materiale
                    case 9:
                        include '../libs/processo_acquisti_materiale.php';
                        break;
                    //Elenco Anni Economici
                    case 10:
                        include '../libs/processo_elenco_anni_economici.php';
                        break;
                    //Singolo Anno Economico in dettaglio
                    case 11:
                        include '../libs/processo_dettagli_anno_economico.php';
                        break;
                    //Elenco clienti utile per selezionare cliente per nuovo ordine
                    case 12:
                        include '../libs/processo_cerca_cliente.php';
                        break;
                    //Elenco stampanti utile per selezionare stampante per nuovo ordine
                    case 13:
                        include '../libs/processo_cerca_ordine_stampante.php';
                        break;
                    //Elenco materiali utile per selezionare materiale per nuovo ordine
                    case 14:
                        include '../libs/processo_cerca_ordine_materiale.php';
                        break;
                    //Elenco servizi post produzione utile per selezionare servizio/i per nuovo ordine
                    case 15:
                        include '../libs/processo_cerca_ordine_servizi.php';
                        break;
                    //Elenco progettisti
                    case 16:
                        include '../libs/processo_elenco_progettisti.php';
                        break;
                    //Scelta dipendente esistente per nuovo contratto
                    case 17:
                        include '../libs/processo_elenco_nuovo_contratto.php';
                        break;
                }
            ?>
        </main>
    </body>
</html>