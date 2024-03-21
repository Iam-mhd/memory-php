<?php
session_start();
require_once('connexion.php'); // Inclure le fichier de connexion à la base de données
$error = "";
$message = "Login Form";

function connexion($email, $password, $connect) {
    // Recherche dans la table etudiant
    $query_etudiant = $connect->prepare("SELECT * FROM etudiant WHERE email = :email AND mot_de_passe = :mot_de_passe");
    $query_etudiant->execute([':email' => $email, ':mot_de_passe' => $password]);
    $user_etudiant = $query_etudiant->fetch(PDO::FETCH_ASSOC);

    // Recherche dans la table admin si l'utilisateur n'est pas trouvé dans la table etudiant
    if (!$user_etudiant) {
        $query_admin = $connect->prepare("SELECT * FROM admin WHERE email = :email AND mot_de_passe = :mot_de_passe");
        $query_admin->execute([':email' => $email, ':mot_de_passe' => $password]);
        $user_admin = $query_admin->fetch(PDO::FETCH_ASSOC);

        if ($user_admin) {
            $_SESSION['user'] = $user_admin;
            $_SESSION['statut'] = 'login';
            return "admin";
        }
    } else {
        $_SESSION['user'] = $user_etudiant;
        $_SESSION['statut'] = 'login';
        if ($user_etudiant['profil'] === "admin") {
            return "admin";
        } else {
            return "etudiant";
        }
    }

    return "error";
}

if (isset($_POST['btn'])) {
    $email = $_POST['login'];
    $password = $_POST['mdp'];
    $result = connexion($email, $password, $connect); // Utilisation de la fonction connexion avec la connexion à la base de données
    if ($result === "admin") {
        header("Location: admin.php");
        exit(); // Terminer le script après la redirection
    } elseif ($result === "etudiant") {
        header("Location: etudiant.php");
        exit(); // Terminer le script après la redirection
    } else {
        $error = "Cet utilisateur n'existe pas";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('./asset/fond_ecran.jpg');

        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .title {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .message {
            text-align: center;
            color: #ff0000;
            margin-bottom: 20px;
        }
        .box {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        form {
            margin-top: 20px;
        }
        input[type='text'],
        input[type='password'] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .inscription {
            margin-top: 10px;
            text-align: right;
        }
        .inscription a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="title">Le plaisir de jouer</div>
    <div class="message"><?= $message; if(!empty($error)){ echo $error; } ?></div>
    <div class="box">
        <form action="" method="post">
            <div>
                <input type="text" name="login" placeholder="Email" required>    
            </div>
            <div>
                <input type="password" name="mdp" placeholder="Mot de passe" required>               
            </div>
            <div>
                <button type="submit" name="btn">Connexion</button>
                <div class="inscription"><a href="inscription.php">S'inscrire?</a></div>
            </div>
        </form> 
    </div>

</div>

</body>
</html>
