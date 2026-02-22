<?php
// --- Bot-Erkennung & Redirect ---
$userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
$botRegex  = '/discordbot|twitterbot|slackbot|facebookexternalhit|telegrambot|'
    . 'linkedinbot|redditbot|embedly|whatsapp|skypeuripreview|vkshare/';

$isBot = (bool) preg_match($botRegex, $userAgent);

// Browser-User direkt zur Invite-URL (302; für dauerhaft -> 301)
if (!$isBot) {
    header('Location: https://discord.com/oauth2/authorize?client_id=1113403511045107773&permissions=2255511571262711&integration_type=0&scope=bot+applications.commands', true, 302);
    exit;
}

// Bots bekommen HTML mit OG/Twitter-Metas
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: public, max-age=600'); // 10 Minuten Cache für Previews
header('X-Robots-Tag: noindex, nofollow');

// Stabile Assets (ohne expiring Query-Parameter)
$ogImage = 'https://cdn.discordapp.com/attachments/1113404918414458991/1405915180881285172/Idee_2_blau.jpg';
$bgImage = 'https://cdn.discordapp.com/attachments/1113404918414458991/1405915181220892733/Profilbanner.gif';
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Astra – Dein All-in-One Discord-Bot</title>
    <link rel="canonical" href="https://astra-bot.de/invite">

    <!-- Open Graph -->
    <meta property="og:locale" content="de_DE">
    <meta property="og:site_name" content="Astra">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://astra-bot.de/invite">
    <meta property="og:title" content="Astra – Dein All-in-One Discord-Bot">
    <meta property="og:description" content="Neueröffnung mit Backup-System, Notifier, Minigames, Level 2.0 und Economy 2.0 – lade Astra jetzt auf deinen Server ein.">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Astra – Dein All-in-One Discord-Bot">
    <meta name="twitter:description" content="Neueröffnung mit Backup-System, Notifier, Minigames, Level 2.0 und Economy 2.0 – lade Astra jetzt auf deinen Server ein.">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root { color-scheme: dark; }
        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, 'Noto Sans', Arial, sans-serif;
            display: grid; place-items: center;
            min-height: 100vh; margin: 0; text-align: center; color: #fff;
            background: #0d1117 url('<?= htmlspecialchars($bgImage, ENT_QUOTES) ?>') no-repeat center/cover;
        }
        .card {
            background: rgba(0,0,0,.55);
            -webkit-backdrop-filter: blur(4px); backdrop-filter: blur(4px);
            padding: 2rem; border-radius: 14px; max-width: 560px;
            box-shadow: 0 10px 30px rgba(0,0,0,.35);
        }
        h1 { margin: 0 0 .5rem }
        p { margin: 0 0 1rem; opacity: .95 }
        a.btn {
            display: inline-block; padding: .85rem 1.25rem;
            border-radius: 10px; font-weight: 700; text-decoration: none;
            background: #5865F2; color: #fff;
        }
        a.btn:hover { background: #4752C4; }
    </style>
</head>
<body>
<div class="card">
    <h1>🚀 Astra – Dein All-in-One Discord-Bot</h1>
    <p>Backup-System · Notifier · Minigames · Level&nbsp;2.0 · Economy&nbsp;2.0</p>
    <a class="btn" href="https://discord.com/oauth2/authorize?client_id=1113403511045107773&permissions=2255511571262711&integration_type=0&scope=bot+applications.commands">Bot einladen</a>
</div>
</body>
</html>
