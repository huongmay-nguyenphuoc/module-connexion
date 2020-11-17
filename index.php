<?php
session_start();
?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Accueil - Cryonics</title>
  <link rel="stylesheet" href="index.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet"> 
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet"> 
</head>

<body>
    
    <header>
        <article></article>
        <nav>
            <a href ="https://www.alcor.org/what-is-cryonics/">Qu'est-ce que Cryonics ?</a>
            <a href="https://www.alcor.org/news/">Actualités</a>
            <a href="https://www.alcor.org/library/">Bibliothèque</a>
            <a href="pages/inscription.php">Inscription</a>
            <a href="pages/connexion.php">Connexion</a>
            <?php 
                if (isset($_SESSION['id']))
                {
                    echo  '<a href="pages/profil.php">Profil</a>';
                }
            ?>
        </nav>
    </header>

    <main>
        <section id="sectionIntro">
            <article id="articleTitle">
                <h1>
                   Prolongez votre vie avec Cryonics.
                </h1>

                <h2>
                    Une vie ne devrait jamais prendre fin. 
                    Quand la médecine d'aujourd'hui abandonne,
                    Cryonics prend le relais.
                </h2>
            </article>

            <article id="articleWelcome">
            <h3>Bienvenue
                    <?php
                        if (!empty($_SESSION['login']))
                        {
                            echo '<em>'.$_SESSION['login'].'</em>';
                        }

                        else 
                        {
                            echo '<em>futur-e congelé-e</em>';
                        }
                    ?>
            </h3>
                <?php 
                    if (isset($_SESSION['id']))
                    {
                        echo "<a href='pages/profil.php'>Votre profil de congelé-e</a>";
                    }

                    else 
                    {
                        echo "<a href=\"pages/inscription.php\">Rejoindre le Congélateur</a>";
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