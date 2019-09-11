<?php require_once 'partials/header.php'; ?>

<?php

/**
 * Die index.php ist die einzige Datei, an der Requests ankommen. Im Folgenden wird anhand des GET-Parameters 'page'
 * entschieden, welcher Inhalt geladen wird.
 *
 * Die header.php und die footer.php werden auch nur noch in dieser Datei eingebunden, weil in den Dateien im Content
 * Ordner nur noch der reine Inhalt der Seiten steht.
 */
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page === 'home') {
        require_once 'content/home.php';
    } elseif ($page === 'contact') {
        require_once 'content/contact.php';
    } elseif ($page === 'admin') {
        require_once 'content/admin.php';
    } else { // der GET-Parameter 'page' hat einen Wert, zu dem wir keinen Inhalt haben.
        echo "Page not found!";
    }
} else { // der GET-Parameter 'page' wurde nicht angegeben
    require_once 'content/home.php';
}

?>

<?php require_once 'partials/footer.php'; ?>