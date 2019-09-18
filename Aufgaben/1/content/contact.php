<?php

function errorMessage (string $key, $errors = []) {
    if (isset($errors[$key])) {
        echo "<p>!!!!!!" . $errors[$key] . "</p>";
    }
}

if (isset($_POST['do-submit'])) { // wenn das Formular abgeschickt wurde
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
                strpos($email, '.', strpos($email, '@')) < 1
        ) {
            $errors['email'] = 'Bitte geben sie eine VALIDE!! Email-Adresse ein.';
        }
    } else { // es wurde keine Email-Adresse angegeben
        $errors['email'] = 'Bitte Email-Adresse eingeben!';
    }

    /**
     * Validierung: Name
     */
    if (isset($_POST['name']) && strlen($_POST['name']) < 2) {
        $errors['name'] = 'Bitte geben Sie einen gültigen Namen an!';
    }

    /**
     * Validierung: Anrede
     */
    if (isset($_POST['salutation']) && $_POST['salutation'] === 'DEFAULT') {
        $errors['salutation'] = 'Bitte auswählen!';
    }

    /**
     * Validierung: Nachricht
     */
    if (isset($_POST['message']) && strlen($_POST['message']) < 10) {
        $errors['message'] = 'Bitte geben Sie eine vernünftige, hilfreiche Nachricht ein, was soll den das?!';
    }

    /**
     * Newsletter Abo
     */
    $newsletter = false;
    if (isset($_POST['newsletter']) && $_POST['newsletter'] === 'on') {
        $newsletter = true;
    }
}

?>

<h2>Contact</h2>

<form method="post">

    <?php

    if (isset($errors) && count($errors) === 0) {
        $successMessage = '';
        if ($newsletter === true) {
            $successMessage = 'Formular erfolgreich abgeschickt und Newsletter aboniert!';
        } else {
            $successMessage = 'Formular erfolgreich abgeschickt. Sicher, dass Sie den Newsletter nicht möchten?';
        }

        echo "<p class=\"success\">$successMessage</p>";
    }

    ?>
    
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
//        if (isset($errors['email'])) {
//            echo "<p>!!!!!!" . $errors['email'] . "</p>";
//        }
        errorMessage('email', $errors);
        ?>
    </div>
    
    <div class="group">
        <label for="name">Name *</label>
        <input type="text" name="name">
        <?php
        errorMessage('name', $errors);
        ?>
    </div>

    <div class="group">
        <label for="salutation">Anrede</label>
        <select name="salutation" id="salutation">
            <option value="DEFAULT">Bitte wählen ...</option>
            <option value="f">Frau</option>
            <option value="m">Herr</option>
        </select>
        <?php
        errorMessage('salutation', $errors);
        ?>
    </div>

    <div class="group">
        <label><input type="checkbox" name="newsletter"> Darfs der Newsletter sein?</label>
    </div>

    <div class="group">
        <label for="message">Nachricht</label>
        <textarea name="message" id="message" cols="30" rows="10"></textarea>
        <?php
        errorMessage('message', $errors);
        ?>
    </div>

    <div class="group">
        <input type="submit" name="do-submit" value="fancy submit text">
    </div>

</form>