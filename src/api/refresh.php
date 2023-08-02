<?php
    $shouldIncludeToken = false;

    require_once __DIR__ . '../../api/autoload.php';

    use Firebase\JWT\JWT;

    function refreshToken($expiredToken, $pdo) {
        $loginManager = new FunctionsManager($pdo);
        $payload = array();

        $refreshToken = $loginManager->get_token($expiredToken);
        foreach ($refreshToken as $token) {
            // $refreshToken = $token['u_token'];

            $payload = array(
                'id' => $token['id'],
                'username' => $token['name'],
                'email' => $token['email'],
                'exp' => time() + 20 // Set token expiration to 10 seconds from now
            );

            $id = $token['id'];
        }

        $encode = JWT::encode($payload, '85ldofi', 'HS256');

        $tokenExpiration = time() + 3600; // 1 hour (3600 seconds)

        // setcookie('jwt_token', $encode, $tokenExpiration, '/', '', true, true);

        setcookie('jwt_token', $encode, [
            'expires' => $tokenExpiration,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None',
        ]);

        // $loginManager->store_token($id, $encode);

        // echo "Token refreshed!"; // Add the echo statement here

        return $encode;
    }

    $token = refreshToken($_COOKIE['jwt_token'], $pdo);

    echo json_encode(['accessToken' => $token]);
?>