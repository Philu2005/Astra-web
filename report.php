<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/lang.php';
?>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ======= ENV LADEN =======
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
    if (isset($env['DISCORD_WEBHOOK'])) {
        $webhook_url = trim($env['DISCORD_WEBHOOK']);
    } else {
        die('DISCORD_WEBHOOK nicht in .env gefunden.');
    }
} else {
    die('.env Datei nicht gefunden.');
}

// ======= PHP HANDLING =======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $type    = $_POST['type'] ?? 'Unbekannt';
    $desc    = trim($_POST['desc'] ?? '');
    $discord = trim($_POST['discord'] ?? '');
    $email   = trim($_POST['email'] ?? '');

    if (!$desc) {
        http_response_code(400);
        echo json_encode(['success'=>false, 'msg'=>'Bitte beschreibe das Problem.']);
        exit;
    }

    $embed_config = [
        "Nutzer" => [
            "color" => 0x8858fa,
            "icon"  => "👤",
            "title" => "Problem mit einem Nutzer",
        ],
        "Webseite" => [
            "color" => 0x3ddbf7,
            "icon"  => "💻",
            "title" => "Fehler auf der Webseite",
        ],
        "Discord" => [
            "color" => 0xff4f6d,
            "icon"  => "🐞",
            "title" => "Fehler auf Discord",
        ],
        "Unbekannt" => [
            "color" => 0x3dfbcd,
            "icon"  => "❓",
            "title" => "Unbekannter Meldungstyp",
        ]
    ];
    $embed = $embed_config[$type] ?? $embed_config["Unbekannt"];

    $fields = [["name" => "Beschreibung", "value" => $desc]];
    if ($discord) $fields[] = ["name"=>"Discord", "value"=>$discord];
    if ($email)   $fields[] = ["name"=>"E-Mail", "value"=>$email];

    $payload = json_encode([
        "embeds" => [[
            "title"      => "{$embed['icon']} {$embed['title']}",
            "fields"     => $fields,
            "color"      => $embed["color"],
            "footer"     => ["text" => "Gesendet am " . date("d.m.Y H:i")]
        ]]
    ]);

    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 204) {
        echo json_encode(['success'=>true]);
    } else {
        http_response_code(500);
        echo json_encode(['success'=>false, 'msg'=>'Discord Webhook Fehler.']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Problem melden | Astra Bot</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="icon" href="/public/favicon_transparent.png">
    <link rel="stylesheet" href="css/style.css?v=2.4"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script defer src="https://cloud.umami.is/script.js" data-website-id="caafee2b-2478-4148-8e69-3ebecc18416c"></script>
</head>
<body class="report-page">

<?php
$pageClass = "report-page";
include "includes/header.php";
?>

<main class="report-main">

    <section class="report-hero-card">

        <!-- BUBBLES -->
        <div class="report-bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="12%" cy="18%" r="42" fill="#65e6ce33"/>
                <circle cx="88%" cy="22%" r="64" fill="#a7c8fd22"/>
                <circle cx="50%" cy="78%" r="52" fill="#7c41ee22"/>
                <circle cx="92%" cy="82%" r="26" fill="#60e9cb22"/>
            </svg>
        </div>

        <div class="report-content">
            <h1><?= $t['report_title'] ?></h1>

            <p class="report-desc">
                <?= $t['report_desc'] ?>
            </p>

            <!-- TYPE SELECT -->
            <div class="astra-problem-types">
                <button class="astra-problem-chip selected" data-type="Nutzer">
                    👤 <?= $t['report_button_user'] ?>
                </button>
                <button class="astra-problem-chip" data-type="Webseite">
                    💻 <?= $t['report_button_website'] ?>
                </button>
                <button class="astra-problem-chip" data-type="Discord">
                    🤖 <?= $t['report_button_discord'] ?>
                </button>
            </div>

            <!-- FORM -->
            <form class="astra-form" id="astra-report-form">

                <input type="hidden" name="type" id="astra-report-type" value="">

                <label><?= $t['report_problem_desc'] ?></label>
                <textarea
                        name="desc"
                        placeholder="<?= $t['report_problem_input_preview'] ?>"
                        required
                ></textarea>

                <label><?= $t['report_discord_name_desc'] ?></label>
                <input
                        type="text"
                        name="discord"
                        placeholder="<?= $t['report_discord_input_preview'] ?>"
                >

                <label><?= $t['report_email_desc'] ?></label>
                <input
                        type="email"
                        name="email"
                        placeholder="<?= $t['report_email_input_preview'] ?>"
                >

                <button type="submit" class="webseite" id="astra-submit-btn">
                    <?= $t['report_button_send'] ?>
                </button>

                <div class="astra-msg-success" id="astra-report-success">
                    ✔ <?= $t['report_button_send'] ?>
                </div>
                <div class="astra-msg-error" id="astra-report-error"></div>

            </form>
        </div>


    </section>

</main>

<?php include "includes/footer.php"; ?>

<script>
    let lastChipType = '';
    const submitBtn = document.getElementById('astra-submit-btn');

    document.querySelectorAll('.astra-problem-chip').forEach(chip => {
        chip.onclick = () => {
            document.querySelectorAll('.astra-problem-chip').forEach(c => c.classList.remove('selected'));
            chip.classList.add('selected');
            const type = chip.getAttribute('data-type');
            document.getElementById('astra-report-type').value = type;
            lastChipType = type;
            document.getElementById('astra-report-error').style.display = 'none';

            // Button-Farbe anpassen
            submitBtn.className = '';
            submitBtn.id = 'astra-submit-btn';
            submitBtn.classList.add(type.toLowerCase());
        }
    });

    // Standardmäßig Webseite vorauswählen
    window.addEventListener('DOMContentLoaded', function() {
        let def = document.querySelector('.astra-problem-chip[data-type="Webseite"]');
        if(def) def.click();
    });

    // Absenden mit Fehler-Handling & UX
    document.getElementById('astra-report-form').onsubmit = async function(e) {
        e.preventDefault();
        const type = document.getElementById('astra-report-type').value;
        if (!type) {
            document.getElementById('astra-report-error').innerText = "Bitte wähle einen Meldungstyp aus.";
            document.getElementById('astra-report-error').style.display = 'block';
            return;
        }
        const formData = new FormData(this);
        try {
            const res = await fetch(location.href, {method:'POST', body:formData});
            const result = await res.json();
            if (result.success) {
                this.style.display = 'none';
                document.getElementById('astra-report-success').style.display = 'block';
                document.getElementById('astra-report-error').style.display = 'none';
            } else {
                document.getElementById('astra-report-success').style.display = 'none';
                document.getElementById('astra-report-error').innerText = result.msg || "Fehler beim Senden. Bitte später erneut versuchen.";
                document.getElementById('astra-report-error').style.display = 'block';
            }
        } catch (err) {
            document.getElementById('astra-report-success').style.display = 'none';
            document.getElementById('astra-report-error').innerText = "Verbindung fehlgeschlagen. Bitte später erneut versuchen.";
            document.getElementById('astra-report-error').style.display = 'block';
        }
    };

    // Chips bleiben nach Senden auswählbar
    document.querySelectorAll('.astra-problem-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            let form = document.getElementById('astra-report-form');
            let succ = document.getElementById('astra-report-success');
            if (form.style.display === 'none') {
                form.reset();
                form.style.display = 'block'; // FIX: war vorher flex
                succ.style.display = 'none';
                document.getElementById('astra-report-type').value = chip.getAttribute('data-type');
            }
        });
    });
</script>
</body>
</html>
