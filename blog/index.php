<?php

ini_set('display_errors', 'On');
error_reporting('E_ALL');

/**
 * Output Buffering einschalten, damit wir zu jedem Zeitpunkt die header()-Funktion verwenden können.
 */
ob_start();

require_once './bootstrap/dbconnect.php';
require_once './bootstrap/session.php';

/**
 * Routing
 */

/*$result = mysqli_query($link, "SHOW TABLES;");

while ($row = mysqli_fetch_assoc($result)) {
    echo "<p>" . $row['Tables_in_blog'] . "</p>";
}*/

require_once 'views/partials/header.php';

// Content Loading
if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'post':
            require_once 'views/templates/post.detail.php';
            break; // break ist sehr wichtig, weil sonst der nächste Case aufgerufen wird
        case 'category':
            require_once 'views/templates/category.php';
            break;
        case 'categories':
            require_once 'views/templates/categories.php';
            break;
        case 'login':
            require_once 'views/templates/admin/login.php';
            break;
        case 'logout':
            require_once 'views/templates/admin/logout.php';
            break;
        case 'signup':
            require_once 'views/templates/admin/signup.php';
            break;
        case 'post-edit':
            require_once 'views/templates/admin/post.edit.php';
            break;
        case 'home':
            // hier verwenden wir kein break, damit das selbe passiert wie im "default" case
        default:
            require_once 'views/templates/home.php';
            break;
    }
} else {
    require_once 'views/templates/home.php';
}


require_once 'views/partials/footer.php';

/**
 * Buffer an den Browser schicken
 */
ob_end_flush();
