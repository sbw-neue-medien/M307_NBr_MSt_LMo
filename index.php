<?php
// Mara: Startseite (index.php)
$pageTitle = 'M307 Praxisarbeit – Home';
require_once __DIR__ . '/includes/header.php';
?>

<div class="home-content">
    <div class="home-hero">
        <h1>M307 Praxisarbeit</h1>
        <p>Willkommen in unserem Onlineshop. Registriere dich, um alle Vorteile zu nutzen.</p>
        <a href="/views/start.php" class="btn btn--primary">Registrieren</a>
    </div>

    <section id="shop" class="impressum-box mb-20">
        <h2>Shop</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </section>

    <section class="impressum-box">
        <h2>Impressum &amp; Datenschutz</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
