<?php
    echo '<form action="../views/visualizza_dati.php" method="get" name="riepilogo_dipendente">
    <h2>Cerca Ordine per Codice</h2><br>
    <label>Numero Ordine<br><input type="number" name="id"></label><br>
    <input type="hidden" name="action" value="6"><br>
    <hr>
    <h2>Cerca Ordine per Cliente</h2><br>
    <label>Nome<br><input type="text" name="nome"></label><br>
    <label>Cognome<br><input type="text" name="cognome"></label><br>
    <script>
        document.getElementById(\'menu\').style.height = \'120%\';
    </script>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Cerca" id="cerca"><br>
        <input type="button" value="Indietro" onclick="location.href = \'../views/menu.php\'"><br>
    </footer>
</form>'
?>