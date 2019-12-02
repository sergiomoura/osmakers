<?php

// Crinando conexão com db
include './includes/dbc.php';

// Pegando o id da os
$id = $_GET['id'];

// Preparando a consulta
$query = $dbc->prepare("select
o.*,
	b.nome,
	t.nome
from (
oss o
	inner join bairros b on o.id_bairro=b.id
	inner join tipos_de_os t on o.id_tipo=t.id
)

WHERE o.id=:id;");

// Executando
$query->execute([':id' => $id]);

// Recuperando os dados
$os = $query->fetchAll(PDO::FETCH_ASSOC);

//query equipes
$queryEquipe = $dbc->prepare("SELECT * FROM ");




$queryEquipes = $dbc->prepare("SELECT 
																e.id,
																e.nome
															FROM
															oss_equipes oe
																INNER JOIN equipes e ON oe.id_equipe=e.id
															WHERE id_os=:id");
$queryEquipes->execute([':id'=> $id]);
$equipes = $queryEquipes->fetchAll(PDO::FETCH_ASSOC);

echo("<pre>");
//print_r($equipes);
echo("</pre>");


//die();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
	<?php
	// Mostrando os dados
	echo ('<pre>');
	print_r($os);
	echo ('</pre>');

	foreach($equipes as $equipe){
		echo "$equipe[nome] <br>";
	 }
	?>
	<a href="edit-os.php?id=<?= $id ?>"><button> Editar </button></a>
	<form action="./includes/delete-os.php" method="post">
		<input type="hidden" value="<?= $id ?>" name="id_os">
		<input type="submit" value="Deletar">
	</form>

</body>
</html>
