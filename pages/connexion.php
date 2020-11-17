<?php
session_start();


    if(isset($_POST['formconnexion']))
    {   
       
        if(strlen($_POST['login'])>255 OR strlen($_POST['password'])>255)
        {
            $erreur = 'Soyez concis-e je vous prie, 255 caractères maximum par champ';
        }

        else 
        {
            $login = htmlspecialchars($_POST['login']);
            $password = htmlspecialchars($_POST['password']);
        }

        if(isset($login,$password))
        {
            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=moduleconnexion;charset=utf8', 'root', 'root');
            }

            catch(Exception $e)
            {
                die('Erreur : '.$e->getMessage());
            }


            $query = 'SELECT * from utilisateurs WHERE login =? AND password=?';
            $sqlcheck = $bdd->prepare($query);
            $sqlcheck->execute([$login, $password]);
            $usercheck = $sqlcheck->rowCount();
                
            if ($usercheck ==1) {

                    $user = $sqlcheck->fetch();
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['login'] = $user['login'];
                    $_SESSION['password'] = $user['password'];

                    if ($user['login'] == 'admin' AND $user['password'] == 'admin')
                    {
                        header("location: admin.php");
                    }

                    else 
                    {
                        header("location: profil.php");
                    }
            }

            else
            {
                $erreur = "Il y a une erreur, vérifiez vos informations.";
            } 
        }


    } 
?>




<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="connexion.css" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Parisienne&display=swap" rel="stylesheet">
    <title>Connexion - Cryonics</title>
</head>

<body>

    <header>
        <nav>
            <a href="../index.php">Accueil</a>
            <a href ="https://www.alcor.org/what-is-cryonics/">Qu'est-ce que Cryonics ?</a>
            <a href="https://www.alcor.org/news/">Actualités</a>
            <a href="https://www.alcor.org/library/">Bibliothèque</a>
            <a href="inscription.php">Inscription</a>
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
            <h1>Connexion</h1>
            <h3>Vous avez ouvert la porte du congélateur.
                Il ne reste plus qu'à entrer.
            </h3>
        </section>

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
                <button type="submit" name="formconnexion">Entrer</button>
            </div>
        </form>

        <?php
            if (isset($erreur))
            {
                echo $erreur;
            }

            elseif (isset($succes))
            {
                echo $succes;
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