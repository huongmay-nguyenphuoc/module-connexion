<?php
session_start();

try { //connexion bdd
    $bdd = new PDO('mysql:host=localhost;dbname=moduleconnexion;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$query = "SELECT id FROM utilisateurs WHERE login='admin'"; //récup id admin
$sqlcheck =  $bdd->prepare($query);
$sqlcheck->execute();
$admin = $sqlcheck->fetch();
?>


<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../style/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <title>Admin - Cryonics</title>
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
                <h1>Session Admin</h1>
                <h3>
                    A l'intérieur des congélateurs.
                </h3>
            </article>

            <article id="tableArticle">
                <?php
                if (isset($_SESSION['id']) and $_SESSION['id'] == $admin['id']) { //affichage tableau pour admin
                    
                    $queryusers = "SELECT * FROM utilisateurs";
                    $sql =  $bdd->prepare($queryusers);
                    $sql->execute();

                    echo '<table>';
                    $i = 0;
                    while ($usertable = $sql->fetch(PDO::FETCH_ASSOC)) { //création dynamique tableau
                        if ($i == 0) {
                            echo '<thead>';
                            foreach ($usertable as $key => $value) {
                                echo '<th>' . $key . '</th>';
                            }
                            echo '</thead>';
                            $i = 1;
                        }

                        echo '<tbody>';
                        foreach ($usertable as $value) {
                            echo '<td>' . $value . '</td>';
                        }
                        echo  '</tbody>';
                    }
                    echo '</table>';
                } 
                
                else { // utilisateur non admin
                    echo 'Cher-chère ';
                    if (isset($_SESSION['login'])) {
                        echo  $_SESSION['login'];
                    } else {
                        echo 'futur-e congelé-e';
                    }
                    echo ', vous n\'avez pas les droits pour afficher cette page.
                <a href="../index.php">Revenir à l\'accueil</a>';
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