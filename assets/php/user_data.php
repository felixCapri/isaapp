<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Eingaben sanitieren und validieren
    $telegramm_id = isset($_POST['telegramm_id']) ? filter_var($_POST['telegramm_id'], FILTER_VALIDATE_INT) : 0;
    $first_name = isset($_POST['first_name']) ? htmlspecialchars(trim($_POST['first_name']), ENT_QUOTES, 'UTF-8') : '';
    $last_name = isset($_POST['last_name']) ? htmlspecialchars(trim($_POST['last_name']), ENT_QUOTES, 'UTF-8') : '';
    $user_name = isset($_POST['user_name']) ? htmlspecialchars(trim($_POST['user_name']), ENT_QUOTES, 'UTF-8') : '';
    $lang_code = isset($_POST['lang_code']) ? htmlspecialchars(trim($_POST['lang_code']), ENT_QUOTES, 'UTF-8') : '';
    $coins = isset($_POST['coins']) ? filter_var($_POST['coins'], FILTER_VALIDATE_INT) : 0;

    // Validierung
    if (empty($telegramm_id) || $telegramm_id <= 0) {
        echo json_encode(["error" => "Invalid Telegram ID."]);
        exit;
    }
    if (strlen($lang_code) > 5) {
        echo json_encode(["error" => "Invalid Language Code."]);
        exit;
    }
    try {
        // Prüfen, ob der Benutzer bereits existiert
        $stmt = $conn->prepare("SELECT id, user_name, points, kingdome_fk FROM user WHERE telegramm_id = :telegramm_id");
        $stmt->bindValue(':telegramm_id', $telegramm_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && (!isset($user['kingdome_fk']))&& $user['kingdome_fk'] === null) {
            header("Location: ../../pages/login_register/success_registration.php?exists=false&username=" . $user['user_name'] . "&points=" . $user['points'] . "&id=" . $user['id']. "&telegramm_id=" . $telegramm_id  );
            exit;
        }
        else if ($user) {//hier ist die aktuelle weiterleitung
            header("Location: ../../pages/login_register/success_login.php?exists=false&username=" . $user['user_name'] . "&points=" . $user['points'] . "&id=" . $user['id']. "&telegramm_id=" . $telegramm_id . "&kingdome_fk=" . $user['kingdome_fk']);
            exit;
        }else{
                // Benutzer existiert nicht, neuen Benutzer einfügen
            $stmt = $conn->prepare("
                INSERT INTO user (telegramm_id, first_name, last_name, user_name, lang_code, points) 
                VALUES (:telegramm_id, :first_name, :last_name, :user_name, :lang_code, :coins)
            ");
            $stmt->bindValue(':telegramm_id', $telegramm_id, PDO::PARAM_INT);
            $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $stmt->bindValue(':lang_code', $lang_code, PDO::PARAM_STR);
            $stmt->bindValue(':coins', $coins, PDO::PARAM_INT);
            $stmt->execute();

            $lastInsertId = $conn->lastInsertId();
            header("Location: ../../pages/login_register/success_registration.php?exists=false&username=" . urlencode($user_name) . "&points=" . $coins . "&id=" . $lastInsertId . "&telegramm_id=" . $telegramm_id );
            exit;
        }

        
    } catch (PDOException $e) {
        // Fehlerprotokollierung
        error_log("Database Error: " . $e->getMessage());
        echo json_encode(["error" => "An error occurred during registration. Please try again."]);
    }
}
?>
