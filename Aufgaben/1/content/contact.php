<?php

if (isset($_POST['do-submit'])) { // wenn das Formular abgeschickt wurde
    var_dump($_POST);
    $name = $_POST['name'];

    /**
     * brauchen wir später
     */
    $errors = [];

    /**
     * Validierung: Email Feld
     */
    if (isset($_POST['email']) && strlen($_POST['email']) > 0) { // wenn eine Email-Adresse angegeben wurde
        $email = trim($_POST['email']); // Whitespace am Anfang und Ende wegschneiden

        /**
         * prüfen, ob es der eingegebene Wert eine Email-Adresse sein könnte oder nicht
         *
         * Hinweis: die Bedingungen in dem if-Block stehen in mehreren Zeilen, damit der Code übersichtlicher ist
         * und nicht die ganze if-Zeile ewig lang wird :)
         */
        if (
                strlen($email) < 5 ||
                strpos($email, '@') < 2 ||
                strpos($email, '.') < strpos($email, '@') + 1
        ) {
            $errors['email'] = 'Bitte geben sie eine VALIDE!! Email-Adresse ein.';
        }
    } else { // es wurde keine Email-Adresse angegeben
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
        /**
         * Wenn es es einen Fehler zur Email-Adresse gibt, zeigen wir ihn hier an.
         *
         * Hinweis: die Rufzeichen dienen nur dazu, dass wir im Browser den Fehler sofort als solchen sehen. In der
         * Praxis machen wir natürlich keine Rufzeichen, sondern lassen den Fehler mit CSS hübsch aber warnend ausschauen.
         */
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