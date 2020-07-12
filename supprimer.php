<?php

require 'config.php';

$etudiants = $conn->query("SELECT * FROM etudiant");
$matieres = $conn->query("SELECT * FROM matiere");

if(isset($_POST['submit-btn-etudiant'])){

$conn->query("DELETE FROM note WHERE id_etudiant = ".$_POST['etudiant']);
$conn->query("DELETE FROM etudiant WHERE id = ".$_POST['etudiant']);


$conn->close();

$msgetudiant = "<p class='message' style='margin-top: 7px; text-align: center; font-size: 1.1em; font-weight: bold; color: #006400;' >L'étudiant a bien été supprimé</p>";
header("Refresh:0");


}

if(isset($_POST['submit-btn-matiere'])){

    $conn->query("DELETE FROM note WHERE id_matiere = ".$_POST['matiere']);
    $conn->query("DELETE FROM matiere WHERE id = ".$_POST['matiere']);


    $conn->close();

    $msgmatiere = "<p class='message' style='margin-top: 7px; text-align: center; font-size: 1.1em; font-weight: bold; color: #006400;' >La matière a bien été supprimée</p>";
    header("Refresh:0");


}


?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
    <link rel="stylesheet" href="assets/style.css">
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
</head>
<body>
<header>
    <div class="menu">
        <div class="menu-item"><a href="ajoutetudiant.php">Ajout étudiant</a></div>
        <div class="menu-item">	<a href="ajoutmatiere.php">Ajout matière</a></div>
        <div class="menu-item"><a href="formulaire.php">Notes</a></div>
        <div class="menu-item"><a href="moyenne.php">Moyennes</a></div>
        <div class="menu-item active"><a href="supprimer.php">Supprimer étudiant/matière</a></div>
    </div>
</header>
<div class="main-cont">
    <div class="inner-cont-small">
        <form method="post" action="supprimer.php">
            <div>
                <p style="font-weight: bold;">Étudiant</p>
                <select name="etudiant" id="etudiant" onchange="notes()" >
                    <?php
                    while($row = mysqli_fetch_assoc($etudiants))
                    {
                        echo "<option value='".$row['id']."'>".$row['id']." - ".$row['nom']." ".$row['prenom']."</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="submit" name="submit-btn-etudiant" value="Supprimer" style="margin-top: 10px">

        </form>
        <?php echo $msgetudiant; ?>

        <form method="post" action="supprimer.php">
            <div style="margin-top: 50px;">
                <p style="font-weight: bold;">Matière</p>
                <select name="matiere" id="matiere" onchange="notes()" >
                    <?php
                    while($row = mysqli_fetch_assoc($matieres))
                    {
                        echo "<option value='".$row['id']."'>".$row['nom_matiere']."</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="submit" name="submit-btn-matiere" value="Supprimer" style="margin-top: 10px">

        </form>
        <?php echo $msgmatiere; ?>



    </div>
</div>

</body>
<script>
    $(".message").fadeOut(5000);
</script>
</html>
