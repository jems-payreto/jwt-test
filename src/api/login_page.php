<?php
    require_once __DIR__ . '/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <a href="test_page.php">Test Page</a>
    <br><br>

    <?php var_dump($token) ?>
    Hello, <?php echo json_encode($token) ?>!
</body>
</html>