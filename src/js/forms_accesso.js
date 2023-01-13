function formhasha(form, password) {
   const msg = document.getElementById('informazioni_accedi');

   //Controllo che i campi non siano stati lasciati vuoti
   if (document.getElementsByName('email_accesso')[0].value === "") {
      msg.innerHTML = "Campo Email Vuoto";
   } else if (document.getElementsByName('password_accesso')[0].value === "") {
      msg.innerHTML = "Campo Password Vuoto";
   } else {
      //Crea campo input hidden con password criptata
      const password_accesso = document.createElement("input");

      form.appendChild(password_accesso);
      password_accesso.name = "password_accesso";
      password_accesso.type = "hidden"
      password_accesso.value = hex_sha512(password.value);
      console.log(hex_sha512(password.value))
      password.value = "";

      //Invia il form definitivamente
      form.submit();
   }
    
 }