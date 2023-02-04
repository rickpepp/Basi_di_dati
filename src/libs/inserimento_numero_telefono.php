<?php
    //Inserimento numero di telefono a persona già esistente
    echo '<form action="../libs/processo_inserimento_numero_telefono.php" method="post" name="riepilogo_dipendente">
    <h2>Aggiungi numero Telefono</h2><br>
    <label>Numero Telefono<br><input type="text" name="numero_telefono"></label><br>
    <input type="hidden" value="'.$_GET['ruolo'].'" name="ruolo"/>
    <input type="hidden" value="'.$_GET['id'].'" name="id"/>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>