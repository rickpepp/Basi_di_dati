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
                        include '../libs/inserimento_contratto.php';
                        break;
                    case 1:
                        include '../libs/inserimento_numero_telefono.php';
                        break;
                    case 2:
                        include '../libs/riepilogo_dipendente.php';
                        break;
                    case 3:
                        include '../libs/inserimento_licenziamento.php';
                        break;
                    case 4:
                        include '../libs/ricerca_stampante.php';
                        break;
                    case 5:
                        include '../libs/inserimento_manutenzione.php';
                        break;
                    case 6:
                        include '../libs/inserimento_servizio.php';
                        break;
                    case 7:
                        include '../libs/ricerca_ordine.php';
                        break;
                    case 8:
                        include '../libs/inserimento_corriere.php';
                        break;
                    case 9:
                        include '../libs/inserimento_stampante.php';
                        break;
                    case 10:
                        include '../libs/ricerca_materiale.php';
                        break;
                }
            ?>
        </main>
    </body>
</html>