<?php
    //Pagina ricerca stampante utile alla creazione nuovo ordine
    echo '<form action="../views/visualizza_dati.php" method="get" name="riepilogo_dipendente">
    <h2>Inserimento Ordine - Cerca Stampante</h2><br>
    <label>Marchio di Produzione<br><input type="text" name="marchio"></label><br>
    <label>Modello<br><input type="text" name="modello"></label><br>
    <label>Numero Seriale<br><input type="text" name="seriale"></label><br>
    <input type="hidden" name="action" value="13"><br>
    <input type="hidden" name="cliente" value="'.$_GET['cliente'].'"><br>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Cerca" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>