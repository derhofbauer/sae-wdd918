<?php
// Login

//  1) ~~Login Formular aufrufen~~
//  2) ist der User bereits eingeloggt? --> ~~Ja: Redirect auf Admin-Home~~; Nein: weiter
//      gewünschter Name der Session Variable: $_SESSION['logged_in']
//  3) ~~Zeige Login Formular~~
//  4) Eingabe durch Benutzer (Benutzername/Email, Passwort)
//  5) Formular abschicken
//  6) Email & Passwort nicht leer? --> Leer: Fehler ausgeben, !Leer: weiter
//  7) Prüfen, ob es einen User mit dieser Email gibt --> Nein: Fehler ausgeben, Ja: weiter
//  8) eingegebenes Passwort hashen
//  9) Eingabe-Hash mit DB-Hash vergleichen --> !==: Fehler ausgeben, ===: weiter
// 10) Session setzen (z.B. logged_in=true)
// 11) Redirect zu Admin-Home

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    /**
     * Haben wir Daten bekommen oder war das der erste Aufruf des Login-Formulars?
     */
    if (isset($_POST['email'], $_POST['password'])) { // das Formular wurde abgeschickt und wir haben daher Daten bekommen
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $error = "Bitte geben Sie Email UND Passwort ein.";
        } else {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $result = mysqli_query($link, "SELECT * FROM users WHERE email = '$email'");

            $result_count = mysqli_num_rows($result);
            $result_user = mysqli_fetch_assoc($result); // array
            if ($result_count === 1 && password_verify($password, $result_user['password'])) { // Account existiert UND Passwort stimmt
                $_SESSION['logged_in'] = true;
                $_SESSION['email'] = $result_user['email'];

                header('Location: index.php?page=admin');
                exit;
            } else {
                // Passwort stimmt nicht ODER Account existiert nicht
                $error = "Benutzername oder Passwort falsch";
            }
        }
    } else {
        // das war der erste Aufruf des Formulars, wir zeigen es einfach nur an und machen hier daher überhaupt nichts
    }
} else {
    header('Location: index.php?page=admin');
    exit;
}


?>
<form class="form-signin col-3" action="index.php?page=login" method="post">
    <h1 class="h3 font-weight-normal">Login</h1>

    <?php if (isset($error)): ?>
        <p class="alert-danger"><?php echo $error; ?></p>
    <?php endif; ?>

    <label for="email" class="sr-only">Email</label>
    <input type="email" id="email" class="form-control" placeholder="Email address" name="email" required autofocus>

    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>
