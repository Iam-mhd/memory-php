<?php
session_start(); // Démarre la session

include 'functions.php';
include 'connexion.php';

$database = new Database($dbhost, $dbname, $dbuser, $dbpswd);

// Traitement du formulaire pour ajouter un mémoire
if (isset($_FILES['memoire'])) {
    // Vérifie si le fichier a été correctement uploadé
    if ($_FILES['memoire']['error'] === UPLOAD_ERR_OK) {
        // Récupère le nom du fichier
        $file_name = $_FILES['memoire']['name'];
        // Déplace le fichier vers le répertoire de stockage des mémoires
        move_uploaded_file($_FILES['memoire']['tmp_name'], 'memoires/' . $file_name);
        // Enregistre le mémoire dans la base de données
        $database->addMemory($student_name, $file_name);
        // Rafraîchit la page pour afficher les changements
        header("Refresh:0");
    } else {
        // Affiche un message d'erreur si le fichier n'a pas été correctement uploadé
        echo "Erreur lors de l'upload du fichier.";
    }
}

// Récupère tous les mémoires de l'étudiant depuis la base de données
$student_memories = $database->getAllMemories();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Étudiant</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .logout-btn {
            float: right;
        }
        .memoire-input {
            margin-bottom: 10px;
        }
    button.envoie_fichier {
    padding: 10px 20px; 
    border: none; 
    border-radius: 5px; 
    background-color: #4CAF50;
    color: white;
    font-size: 16px; 
    cursor: pointer; 
}

button.envoie_fichier:hover {
    background-color: #45a049; 
}

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Espace Étudiant</h1>
        <p>Bienvenue, </p>
        <form action="" method="post" enctype="multipart/form-data" class="memoire-input">
            <input class="fichier" type="file" name="memoire" accept=".pdf">
            <button class="envoie_fichier" type="submit">Ajouter Mémoire</button>
        </form>
        <a href="deconnexion.php" class="logout-btn">Se Déconnecter</a>
        <table>
            <tr>
                <th>Nom du Mémoire</th>
                <th>Action</th>
            </tr>
            <?php foreach ($student_memories as $memory) { ?>
                <tr>
                    <td><?php echo $memory['titre']; ?></td>
                    <td>
                        <a href="memoires/<?php echo $memory['titre']; ?>" target="_blank">Voir</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
