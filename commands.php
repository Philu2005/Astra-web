<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/lang.php';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Commands | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css?v=4.3" />
    <script defer src="https://cloud.umami.is/script.js" data-website-id="caafee2b-2478-4148-8e69-3ebecc18416c"></script>
</head>
<body>

<!-- ASTRA LOADER -->
<div id="astra-loader">
    <div class="astra-loader-bg"></div>
    <div class="astra-loader-bubbles">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="astra-loader-core">
        <div class="astra-loader-ring"></div>
        <img src="/public/favicon_transparent.png" class="astra-loader-logo" alt="Astra">
        <span class="astra-loader-text">Booting Astra</span>
    </div>
</div>

<?php include 'includes/header.php'; ?>

<main class="commands-main">

    <!-- HERO -->
    <section class="commands-hero-card">
        <div class="bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="12%" cy="18%" r="42" fill="#65e6ce33"/>
                <circle cx="88%" cy="22%" r="64" fill="#a7c8fd22"/>
                <circle cx="50%" cy="78%" r="52" fill="#7c41ee22"/>
                <circle cx="92%" cy="82%" r="26" fill="#60e9cb22"/>
            </svg>
        </div>

        <div class="commands-hero-content">
            <div class="commands-hero-text">
                <div class="astra-label-row">
                    <span class="astra-label green"><?= $t['cmd_label_slash'] ?></span>
                    <span class="astra-label blue"><?= $t['cmd_label_live'] ?></span>
                    <span class="astra-label yellow"><?= $t['cmd_label_version'] ?></span>
                </div>

                <h1><?= $t['cmd_title'] ?></h1>
                <p class="astra-desc"><?= $t['cmd_desc'] ?></p>

                <div class="astra-badges-row">
                    <span class="astra-badge mint"><?= $t['cmd_badge_mod'] ?></span>
                    <span class="astra-badge blue"><?= $t['cmd_badge_level'] ?></span>
                    <span class="astra-badge violet"><?= $t['cmd_badge_eco'] ?></span>
                    <span class="astra-badge yellow"><?= $t['cmd_badge_fun'] ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- COMMANDS PANEL -->
    <section class="commands-panel-card">

        <input
                id="commandSearch"
                class="commands-search"
                type="text"
                placeholder="<?= $t['cmd_search'] ?>"
                data-placeholder="<?= $t['cmd_search'] ?>"
        />

        <div class="commands-filters">
            <button class="active" data-filter-key="all"><?= $t['filter_all'] ?></button>

            <button data-filter-key="moderation"><?= $t['filter_mod'] ?></button>
            <button data-filter-key="level"><?= $t['filter_level'] ?></button>
            <button data-filter-key="economy"><?= $t['filter_eco'] ?></button>
            <button data-filter-key="fun"><?= $t['filter_fun'] ?></button>
            <button data-filter-key="settings"><?= $t['filter_settings'] ?></button>
            <button data-filter-key="information"><?= $t['filter_info'] ?></button>
        </div>


        <div class="commands-accordion" id="commandsAccordion"></div>

    </section>
</main>

<?php include 'includes/footer.php'; ?>

<script>
    const lang = "<?= $lang ?>";
</script>

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
            }, 600); // fühlt sich smooth an, nicht künstlich
        });

    })();
</script>

