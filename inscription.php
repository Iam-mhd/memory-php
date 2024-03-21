<?php
include("connexion.php");

// Initialisez les variables pour éviter les erreurs
$error = ["nom" => "", "prenom" => "", "login" => "", 'pwd' => ""];
$nom = isset($_POST['nom']) ? $_POST['nom'] : "";
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : ""; // Ajoutez cette ligne
$login = isset($_POST['email']) ? $_POST['email'] : ""; // Changez 'login' en 'email'

if (isset($_POST['btn'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['pwd'];
    $mot_de_passe_confirm = $_POST['pwd2'];

    // Vérifier si les mots de passe correspondent
    if ($mot_de_passe != $mot_de_passe_confirm) {
        echo "<script>alert('Les mots de passe doivent être identiques !')</script>";
    } else {
        // Vérifier si l'email existe déjà
        $query_check_email = $connect->prepare("SELECT * FROM etudiant WHERE email = :email");
        $query_check_email->execute([':email' => $email]);
        if ($query_check_email->rowCount() > 0) {
            echo "<script>alert('Cet email est déjà utilisé !')</script>";
        } else {
            // Insérer l'utilisateur dans la base de données
            $query_insert_user = $connect->prepare("INSERT INTO etudiant (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)");
            $query_insert_user->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':mot_de_passe' => $mot_de_passe
            ]);

            echo "<script>alert('Utilisateur créé avec succès !')</script>";
            header("Location: index.php");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/css/style.css">
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('./asset/fond_ecran.jpg');
        }
        .image {
            display: block;
            margin: 20px auto;
        }
        .haut {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .inscrire {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .inshaut {
            text-align: center;
        }
        .inshaut strong {
            font-size: 20px;
            color: #333;
        }
        .inshaut p {
            color: #666;
            margin: 10px 0 20px;
        }
        .sepins {
            margin: 20px auto;
            width: 50%;
            border: none;
            border-top: 1px solid #ccc;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
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
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <img class="image" src="../asset/img/logo-QuizzSA.png" alt="">
    <div class="haut">Le plaisir de jouer</div>
    <div class="inscrire">
        <div class="inshaut">
            <strong>S'INSCRIRE</strong>
            <p>Pour tester votre niveau de culture générale ! </p>
            <hr class="sepins">
            <form action="" method="post" enctype="multipart/form-data" id="form">
                <div>
                    <label for="">Prénom</label>
                    <input type="text" name="prenom" error="error-1" value="<?= $prenom ?>" class="putins">
                </div>
                <span id="error-1"><?= isset($error['prenom']) ? $error['prenom'] : ''; ?></span>

                <div>
                    <label for="">Nom</label>
                    <input type="text" name="nom" error="error-2" value="<?= $nom ?>" class="putins">
                </div>
                <span id="error-2"><?= isset($error['nom']) ? $error['nom'] : ''; ?></span>
                <div>
                    <label for="">Email</label>
                    <input type="text" name="email" error="error-3" value="<?= $email ?>" class="putins">
                </div>
                <span id="error-3"><?= isset($error['email']) ? $error['email'] : ''; ?></span>
                <div>
                    <label for="">Password</label>
                    <input type="password" error="error-4" name="pwd" class="putins">
                </div>
                <span id="error-4"></span>
                <div>
                    <label for="">Confirmation</label>
                    <input type="password" error="error-5" name="pwd2" class="putins">
                </div>
                <span id="error-5"> <?= isset($error['pwd']) ? $error['pwd'] : ''; ?></span>
                <button type="submit" name="btn" class="btn">Créer compte</button>
                <a href="index.php">RETOUR</a>
            </form>
        </div>
    </div>
</body>

</html>


    <script>
        const inputs = document.getElementsByTagName("input");
        for (input of inputs) {
            input.addEventListener("keyup", function(e) {
                if (e.target.hasAttribute("error")) {
                    var idDivError = e.target.getAttribute("error");
                    document.getElementById(idDivError).innerText = ""
                }
            })
        }

        document.getElementById("form").addEventListener("submit", function(e) {
            const inputs = document.getElementsByTagName("input");
            var error = false;
            for (input of inputs) {
                if (input.hasAttribute("error")) {
                    var idDivError = input.getAttribute("error");
                    if (!input.value) {
                        document.getElementById(idDivError).innerText = "Ce champ est obligatoire !";
                        error = true;
                    }

                }
            }
            if (error) {
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>

</html>
