<?php
session_start();


if (isset($_POST['formconnexion'])) {

    if (strlen($_POST['login']) > 255 or strlen($_POST['password']) > 255) { //vérification nb caractères
        $erreur = 'Soyez concis-e je vous prie, 255 caractères maximum par champ';
    } else { //récupération infos
        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);
    }

    if (isset($login, $password)) { //connexion bdd
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=moduleconnexion;charset=utf8', 'root', 'root');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        $query = 'SELECT * from utilisateurs WHERE login =? AND password=?'; //vérification utilisateur
        $sqlcheck = $bdd->prepare($query);
        $sqlcheck->execute([$login, $password]);
        $usercheck = $sqlcheck->rowCount();

        if ($usercheck == 1) {

            $user = $sqlcheck->fetch(); //création variables session
            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['password'] = $user['password'];

            if ($user['login'] == 'admin' and $user['password'] == 'admin') { //cas admin
                header("location: admin.php");
            } else { //autres cas
                header("location: profil.php");
            }
        } else {
            $erreur = "Il y a une erreur, vérifiez vos informations.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../style/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <title>Connexion - Cryonics</title>
</head>

<body class="Bodypages">

    <header>
        <nav>
            <a href="../index.php">Accueil</a>
            <a href="https://www.alcor.org/what-is-cryonics/">Qu'est-ce que Cryonics ?</a>
            <a href="https://www.alcor.org/news/">Actualités</a>
            <a href="https://www.alcor.org/library/">Bibliothèque</a>
            <a href="inscription.php">Inscription</a>
            <?php
            if (isset($_SESSION['id'])) {
                echo  '<a href="profil.php">Profil</a>';
                echo  '<a href="logout.php">Déconnexion</a>';
            }
            ?>
        </nav>
    </header>

    <main>

        <section class="sectionIntro">
            <article>
                <h1>Connexion</h1>
                <h3>Vous avez ouvert la porte du congélateur.
                    Il ne reste plus qu'à entrer.
                </h3>
            </article>

            <form action="connexion.php" method="post">
                <div>
                    <label for="login">Identifiant <abbr title="obligatoire">*</abbr></label>
                    <input type="text" id="login" name="login" required>
                </div>

                <div>
                    <label for="password">Mot de passe <abbr title="obligatoire">*</abbr></label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div>
                    <button class="bouton" type="submit" name="formconnexion">Entrer</button>
                    <?php
                    if (isset($erreur)) {
                        echo $erreur;
                    }
                    ?>
                </div>
            </form>
        </section>


    </main>

    <footer>
        <div>
            <p>© 2020 - Cryonics</p>
            <p>Tous droits réservés</p>
        </div>

        <a href=#>^</a>
    </footer>
</body>

</html>

<?php
$bdd = null;
?>