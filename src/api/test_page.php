<?php
    require_once __DIR__ . '/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
    <a href="login_page.php">Login Page</a>
    <br><br>

    <?php var_dump($token) ?>
    Hello, <?php echo json_encode($token) ?>!
</body>
</html>