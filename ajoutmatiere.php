<?php

require 'config.php';

if ($conn->connect_error) {
    die("Erreur : " . $conn->connect_error);
}
if(isset($_POST['submit-btn'])){

    $stmt = $conn->prepare("INSERT INTO matiere(nom_matiere, coef) VALUES (?, ?)");
    $stmt->bind_param("si",$nomMatiere, $coef);

    $nomMatiere = htmlspecialchars($conn -> real_escape_string($_POST['nom-matiere']), ENT_QUOTES, 'UTF-8');
    $coef = htmlspecialchars($conn -> real_escape_string($_POST['coef']), ENT_QUOTES, 'UTF-8');

    $testID= $conn->query("SELECT COUNT(*) AS total FROM matiere WHERE nom_matiere = '" . $nomMatiere . "'");
    $testID = mysqli_fetch_assoc($testID);
    $testID = $testID['total'];

    if($testID != 0){
        $msg .= "<p class='message' style='margin-top: 7px; text-align: center; font-size: 1.1em; font-weight: bold; color: #b22222;' >Cette matière existe déjà</p>";
        $err = true;
    }


    if(empty($nomMatiere) || empty($coef)){
        $msg .= "<p class='message' style='margin-top: 7px; text-align: center; font-size: 1.1em; font-weight: bold; color: #b22222;' >Veuillez remplir tous les champs</p>";
        $err = true;
    }

    if(!is_numeric($coef)){
        $msg .= "<p class='message' style='margin-top: 7px; text-align: center; font-size: 1.1em; font-weight: bold; color: #b22222;' >Coefficient invalide</p>";
        $err = true;
    }
   if(!isset($err)) {
       $stmt->execute();
       $msg = "<p class='message' style='margin-top: 7px; text-align: center; font-size: 1.1em; font-weight: bold; color: #006400;' >Matière ajoutée avec succès</p>";
   }
    $stmt->close();
    $conn->close();
}

?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajout matière</title>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
    <script
            src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/style.css">

</head>
<body>
<header>
    <div class="menu">
        <div class="menu-item"><a href="ajoutetudiant.php">Ajout étudiant</a></div>
        <div class="menu-item active">	<a href="ajoutmatiere.php">Ajout matière</a></div>
        <div class="menu-item"><a href="formulaire.php">Notes</a></div>
        <div class="menu-item"><a href="moyenne.php">Moyennes</a></div>
        <div class="menu-item"><a href="supprimer.php">Supprimer étudiant/matière</a></div>

    </div>
</header>
<div class="main-cont">
    <div class="inner-cont-small">
        <form method="post" action="ajoutmatiere.php">
    <label>Nom matière</label>
    <input type="text" name="nom-matiere" style="width: 100%" required><br>
    <label>Coefficient</label>
    <input type="number" min = "1" max = "9" step="1" name="coef" style="width: 100%" required><br>
    <input type="submit" name="submit-btn" style="display: block; margin: 0 auto; margin-top: 10px;" value="Valider">
</form>
        <?php echo $msg ?>

    </div>
</div>

</body>
<script>
    $(".message").fadeOut(5000);
</script>
</html>


