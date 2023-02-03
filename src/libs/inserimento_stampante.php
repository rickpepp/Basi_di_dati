<?php
    echo '<form action="../libs/processo_inserimento_stampante.php" method="post" name="riepilogo_dipendente">
    <h2>Inserisci Nuova Stampante</h2><br>
    <label>Produttore<br><input type="text" name="produttore"></label><br>
    <label>Modello<br><input type="text" name="modello"></label><br>
    <label>Codice Seriale<br><input type="text" name="seriale"></label><br>
    <label>Tipologia Stampa<br><input type="text" name="tipologia"></label><br>
    <label>Data Acquisto<br><input type="date" name="data"></label><br>
    <label>Prezzo di Acquisto<br><input type="number" name="prezzo"></label><br>
    <script>
        document.getElementById(\'menu\').style.height = \'140%\';
    </script>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>