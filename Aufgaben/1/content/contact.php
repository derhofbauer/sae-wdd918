<?php

if (isset($_POST['do-submit'])) {
    var_dump($_POST);
    $name = $_POST['name'];

    $errors = [];

    if (isset($_POST['email']) && strlen($_POST['email']) > 0) {
        $email = trim($_POST['email']);
        // prüfen, ob es eine email-adresse ist oder nur irgendein string
        if (
                strlen($email) < 5 ||
                strpos($email, '@') < 2 ||
                strpos($email, '.') < strpos($email, '@') + 1
        ) {
            $errors['email'] = 'Bitte geben sie eine VALIDE!! Email-Adresse ein.';
        }
    } else {
        $errors['email'] = 'Bitte Email-Adresse eingeben!';
    }

}

?>

<h2>Contact</h2>

<form method="post">
    
    <div class="group">
        <label for="email">Email *</label>
        <input type="text" name="email">
        <?php
        if (isset($errors['email'])) {
            echo "<p>!!!!!!" . $errors['email'] . "</p>";
        }
        ?>
    </div>
    
    <div class="group">
        <label for="name">Name *</label>
        <input type="text" name="name">
    </div>

    <div class="group">
        <label for="salutation">Anrede</label>
        <select name="salutation" id="salutation">
            <option value="DEFAULT">Bitte wählen ...</option>
            <option value="f">Frau</option>
            <option value="m">Herr</option>
        </select>
    </div>

    <div class="group">
        <label><input type="checkbox" name="newsletter"> Darfs der Newsletter sein?</label>
    </div>

    <div class="group">
        <label for="message">Nachricht</label>
        <textarea name="message" id="message" cols="30" rows="10"></textarea>
    </div>

    <div class="group">
        <input type="submit" name="do-submit" value="fancy submit text">
    </div>

</form>