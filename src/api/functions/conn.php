<?php
    // Database credentials
    $db_host = $_ENV['DB_HOST'];
    $db_username = $_ENV['DB_USERNAME'];
    $db_password = $_ENV['DB_PASSWORD'];
    $db_name = $_ENV['DB_NAME'];

    try {
        // Create a PDO connection
        $db = "mysql:host=$db_host;dbname=$db_name";
        $pdo = new PDO($db, $db_username, $db_password);

        // Set PDO attributes for error handling
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die(json_encode(["Connection failed: " . $e->getMessage()]));
    }
?>