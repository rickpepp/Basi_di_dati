<!DOCTYPE html>
<html lang="it" id="menu">
    <head>
        <title>Printing Farm</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="icon" type="img/png" href="#" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script type="text/javascript"><?php echo "alert(\"".$_GET['msg']."\");" ?></script>
    </head>
    <body class="centered">
        <header>
            <h1>Printing Farm</h1>
        </header>
        <main>
            <div>
                <ul>
                    <!--Inserire javascript per regolare altezza html in base ad elementi-->
                    <?php 
                        require_once '../libs/database.php';
                        require_once '../libs/functions.php';
                        require_once '../libs/bootstrap.php';

                        sec_session_start();

                        //Seleziona Ruolo in base al ruolo
                        if($dbh -> login_check()) {
                            switch ($_SESSION['ruolo']) {
                                case 'addettorisorseumane':
                                    echo "<a href='inserimento_dati.php?action=0'><li>Inserimento nuovo contratto di lavoro</li></a><br>
                                    <a href='visualizza_dati.php?action=1'><li>Costo dipendenti per settore</li></a><br>
                                    <a href='inserimento_dati.php?action=2'><li>Riepilogo e modifica contratto dipendente</li></a><br>";
                                    break;
                                case 'operaio':
                                    echo "<a href='inserimento_dati.php?action=4'><li>Gestione manutenzione stampante</li></a><br>
                                    <a href='visualizza_dati.php?action=4'><li>Gestione servizi di post produzione</li></a><br>
                                    <a href='inserimento_dati.php?action=7'><li>Ricerca Ordine</li></a><br>
                                    <a href=visualizza_dati.php?action=6'><li>Elenco Ordini da Spedire</li></a>";
                                    break;
                                case 'venditore':
                                    echo "<li>Inserimento nuovo corriere</li><br>
                                    <li>Inserimento nuovo ordine</li><br>
                                    <li>Inserimento nuova spedizione</li><br>
                                    <li>Inserimento nuovo materiale</li><br>
                                    <li>Acquisto materiale esistente</li><br>
                                    <li>Acquisto nuova stampante</li><br>
                                    <li>Riepilogo ordini cliente</li><br>
                                    <li>Riepilogo ordine specifico</li><br>
                                    <li>Utile annuale</li><br>
                                    <script>
                                        document.getElementById('menu').style.height = '140%';
                                    </script>";
                                    break;
                            }
                        }                      
                    ?>
                    <a href="../libs/processo_logout.php"><li>Logout</li></a>
                </ul>
            </div>
        </main>
    </body>
</html>