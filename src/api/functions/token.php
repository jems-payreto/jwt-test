<?php
    // This is the decoder for the token
    require_once __DIR__ . '../../../../vendor/autoload.php';

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    $header = apache_request_headers();

    $sec_key = '85ldofi';
    if(isset($_COOKIE['jwt_token'])) {
        $jwt_token = $_COOKIE['jwt_token'];

        try {
            $token = JWT::decode($jwt_token, new Key($sec_key, 'HS256'));
        } catch (Exception $e) {
            // http_response_code(401);
            echo json_encode(['message' => 'Invalid JWT token']);
            exit();
        }
    } else {
        // http_response_code(401);
        echo json_encode(['message' => 'Invalid JWT token']);
        exit();
    }

    // echo "TOKEN  :" . print_r($token);
?>