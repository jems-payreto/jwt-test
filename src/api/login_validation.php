<?php
    // $shouldIncludeToken = false;

    // require_once __DIR__ . '/autoload.php';

    // echo $_ENV['SECRET_KEY'] ?? 'no env';
    // echo "<br>";

    // $username = 'John Doe';
    // $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

    // $username = 'Pat Test';
    // $password = '$2y$10$WshsjhD.CjP0p6mWr/By7eNDFfCReNV4mxAZq9l5y7pQs1yXUYx3K';
    
    // $user_level = '';
    // $functionsManager = new FunctionsManager($pdo);

    // $creds = $functionsManager->email_test($username, $password);

    // echo $functionsManager->updateField(1, 'Update Test');

    // echo "<br><br>CREDS : ";
    // var_dump($creds);
    // foreach($creds as $cred) {
    //     $user_level = $cred['u_level'];
    // }

    // switch($user_level) {
    //     case 0 :
    //         echo json_encode(['message' => 'Account already deactivated']);
    //         break;
    //     case 1 :
    //         echo json_encode(['message' => 'Login Authenticated']);
    //         break;
    //     default : 
    //         echo json_encode(['message' => 'Invalid login credentials']);
    //         break;
    // }

    // var_dump($decode);

    $shouldIncludeToken = false;

    require __DIR__ . '/autoload.php';

    use Firebase\JWT\JWT;

    $sec_key = $_ENV['SECRET_KEY'];
    $loginManager = new FunctionsManager($pdo); 

    // Fetch the files from the front end
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->email) && isset($data->password)) {
        $login_user = $loginManager->find_user($data->email, $data->password);

        if(!$login_user) {
            echo json_encode(array(
                'success' => false,
                'message' => "Invalid login credentials"
            ));
            exit();
        } else {
            foreach($login_user as $user) {
                $payload = array(
                    'id' => $user['id'],
                    'username' => $user['name'],
                    'email' => $user['email'],
                    'exp' => time() + 5 // Set token expiration to 10 seconds from now
                );

                $id = $user['id'];
                $email = $user['email'];
                $name = $user['name'];
            }

            $encode = JWT::encode($payload, $sec_key, 'HS256');

            session_start();
            $_SESSION['jwt_token'] = $encode;

            $tokenExpiration = time() + 3600; // 1 hour (3600 seconds)

            // setcookie('jwt_token', $encode, $tokenExpiration, '/', '', true, true, 'none');

            setcookie('jwt_token', $encode, [
                'expires' => $tokenExpiration,
                'secure' => true,
                'httponly' => true,
                'samesite' => 'None',
            ]);

            $loginManager->store_token($id, $encode);

            echo json_encode(['accessToken' => $encode, 'user' => array('email' => $email, 'name' => $name)]);
        }
    }
?>