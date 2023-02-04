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
                                    echo "<a href='inserimento_dati.php?action=20'><li>Inserimento nuovo contratto di lavoro</li></a><br>
                                    <a href='visualizza_dati.php?action=1'><li>Costo dipendenti per settore</li></a><br>
                                    <a href='inserimento_dati.php?action=2'><li>Riepilogo e modifica contratto dipendente</li></a><br>";
                                    break;
                                case 'operaio':
                                    echo "<a href='inserimento_dati.php?action=4'><li>Gestione manutenzione stampante</li></a><br>
                                    <a href='visualizza_dati.php?action=4'><li>Gestione servizi di post produzione</li></a><br>
                                    <a href='inserimento_dati.php?action=7'><li>Gestione Ordini</li></a><br>";
                                    break;
                                case 'venditore':
                                    echo "<a href='visualizza_dati.php?action=7'><li>Gestione Corrieri</li></a><br>
                                    <a href='inserimento_dati.php?action=4'><li>Gestione Stampanti</li></a><br>
                                    <a href='inserimento_dati.php?action=7'><li>Dettagli Ordini</li></a><br>
                                    <a href='inserimento_dati.php?action=14'><li>Nuovo Ordine</li></a><br>
                                    <a href='inserimento_dati.php?action=10'><li>Gestione Materiali</li></a><br>
                                    <a href='visualizza_dati.php?action=10'><li>Resoconti Economici</li></a><br>
                                    <script>
                                        document.getElementById('menu').style.height = '120%';
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