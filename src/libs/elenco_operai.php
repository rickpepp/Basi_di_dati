<?php
    require_once 'database.php';
    require_once 'bootstrap.php';
    require_once 'functions.php';

    sec_session_start();

    //Mostra elenco operai
    if ($dbh -> login_check()) {
        
        $risultati = $dbh -> get_operai();

        echo '<fieldset>
                <legend>Operai</legend>';

        foreach ($risultati as $result) {
            echo '<input type="checkbox" name="'.$result["CodiceOperaio"].'" id="'.$result["CodiceOperaio"].'" value="'.$result["CodiceOperaio"].'"/>
                    <label for="'.$result["CodiceOperaio"].'">'.$result["Nome"].' '.$result["Cognome"].'</label><br/>
                    <script>
                        document.getElementById(\'menu\').style.height = \'140%\';
                    </script>';
        }

        echo '</fieldset>';
        
    }

?>