<?php
include 'connect.php'; // Connexion à la base de données

if (isset($_POST['signUp'])) {
    // Récupérer les données de l'utilisateur
    $firstName = trim($_POST['fName']);
    $lastName = trim($_POST['lName']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $password = trim($_POST['password']);

   
    
    // Hacher le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Vérifier si l'email existe déjà
    $stmt = $conn->prepare("SELECT * FROM membres WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email Address Already Exists!');</script>";
    } else {
        // Insérer un nouvel utilisateur dans la base de données
        $insertQuery = $conn->prepare("INSERT INTO membres (nom, prenom, email, telephone, password) VALUES (?, ?, ?, ?, ?)");
        $insertQuery->bind_param("sssss", $firstName, $lastName, $email, $telefone, $hashedPassword);
        if ($insertQuery->execute()) {
            echo "<script>alert('Registration Successful! Redirecting to login...');</script>";
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
        $insertQuery->close();
    }
    $stmt->close();
}

if (isset($_POST['signIn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['passwordIN'] );

    $stmt = $conn->prepare("SELECT * FROM membres WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['ID_Membre'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['is_admin'] = $row['is_admin'] ?? 0;

            if ($_SESSION['is_admin'] == 1) {
                header("Location: admin.php");
            } else {
                header("Location: homepage.php");
            }
            exit();
        } else {
            echo "<script>alert('Incorrect Password!');</script>";
        }
    } else {
        echo "<script>alert('Email Not Found!');</script>";
    }
    $stmt->close();
}
?>
