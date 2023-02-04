<?php
    //Pagina ricerca cliente utile alla creazione nuovo ordine
    echo '<form action="../views/visualizza_dati.php" method="get" name="riepilogo_dipendente">
    <h2>Inserimento Ordine - Cerca Cliente</h2><br>
    <label>Nome<br><input type="text" name="nome"></label><br>
    <label>Cognome<br><input type="text" name="cognome"></label><br>
    <input type="hidden" name="action" value="12"><br>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Cerca" id="cerca"><br>
        <input type="button" value="Indietro" onclick="location.href = \'../views/menu.php\'"><br>
    </footer>
</form>'
?>