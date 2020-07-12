<?php
require 'config.php';

$etudiants = $conn->query("SELECT * FROM etudiant");
$matieres = $conn->query("SELECT * FROM matiere");




if(isset($_POST['submit-btn'])){
    $stmt = $conn->prepare("REPLACE INTO note(id_etudiant, id_matiere, note) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $idEtudiant, $idMatiere, $note);
    $idEtudiant = $_POST['etudiant'];
    $conn->query("DELETE FROM note WHERE id_etudiant = ".$idEtudiant);


    foreach($_POST as $key => $value){
        if (strstr($key, 'matiere')){
            $idMatiere = str_replace('matiere','',$key);
            if(!empty($_POST[$key])){
            $note = htmlspecialchars($conn -> real_escape_string($_POST[$key]), ENT_QUOTES, 'UTF-8');
            $stmt->execute();}

        }

    }
    $stmt->close();
    $conn->close();
    $msg = "<p class='message' style='margin-top: 7px; text-align: center; font-size: 1.1em; font-weight: bold; color: #006400;' >Notes mises à jours avec succès</p>";
}


?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire saisie de notes</title>
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
        <div class="menu-item active"><a href="formulaire.php">Notes</a></div>
        <div class="menu-item"><a href="moyenne.php">Moyennes</a></div>
        <div class="menu-item"><a href="supprimer.php">Supprimer étudiant/matière</a></div>

    </div>
</header>
<div class="main-cont">
    <div class="inner-cont">
<form method="post" action="formulaire.php">
   <div class="select-student">
       <p style="font-weight: bold;">Étudiant</p>
    <select name="etudiant" id="etudiant" onchange="notes()">
    <?php
    while($row = mysqli_fetch_assoc($etudiants))
    {
    echo "<option value='".$row['id']."'>".$row['id']." - ".$row['nom']." ".$row['prenom']."</option>";
    }
    ?>
    </select></div>
    <table>
        <thead>
        <tr>
            <th>Matière</th>
            <th class='coef'>Coefficient</th>
            <th>Note</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($row = mysqli_fetch_assoc($matieres)){
            echo "<tr>
           <td>".$row['nom_matiere']."</td>
           <td>".$row['coef']."</td>
           <td><input class='note' type='number' id='matiere".$row['id']."' name='matiere".$row['id']."' min='0' max='20' step='0.01'></td>
        </tr>";
        }


        ?>

        </tbody>
    </table>
    <input type="submit" name="submit-btn" value="Valider" style="height: 50px; width: 100px;">
</form>
<?php echo $msg ?>
    </div>
</div>
</body>

<script>
    $(document).ready(function() {
        var selItem = sessionStorage.getItem("selectedStudent");
        $('#etudiant').val(selItem);
        clear();
        notes();
    });
    $('#etudiant').change(function() {
        var selVal = $(this).val();
        sessionStorage.setItem("selectedStudent", selVal);
    });

    $(".message").fadeOut(5000);
    function notes(){
        clear();
        let i = 0;
        $.post("getNotes.php", {id: $("#etudiant").val()})
            .done(function (data) {
                data = JSON.parse(data);
                for (var element of data){
                    setNote(element);
                }});
    }

    function setNote(element){
        let i = 0;
        let x = 'input[name=\"matiere'+element.id_matiere+'\"]';
        $(x).val(element.note);
    }

    function clear(){
        $( "input[name^='matiere']" ).val("");
    }
</script>

</html>

