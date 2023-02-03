<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    echo '<form action="../libs/processo_inserimento_spedizione.php" method="post" name="riepilogo_dipendente">
    <h2>Inserisci Nuova Spedizione</h2><br>
    <label>Codice Tracciamento<br><input type="text" name="CodiceTracciamento"></label><br>
    <label for="corriere">Corriere</label><br>
    <input type="hidden" name="id" value="'.$_GET["id"].'"/>
    <select name="corriere" id="corriere">';

    $corrieri = $dbh -> get_corrieri();

    foreach ($corrieri as $corriere) {
        echo '<option value="'.$corriere["CodiceCorriere"].'">'.$corriere["NomeCorriere"].'</option>';
    }

    echo '</select><br/>
    <label>Data Spedizione<br><input type="date" name="data" required></label><br>
    <footer>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>