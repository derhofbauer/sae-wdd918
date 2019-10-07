<?php

ini_set('display_errors', 'On');
error_reporting('E_ALL');

require_once './bootstrap/dbconnect.php';

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
