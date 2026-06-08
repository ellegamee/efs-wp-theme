🚀 DDEV & WordPress via VS Code SSH Tunnel (Fix)

När du utvecklar i en DDEV-miljö på en fjärrmaskin (t.ex. en Arch-VM eller Unraid) och ansluter via VS Code SSH Port Forwarding, uppstår ofta Redirect Loops eller SSL-fel (SSL_ERROR_RX_RECORD_TOO_LONG).

Detta beror på att DDEV och WordPress förväntar sig att du surfar in på [https://sajtnamn.ddev.site](https://sajtnamn.ddev.site), medan du i själva verket ansluter via en okrypterad localhost-port (t.ex. http://localhost:32781) som skickas genom VS Codes SSH-tunnel.

Här är checklistan för att göra miljön helt dynamisk så att den alltid fungerar, oavsett vilket portnummer VS Code tilldelar dig.
🛠 1. Fixa wp-config.php (Dynamisk URL & SSL)

WordPress måste lära sig att lyssna på den port du ansluter ifrån just nu, istället för att titta i databasen. Vi måste också stänga av DDEV:s standardinställning som tvingar fram HTTPS på adminpanelen.

Öppna wp-config.php och klistra in följande block ABSOLUT HÖGST UPP (direkt under <?php). Det måste ligga före DDEV:s egna settings och innan wp-settings.php laddas!
PHP

<?php
/**
 * DYNAMISK URL-HANTERING FÖR VS CODE SSH-TUNNLAR
 * Gör att WordPress accepterar localhost-portar dynamiskt.
 */
if (isset($_SERVER['HTTP_HOST'])) {
    // Känn av om anslutningen är HTTP eller HTTPS
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https://' : 'http://';
    
    // Överskriv databasens hårdkodade URL:er med nuvarande port
    define('WP_HOME', $protocol . $_SERVER['HTTP_HOST']);
    define('WP_SITEURL', $protocol . $_SERVER['HTTP_HOST']);
}

// Stoppa WordPress/DDEV från att tvinga HTTPS (löser SSL_ERROR_RX_RECORD_TOO_LONG)
define('FORCE_SSL_ADMIN', false);
define('FORCE_SSL_LOGIN', false);

// =========================================================================
// HÄR UNDER KAN RESTEN AV DIN STANDARD-KONFIGURATION LIGGA KVAR...
// =========================================================================

🌐 2. Fixa .ddev/config.yaml (Acceptera Localhost)

DDEV:s interna Nginx-router måste tillåtas att släppa igenom trafik som är adresserad till localhost istället för att kasta iväg dig till .ddev.site.

    Öppna .ddev/config.yaml.

    Leta upp eller lägg till inställningen additional_hostnames i detta exakta format:
    YAML

    additional_hostnames:
      - "localhost"

3. Starta om DDEV i din terminal för att ladda om Nginx-reglerna:
   ```bash
ddev restart

🧹 3. Om det fortfarande spökar (Snabbkommandon för terminalen)

Om webbläsaren fortfarande omdirigerar dig till gamla adresser, beror det på att WordPress har sparat inställningarna i sitt interna cacheminne (Object Cache/Transients), eller att Firefox har cachen full.

Kör dessa kommandon i projektmappen på din VM:
Bash

# 1. Töm WordPress interna cacheminne
ddev wp cache flush

# 2. Ta bort tillfälliga URL-inställningar (transients) ur databasen
ddev wp transient delete --all

# 3. Starta om DDEV:s router helt (om Docker nyligen startats om)
ddev poweroff && ddev start

💡 Sista steget i webbläsaren:

När du har gjort ändringarna, öppna ALLTID en helt ny privat flik (Incognito) i Firefox via Ctrl + Shift + P. Firefox är extremt envis med att komma ihåg gamla felaktiga omdirigeringar!