🚀 DDEV & WordPress via VS Code SSH Tunnel (Fix)

När du utvecklar i en DDEV-miljö på en fjärrmaskin (t.ex. en Arch-VM eller Unraid) och ansluter via VS Code SSH Port Forwarding, uppstår ofta Redirect Loops, SSL-fel (SSL_ERROR_RX_RECORD_TOO_LONG) eller trasiga menylänkar.

Detta beror på att VS Code slumpar nya localhost-portar (t.ex. http://localhost:32781) varje gång du ansluter, medan WordPress har de gamla portarna hårdkodade i databasen och menyerna.

Följande trestegslösning gör din lokala miljö 100 % dynamisk. Alla menyer, länkar och adminpaneler kommer att fungera automatiskt, oavsett vilken port VS Code tilldelar dig för dagen.
🛠 1. Fixa wp-config.php (Dynamisk URL & SSL)

Vi måste se till att WordPress accepterar localhost-porten som systemets bas-URL och stänga av DDEV:s standardinställning som tvingar fram HTTPS på adminpanelen.

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

🪄 2. Skapa en mu-plugin (Dynamiska menyer & länkar)

Eftersom WordPress sparar menyer som absoluta länkar i databasen, använder vi en "Must-Use Plugin" som skannar av den färdiga HTML-sidan via en Output Buffer. Precis innan sidan skickas till webbläsaren byts alla gamla portar ut mot din nuvarande port.

    Gå till mappen wp-content/.

    Skapa en ny mapp som heter mu-plugins (om den inte redan finns).

    Skapa en fil i mappen som heter dynamic-ports.php.

    Klistra in följande kod:

PHP

<?php
/**
 * Plugin Name: Universell Dynamisk Port-Fixer (Output Buffer)
 * Description: Skannar den färdiga HTML-sidan och ersätter alla gamla localhost-portar med den aktuella.
 */

// Starta output buffering så fort detta plugin laddas
add_action('plugins_loaded', function() {
    if (isset($_SERVER['HTTP_HOST'])) {
        
        ob_start(function($html) {
            $current_host = $_SERVER['HTTP_HOST']; // Innehåller "localhost:PORT"

            // Sök efter alla varianter av localhost:XXXX eller 127.0.0.1:XXXX
            // och ersätt med din aktuella localhost:PORT överallt i HTML-koden
            return preg_replace('/(localhost|127\.0\.0\.1):\d+/', $current_host, $html);
        });
        
    }
}, 1);

// Avsluta och skicka bufferten när WordPress är helt färdigt
add_action('shutdown', function() {
    if (ob_get_length() > 0) {
        ob_end_flush();
    }
}, 999);

🌐 3. Fixa .ddev/config.yaml (Acceptera Localhost)

DDEV:s interna Nginx-router måste tillåtas att släppa igenom trafik som är adresserad till localhost istället för att blockera den eller omdirigera till .ddev.site.

    Öppna .ddev/config.yaml.

    Leta upp eller lägg till inställningen additional_hostnames i detta exakta format:
    YAML

    additional_hostnames:
      - "localhost"

    Starta om DDEV i din terminal för att lamma om Nginx-reglerna:
    Bash

    ddev restart

🧹 Felsökning (Om det ändå spökar)

Om webbläsaren mot förmodan visar felaktiga länkar efter en omstart av VS Code, beror det på stenhård caching i WordPress eller webbläsaren. Kör då dessa kommandon i din VM-terminal:
Bash

# Töm WordPress interna cacheminne
ddev wp cache flush

# Ta bort tillfälliga transients ur databasen
ddev wp transient delete --all

Viktigt för webbläsaren: Öppna alltid sidan i en helt ny privat flik (Incognito) via Ctrl + Shift + P när du testar efter en portändring. Firefox sparar omdirigeringar i ett eget minne som inte alltid rensas med vanlig F5.