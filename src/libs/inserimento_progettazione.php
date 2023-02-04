<?php
    echo '<form action="../libs/processo_inserimento_progettazione.php" method="post" name="riepilogo_dipendente">
    <h2>Inserisci Dati Progettazione</h2><br>
    <label>Costo Progettazione<br><input type="number" name="costo"></label><br>
    <label>Data Progettazione<br><input type="date" name="data"></label><br>
    <input type="hidden" name="ordine" value="'.$_GET['ordine'].'"/>
    <input type="hidden" name="progettista" value="'.$_GET['progettista'].'"/>
    <footer>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>