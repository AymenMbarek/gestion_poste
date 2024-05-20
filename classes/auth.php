<?php
include_once 'config.php';

class Auth extends Config
{
    protected $conn;

    function __construct()
    {
        parent::__construct();
        $this->conn = $this->con; // Assurez-vous que $conn est correctement initialisé
    }

    public function check($post)
    {
        $email = $this->sanitize($_POST['email']);
        $password = $this->sanitize($_POST['password']);
        $query = "SELECT * FROM login WHERE email= '$email' and password='$password'";
        $result = $this->conn->query($query); // Utilisez $this->conn ici aussi
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $this->setval(1, $row['email']);
            $this->role($row['role']);

            return $row;
        } else {
            $this->redirect('login');
        }
    }

    	public function generateResetCode($email) {
    // Vérifiez si l'email existe dans la base de données
    $stmt = $this->conn->prepare("SELECT * FROM login WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Générer un code de réinitialisation
        $resetCode = rand(100000, 999999);
        // Enregistrer le code de réinitialisation dans la base de données
        $stmt = $this->conn->prepare("UPDATE login SET reset_code = ? WHERE email = ?");
        $stmt->bind_param("is", $resetCode, $email);
        $stmt->execute();
        // Rediriger vers la page de réinitialisation de mot de passe
        header("Location: reset_password.php");
        exit();
    } else {
        echo "Email not found.";
    }
}



    public function sendPasswordReset($email) {
    // Vérifiez si l'email existe dans la base de données
    $stmt = $this->conn->prepare("SELECT * FROM login WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Générer un code de réinitialisation
        $resetCode = rand(100000, 999999);
        // Enregistrer le code de réinitialisation dans la base de données
        $stmt = $this->conn->prepare("UPDATE login SET reset_code = ? WHERE email = ?");
        $stmt->bind_param("is", $resetCode, $email);
        $stmt->execute();
        // Envoyer l'email avec le code de réinitialisation
        $subject = "Password Reset";
        $body = "Your reset code is: $resetCode";
        mail($email, $subject, $body);
        echo "A reset code has been sent to your email.";
    } else {
        echo "Email not found.";
    }
}



  public function resetPassword($email, $code, $newPassword) {
    // Vérifiez le code de réinitialisation
    $stmt = $this->conn->prepare("SELECT * FROM login WHERE email = ? AND reset_code = ?");
    $stmt->bind_param("si", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Mettre à jour le mot de passe sans le crypter
        $stmt = $this->conn->prepare("UPDATE login SET password = ?, reset_code = NULL WHERE email = ?");
        $stmt->bind_param("ss", $newPassword, $email);
        $stmt->execute();
        echo "Password successfully reset.";
    } else {
        echo "Invalid reset code.";
    }
}





    public function setval($login, $id)
    {
        $_SESSION['login'] = $login;
        $_SESSION['id'] = $id;
    }

    public function role($val)
    {
        $value = (int)$val;
        if ($value === 1) {
            $this->redirect('admin');
        } elseif ($value === 2) {
            $this->redirect('supervisor');
        } elseif ($value === 3) {
            $this->redirect('user');
        } else {
            return "invalid role";
        }
    }

    public function redirect($type)
    {
        if ($type === 'user') {
            header("location:user/dashboard.php");
        } else if ($type === 'admin') {
            header("location:admin/dashboard.php");
        } else if ($type === 'supervisor') {
            header("location:supervisor/dashboard.php");
        } elseif ($type === 'login') {
            header("location:login.php?msg=Invalid email or password!&type=error");
        } else {
            header("location:login.php?msg=No info found!&type=info");
        }
    }

    public function sendMessage($sender, $receiver, $message) {
    $stmt = $this->conn->prepare("INSERT INTO chat (sender, receiver, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $sender, $receiver, $message);
    $stmt->execute();
}

    public function sanitize($str = '')
    {
        $str = htmlentities($str, ENT_QUOTES, 'UTF-8'); // Add Html Protection
        $str = stripslashes($str); // Add Strip Slashes Protection
        if ($str != '') {
            $str = trim($str);
            return mysqli_real_escape_string($this->conn, $str); // Utilisez $this->conn ici aussi
        }
    }
}
?>
