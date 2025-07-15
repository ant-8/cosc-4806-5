<?php

class Create extends Controller {

    public function index() {
        $this->view('create/index');
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                $_SESSION['create_error'] = 'Passwords do not match.';
                header('Location: /create');
                exit;
            }

            $user = $this->model('User');
            $result = $user->create_user($username, $password);

            if ($result['success']) {
                $_SESSION['auth'] = 1;
                $_SESSION['username'] = $username;
                header('Location: /home');
                exit;
            } else {
                $_SESSION['create_error'] = $result['message'];
                header('Location: /create');
                exit;
            }
        } else {
            header('Location: /create');
            exit;
        }
    }
}