<?php
    echo '<form action="../libs/processo_inserimento_manutenzione.php" method="post" name="riepilogo_dipendente">
    <h2>Inserisci Manutenzione</h2><br>
    <label>Data Manutenzione<br><input type="date" name="data"></label><br>
    <label>Descrizione<br><input type="text" name="descrizione"></label><br>
    <input type="hidden" value="'.$_GET["id"].'" name="id"/>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>