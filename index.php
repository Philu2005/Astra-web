<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/lang.php';
?>

<?php
// Funktion um .env zu laden
function loadEnv($path) {
    if (!file_exists($path)) {
        die(".env Datei nicht gefunden!");
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Kommentare überspringen
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
    return $env;
}

// Lade die .env (Pfad anpassen falls nötig)
$env = loadEnv(__DIR__ . '/.env');

// Benutze die geladenen Variablen
$servername = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$dbname = $env['DB_NAME'];

// Verbindung herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung prüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Beispiel-Abfrage
$sql = "SELECT id, servercount, usercount, commandCount, channelCount FROM website_stats";
$result = $conn->query($sql);

// Daten auslesen
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $servercount = $row['servercount'];
        $usercount = $row['usercount'];
        $commandCount = $row['commandCount'];
        $channelCount = $row['channelCount'];
    }
} else {
    $servercount = 0;
    $usercount = 0;
    $commandCount = 0;
    $channelCount = 0;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Astra | Discord Bot</title>
    <meta name="description" content="Astra – All-in-One Discord Bot mit Levelsystem, Economy, Moderation, Tickets, Mini-Games & mehr.">
    <meta name="theme-color" content="#251f5b">
    <link rel="icon" href="/public/favicon_transparent.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css?v=2.4"/>
    <meta property="og:title" content="Astra | Discord Bot">
    <meta property="og:description" content="All-in-One Discord Bot mit Levels, Economy, Moderation, Tickets, Mini-Games & mehr.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://astra-bot.de/">
    <meta property="og:image" content="https://astra-bot.de/public/og-image.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/png">
    <script defer src="https://cloud.umami.is/script.js" data-website-id="caafee2b-2478-4148-8e69-3ebecc18416c"></script>
</head>
<body>

<script>
    if (window.self !== window.top) {
        const loader = document.getElementById('astra-loader');
        if (loader) loader.remove();
    }
</script>

<div id="astra-loader">
    <div class="astra-loader-bg"></div>

    <!-- Floating bubbles -->
    <div class="astra-loader-bubbles">
        <span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="astra-loader-core">
        <div class="astra-loader-ring"></div>
        <img src="/public/favicon_transparent.png" class="astra-loader-logo" alt="Astra">
        <span class="astra-loader-text">Booting Astra</span>
    </div>
</div>


<?php include "includes/header.php"; ?>


<main>
    <!-- HERO -->
    <section id="hero" class="astra-hero-card">
        <div class="bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="18%" cy="18%" r="38" fill="#65e6ce33"/>
                <circle cx="90%" cy="25%" r="64" fill="#a7c8fd22"/>
                <circle cx="52%" cy="77%" r="44" fill="#7c41ee22"/>
                <circle cx="95%" cy="90%" r="24" fill="#7c41ee22"/>
                <circle cx="6%" cy="89%" r="41" fill="#60e9cb22"/>
            </svg>
        </div>

        <div class="astra-hero-content">
            <div>
                <div class="astra-label-row">
                    <span class="astra-label green"><?= $t['label_level'] ?></span>
                    <span class="astra-label blue"><?= $t['label_mod'] ?></span>
                    <span class="astra-label yellow"><?= $t['label_eco'] ?></span>
                </div>

                <h1 class="hero-headline">
                    <span class="headline-static"><?= $t['hero_static'] ?></span>
                    <span id="typing-text" class="headline-dynamic"></span>
                </h1>

                <div class="astra-desc">
                    <b><?= $t['hero_title'] ?></b><br>
                    <?= $t['hero_desc'] ?>
                </div>

                <div class="astra-btn-row">
                    <a href="/invite.php" class="astra-btn main"><?= $t['invite_bot'] ?></a>
                    <a href="/support.php" class="astra-btn outline"><?= $t['support_server'] ?></a>
                </div>

                <div class="astra-badges-row">
                    <span class="astra-badge mint"><?= $t['badge_xp'] ?></span>
                    <span class="astra-badge violet"><?= $t['badge_games'] ?></span>
                    <span class="astra-badge yellow"><?= $t['badge_tickets'] ?></span>
                    <span class="astra-badge blue"><?= $t['badge_automod'] ?></span>
                </div>

                <div class="cta-absatz">
                    <b><?= $t['hero_cta'] ?></b>
                </div>
            </div>

            <div>
                <img src="/public/favicon_transparent.png" alt="Astra Logo" class="astra-hero-logo">
            </div>
        </div>
    </section>

    <!-- STATS -->
    <section id="stats" class="astra-stats">
        <div class="stat-card">
            <span class="stat-num" data-val="<?= $servercount ?>">0</span>
            <div class="stat-title"><?= $t['servers'] ?></div>
        </div>
        <div class="stat-card">
            <span class="stat-num" data-val="<?= $usercount ?>">0</span>
            <div class="stat-title"><?= $t['users'] ?></div>
        </div>
        <div class="stat-card">
            <span class="stat-num" data-val="<?= $commandCount ?>">0</span>
            <div class="stat-title"><?= $t['commands'] ?></div>
        </div>
        <div class="stat-card">
            <span class="stat-num" data-val="<?= $channelCount ?>">0</span>
            <div class="stat-title"><?= $t['channels'] ?></div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="astra-about-card">
        <div class="about-img-wrap">
            <img src="/public/favicon_transparent.png" alt="Astra About" class="about-img">
        </div>
        <div>
            <h2><?= $t['about_title'] ?></h2>
            <p><?= $t['about_text'] ?></p>
            <ul>
                <?php foreach ($t['about_list'] as $item): ?>
                    <li><?= $item ?></li>
                <?php endforeach; ?>
            </ul>
            <a href="/commands" class="about-link"><?= $t['about_link'] ?></a>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="astra-features-grid">
        <div class="feature-card">
            <div class="feature-title green"><?= $t['feature_level'] ?></div>
            <div><?= $t['feature_level_desc'] ?></div>
        </div>
        <div class="feature-card">
            <div class="feature-title yellow"><?= $t['feature_eco'] ?></div>
            <div><?= $t['feature_eco_desc'] ?></div>
        </div>
        <div class="feature-card">
            <div class="feature-title blue"><?= $t['feature_mod'] ?></div>
            <div><?= $t['feature_mod_desc'] ?></div>
        </div>
        <div class="feature-card">
            <div class="feature-title violet"><?= $t['feature_tools'] ?></div>
            <div><?= $t['feature_tools_desc'] ?></div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="astra-faq-section">
        <h2><?= $t['faq_title'] ?></h2>
        <div class="faq-list">
            <?php foreach ($t['faq'] as $faq): ?>
                <div class="faq-item">
                    <button class="faq-question"><?= $faq['q'] ?></button>
                    <div class="faq-answer"><?= $faq['a'] ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>


<?php include "includes/footer.php";?>

<script>
    (function () {

        const loader = document.getElementById('astra-loader');
        const KEY = 'astra_loader_shown';

        // Nur beim ersten Besuch
        if (sessionStorage.getItem(KEY)) {
            loader.remove();
            return;
        }

        sessionStorage.setItem(KEY, 'true');

        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.add('hide');
                setTimeout(() => loader.remove(), 500);
            }, 1300); // fühlt sich smooth an, nicht künstlich
        });

    })();
