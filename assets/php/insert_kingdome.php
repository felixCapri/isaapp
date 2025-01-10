<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>save Kingdome</title>
        <link rel="icon" type="image/x-icon" href="../../assets/images/logo.png">
    </head>
    <body>
        <h1 style="text-align: center;">Interactive Map</h1>
        <p>
            <?php
                include './db.php';                
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    // Eingaben aus URL-Parametern abrufen und validieren
                    $id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;
                    $kingdome_fk = isset($_GET['value']) ? filter_var($_GET['value'], FILTER_VALIDATE_INT) : null;

                    // Validierung
                    if ($id <= 0 || $kingdome_fk === null) {
                     //   echo json_encode(["error" => "Invalid ID or kingdom value."]);
                        exit;
                    }
                    try {
                        // Aktualisiere den `kingdome_fk`-Wert für die angegebene ID
                        $stmt = $conn->prepare("UPDATE user SET kingdome_fk = :kingdome_fk WHERE id = :id");
                        $stmt->bindValue(':kingdome_fk', $kingdome_fk, PDO::PARAM_INT);
                        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                        echo "<script>
                            const kingdome_fk = '$kingdome_fk';
                            localStorage.setItem('kingdome_fk', kingdome_fk);

                            // Weiterleitung
                            setTimeout(() => {
                                window.location.href = '../../pages/home.html';
                            }, 500); // 1 Sekunde warten
                        </script>";
                exit;

                    } catch (PDOException $e) {
                        // Fehlerprotokollierung
                        error_log("Database Error: " . $e->getMessage());
                        echo json_encode(["error" => "An error occurred while updating the kingdom."]);
                    }
                } else {
                    echo json_encode(["error" => "Invalid request method. Use GET."]);
                }
            ?>
        </p>

    </body>
</html>