<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/lang.php';
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title><?= $t['privacy_title'] ?> | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css?v=4.3" />
    <script defer src="https://cloud.umami.is/script.js" data-website-id="caafee2b-2478-4148-8e69-3ebecc18416c"></script>
</head>
<body>

<?php include "includes/header.php"; ?>

<main class="legal-main">

    <!-- HERO -->
    <section class="legal-hero-card">
        <div class="bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="14%" cy="26%" r="46" fill="#65e6ce22"/>
                <circle cx="82%" cy="30%" r="64" fill="#a7c8fd22"/>
                <circle cx="52%" cy="78%" r="40" fill="#7c41ee22"/>
            </svg>
        </div>

        <div class="legal-hero-content">
            <h1><?= $t['privacy_title'] ?></h1>
            <p class="legal-hero-desc"><?= $t['privacy_desc'] ?></p>

            <div class="legal-hero-meta">
                <span>🔐 <?= $t['privacy_meta_gdpr'] ?></span>
                <span>🤖 <?= $t['privacy_meta_bot'] ?></span>
                <span>🌐 <?= $t['privacy_meta_website'] ?></span>
                <span>🇪🇺 <?= $t['privacy_meta_law'] ?></span>
            </div>
        </div>
    </section>

    <!-- MAIN -->
    <section class="legal-main-card">

        <!-- RESPONSIBLE -->
        <div class="legal-section">
            <h2>👤 <?= $t['privacy_responsible_title'] ?></h2>

            <div class="legal-grid">
                <div class="legal-label"><?= $t['privacy_name'] ?></div>
                <div class="legal-value">Stüve, Philipp Lukas</div>

                <div class="legal-label"><?= $t['privacy_address'] ?></div>
                <div class="legal-value">
                    Berliner Straße 25<br>
                    63477 Maintal<br>
                    Deutschland
                </div>

                <div class="legal-label"><?= $t['privacy_email'] ?></div>
                <div class="legal-value">
                    <a href="mailto:support@astra-bot.de">support@astra-bot.de</a>
                </div>
            </div>
        </div>

        <div class="legal-divider"></div>

        <!-- DATA -->
        <div class="legal-section">
            <h2>📊 <?= $t['privacy_data_title'] ?></h2>
            <p class="legal-text"><?= $t['privacy_data_desc'] ?></p>

            <ul class="legal-list">
                <li><?= $t['privacy_data_1'] ?></li>
                <li><?= $t['privacy_data_2'] ?></li>
                <li><?= $t['privacy_data_3'] ?></li>
                <li><?= $t['privacy_data_4'] ?></li>
            </ul>
        </div>

        <div class="legal-divider"></div>

        <!-- PURPOSE -->
        <div class="legal-section">
            <h2>🎯 <?= $t['privacy_purpose_title'] ?></h2>
            <p class="legal-text"><?= $t['privacy_purpose_desc'] ?></p>
        </div>

        <div class="legal-divider"></div>

        <!-- STORAGE & SECURITY -->
        <div class="legal-section legal-two-col">
            <div>
                <h2>🗑️ <?= $t['privacy_storage_title'] ?></h2>
                <p class="legal-text"><?= $t['privacy_storage_desc'] ?></p>
            </div>

            <div>
                <h2>🔒 <?= $t['privacy_security_title'] ?></h2>
                <p class="legal-text"><?= $t['privacy_security_desc'] ?></p>
            </div>
        </div>

    </section>

    <!-- MINI CARDS -->
    <section class="legal-mini-cards">

        <div class="legal-mini-card">
            <h3>🤖 <?= $t['privacy_bot_title'] ?></h3>
            <ul>
                <li><?= $t['privacy_bot_1'] ?></li>
                <li><?= $t['privacy_bot_2'] ?></li>
                <li><?= $t['privacy_bot_3'] ?></li>
            </ul>
            <span class="legal-chip">Art. 6 Abs. 1 lit. b DSGVO</span>
        </div>

        <div class="legal-mini-card">
            <h3>🌐 <?= $t['privacy_website_title'] ?></h3>
            <ul>
                <li><?= $t['privacy_website_1'] ?></li>
                <li><?= $t['privacy_website_2'] ?></li>
                <li><?= $t['privacy_website_3'] ?></li>
            </ul>
        </div>

        <div class="legal-mini-card">
            <h3>⚖️ <?= $t['privacy_rights_title'] ?></h3>
            <ul>
                <li><?= $t['privacy_rights_1'] ?></li>
                <li><?= $t['privacy_rights_2'] ?></li>
                <li><?= $t['privacy_rights_3'] ?></li>
                <li><?= $t['privacy_rights_4'] ?></li>
            </ul>
            <span class="legal-chip">📩 <?= $t['privacy_contact_note'] ?></span>
        </div>

    </section>

</main>

<?php include "includes/footer.php"; ?>

</body>
</html>
