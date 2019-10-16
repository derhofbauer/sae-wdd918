<?php

/**
 * löscht die komplette Session!
 */
session_destroy();

header('Location: index.php?page=home');
exit;
