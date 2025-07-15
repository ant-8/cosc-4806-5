<?php

class User
{
    public $username;
    public $password;
    public $auth = false;

    public function __construct()
    {
    }

    public function test()
    {
        $db = db_connect();
        $statement = $db->prepare("select * from users;");
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function authenticate($username, $password)
    {
        /*
         * if username and password good then
         * $this->auth = true;
         */
        $username = strtolower($username);
        $db = db_connect();

        $stmt = $db->prepare("SELECT COUNT(*) AS failed_attempts FROM login_attempts WHERE username = :username AND success = 0 AND attempt_time > (NOW() - INTERVAL 60 SECOND)");
        $stmt->execute([':username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result['failed_attempts'] >= 3) {
            $_SESSION["failedAuth"] = 3;
            $_SESSION["error_message"] = "Too many failed login attempts. Please try again in 60 seconds.";
            header("Location: /login");
            exit;
        }

        $statement = $db->prepare("select * from users WHERE username = :name;");
        $statement->bindValue(":name", $username);
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
        $isSuccessful = false;

        if (password_verify($password, $rows["password"])) {
            $isSuccessful = true;
            $_SESSION["auth"] = 1;
            $_SESSION["username"] = ucwords($username);
            $_SESSION["userid"] = $rows["userid"];
            unset($_SESSION["failedAuth"]);
            header("Location: /home");
        } else {
            if (isset($_SESSION["failedAuth"])) {
                $_SESSION["failedAuth"]++; //increment
            } else {
                $_SESSION["failedAuth"] = 1;
            }
            if ($result && $result['failed_attempts'] < 3){
                $_SESSION["error_message"] = "Invalid username or password.";
            }
            header("Location: /login");
        }
        $this->log_attempt($username, $isSuccessful);
    }

    public function username_exists($username)
    {
        $db = db_connect();
        $statement = $db->prepare(
            "SELECT * FROM users WHERE username = :username"
        );
        $statement->execute([":username" => $username]);
        return $statement->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function create_user($username, $password)
    {
        if ($this->username_exists($username)) {
            return [
                "success" => false,
                "message" => "Username already exists.",
            ];
        }

        if (!$this->is_password_strong($password)) {
            return [
                "success" => false,
                "message" => "Passwords must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.",
            ];
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $db = db_connect();
        $statement = $db->prepare(
            "INSERT INTO users (username, password) VALUES (:username, :password)"
        );
        $success = $statement->execute([
            ":username" => $username,
            ":password" => $hashed_password,
        ]);

        return [
            "success" => $success,
            "message" => $success
                ? "Account created successfully"
                : "Failed to create account.",
        ];
    }

    private function is_password_strong($password)
    {
        return strlen($password) >= 8 &&
            preg_match("/[A-Z]/", $password) &&
            preg_match("/[a-z]/", $password) &&
            preg_match("/[0-9]/", $password) &&
            preg_match("/[\W]/", $password);
    }

    private function log_attempt($username, $success)
    {
        $db = db_connect();

        $successValue = 0;
        if ($success === true) {
            $successValue = 1;
        }

        $statement = $db->prepare(
            "INSERT INTO login_attempts (username, success) VALUES (:username, :success)"
        );
        $statement->execute([
            ":username" => $username,
            ":success" => $successValue,
        ]);
    }
}
