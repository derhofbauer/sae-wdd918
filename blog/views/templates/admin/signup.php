<?php
// Signup

// 0) User bereits eingeloggt? --> Ja: Redirect, Nein: weiter
// 1) Eingabe durch Benutzer (Benutzername/Email, Passwort)
// 2) Formular abschicken
// 3) Email, Passwort & Passwort2 nicht leer? --> Leer: Fehler ausgeben, !Leer: weiter
// 4) Gültige Email Adresse? --> Ja: weiter, Nein: Fehler ausgeben
// 5) Email Adresse schon in DB vorhanden? --> Ja: Fehler ausgeben, Nein: weiter
// 6) Passwörter ident? --> Ja: weiter, nein: Fehler ausgeben
// 7) Mindestanforderungen prüfen (min. 8 Zeichen, mind. 1 Sonderzeichen, mind. 1 Großbuchstabe, mind. 1 Kleinbuchstabe, mind. 1 Ziffer, kein Whitespace) --> Gültig: weiter, Ungültig: Fehler ausgeben
// 8) Passwörter hashen
// 9) Daten in DB speichern
// 10) Redirect auf Login

$errors = [];

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { // ist der User bereits eingeloggt?
    if (isset($_POST['email'], $_POST['password'], $_POST['password2'])) { // wurde das Formular abgeschickt oder nur die Seite aufgerufen?
        if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password2'])) { // wurden Daten in die Felder eingegeben?
            $errors[] = "Bitte füllen Sie alle Felder aus!";
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
                $errors[] = "Bitte geben Sie eine gültige Email-Adresse ein.";
            }
            $email = strtolower($email);

            // Email schon in DB?
            if (empty($errors)) {
                $result = mysqli_query($link, "SELECT * FROM users WHERE email = '$email'");
                $result_count = mysqli_num_rows($result);

                if ($result_count > 0) {
                    $errors[] = "Diese Email-Adresse wird schon von jemand anderem verwendet :(";
                }
            }

            // Passwörter ident?
            if ($password !== $password2) {
                $errors[] = "Die Passwörter stimmen nicht überein";
            }

            if (empty($errors)) {
                $regex_special_chars = "/[!§$%&._\-*?]+/";
                $regex_uppercase_chars = "/[A-Z]+/";
                $regex_number = "/[0-9]+/";
                $regex_whitespace = "/\s+/";
                $regex_lowercase_chars = "/[a-z]+/";
                if (
                    strlen($password) < 8 ||
                    preg_match($regex_special_chars, $password) !== 1 ||
                    preg_match($regex_uppercase_chars, $password) !== 1 ||
                    preg_match($regex_number, $password) !== 1 ||
                    preg_match($regex_whitespace, $password) === 1 ||
                    preg_match($regex_lowercase_chars, $password) !== 1
                ) {
                    $errors[] = "Das Passwort erfüllt nicht die Kriterien (mind. 1 Uppercase, 1 lowercase, 1 Ziffer, 1 Sonderzeichen, kein Whitespace)";
                }
            }

            if (empty($errors)) {
                $password_hash = password_hash($password, PASSWORD_BCRYPT);

                // prepared statement
                $stmt = mysqli_prepare($link, "INSERT INTO users SET email = ?, password = ?");
                mysqli_stmt_bind_param($stmt, 'ss', $email, $password_hash);

                $result = mysqli_stmt_execute($stmt);

                if ($result === true) {
                    header("Location: index.php?page=login");
                } else {
                    echo mysqli_error($link);
                }
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

    <?php foreach ($errors as $error): ?>
        <p class="alert-danger"><?php echo $error; ?></p>
    <?php endforeach; ?>

    <label for="email" class="sr-only">Email</label>
    <input type="email" id="email" class="form-control" placeholder="Email address" name="email" required autofocus>

    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>

    <label for="password2" class="sr-only">Password repeat</label>
    <input type="password" id="password2" class="form-control" placeholder="Password repeat" name="password2" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
</form>
