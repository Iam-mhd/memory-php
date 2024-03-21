<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['nom'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté ou si ses informations ne sont pas définies
    header("Location: connexion.php");

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('./asset/acceuil.jpg');
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            color: white;
        }
        p {
            text-align: center;
            color: white;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            display: block;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-image: url('./asset/acceuil.jpg');
        }
        form {
            margin-left: 20px;
            margin-top: 20px;
        }
        button {
            padding: 10px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #c82333;
        }
        .container {
            margin-left: 200px; /* Marge pour laisser de l'espace vide à gauche */
            padding: 20px;
            background-image: url('./asset/acceuil2.jpg');
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenue, <?= $_SESSION['user']['nom'] ?></h1>
        <p>Que souhaitez-vous faire aujourd'hui ?</p>
        <ul>
            <li><a href="inscrire_etudiant.php">Inscrire un étudiant</a></li>
            <li><a href="inscrire_admin.php">Inscrire un administrateur</a></li>
            <li><a href="memoires.php">Opérations sur les mémoires</a></li>
        </ul>
        <form action="deconnexion.php" method="post">
            <button type="submit" name="logout">Déconnexion</button>
        </form>
    </div>
</body>
</html>
