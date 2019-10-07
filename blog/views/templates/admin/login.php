<?php
// Login

//  1) Login Formular aufrufen
//  2) ist der User bereits eingeloggt? --> Ja: Redirect auf Admin-Home; Nein: weiter
//      gewünschter Name der Session Variable: $_SESSION['logged_in']
//  3) Zeige Login Formular
//  4) Eingabe durch Benutzer (Benutzername/Email, Passwort)
//  5) Formular abschicken
//  6) Email & Passwort nicht leer? --> Leer: Fehler ausgeben, !Leer: weiter
//  7) Prüfen, ob es einen User mit dieser Email gibt --> Nein: Fehler ausgeben, Ja: weiter
//  8) eingegebenes Passwort hashen
//  9) Eingabe-Hash mit DB-Hash vergleichen --> !==: Fehler ausgeben, ===: weiter
// 10) Session setzen (z.B. logged_in=true)
// 11) Redirect zu Admin-Home

?>
<form class="form-signin col-3">
    <h1 class="h3 font-weight-normal">Login</h1>

    <label for="email" class="sr-only">Email</label>
    <input type="email" id="email" class="form-control" placeholder="Email address" required autofocus>

    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" class="form-control" placeholder="Password" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>
