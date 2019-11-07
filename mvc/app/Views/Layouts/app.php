<?php
/**
 * Header laden
 */
require_once __DIR__ . '/../Partials/header.php';
?>

<main id="main" class="container">
    <?php
    /**
     * Layouts sind die größten Einheiten unserer Template-Struktur. Darin kommen Templates und diese Templates sind aus
     * Partials zusammengebaut. Wir laden also in der View Klasse das Layout und das Layout lädt an dieser Stelle erst
     * das gewünschte Template. Dabei sind wir immernoch im Scope der View->render() Methode.
     */
    require_once __DIR__ . "/../Templates/$templatePath.php";
    ?>
</main>

<?php
/**
 * Footer laden
 */
require_once __DIR__ . '/../Partials/footer.php';
?>
