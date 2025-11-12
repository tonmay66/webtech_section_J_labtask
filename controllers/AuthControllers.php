<?php
include_once '../models/userModel.php'  ;
include_once './register.php'; 
include_once './login.php';

class AuthController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];
            $confirm = $_POST['confirm_password'];

            if (!$username  || !$email  || !$password || !$password !== $confirm) {
                $error = "Validation error";
                //include  '/../views/register.php';
                return;
            }

            if ($this->userModel->register($username, $email, $password)) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Registration failed";
                //include DIR . '/../views/register.php';
            }
        } else {
            //include DIR . '/../views/register.php';
            return "connection problem";
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];

            if ($this->userModel->login($email, $password)) {
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid credentials";
               // include DIR . '/../views/login.php';
            }
        } else {
            return "login failed";
            //include DIR . '/../views/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit;
    }
}
?>