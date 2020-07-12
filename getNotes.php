<?php

require 'config.php';


if ($conn->connect_error) {
    die("Erreur : " . $conn->connect_error);
}

$id = $_POST['id'];
$notesArray = array();
$notes = $conn->query("SELECT * FROM note where id_etudiant = ".$id);

while($row =mysqli_fetch_assoc($notes))
{
    $notesArray[] = $row;
}
echo json_encode($notesArray);

$conn->close();



