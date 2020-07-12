<?php
require 'config.php';
 function moyenne($id){
    $total = 0;
    $totalcoef = 0;
    global $conn;

    $nbMatieres = $conn->query("SELECT COUNT(*) AS total FROM matiere");
    $nbMatieres = mysqli_fetch_assoc($nbMatieres);
    $nbMatieres = $nbMatieres['total'];

    $notes = $conn->query("SELECT note.note as note, matiere.coef as coef FROM note INNER JOIN matiere on note.id_matiere = matiere.id WHERE id_etudiant = ".$id);
     if(mysqli_num_rows($notes) != $nbMatieres){
         return "Notes Incomplètes";
     }

    while($row = mysqli_fetch_assoc($notes)){
        $total += $row['note']*$row['coef'];
        $totalcoef += $row['coef'];
    }
     $moyenne = round($total / $totalcoef, 2);
    if($moyenne >= 10){
        return "<p style='color : #006400; font-weight: bold';>$moyenne</p>";
    }else{
        return "<p style='color : #b22222; font-weight: bold;'>$moyenne</p>";

    }
 }

 if ($conn->connect_error) {
    die("Erreur : " . $conn->connect_error);
}

$etudiants = $conn->query("SELECT * FROM etudiant");



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
    <script src="https://kit.fontawesome.com/8ead3c1037.js" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

</head>
<body>
<header>
    <div class="menu">
        <div class="menu-item"><a href="ajoutetudiant.php">Ajout étudiant</a></div>
        <div class="menu-item">	<a href="ajoutmatiere.php">Ajout matière</a></div>
        <div class="menu-item"><a href="formulaire.php">Notes</a></div>
        <div class="menu-item active"><a href="moyenne.php">Moyennes</a></div>
        <div class="menu-item"><a href="supprimer.php">Supprimer étudiant/matière</a></div>

    </div>
</header>
<div class="main-cont">
    <div class="inner-cont">
<table id="table-etudiants">
    <thead>
    <tr>
        <th class="sort" data-sort="num">N° Etudiant <i class="fas fa-sort"></i></th>
        <th class="sort" data-sort="nom">Nom <i class="fas fa-sort"></i></th>
        <th class="sort" data-sort="prenom">Prenom <i class="fas fa-sort"></i></th>
        <th class="sort" data-sort="moyenne">Moyenne <i class="fas fa-sort"></i></th>

   </tr>
    </thead>
    <tbody class="list">
    <?php
    while($row = mysqli_fetch_assoc($etudiants)){
        echo "<tr>
           <td class='num'>".$row['id']."</td>
           <td class='nom'>".$row['nom']."</td>
           <td class='prenom'>".$row['prenom']."</td>
           <td class='moyenne'>".moyenne($row['id'])."</td>

        </tr>";
    }
    $conn->close();

    ?>

    </tbody>
</table>
    </div>
</div>
</body>
<script>
    var options = {
        valueNames: [ 'num','nom','prenom','moyenne' ]
    };

    var myList = new List('table-etudiants', options);
</script>
</html>

