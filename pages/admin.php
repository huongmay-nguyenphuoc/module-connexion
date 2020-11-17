<?php
session_start();

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=moduleconnexion;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$query = "SELECT id FROM utilisateurs WHERE login='admin'";
$sqlcheck =  $bdd->prepare($query);
$sqlcheck->execute();
$admin = $sqlcheck->fetch();

if ($_SESSION['id'] == $admin['id'])
{
    $queryusers = "SELECT * FROM utilisateurs";
    $sql =  $bdd->prepare($queryusers);
    $sql->execute();

    echo '<html><table>';
    $i = 0;
        while ($usertable = $sql->fetch(PDO::FETCH_ASSOC))
        {
            if($i == 0) {
                echo '<thead>';
                    foreach($usertable as $key => $value) 
                    {
                        echo '<th>' . $key . '</th>';
                    }
                echo '</thead>';
                $i= 1;
            }

            echo '<tbody>';
            foreach ($usertable as $value) 
            {
                echo '<td>' . $value . '</td>';
            }
        echo  '</tbody>';
        }
    echo '</table></html>'; 
}

else 
{
    echo 'Cher-chère '. $_SESSION['login'] . ' Vous n\'avez pas les droits pour afficher cette page.
    <a href="../index.php">Revenir à l\'accueil</a>';
}


$bdd = null;
?>