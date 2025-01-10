<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Success</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; }
            ul { list-style: none; padding: 0; }
            li { margin: 5px 0; padding: 5px; background-color: #f4f4f4; border-radius: 5px; }
        </style>
    </head>
    <body>
        <h1>Success!</h1>
        <p>
            <?php
        // PHP-Variablen aus den GET-Parametern
        $username = htmlspecialchars($_GET['username']);
        $points = intval($_GET['points']);
        $id = intval($_GET['id']);
        $telegramm_id = intval($_GET['telegramm_id']);
        $kingdome_fk = isset($_GET['kingdome_fk']) ? intval($_GET['kingdome_fk']) : 0;
            ?>
        </p>

        <!-- JavaScript für sessionStorage -->
        <script>
            // Werte aus PHP in JavaScript übernehmen
            const username = "<?php echo $username; ?>";
            const points = <?php echo $points; ?>;
            const id = <?php echo $id; ?>;
            const telegrammId = <?php echo $telegramm_id; ?>;
            const kingdomeFk = <?php echo isset($kingdome_fk) ? $kingdome_fk : 0; ?>;

            // sessionStorage setzen
            localStorage.setItem('username', username);
            localStorage.setItem('points', points);
            localStorage.setItem('id', id);
            localStorage.setItem('telegramm_id', telegrammId);
            localStorage.setItem('kingdome_fk', kingdomeFk);
            setTimeout(() => {
                window.location.href = '../../pages/home.html';
            }, 500); // 1 Sekunde warten
        </script>
    </body>
</html>
