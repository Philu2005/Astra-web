<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/lang.php';

function loadEnv(string $path): array {
    if (!file_exists($path)) {
        die(".env Datei nicht gefunden!");
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        $trim = trim($line);
        if ($trim === '' || $trim[0] === '#' || strpos($trim, '=') === false) continue;
        list($key, $value) = explode('=', $trim, 2);
        $env[trim($key)] = trim($value);
    }
    return $env;
}

// ENV laden
$env = loadEnv($_SERVER['DOCUMENT_ROOT'] . '/.env');

// DB Connect
$conn = @new mysqli(
    $env['DB_SERVER'] ?? '',
    $env['DB_USER'] ?? '',
    $env['DB_PASS'] ?? '',
    $env['DB_NAME'] ?? ''
);

$stats = [
    'servercount' => 0,
    'usercount' => 0,
    'commandCount' => 0,
    'channelCount' => 0
];

if ($conn && !$conn->connect_error) {
    $res = $conn->query("SELECT servercount, usercount, commandCount, channelCount FROM website_stats LIMIT 1");
    if ($res && $res->num_rows) {
        $stats = $res->fetch_assoc();
    }
    $conn->close();
}

// Bot Status prüfen
$bot_online = false;
try {
    $json = @file_get_contents('http://localhost:5000/status');
    if ($json) {
        $data = json_decode($json, true);
        $bot_online = (json_last_error() === JSON_ERROR_NONE && !empty($data['online']));
    }
} catch (Exception $e) {}

$system_status = [
    'api' => $bot_online,
    'database' => true,
    'commands' => $bot_online
];

$recent_activity = [];

if ($stats['servercount'] > 0) {
    $recent_activity[] = "Bot ist aktuell auf {$stats['servercount']} Servern aktiv";
}
if ($stats['usercount'] > 0) {
    $recent_activity[] = "Über {$stats['usercount']} Nutzer nutzen Astra Bot";
}
$recent_activity[] = "Dashboard erfolgreich geladen";

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None'
]);

session_start();

session_start();

if (!isset($_SESSION['access_token'])) {
    header("Location: /login/discord.php");
    exit;
}

function discord_api($endpoint) {
    $token = $_SESSION['access_token'];
    $ctx = stream_context_create([
        "http" => [
            "header" => "Authorization: Bearer $token"
        ]
    ]);
    return json_decode(
        file_get_contents("https://discord.com/api/$endpoint", false, $ctx),
        true
    );
}

/* =========================
   🔥 NEU: DISCORD USER + ADMIN SERVER
========================= */
$discord_user = discord_api("users/@me");
$discord_guilds = discord_api("users/@me/guilds");

$managed_servers = [];

if (is_array($discord_guilds)) {
    foreach ($discord_guilds as $guild) {

        // Admin Permission (0x8)
        if ((($guild['permissions'] ?? 0) & 0x8) !== 0x8) {
            continue;
        }

        $gid = $guild['id'];

        $api = @file_get_contents("http://localhost:5000/servers/$gid");
        if (!$api) continue;

        $api_data = json_decode($api, true);
        if (!empty($api_data['success'])) {
            $managed_servers[] = $api_data['server'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Astra Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css?v=5.0">
</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<main class="dashboard-page">
    <div class="dashboard-wrapper">
        <div class="dashboard">

            <?php include $_SERVER['DOCUMENT_ROOT'].'/dashboard/includes/dashboard-sidebar.php'; ?>

            <section class="dashboard-content">

                <header class="dashboard-header">
                    <div>
                        <h1>Overview</h1>
                        <p class="dashboard-subtitle">Überblick über deinen Astra Bot Status</p>
                    </div>
                    <div class="dashboard-actions">
                        <button id="btn-refresh" class="dashboard-btn secondary">Refresh</button>
                        <button id="btn-invite" class="dashboard-btn primary">Invite Bot</button>
                    </div>
                </header>

                <section class="dashboard-stats">
                    <div class="dashboard-stat" data-count="<?= (int)$stats['servercount'] ?>"><span>Servers</span><strong>0</strong></div>
                    <div class="dashboard-stat" data-count="<?= (int)$stats['usercount'] ?>"><span>Users</span><strong>0</strong></div>
                    <div class="dashboard-stat" data-count="<?= (int)$stats['commandCount'] ?>"><span>Commands</span><strong>0</strong></div>
                </section>

                <section class="dashboard-panels">

                    <div class="dashboard-panel">
                        <h3>System Status</h3>
                        <ul>
                            <li><?= $system_status['api'] ? '🟢' : '🔴' ?> API</li>
                            <li><?= $system_status['commands'] ? '🟢' : '🔴' ?> Commands</li>
                            <li><?= $system_status['database'] ? '🟢' : '🔴' ?> Datenbank</li>
                        </ul>
                    </div>

                    <div class="dashboard-panel">
                        <h3>Recent Activity</h3>
                        <ul>
                            <?php foreach ($recent_activity as $item): ?>
                                <li><?= htmlspecialchars($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </section>

                <!-- 🔒 DEIN ORIGINALER COMING SOON BLOCK -->
                <section class="dashboard-panel" style="margin-top:32px;">
                    <h3>Coming Soon</h3>
                    <p>Hier kommen bald:</p>
                    <ul>
                        <li>📈 Live Statistiken</li>
                        <li>⚙️ Server Konfiguration</li>
                        <li>👥 User Management</li>
                        <li>🔔 Logs & Events</li>
                    </ul>
                </section>

            </section>
        </div>
    </div>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>

</body>
</html>

<!-- ❗ ORIGINAL SCRIPTS: UNVERÄNDERT ❗ -->
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const stats = document.querySelectorAll('.dashboard-stat');

        stats.forEach(stat => {
            const target = parseInt(stat.dataset.count, 10);
            const output = stat.querySelector('strong');

            if (isNaN(target)) return;

            let current = 0;
            const duration = 1200;
            const steps = 60;
            const increment = target / steps;
            const formatter = new Intl.NumberFormat('de-DE');

            const interval = setInterval(() => {
                current += increment;

                if (current >= target) {
                    output.textContent = formatter.format(target);
                    clearInterval(interval);
                } else {
                    output.textContent = formatter.format(Math.floor(current));
                }
            }, duration / steps);
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const refreshBtn = document.getElementById('btn-refresh');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => {
                refreshBtn.classList.add('loading');
                setTimeout(() => {
                    window.location.reload();
                }, 300);
            });
        }

        const inviteBtn = document.getElementById('btn-invite');
        if (inviteBtn) {
            inviteBtn.addEventListener('click', () => {
                const inviteUrl = "https://discord.com/oauth2/authorize?client_id=1113403511045107773&permissions=2255511571262711&integration_type=0&scope=bot+applications.commands";
                window.open(inviteUrl, "_blank", "noopener");
            });
        }

    });
</script>
