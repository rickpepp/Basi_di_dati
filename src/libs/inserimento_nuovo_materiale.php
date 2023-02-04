<?php
    //Inserimento nuovo materiale
    echo '<form action="../libs/processo_inserimento_materiale.php" method="post" name="riepilogo_dipendente">
    <h2>Inserisci Nuovo Materiale</h2><br>
    <label>Nome Materiale<br><input type="text" name="nome" required></label><br>
    <label>Produttore<br><input type="text" name="produttore" required></label><br>
    <label>Peso per Unità<br><input type="number" name="peso" required></label><br>
    <label for="tipologia">Tipologia</label>
    <select name="tipologia" id="tipologia">
        <option value="Materiale Metallico">Materiale Metallico</option>
        <option value="Materiale Polimerico">Materiale Polimerico</option>
        <option value="Materiale Composito">Materiale Composito</option>
    </select>
    <script>
        document.getElementById(\'menu\').style.height = \'120%\';
    </script>
    <footer>
        <input type="submit" value="Inserisci" id="cerca"><br>
        <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
    </footer>
</form>'
?>