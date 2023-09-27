<?php
require_once __DIR__ . '/parent.php';

class FunctionsManager extends MainFunction {
    public function __construct($pdo) {
        parent::__construct($pdo);
    }

    public function email_test($username, $password) {
        $params = array(
            'name' => array(
                'value' => $username, 
                'type' => PDO::PARAM_STR
            ),
            'password' => array(
                'value' => $password, 
                'type' => PDO::PARAM_STR
            )
        );

        $sql = "SELECT * FROM `users` 
                    WHERE name = :name 
                    AND password = :password";

        return parent::prepareAndExecute($params, $sql);
    }

    public function updateField($user_id, $username) {
        $params = array(
            'user_id' => array(
                'value' => $user_id,
                'type' => PDO::PARAM_INT
            ),
            'username' => array(
                'value' => $username,
                'type' => PDO::PARAM_STR
            )
        );

        $sql = "UPDATE users SET 
                    name = :username 
                    WHERE id = :user_id";

        $rowCount = parent::prepareAndExecute($params, $sql);
        return parent::handleUpdateResponse($rowCount);
    }

    public function find_user($email, $password) {
        $params = array(
            'email' => array(
                'value' => $email,
                'type' => PDO::PARAM_STR
            ),
            'password' => array(
                'value' => $password,
                'type' => PDO::PARAM_STR
            )
        );

        $sql = "SELECT * FROM users
                    WHERE email = :email 
                    AND password = :password";

        return parent::prepareAndExecute($params, $sql);
    }

    public function store_token($user_id, $refreshToken) {
        $param = array(
            'id' => array(
                'value' => $user_id,
                'type' => PDO::PARAM_INT
            ),
            'token' => array(
                'value' => $refreshToken,
                'type' => PDO::PARAM_STR
            )
        );

        $sql = "UPDATE users SET refreshToken = :token
                    WHERE id = :id";

        $rowCount = parent::prepareAndExecute($param, $sql);
        return parent::handleUpdateResponse($rowCount);
    }

    public function get_token($token) {
        $param = array(
            'token' => array(
                'value' => $token,
                'type' => PDO::PARAM_STR
            )
        );

        $sql = "SELECT * FROM users
                    WHERE refreshToken = :token";

        return parent::prepareAndExecute($param, $sql);
    }
}
?>