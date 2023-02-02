<?php
    echo '<form action="../libs/processo_inserimento_licenziamento.php" method="post" name="riepilogo_dipendente">
    <h2>Aggiungi Data Licenziamento</h2><br>
    <label>Data Licenziamento<input type="date" name="data_licenziamento" value="2023-01-13"></label><br>
    <input type="hidden" value="'.$_GET['CodiceContratto'].'" name="CodiceContratto"/>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>