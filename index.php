<?php
session_start();
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Accueil - Cryonics</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
</head>

<body id="bodyIndex">

    <header> <!-- nav barre -->
        <article></article>
        <nav>
            <a href="https://www.alcor.org/what-is-cryonics/">Qu'est-ce que Cryonics ?</a>
            <a href="https://www.alcor.org/news/">Actualités</a>
            <a href="https://www.alcor.org/library/">Bibliothèque</a>
            <?php 
            if (!isset($_SESSION['id'])) {
                echo '<a href="inscription.php">Inscription</a>
                <a href="connexion.php">Connexion</a>';
            } else {
                echo  '<a href="pages/profil.php">Profil</a>
                <a href="pages/logout.php">Déconnexion</a>';
            }
            ?>
        </nav>
    </header>

    <main>
        
        <section class="sectionIntro">
            <article id="articleTitle"> <!-- bloc gauche -->
                <h1>
                    Prolongez votre vie avec Cryonics.
                </h1>
                <h2>
                    Une vie ne devrait jamais prendre fin.
                    Quand la médecine d'aujourd'hui abandonne,
                    Cryonics prend le relais.
                </h2>
            </article>

            <article id="articleWelcome"> <!-- bloc droit -->
                <h3>Bienvenue
                    <?php
                    if (!empty($_SESSION['login'])) {
                        echo '<em>' . $_SESSION['login'] . '</em>';
                    } else {
                        echo '<em>futur-e congelé-e</em>';
                    }
                    ?>
                </h3>
                <?php
                if (isset($_SESSION['id'])) {
                    echo "<a class='bouton' href='pages/profil.php'>Votre profil de congelé-e</a>";
                } else {
                    echo "<a class='bouton' href='pages/inscription.php'>Rejoindre le Congélateur</a>";
                }
                ?>
            </article>
        </section>


        <section id="sectionFiller">
            <article>
                <h5>181</h5>
                <p>congelé-es</p>
            </article>

            <article>
                <h5>1317</h5>
                <p>futur-es congelé-es</p>
            </article>

            <article>
                <h5>3500</h5>
                <p>congélateurs disponibles</p>
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