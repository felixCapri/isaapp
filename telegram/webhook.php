<?php
// Telegram Webhook: Empfängt Daten von Telegram
header('Content-Type: application/json');

// Rohdaten aus der Telegram-Anfrage abrufen
$content = file_get_contents("php://input");
$update = json_decode($content, true);

// Überprüfen, ob eine Nachricht empfangen wurde
if (isset($update['message'])) {
    $message = $update['message'];

    // Telegram-Benutzerdaten extrahieren
    $telegram_id = $message['from']['id'];
    $first_name = $message['from']['first_name'] ?? '';
    $last_name = $message['from']['last_name'] ?? '';
    $username = $message['from']['username'] ?? '';
    $text = $message['text'] ?? '';

    // Antwort senden (optional für Bot-Interaktionen)
    $response = [
        'chat_id' => $telegram_id,
        'text' => "Hello, $first_name! Your message: '$text' was received.",
    ];

    // Antwort an Telegram senden
    file_get_contents("https://api.telegram.org/bot<YOUR_BOT_TOKEN>/sendMessage?" . http_build_query($response));

    // Daten zurückgeben (z. B. für Debugging)
    echo json_encode([
        'telegram_id' => $telegram_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'username' => $username,
        'message_text' => $text,
    ]);
} else {
    // Kein gültiger Inhalt empfangen
    echo json_encode(['error' => 'No valid message received.']);
}
?>
