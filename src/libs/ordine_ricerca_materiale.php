<?php
    //Pagina ricerca materiale utile alla creazione nuovo ordine
    echo '<form action="../views/visualizza_dati.php" method="get" name="riepilogo_dipendente">
    <h2>Inserimento Ordine - Cerca Materiale</h2><br>
    <label>Nome Materiale<br><input type="text" name="materiale"></label><br>
    <input type="hidden" name="action" value="14"><br>
    <input type="hidden" name="cliente" value="'.$_GET['cliente'].'"><br>
    <input type="hidden" name="stampante" value="'.$_GET['stampante'].'"><br>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Cerca" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>