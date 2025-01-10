<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telegram User Data</title>
</head>
<body>
    <h1>Telegram User Data</h1>
    <div id="telegram-data">
        <p>Fetching data...</p>
    </div>

    <script>
        // Telegram Webhook-URL
        const webhookUrl = '/telegram/webhook.php';

        // Abruf der Daten vom Webhook
        fetch(webhookUrl)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('telegram-data').innerHTML = `<p>Error: ${data.error}</p>`;
                } else {
                    const { telegram_id, first_name, last_name, username } = data;

                    // Daten auf der Webseite anzeigen
                    document.getElementById('telegram-data').innerHTML = `
                        <p>Telegram ID: ${telegram_id}</p>
                        <p>First Name: ${first_name}</p>
                        <p>Last Name: ${last_name}</p>
                        <p>Username: ${username}</p>
                    `;

                    // Optional: Daten in localStorage speichern
                    localStorage.setItem('telegram_id', telegram_id);
                    localStorage.setItem('first_name', first_name);
                    localStorage.setItem('last_name', last_name);
                    localStorage.setItem('username', username);
                }
            })
            .catch(error => {
                console.error('Error fetching Telegram data:', error);
                document.getElementById('telegram-data').innerHTML = `<p>Error fetching data.</p>`;
            });
    </script>
</body>
</html>
