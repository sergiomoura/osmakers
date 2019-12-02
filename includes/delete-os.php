<?php 

include "dbc.php";

$id = $_POST['id_os'];
$query = $dbc->prepare("DELETE FROM oss WHERE id = :id;");
$query->execute([':id' => $id]);

header('Location: ../index.php');
