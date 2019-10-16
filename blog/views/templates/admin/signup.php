<?php
// Signup

// 0) User bereits eingeloggt? --> Ja: Redirect, Nein: weiter
// 1) Eingabe durch Benutzer (Benutzername/Email, Passwort)
// 2) Formular abschicken
// 3) Email, Passwort & Passwort2 nicht leer? --> Leer: Fehler ausgeben, !Leer: weiter
// 4) Gültige Email Adresse? --> Ja: weiter, Nein: Fehler ausgeben
// 5) Email Adresse schon in DB vorhanden? --> Ja: Fehler ausgeben, Nein: weiter
// 6) Passwörter ident? --> Ja: weiter, nein: Fehler ausgeben
// 7) Mindestanforderugen prüfen (min. 8 Zeichen, mind. 1 Sonderzeichen, mind. 1 Großbuchstabe, mind. 1 Ziffer, kein Whitespace) --> Gültig: weiter, Ungültig: Fehler ausgeben
// 8) Passwörter hashen
// 9) Daten in DB speichern
// 10) Redirect auf Login

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { // ist der User bereits eingeloggt?
    if (isset($_POST['email'], $_POST['password'], $_POST['password2'])) { // wurde das Formular abgeschickt oder nur die Seite aufgerufen?
        if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password2'])) { // wurden Daten in die Felder eingegeben?
            $error = "Bitte füllen Sie alle Felder aus!";
        } else {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            /**
             * Diese Regular Expression ist alles andere als perfekt, sie deckt nicht alle Möglichkeiten ab. Eine
             * "korrekte" Expression für Emails ist wesentlich länger und komplexer (s. https://www.regular-expressions.info/email.html).
             */
            $regex_email = "/^[a-zA-Z0-9_]+\.?\w+@\w+\.[a-zA-Z]{2,10}$/";
            if (preg_match($regex_email, $email) !== 1) {
                $error = "Bitte geben Sie eine gültige Email-Adresse ein.";
            }
        }
    }
} else {
    header('Location: index.php?page=admin');
    exit;
}

?>

<form class="form-signin col-3" action="index.php?page=signup" method="post">
    <h1 class="h3 font-weight-normal">Signup</h1>

    <?php if (isset($error)): ?>
        <p class="alert-danger"><?php echo $error; ?></p>
    <?php endif; ?>

    <label for="email" class="sr-only">Email</label>
    <input type="email" id="email" class="form-control" placeholder="Email address" name="email" required autofocus>

    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>

    <label for="password2" class="sr-only">Password repeat</label>
    <input type="password" id="password2" class="form-control" placeholder="Password repeat" name="password2" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
</form>
