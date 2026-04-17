<?php
// --- Bot-Erkennung & Redirect ---
$userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');

// gängige Crawler/Preview-Bots für Embeds
$botRegex = '/discordbot|twitterbot|slackbot|facebookexternalhit|telegrambot|linkedinbot|redditbot|embedly|whatsapp|skypeuripreview|vkshare/';

$isBot = (bool) preg_match($botRegex, $userAgent);

// Normale Nutzer sofort weiterleiten (302; nimm 301, wenn dauerhaft)
if (!$isBot) {
    header('Location: https://discord.gg/eatdJPfjWc', true, 302);
    exit;
}

// Bots bekommen eine HTML-Seite mit Open-Graph-Meta
header('Content-Type: text/html; charset=utf-8');
// Caching für Previews ok (10 Min.), aber nicht indexieren
header('Cache-Control: public, max-age=600');
header('X-Robots-Tag: noindex, nofollow');

// Stabiles Bild ohne expiring Query-Parameter:
$ogImage = 'https://cdn.discordapp.com/attachments/1113404918414458991/1405915180881285172/Idee_2_blau.jpg';
// Tipp: Am besten eigenes, dauerhaftes Bild hosten, z. B. https://astra-bot.de/static/og/astrabot.jpg
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Astra Support-Server</title>
    <link rel="canonical" href="https://astra-bot.de/support">

    <!-- Open Graph -->
    <meta property="og:locale" content="de_DE">
    <meta property="og:site_name" content="Astra">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://astra-bot.de/support">
    <meta property="og:title" content="Astra Support-Server">
    <meta property="og:description" content="Tritt dem offiziellen Astra Support-Server bei – Community, Hilfe & Updates direkt vom Team.">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Astra Support-Server">
    <meta name="twitter:description" content="Community, Hilfe & Updates direkt vom Astra-Team.">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root { color-scheme: dark; }
        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, 'Noto Sans', Arial, sans-serif;
            display: grid; place-items: center;
            min-height: 100vh; margin: 0;
            background: #0d1117; color: #fff; text-align: center;
        }
        .card {
            background: rgba(255,255,255,0.06);
            padding: 2rem; border-radius: 14px; max-width: 520px;
            box-shadow: 0 10px 30px rgba(0,0,0,.35);
        }
        a.btn {
            display: inline-block; margin-top: 1rem; padding: .8rem 1.2rem;
            background: #5865F2; color: #fff; border-radius: 10px; text-decoration: none; font-weight: 700;
        }
        a.btn:hover { background: #4752C4; }
        p { margin: .25rem 0 0; opacity: .9; }
    </style>
    <script defer src="https://cloud.umami.is/script.js" data-website-id="caafee2b-2478-4148-8e69-3ebecc18416c"></script>
</head>
<body>
<div class="card">
    <h1>🛠 Astra Support-Server</h1>
    <p>Community, Hilfe &amp; Updates direkt vom Astra-Team.</p>
    <a class="btn" href="https://discord.gg/eatdJPfjWc">Server beitreten</a>
</div>
</body>
</html>
