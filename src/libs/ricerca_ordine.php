<?php
    echo '<form action="../views/visualizza_dati.php" method="get" name="riepilogo_dipendente">
    <h2>Cerca Ordine</h2><br>
    <label>Numero Ordine<br><input type="number" name="id"></label><br>
    <input type="hidden" name="action" value="5"><br>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Cerca" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>