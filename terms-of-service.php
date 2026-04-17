

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title><?= $t['terms_title'] ?> | Astra Bot</title>
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
                <circle cx="15%" cy="24%" r="46" fill="#65e6ce22"/>
                <circle cx="85%" cy="30%" r="66" fill="#a7c8fd22"/>
                <circle cx="52%" cy="78%" r="42" fill="#7c41ee22"/>
            </svg>
        </div>

        <div class="legal-hero-content">
            <h1><?= $t['terms_title'] ?></h1>

            <p class="legal-hero-desc"><?= $t['terms_desc'] ?></p>

            <div class="legal-hero-meta">
                <span>📜 <?= $t['terms_meta_terms'] ?></span>
                <span>🤖 <?= $t['terms_meta_bot'] ?></span>
                <span>🌐 <?= $t['terms_meta_website'] ?></span>
                <span>🇪🇺 <?= $t['terms_meta_law'] ?></span>
            </div>
        </div>
    </section>

    <!-- MAIN CARD -->
    <section class="legal-main-card">

        <div class="legal-section">
            <h2>📌 <?= $t['terms_scope_title'] ?></h2>
            <p class="legal-text"><?= $t['terms_scope_desc'] ?></p>
        </div>

        <div class="legal-divider"></div>

        <div class="legal-section">
            <h2>✅ <?= $t['terms_requirements_title'] ?></h2>
            <ul class="legal-list">
                <li><?= $t['terms_req_1'] ?></li>
                <li><?= $t['terms_req_2'] ?></li>
                <li><?= $t['terms_req_3'] ?></li>
            </ul>
        </div>

        <div class="legal-divider"></div>

        <div class="legal-section">
            <h2>🤖 <?= $t['terms_bot_title'] ?></h2>
            <p class="legal-text"><?= $t['terms_bot_desc'] ?></p>
            <ul class="legal-list">
                <li><?= $t['terms_bot_1'] ?></li>
                <li><?= $t['terms_bot_2'] ?></li>
                <li><?= $t['terms_bot_3'] ?></li>
            </ul>
        </div>

        <div class="legal-divider"></div>

        <div class="legal-section">
            <h2>⏱️ <?= $t['terms_availability_title'] ?></h2>
            <p class="legal-text"><?= $t['terms_availability_desc'] ?></p>
        </div>

        <div class="legal-divider"></div>

        <div class="legal-section">
            <h2>⚖️ <?= $t['terms_liability_title'] ?></h2>
            <p class="legal-text"><?= $t['terms_liability_desc'] ?></p>
        </div>

        <div class="legal-divider"></div>

        <div class="legal-section">
            <h2>🚫 <?= $t['terms_block_title'] ?></h2>
            <p class="legal-text"><?= $t['terms_block_desc'] ?></p>
        </div>

        <div class="legal-divider"></div>

        <div class="legal-section">
            <h2>🔄 <?= $t['terms_changes_title'] ?></h2>
            <p class="legal-text"><?= $t['terms_changes_desc'] ?></p>
        </div>

    </section>

    <!-- MINI CARDS -->
    <section class="legal-mini-cards">

        <div class="legal-mini-card">
            <h3>🤖 <?= $t['terms_card_bot_title'] ?></h3>
            <ul>
                <li><?= $t['terms_card_bot_1'] ?></li>
                <li><?= $t['terms_card_bot_2'] ?></li>
                <li><?= $t['terms_card_bot_3'] ?></li>
            </ul>
        </div>

        <div class="legal-mini-card">
            <h3>📜 <?= $t['terms_card_rules_title'] ?></h3>
            <ul>
                <li><?= $t['terms_card_rules_1'] ?></li>
                <li><?= $t['terms_card_rules_2'] ?></li>
                <li><?= $t['terms_card_rules_3'] ?></li>
            </ul>
        </div>

        <div class="legal-mini-card">
            <h3>📩 <?= $t['terms_card_contact_title'] ?></h3>
            <ul>
                <li><?= $t['terms_card_contact_1'] ?></li>
                <li><?= $t['terms_card_contact_2'] ?></li>
            </ul>
            <span class="legal-chip"><?= $t['terms_card_contact_note'] ?></span>
        </div>

    </section>

</main>

<?php include "includes/footer.php"; ?>

</body>
</html>
