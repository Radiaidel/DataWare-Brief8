<?php
require_once 'app/Database.php';

class User
{
    private $username;
    private $email;
    private $password;
    private $imageURL;
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
        if (!$this->conn) {
            die("La connexion à la base de données a échoué.");
        }
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setImageURL($imageURL)
    {
        $this->imageURL = $imageURL;
    }

    public function emailExists()
    {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->bindParam(1, $this->email);
            $stmt->execute();

            $count = $stmt->fetchColumn();

            $stmt->closeCursor();

            return $count > 0;
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            return false;
        } finally {
            $conn = null;
        }
    }

    public function save()
    {

        try {
            $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

            $stmt = $this->conn->prepare("INSERT INTO users (username, pass_word, status, email, image_url, role) VALUES (?, ?, 'active', ?, ?, 'user')");

            if ($stmt) {
                $stmt->bindParam(1, $this->username);
                $stmt->bindParam(2, $hashedPassword);
                $stmt->bindParam(3, $this->email);
                $stmt->bindParam(4, $this->imageURL);

                $stmt->execute();
                $stmt->closeCursor();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }
    public function signIn()
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $this->email);

        try {
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($this->password, $user['pass_word'])) {
                // Successfully signed in
                session_start();
                $_SESSION['user_id'] = $user['id_user'];
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getScrumMasters()
    {
        $sql = "SELECT id_user,email FROM users WHERE role <> 'po'";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt->execute()) {
            die("Erreur d'exécution de la requête.");
        }

        $scrumMasters = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();
        return $scrumMasters;
    }
    public function New_scrum_master($id_user)
    {
        $queryRole = "SELECT role FROM users WHERE id_user = ?";
        $stmtRole = $this->conn->prepare($queryRole);
        $stmtRole->execute([$id_user]);

        $currentRole = $stmtRole->fetchColumn();

        if ($currentRole == 'user') {
            $newRole = 'sm';

            $queryUpdateRole = "UPDATE users SET role = ? WHERE id_user = ?";
            $stmtUpdateRole = $this->conn->prepare($queryUpdateRole);
            $stmtUpdateRole->execute([$newRole, $id_user]);

        }
    }


}
?>