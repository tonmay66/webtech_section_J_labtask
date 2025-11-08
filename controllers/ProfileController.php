<?php
include_once '../models/userModel.php';
include_once './profile.php';

class ProfileController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function editProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }

        $user = $this->userModel->getUserById($_SESSION['user_id']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

            if (!$username || !$email) {
                $error = "Please fill all fields correctly.";
                header('location: ./profile.php');
                return;
            }

            if ($this->userModel->updateProfile($_SESSION['user_id'], $username, $email)) {
                $success = "Profile updated successfully.";
                $_SESSION['username'] = $username;
                $user = $this->userModel->getUserById($_SESSION['user_id']);
                header('location: ./profile.php');
                //include DIR . '/../views/profile.php';
            } else {
                $error = "Update failed.";
                header('location: ./profile.php');

                //include DIR . '/../views/profile.php';
            }
        } else {
            header('location: ./profile.php');
            //include DIR . '/../views/profile.php';
        }
    }
}
?>