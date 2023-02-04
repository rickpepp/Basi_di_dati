<?php
    //Inserimento nuovo cliente
    echo '<form action="../libs/processo_inserimento_cliente.php" method="post" name="riepilogo_dipendente">
    <h2>Aggiungi Nuovo Cliente</h2><br>
    <label>Nome<br><input type="text" name="nome"></label><br>
    <label>Cognome<br><input type="text" name="cognome"></label><br>
    <label>Email<br><input type="email" name="email"></label><br>
    <label>Codice Fiscale<br><input type="text" name="codiceFiscale"></label><br>
    <label>Indirizzo<br><input type="text" name="indirizzo"></label><br>
    <label>Numero Civico<br><input type="number" name="numeroCivico"></label><br>
    <label>CAP<br><input type="number" name="cap"></label><br>
    <label>Città<br><input type="text" name="città"></label><br>
    <script>
        document.getElementById(\'menu\').style.height = \'160%\';
    </script>
    <footer>
        <p id="informazioni"></p>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>