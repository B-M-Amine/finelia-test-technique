<?php
require 'config.php';


if ($conn->connect_error) {
    die("Erreur : " . $conn->connect_error);
}
if(isset($_POST['submit-btn'])){

    $stmt = $conn->prepare("INSERT INTO etudiant(id, nom, prenom) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $num, $nom, $prenom);

    $num = htmlspecialchars($conn -> real_escape_string($_POST['num-etudiant']), ENT_QUOTES, 'UTF-8');
    $nom = htmlspecialchars($conn -> real_escape_string($_POST['nom-etudiant']), ENT_QUOTES, 'UTF-8');
    $prenom = htmlspecialchars($conn -> real_escape_string($_POST['prenom-etudiant']), ENT_QUOTES, 'UTF-8');

    $testID= $conn->query("SELECT COUNT(*) AS total FROM etudiant WHERE id=" . $num);
    $testID = mysqli_fetch_assoc($testID);
    $testID = $testID['total'];



    if(empty($nom) || empty($prenom) || empty($num)){
        $msg .= "<p class='message' style='margin-top: 7px; text-align: center; font-size: 1.1em; font-weight: bold; color: #b22222;' >Veuillez remplir tous les champs</p>";
        $err = true;
    }
    if($testID != 0){
        $msg .= "<p class='message' style='margin-top: 7px; text-align: center; font-size: 1.1em; font-weight: bold; color: #b22222;' >Ce numéro d'étudiant est déjà pris</p>";
        $err = true;
    }

    if(!isset($err)){
        $stmt->execute();
        $msg = "<p class='message' style='margin-top: 7px; text-align: center; font-size: 1.1em; font-weight: bold; color: #006400;' >Etudiant ajouté avec succès</p>";
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
    <title>Document</title>
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
        <div class="menu-item active"><a href="ajoutetudiant.php">Ajout étudiant</a></div>
        <div class="menu-item">	<a href="ajoutmatiere.php">Ajout matière</a></div>
        <div class="menu-item"><a href="formulaire.php">Notes</a></div>
        <div class="menu-item"><a href="moyenne.php">Moyennes</a></div>
        <div class="menu-item"><a href="supprimer.php">Supprimer étudiant/matière</a></div>

    </div>
</header>
<div class="main-cont">
    <div class="inner-cont-small">
    <form method="post" action="ajoutetudiant.php">
        <label>Numéro étudiant</label>
        <input type="text" name="num-etudiant" style="width: 100%" pattern="\b\d{5}\b" title="5 Chiffres" required><br>
        <label>Nom</label>
        <input type="text" name="nom-etudiant" style="width: 100%" required><br>
        <label>Prénom</label>
        <input type="text" name="prenom-etudiant" style="width: 100%" required><br>
        <input type="submit" name="submit-btn" style="display: block; margin: 0 auto; margin-top: 10px;" value="Valider">
    </form>
        <p class="message"><?php echo $msg ?></p>

    </div>
</div>
</body>
<script>
    $(".message").fadeOut(5000);
</script>
</html>


