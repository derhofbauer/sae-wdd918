<?php

ini_set('display_errors', 'On');
error_reporting('E_ALL');

require_once './bootstrap/dbconnect.php';

/**
 * Routing
 */

$result = mysqli_query($link, "SHOW TABLES;");

while ($row = mysqli_fetch_assoc($result)) {
    echo "<p>" . $row['Tables_in_blog'] . "</p>";
}