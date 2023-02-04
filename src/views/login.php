<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Printing Farm</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="icon" type="img/png" href="#" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script type="text/javascript" src="../js/sha512.js"></script>
        <script type="text/javascript" src="../js/forms_accesso.js"></script>
    </head>
    <body class="centered">
        <header>
            <h1>Printing Farm</h1>
        </header>
        <main>
            <form action="../libs/processo_login.php" method="post" name="login_form">
                <h2>Effettua l'accesso</h2><br>
                <label>Email<br><input type="text" name="email_accesso"></label><br>
                <label>Password<br><input type="password" name="password_accesso" id="lpassword"></label>
                <input type="hidden" name="r" value="<?php echo $_GET['r'] ?>">
                <footer>
                    <input type="button" value="Accedi" onclick="formhasha(this.form, this.form.lpassword);">
                    <p id="informazioni_accedi"></p>
                    <input type="button" value="Indietro" onclick="javascript:history.go(-1)"><br>
                </footer>
                <style>
                    html {
                        height: 200%;
                    }
                </style>
            </form>
        </main>
    </body>
</html>