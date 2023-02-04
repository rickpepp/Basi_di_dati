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
                    //Inserimento nuovo contratto e nuova persona
                    case 0:
                        include '../libs/inserimento_contratto.php';
                        break;
                    //Inserimento numero di telefono a persona già esistente
                    case 1:
                        include '../libs/inserimento_numero_telefono.php';
                        break;
                    //Pagina di ricerca dipendente
                    case 2:
                        include '../libs/riepilogo_dipendente.php';
                        break;
                    //Inserimento data licenziamento contratto
                    case 3:
                        include '../libs/inserimento_licenziamento.php';
                        break;
                    //Pagina inserimento per la ricerca della stampante
                    case 4:
                        include '../libs/ricerca_stampante.php';
                        break;
                    //Inserimento nuova Manutenzione
                    case 5:
                        include '../libs/inserimento_manutenzione.php';
                        break;
                    //Inserimento nuovo servizio di post produzione
                    case 6:
                        include '../libs/inserimento_servizio.php';
                        break;
                    //Pagina per ricerca ordine
                    case 7:
                        include '../libs/ricerca_ordine.php';
                        break;
                    //Inserimento nuovo corriere
                    case 8:
                        include '../libs/inserimento_corriere.php';
                        break;
                    //Inserimento nuova stampante
                    case 9:
                        include '../libs/inserimento_stampante.php';
                        break;
                    //Pagina di ricerca materiale
                    case 10:
                        include '../libs/ricerca_materiale.php';
                        break;
                    //Inserimento dati spedizione a ordine esistente
                    case 11:
                        include '../libs/inserimento_spedizione.php';
                        break;
                    //Inserimento nuovo materiale
                    case 12:
                        include '../libs/inserimento_nuovo_materiale.php';
                        break;
                    //Acquisto materiale esistente
                    case 13:
                        include '../libs/inserimento_acquisto_materiale.php';
                        break;
                    //Pagina ricerca cliente utile alla creazione nuovo ordine
                    case 14:
                        include '../libs/ordine_ricerca_cliente.php';
                        break;
                    //Pagina ricerca stampante utile alla creazione nuovo ordine
                    case 15:
                        include '../libs/ordine_ricerca_stampante.php';
                        break;
                    //Pagina ricerca materiale utile alla creazione nuovo ordine
                    case 16:
                        include '../libs/ordine_ricerca_materiale.php';
                        break;
                    //Inserimento dati nuovo ordine
                    case 17:
                        include '../libs/inserimento_ordine.php';
                        break;
                    //Inserimento progettazione a ordine esistente
                    case 18:
                        include '../libs/inserimento_progettazione.php';
                        break;
                    //Inserimento nuovo cliente
                    case 19:
                        include '../libs/inserimento_cliente.php';
                        break;
                    //Ricerca dipendente per inserimento contratto
                    case 20:
                        include '../libs/ricerca_persona_nuovo_contratto.php';
                        break;
                    //Inserimento dati contratto persona esistente
                    case 21:
                        include '../libs/inserimento_contratto_esistente.php';
                        break;
                }
            ?>
        </main>
    </body>
</html>