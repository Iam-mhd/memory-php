<?php
include 'functions.php';
include 'connexion.php';
// Créer une instance de la classe Database avec les informations de connexion
$database = new Database($dbhost, $dbname, $dbuser, $dbpswd);

// Récupérer tous les mémoires depuis la base de données
$memories = $database->getAllMemories();

// Vérifier si le formulaire de suppression a été soumis
if (isset($_POST['delete_memory'])) {
    $memory_id = $_POST['memory_id'];
    $database->deleteMemory($memory_id);
    header("Refresh:0"); // Rafraîchir la page pour refléter les changements
}

// Vérifier si le formulaire de modification a été soumis
if (isset($_POST['modify_memory'])) {
    $memory_id = $_POST['memory_id'];
    $new_title = $_POST['new_title'];
    $new_theme = $_POST['new_theme'];
    $new_owner = $_POST['new_owner'];
    $new_name = $_POST['new_name'];
    $database->modifyMemory($memory_id, $new_title, $new_theme, $new_owner, $new_name);
    header("Refresh:0"); // Rafraîchir la page pour refléter les changements
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Mémoires</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('./asset/22.jpg');
        }
        h1 {
            text-align: center;
            color: red; /* Couleur verte */
            font-size: 24px; /* Taille de police plus grande */
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
            color: red; /* Couleur verte */
            font-size: 18px; /* Taille de police plus grande */
        }
        th {
            background-color: #f2f2f2;
        }
        input[type="text"] {
            padding: 5px;
            width: 100px;
            margin-right: 5px;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            font-size: 16px; /* Taille de police plus grande */
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Liste des Mémoires</h1>
    <table>
        <tr>
            <th>Titre</th>
            <th>Thème</th>
            <th>Propriétaire</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($memories as $memory) { ?>
            <tr>
                <td><?= $memory['titre'] ?></td>
                <td><?= $memory['theme'] ?></td>
                <td><?= $memory['proprietaire'] ?></td>
                <td>
                    <!-- Formulaire pour supprimer le mémoire -->
                    <form method="post" action="">
                        <input type="hidden" name="memory_id" value="<?= $memory['id'] ?>">
                        <button type="submit" name="delete_memory">Supprimer</button>
                    </form>
                    <!-- Formulaire pour modifier le mémoire -->
                    <form method="post" action="">
                        <input type="hidden" name="memory_id" value="<?= $memory['id'] ?>">
                        <input type="text" name="new_title" placeholder="Nouveau titre">
                        <input type="text" name="new_theme" placeholder="Nouveau thème">
                        <input type="text" name="new_owner" placeholder="Nouveau propriétaire">
                        <input type="text" name="new_name" placeholder="Nouveau nom du mémoire">
                        <button type="submit" name="modify_memory">Modifier</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
