<?php
    //Inserimento dati nuovo ordine
    echo '<form action="../libs/processo_inserimento_ordine.php" method="post" name="riepilogo_dipendente">
    <h2>Inserisci Dati Ordine</h2><br>
    <label>Nome File<br><input type="text" name="nome"></label><br>
    <label>Tempo Richiesto in minuti<br><input type="number" name="tempo"></label><br>
    <label>Data Ordine<br><input type="date" name="data"></label><br>
    <label>Quantità Materiale<br><input type="number" name="quantità"></label><br>
    <label>Compenso Ordine<br><input type="number" name="costo"></label><br>
    <input type="hidden" name="cliente" value="'.$_GET['cliente'].'"/>
    <input type="hidden" name="stampante" value="'.$_GET['stampante'].'"/>
    <input type="hidden" name="materiale" value="'.$_GET['materiale'].'"/>';
    
    foreach ($_GET['servizio'] as $servizio) {
        echo '<input type="hidden" name="servizio[]" value="'.$servizio.'"/>';
    }

    echo '<footer>
        <p id="informazioni"></p>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
    <script>
        document.getElementById(\'menu\').style.height = \'140%\';
    </script>
</form>';
?>