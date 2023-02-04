<?php
    //Inserimento nuovo servizio di post produzione
    echo '<form action="../libs/processo_inserimento_servizio.php" method="post" name="riepilogo_dipendente">
    <h2>Inserisci Servizio Post Produzione</h2><br>
    <label>Nome Servizio<br><input type="text" name="nome" required></label><br>
    <label>Costo Servizio<br><input type="number" name="costo" required></label><br>
    <label for="disp">Disponibilità</label>
    <select name="disp" id="disp">
        <option value="Sì">Sì</option>
        <option value="No">No</option>
    </select>';

    include '../libs/elenco_operai.php';

    echo '<footer>
        <p id="informazioni"></p>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>