<?php
    //Inserimento dati contratto persona esistente
    $array = explode(' ', $_GET['persona']);
    echo '<form action="../libs/processo_registrazione_esistente.php" method="post" name="signup_form">
            <h2>Inserisci Dati Contratto</h2><br>
            <label>Data Assunzione<input type="date" name="data_assunzione" value="2023-01-13"></label><br>
            <label>Costo Dipendente<br><input type="number" name="costo_registrazione"></label><br>
            <label>Livello Contrattuale<br><input type="number" name="livello_registrazione"></label><br>
            <input type="hidden" name="ruolo" value="'.$array[0].'"/>
            <input type="hidden" name="id" value="'.$array[1].'"/>
            <footer>
                <p id="informazioni"></p>
                <input type="submit" value="Inserisci"><br>
                <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
            </footer>
        </form>'
?>