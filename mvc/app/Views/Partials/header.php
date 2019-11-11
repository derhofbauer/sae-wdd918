<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fancy Blog</title>

    <base href="<?php echo $this->baseUrl; ?>">

    <?php echo $this->getCssMarkup(); ?>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Fancy Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=imprint">Impressum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=contact">Kontakt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=categories">Kategorien</a>
                </li>
            </ul>

            <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
                <a href="login">Login</a> or <a href="signup">Signup</a>
            <?php else: ?>
                <span>
                    <?php echo $_SESSION['email']; ?>,
                </span>
                <a href="logout">Logout</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
