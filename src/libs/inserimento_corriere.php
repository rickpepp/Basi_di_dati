<?php
    echo '<form action="../libs/processo_inserimento_corriere.php" method="post" name="riepilogo_dipendente">
    <h2>Inserisci Nuovo Corriere</h2><br>
    <label>Nome Corriere<br><input type="text" name="nome" required></label><br>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="../views/menu.php"><br>
    </footer>
</form>'
?>