</script>


<script>
    const navToggle = document.querySelector('.astra-nav-toggle');
    navToggle.addEventListener('click', () => {
        document.body.classList.toggle('nav-open');
        // aria-expanded toggle
        const expanded = navToggle.getAttribute('aria-expanded') === 'true';
        navToggle.setAttribute('aria-expanded', !expanded);
    });
</script>

<!-- FAQ Dropdown Script -->
<script>
    document.querySelectorAll('.faq-question').forEach(q => {
        q.addEventListener('click', function() {
            const item = this.parentElement;
            const answer = item.querySelector('.faq-answer');

            if (item.classList.contains('open')) {
                answer.style.maxHeight = null;
                item.classList.remove('open');
            } else {
                // Alle anderen schließen
                document.querySelectorAll('.faq-item.open').forEach(openItem => {
                    openItem.classList.remove('open');
                    openItem.querySelector('.faq-answer').style.maxHeight = null;
                });

                // Dieses öffnen
                answer.style.maxHeight = answer.scrollHeight + "px";
                item.classList.add('open');
            }
        });
    });
</script>
<!-- Counter Animation -->
<script>
    document.querySelectorAll('.stat-num').forEach(el => {
        const end = +el.getAttribute('data-val');
        let n = 0, step = Math.max(1, Math.floor(end / 40));
        const inc = () => {
            n += step;
            if(n >= end) { el.textContent = end; }
            else { el.textContent = n; requestAnimationFrame(inc); }
        };
        inc();
    });
</script>
<!-- Scrollto Script (smooth scroll for nav) -->
<script>
    document.querySelectorAll('.scrollto').forEach(link => {
        link.addEventListener('click', function(e) {
            const id = this.getAttribute('href').split('#')[1];
            const target = document.getElementById(id);
            if (target) {
                e.preventDefault();
                window.scrollTo({ top: target.offsetTop - 80, behavior: 'smooth' });
                document.body.classList.remove('nav-open');
            }
        });
    });
</script>
<script>
    const navToggle = document.querySelector('.astra-nav-toggle');

    navToggle.addEventListener('click', (e) => {
        e.stopPropagation();

        body.classList.toggle('nav-open');

        const expanded = navToggle.getAttribute('aria-expanded') === 'true';
        navToggle.setAttribute('aria-expanded', String(!expanded));

        // Sofort Fokus entfernen, damit :focus oder :active nicht hängen bleiben
        navToggle.blur();
    });
</script>
<script>
    const words = [
        "modern.",
        "zuverlässig.",
        "effizient.",
        "modular.",
        "stabil.",
        "innovativ."
    ];

    const el = document.getElementById("typing-text");

    let wordIndex = 0;
    let charIndex = 0;
    let state = "typing";

    const typingSpeed = 90;
    const deletingSpeed = 50;
    const pauseAfterTyping = 1400;
    const pauseAfterDeleting = 400;

    function loop() {
        const word = words[wordIndex];

        if (state === "typing") {
            el.textContent = word.slice(0, charIndex + 1);
            charIndex++;

            if (charIndex === word.length) {
                state = "pause";
                setTimeout(() => state = "deleting", pauseAfterTyping);
            }
        }
        else if (state === "deleting") {
            el.textContent = word.slice(0, charIndex - 1);
            charIndex--;

            if (charIndex === 0) {
                state = "pause";
                wordIndex = (wordIndex + 1) % words.length;
                setTimeout(() => state = "typing", pauseAfterDeleting);
            }
        }

        setTimeout(loop, state === "typing" ? typingSpeed : deletingSpeed);
    }

    loop();
</script>
<script>
    const words = <?= json_encode($t['typing_words']) ?>;
</script>
</body>
</html>