<script>
    /* ============================
       LOAD JSON & RENDER (SAFE)
    ============================ */
    fetch(`/json/commands_${lang}.json`)
        .then(res => res.json())
        .then(data => renderCommands(data));

    function renderCommands(data) {
        const accordion = document.getElementById('commandsAccordion');
        accordion.innerHTML = '';

        Object.entries(data).forEach(([key, catData]) => {
            const count = catData.commands.length;

            const categoryEl = document.createElement('div');
            categoryEl.className = 'command-category';
            categoryEl.dataset.filterKey = key;

            categoryEl.innerHTML = `
                <button class="command-category-header">
                    ${getIcon(key)} ${catData.title}
                    <span>${count} Commands</span>
                </button>
            `;

            const body = document.createElement('div');
            body.className = 'command-category-body';

            catData.commands.forEach(cmd => {
                const item = document.createElement('div');
                item.className = 'command-item';

                const nameEl = document.createElement('div');
                nameEl.className = 'cmd-name';
                nameEl.textContent = cmd.name;

                const descEl = document.createElement('div');
                descEl.className = 'cmd-desc';
                descEl.textContent = cmd.description;

                const usageEl = document.createElement('div');
                usageEl.className = 'cmd-usage';
                usageEl.textContent = cmd.usage;

                item.appendChild(nameEl);
                item.appendChild(descEl);
                item.appendChild(usageEl);

                body.appendChild(item);
            });

            categoryEl.appendChild(body);
            accordion.appendChild(categoryEl);
        });

        initAccordion();
    }

    /* ============================
       ICONS
    ============================ */
    function getIcon(key) {
        const icons = {
            moderation: '🛡️',
            level: '📈',
            economy: '💰',
            fun: '🎉',
            settings: '⚙️',
            information: 'ℹ️',
            giveaways: '🎁',
            ticket: '🎫',
            automoderation: '🤖',
            messages: '💬',
            minigames: '🕹️',
            backups: '🗄️',
            birthdays: '🎂'
        };
        return icons[key] || '📘';
    }

    /* ============================
       ACCORDION
    ============================ */
    function initAccordion() {
        document.querySelectorAll('.command-category-header').forEach(btn => {
            btn.addEventListener('click', () => {
                const current = btn.parentElement;

                document.querySelectorAll('.command-category').forEach(cat => {
                    if (cat !== current) cat.classList.remove('open');
                });

                current.classList.toggle('open');
            });
        });
    }

    /* ============================
       FILTER
    ============================ */
    document.querySelectorAll('.commands-filters button').forEach(btn => {
        btn.addEventListener('click', () => {

            document.querySelectorAll('.commands-filters button')
                .forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filterKey = btn.dataset.filterKey;

            document.querySelectorAll('.command-category').forEach(cat => {
                const isMatch =
                    filterKey === 'all' ||
                    cat.dataset.filterKey === filterKey;

                cat.style.display = isMatch ? '' : 'none';

                if (filterKey === 'all') {
                    cat.classList.remove('open');
                } else {
                    cat.classList.toggle('open', isMatch);
                }
            });
        });
    });

    /* ============================
       SEARCH (FILTER LOGIC)
    ============================ */
    document.getElementById('commandSearch').addEventListener('input', e => {
        const val = e.target.value.toLowerCase().trim();

        document.querySelectorAll('.command-category').forEach(cat => {
            let hasMatch = false;

            cat.querySelectorAll('.command-item').forEach(cmd => {
                const name = cmd.querySelector('.cmd-name')?.innerText.toLowerCase() || '';
                const usage = cmd.querySelector('.cmd-usage')?.innerText.toLowerCase() || '';

                const match = name.includes(val) || usage.includes(val);

                cmd.style.display = match ? '' : 'none';
                if (match) hasMatch = true;
            });

            if (val === '') {
                cat.style.display = '';
                cat.classList.remove('open');
                cat.querySelectorAll('.command-item')
                    .forEach(cmd => cmd.style.display = '');
            } else {
                cat.style.display = hasMatch ? '' : 'none';
                cat.classList.toggle('open', hasMatch);
            }
        });
    });
</script>

<script>
    /* ============================
       SEARCH PREVIEW (FIXED)
    ============================ */
    const search = document.getElementById('commandSearch');
    const previewText = search.placeholder;

    let typingTimer = null;

    function typeText(text, speed = 35) {
        let i = 0;
        search.value = '';
        search.classList.add('is-preview'); // 🔥 DAS WAR DER FEHLER

        typingTimer = setInterval(() => {
            if (i >= text.length) {
                clearInterval(typingTimer);
                return;
            }
            search.value += text[i];
            i++;
        }, speed);
    }

    // Initial Preview
    typeText(previewText);

    // Sobald User tippt → Preview aus
    search.addEventListener('input', () => {
        search.classList.remove('is-preview');
    });

    // FOCUS → Preview weg
    search.addEventListener('focus', () => {
        clearInterval(typingTimer);
        search.classList.remove('is-preview'); // 🔥 WICHTIG
        search.classList.add('hide-placeholder');

        if (search.value === previewText) {
            search.value = '';
        }
    });

    // BLUR → Preview langsam eintippen
    search.addEventListener('blur', () => {
        search.classList.remove('hide-placeholder');

        if (search.value.trim() === '') {
            typeText(previewText);
        }
    });
</script>



</body>
</html>
