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
                        include '../libs/processo_elenco_stampanti.php';
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
                        include '../libs/processo_ordini_non_spediti.php';
                        break;
                }
            ?>
        </main>
    </body>
</html>