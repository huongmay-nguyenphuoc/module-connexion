<?php

    if(isset($_POST['forminscription']))
    {

        foreach ($_POST as $element)
        {
            if(strlen($element)> 255)
            {
                $erreur = 'Soyez concis-e, 255 caractères maximum par champ';
            }
        }

        if ($_POST['password'] != $_POST['passwordverif'])
        {
            $erreur = 'Cher-chère futur-e congelé-e, le mot de passe ne correspond pas';
        }
    
        else {
            $login = htmlspecialchars($_POST['login']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $nom = htmlspecialchars($_POST['nom']);
            $password = htmlspecialchars($_POST['password']);
        }

        
        if(isset($login,$prenom,$nom,$password))

        {
                try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=moduleconnexion;charset=utf8', 'root', 'root');
            }
            
            catch(Exception $e)
            {
                    die('Erreur : '.$e->getMessage());
            }


            $query = 'SELECT login from utilisateurs WHERE login =?';
            $sqlcheck = $bdd->prepare($query);
            $sqlcheck->execute([$login]);
            $res = $sqlcheck->fetch();

                if ($res) {
                    $erreur = "Cet identifiant existe déjà.";
                }

                else
                {
                    $query = 'INSERT INTO utilisateurs (login, prenom, nom, password) VALUES (?,?,?,?)';
                    $sql = $bdd->prepare($query);
                    $sql->execute(array($login, $prenom, $nom, $password));
                    header("location: connexion.php");
                }
        }

    }
    
?>



<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="connexion.css" />
    <title>Inscription - Cryonics</title>
</head>

    <body>
    <header>
            <nav>
                <a href="../index.php">Accueil</a>
                <a href ="https://www.alcor.org/what-is-cryonics/">Qu'est-ce que Cryonics ?</a>
                <a href="https://www.alcor.org/news/">Actualités</a>
                <a href="https://www.alcor.org/library/">Bibliothèque</a>
                <a href="connexion.php">Connexion</a>
                <?php 
                if (isset($_SESSION['id']))
                {
                    echo  '<a href="profil.php">Profil</a>';
                }
                ?>
            </nav>
    </header>

    <main>

        <section>
            <h1>Inscription</h1>
            <h3>
                Faites le choix qui changera la fin de votre histoire.
                Rejoignez le congélateur.
            </h3>
        </section>

        <form action="inscription.php" method="post">
            <div>
                <label for="login">Identifiant <abbr title="obligatoire">*</abbr></label>
                <input type="text" id="login" name="login" required>
            </div>

            <div>
                <label for="prenom">Prénom <abbr title="obligatoire">*</abbr></label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div>
                <label for="nom">Nom <abbr title="obligatoire">*</abbr></label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div>
                <label for="password">Mot de passe <abbr title="obligatoire">*</abbr></label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="passwordverif">Confirmation du mot de passe <abbr title="obligatoire">*</abbr></label>
                <input type="password" id="passwordverif" name="passwordverif" required>
            </div>

            <div>
                <button type="submit" name="forminscription">Ouvrir la porte</button>
            </div>
        </form>

        <p>Si le formulaire est valide, vous serez immédiatement redirigé-e vers la page de connexion.</p>
        <?php
            if (isset($erreur))
            {
                echo $erreur;
            }
        ?>

    </main>

    <footer>
        <p>© 2020 - Cryonics</p>
        <p>Tous droits réservés</p>
    </footer>

</body>

</html>


<?php 
$bdd = null;
?>