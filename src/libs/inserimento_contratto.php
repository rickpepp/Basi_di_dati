<?php
    //Crea form inserimento nuovo dipendente
    echo '<form action="../libs/processo_registrazione.php" method="post" name="signup_form">
            <h2>Inserisci Dipendente</h2><br>
            <label>Nome<br><input type="text" name="nome_registrazione"></label><br>
            <label>Cognome<br><input type="text" name="cognome_registrazione"></label><br>
            <label>Codice Fiscale<br><input type="text" name="codice_fiscale_registrazione"></label><br>
            <label>Numero Telefono<br><input type="number" name="numero_telefono_registrazione"></label><br>
            <label>Email<br><input type="email" name="email_registrazione"></label><br>
            <label for="ruolo">Ruolo:</label><br>
            <select name="ruolo" id="ruolo" onchange="controllo_progettista(value);">
	            <option value="Venditore">Venditore</option>
	            <option value="Addetto Risorse Umane">Addetto Risorse Umane</option>
	            <option value="Operaio">Operaio</option>
	            <option value="Progettista">Progettista</option>
            </select><br>
            <label>Data Assunzione<input type="date" name="data_assunzione" value="2023-01-13"></label><br>
            <label>Costo Dipendente<br><input type="number" name="costo_registrazione"></label><br>
            <label>Livello Contrattuale<br><input type="number" name="livello_registrazione"></label><br>
            <label>Password<input type="password" name="password_registrazione" id="spassword" onkeyup="controllo_password()"></label><br>
            <label>Conferma Password<input type="password" name="cpassword_registrazione" id="check_password" onkeyup="password_uguali()" disabled></label><br>
            <script>
                document.getElementById(\'menu\').style.height = \'200%\';
            </script>
            <footer>
                <p id="informazioni"></p>
                <input type="button" value="Salva" id="rbutton" onclick="formhashr(this.form, this.form.check_password,\'registrazione\');"  disabled><br>
                <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
            </footer>
        </form>'
?>