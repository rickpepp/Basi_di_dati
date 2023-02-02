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
                            echo "<a href='../views/inserimento_dati.php?action=1&id=".$_GET["id"]."&ruolo=".$_GET["ruolo_id"]."'><li>Aggiungi Numero di Telefono</li></a><br>
                            <a href='../views/inserimento_dati.php?action=3&CodiceContratto=".$_GET["CodiceContratto"]."''><li>Aggiungi Data Licenziamento</li></a><br>
                            <a href='../libs/cancella_contratto.php?CodiceContratto=".$_GET["CodiceContratto"]."'><li>Cancella Contratto</li></a><br>";
                        }                      
                    ?>
                    <a href="javascript:history.go(-1)"><li>Torna Indietro</li></a>
                </ul>
            </div>
        </main>
    </body>
</html>