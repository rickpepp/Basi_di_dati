<?php
    //Acquisto materiale esistente
    echo '<form action="../libs/processo_inserimento_acquisto_materiale.php" method="post" name="riepilogo_dipendente">
    <h2>Acquista Materiale</h2><br>
    <label>Quantità<br><input type="number" name="quantità" required></label><br>
    <label>Data Acquisto<br><input type="date" name="data" required></label><br>
    <label>Prezzo Acquisto<br><input type="number" name="prezzo" required></label><br>
    <input type="hidden" value="'.$_GET['id'].'" name="materiale"/>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="../views/menu.php"><br>
    </footer>
</form>'
?>