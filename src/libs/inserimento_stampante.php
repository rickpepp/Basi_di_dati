<?php
    echo '<form action="../libs/processo_inserimento_stampante.php" method="post" name="riepilogo_dipendente">
    <h2>Inserisci Nuova Stampante</h2><br>
    <label>Produttore<br><input type="text" name="produttore" required></label><br>
    <label>Modello<br><input type="text" name="modello" required></label><br>
    <label>Codice Seriale<br><input type="text" name="seriale" required></label><br>
    <label>Tipologia Stampa<br><input type="text" name="tipologia" required></label><br>
    <label>Data Acquisto<br><input type="date" name="data" required></label><br>
    <label>Prezzo di Acquisto<br><input type="number" name="prezzo" required></label><br>
    <script>
        document.getElementById(\'menu\').style.height = \'140%\';
    </script>
    <footer>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>