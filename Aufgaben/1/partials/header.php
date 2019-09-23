<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <?php
    /**
     * Wenn ein HTML Redirect durchgeführt werden soll, geschieht das an dieser Stelle. Der Click wird aber in der
     * includes/redirect.php registriert.
     */
    ?>
    <?php if (isset($_GET['url']) && isset($_GET['html_redirect']) && $_GET['html_redirect'] == "true"): ?>
        <meta http-equiv="refresh" content="2; URL=<?php echo urldecode($_GET['url']) ?>/">
    <?php endif; ?>
</head>
<body>
<header>
    <h1>Fancy Seite</h1>

    <?php require_once 'nav.php'; ?>
</header>

<main>