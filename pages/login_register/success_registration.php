<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Interactive Map</title>
        <link rel="icon" type="image/x-icon" href="../../assets/images/logo.png">
        <link rel="stylesheet" href="../../assets/css/responsive.css">

        <style>
            /* Container für das Bild */
            .image-container {
                position: relative;
                width: 100%;
                max-width: 600px; /* Maximale Breite für Desktop */
                margin: 0 auto;
                border: 2px solid #ffffff;
            }

            /* Das Bild selbst */
            .image-container img {
                width: 100%;
                height: auto;
                display: block;
            }

            /* Überlagerung für die klickbaren Bereiche */
            .clickable-area {
                position: absolute;
                cursor: pointer;
                background: rgba(255, 255, 255, 0.3); /* Transparenter Hintergrund für Sichtbarkeit */
                border: 1px solid rgba(255, 255, 255, 0.5);
                transition: background 0.3s ease;
            }

            .clickable-area:hover {
                background: rgba(255, 255, 255, 0.5);
            }

            /* Definition der vier Bereiche */
            .top-left {
                top: 0;
                left: 0;
                width: 50%;
                height: 50%;
            }

            .top-right {
                top: 0;
                right: 0;
                width: 50%;
                height: 50%;
            }

            .bottom-left {
                bottom: 0;
                left: 0;
                width: 50%;
                height: 50%;
            }

            .bottom-right {
                bottom: 0;
                right: 0;
                width: 50%;
                height: 50%;
            }

            /* Ausgabe für die gespeicherte Variable */
            .output {
                text-align: center;
                margin-top: 20px;
                font-size: 1.2rem;
                color: #ffffff;
            }

            body {
                background-color: #191919;
                font-family: Arial, sans-serif;
                color: #ffffff;
                margin: 0;
                padding: 20px;
            }
        </style>
    </head>
    <body>

        <h1 style="text-align: center;">Interactive Map</h1>
        <p>
            <?php
                // PHP-Variablen aus den GET-Parametern
                $username = htmlspecialchars($_GET['username']);
                $points = intval($_GET['points']);
                $id = intval($_GET['id']);
                $telegramm_id = intval($_GET['telegramm_id']);
            ?>
        </p>
        <!-- Bildcontainer -->
        <div class="image-container">
            <img src="../../assets/images/map.webp" alt="Interactive Map">

            <!-- Klickbare Bereiche -->
            <div class="clickable-area top-left" data-value="1"></div>
            <div class="clickable-area top-right" data-value="2"></div>
            <div class="clickable-area bottom-left" data-value="3"></div>
            <div class="clickable-area bottom-right" data-value="4"></div>
        </div>

        <!-- Ausgabe für die Variable -->
        <div class="output" id="output">Choose your kingdome</div>
        <script>
            const username = "<?php echo $username; ?>";
            const points = <?php echo $points; ?>;
            const id = <?php echo $id; ?>;
            const telegrammId = <?php echo $telegramm_id; ?>;

            // sessionStorage setzen
            localStorage.setItem('username', username);
            localStorage.setItem('points', points);
            localStorage.setItem('id', id);
            localStorage.setItem('telegramm_id', telegrammId);

            // Alle klickbaren Bereiche auswählen
            const clickableAreas = document.querySelectorAll('.clickable-area');
            const output = document.getElementById('output');
            let savedVariable = null;

            // Event-Listener für Klicks auf die Bereiche
            clickableAreas.forEach(area => {
                area.addEventListener('click', (e) => {
                    // Den Wert aus dem "data-value" Attribut speichern
                    const savedVariable = parseInt(e.target.dataset.value, 10);

                    // Ausgabe aktualisieren
                    output.textContent = `Saved variable: ${savedVariable}`;

                    // Weiterleitung zur nächsten Seite mit der Variable als URL-Parameter
                    window.location.href = `../../assets/php/insert_kingdome.php?value=${savedVariable}&id=<?php echo $_GET['id']; ?>`;
                });
            });
        </script>
    </body>
</html>