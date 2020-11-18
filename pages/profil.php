<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=moduleconnexion;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_SESSION['id'])) {
    $query = 'SELECT * from utilisateurs WHERE id =?';
    $sqlcheck = $bdd->prepare($query);
    $sqlcheck->execute([$_SESSION['id']]);
    $user = $sqlcheck->fetch();
}


if (isset($_POST['login']) and isset($_POST['prenom']) and isset($_POST['nom']) and isset($_POST['password'])) {

    if ($_POST['password'] != $_POST['passwordverif']) {
        $erreur = 'Le mot de passe ne correspond pas';
    } elseif (strlen($_POST['login']) > 255 or  strlen($_POST['nom']) > 255 or strlen($_POST['prenom']) > 255 or strlen($_POST['password']) > 255) {
        $erreur = 'Soyez concis-e, 100 caractères maximum par champ';
    } else {
        $newpseudo = htmlspecialchars($_POST['login']);
        $newprenom = htmlspecialchars($_POST['prenom']);
        $newnom = htmlspecialchars($_POST['nom']);
        $newpassword = htmlspecialchars($_POST['password']);

        $query = 'UPDATE utilisateurs SET login = ?, prenom = ?, nom = ?, password = ? WHERE id = ?';
        $insertnewdata = $bdd->prepare($query);
        $insertnewdata->execute(array($newpseudo, $newprenom, $newnom, $newpassword, $_SESSION['id']));
        $succes = $newpseudo . ', le changement a bien été enregistré.';
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
    <title>Profil - Cryonics</title>
</head>

<body  class="Bodypages">

    <header>
        <nav>
            <a href="../index.php">Accueil</a>
            <a href="https://www.alcor.org/what-is-cryonics/">Qu'est-ce que Cryonics ?</a>
            <a href="https://www.alcor.org/news/">Actualités</a>
            <a href="https://www.alcor.org/library/">Bibliothèque</a>
            <a href="inscription.php">Inscription</a>
            <a href="connexion.php">Connexion</a>
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
                <h1>Votre profil de congelé-e</h1>
                <h3>Consultez et modifiez vos informations</h3>
            </article>

            <article>
                <?php
                if (isset($_SESSION['id'])) {
                    echo '<form action="profil.php" method="post">
                <div>
                    <label for="login">Identifiant</label>
                    <input type="text" id="login" name="login" value="' .
                        $user['login'] .
                        '"</div>

                <div>
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="' .
                        $user['prenom'] .
                        '"</div>

                <div>
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="' .
                        $user['nom'] .

                        '"</div>

                <div>
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" value="' .
                        $user['password'] .
                        '"</div>

                <div>
                    <label for="passwordverif">Confirmation du mot de passe</label>
                    <input type="password" id="passwordverif" name="passwordverif">
                </div>

                <div>
                    <button class="bouton" type="submit" name="formprofil">Envoyer</button>
                </div>
            </form>

            <p></p>';

                    if (isset($erreur)) {
                        echo $erreur;
                    } elseif (isset($succes)) {
                        echo $succes;
                    }
                } else {
                    echo "Pour accéder à cet espace, veuillez vous connecter.";
                }
                ?>
            </article>
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