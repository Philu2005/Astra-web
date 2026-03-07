# 🚧 WORK IN PROGRESS – DIESE WEBSITE BEFINDET SICH NOCH IN ENTWICKLUNG 🚧
**Viele Funktionen können sich noch ändern, sind unvollständig oder werden aktuell überarbeitet.**

---

# 🌐 Astra Website

![PHP](https://img.shields.io/badge/PHP-8.0+-blue)
![Discord OAuth](https://img.shields.io/badge/Auth-Discord-blue)
![License](https://img.shields.io/badge/License-MIT-green)

Die **Astra Website** ist das offizielle Web-Interface für den **Astra Discord Bot**.

Sie bietet eine zentrale Plattform für:

• Bot-Informationen  
• Commands Übersicht  
• Server-Dashboard  
• Support & Status  
• Bot-Einladung

Die Website ermöglicht es Server-Administratoren, ihren Server direkt über ein **Web-Dashboard** zu verwalten.

---

## ✨ Übersicht

Die Website stellt verschiedene Funktionen für Nutzer und Serveradministratoren bereit.

### 🌍 Öffentliche Seiten

• Startseite  
• Commands Übersicht  
• Bot Invite  
• Support Seite  
• Status Seite  
• Impressum / Datenschutz / AGB

### 🔐 Login & Auth

Die Authentifizierung erfolgt über **Discord OAuth2**.

Funktionen:

• Discord Login  
• Server-Erkennung  
• Benutzer-Sessions  
• Logout System

### 🖥 Dashboard

Serveradministratoren können über das Dashboard ihren Server verwalten.

Beispiele:

• Server auswählen  
• Join Roles verwalten  
• Server-Informationen anzeigen  
• Bot-Konfiguration

---

## ⚡ Installation & Einrichtung

```bash
# Repository klonen
git clone https://github.com/Philu2005/astra-website.git
cd astra-website
```

### Voraussetzungen

Die Website benötigt:

- **PHP 8.0+**
- **Webserver (Apache oder Nginx)**
- **Discord Developer Application**
- optional **Datenbank / Bot API Backend**

---

## ⚙ Konfiguration

Erstelle eine **Discord Application** im Discord Developer Portal:

https://discord.com/developers/applications

Beispielkonfiguration:

```env
# Discord OAuth
CLIENT_ID=
CLIENT_SECRET=
REDIRECT_URI=

# Bot
BOT_ID=

# Optional API
API_URL=
API_TOKEN=
```

Diese Werte werden in den Login- und API-Dateien verwendet.

---

## 📁 Projektstruktur

```text
astra-website
│
├── index.php              # Startseite
├── commands.php           # Commands Übersicht
├── invite.php             # Bot Einladung
├── support.php            # Support Seite
├── status.php             # Bot Status
│
├── dashboard/             # Web Dashboard
│   ├── index.php
│   ├── servers.php
│   ├── server.php
│   └── api/
│       ├── server.php
│       ├── servers.php
│       └── joinrole.php
│
├── login/                 # Discord OAuth Login
│   ├── discord.php
│   ├── callback.php
│   └── logout.php
│
├── includes/              # Header / Footer / Config
├── lang/                  # Sprachdateien
├── json/                  # Command Daten
├── css/                   # Styles
└── public/                # Bilder / Assets
```

---

## 🌍 Mehrsprachigkeit

Die Website unterstützt mehrere Sprachen.

Aktuell verfügbar:

• 🇩🇪 Deutsch  
• 🇬🇧 Englisch  
• 🇪🇸 Spanisch  
• 🇫🇷 Französisch

Sprachdateien befinden sich im Ordner:

```
/lang
```

Neue Sprachen können leicht hinzugefügt werden.

---

## 🔗 API

Das Dashboard kommuniziert über interne API-Endpunkte.

Beispiele:

```
/dashboard/api/server.php
/dashboard/api/servers.php
/dashboard/api/joinrole.php
```

Diese APIs verbinden das Web-Dashboard mit der **Bot-Datenbank oder dem Backend-System**.

---

## 🤝 Mitwirken

Dieses Projekt ist **Open Source**.

Du kannst gerne:

• Fehler melden  
• Verbesserungen vorschlagen  
• Pull Requests erstellen

---

## 📄 Lizenz

Dieses Projekt steht unter der **MIT License**.