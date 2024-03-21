<?php
include 'connexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    try {
        $connect = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpswd);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $connect->prepare("INSERT INTO etudiant (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)");
        $query->bindParam(':nom', $nom);
        $query->bindParam(':prenom', $prenom);
        $query->bindParam(':email', $email);
        $query->bindParam(':mot_de_passe', $mot_de_passe);

        $query->execute();

        echo "Étudiant inscrit avec succès!";
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }

}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Étudiant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000;
            color: #fff;
        }
        h1 {
            text-align: center;
            margin-top: 50px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1); /* Couleur de fond semi-transparente */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1); /* Ombre semi-transparente */
        }
        div {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type='text'],
        input[type='email'],
        input[type='password'] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #fff;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.1); /* Couleur de fond semi-transparente */
            color: #fff;
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
    </style>
</head>
<body>
    <h1>Inscription Étudiant</h1>
    <form method="post">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>
        <button type="submit">Inscrire</button>
    </form>
</body>
</html>
