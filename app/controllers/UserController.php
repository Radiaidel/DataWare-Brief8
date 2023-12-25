<?php
include_once 'app/models/User.php';

class UserController
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function handleSignup()
    {
        $message = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            $this->userModel->setUsername($username);
            $this->userModel->setEmail($email);
            $this->userModel->setPassword($password);

            $img = "default.jpg";

            if ($_FILES['profilePicture']['name']) {
                $targetDirectory = "upload/";
                $targetPath = $targetDirectory . basename($_FILES['profilePicture']['name']);

                if (!file_exists($targetDirectory)) {
                    mkdir($targetDirectory, 0755, true);
                }

                if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetPath)) {
                    $img = "upload/" . $_FILES['profilePicture']['name'];
                } else {
                    $message = "Sorry, there was a problem uploading your file.";
                }
            }

            $this->userModel->setImageURL($img);

            if ($this->userModel->emailExists()) {
                $message = "Un utilisateur avec cet email existe déjà.";
                include_once "app/views/auth/register.php";
            } else {
                try {
                    $this->userModel->save();
                    $message = "Inscription réussie. Vous pouvez vous connecter.";
                    header("Location: index.php?action=signin");
                    exit;
                } catch (Exception $e) {
                    $message = "Erreur lors de l'inscription. Veuillez réessayer.";
                }
            }
        } else {
            include_once "app/views/auth/register.php";
        }
    }


        public function handleSignIn()
        {
            $message = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST["email"];
                $password = $_POST["password"];

                // Set user data for sign-in
                $this->userModel->setEmail($email);
                $this->userModel->setPassword($password);

                if (!$this->userModel->emailExists()) {
                    $message = "Cet email n'existe pas. Veuillez vous inscrire.";
                    include_once "app/views/auth/login.php";

                } else {
                    // Perform sign-in
                    try {
                        if ($this->userModel->signIn()) {
                            header("Location: index.php?action=project");
                            exit();
                        } else {
                            $message = "Mot de passe incorrect.";
                            include_once "app/views/auth/login.php";
                        }
                    } catch (Exception $e) {
                        $message = "Error: " . $e->getMessage();
                    }
                }
            }else {
                include_once "app/views/auth/login.php";
            }
        }

        public function logout() {
            session_start();
    
            session_unset();
    
            session_destroy();
    
            header("Location: index.php?action=signin");
            exit();
        }
}
?>