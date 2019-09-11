<?php require_once 'partials/header.php'; ?>

<?php

if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page === 'home') {
        require_once 'content/home.php';
    } elseif ($page === 'contact') {
        require_once 'content/contact.php';
    } elseif ($page === 'admin') {
        require_once 'content/admin.php';
    } else {
        echo "Page not found!";
    }
} else {

    // kein Parameter angegeben
    require_once 'content/home.php';
}

?>

<?php require_once 'partials/footer.php'; ?>