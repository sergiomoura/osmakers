<?php

// Verificando se o formulário está sendo enviado
if ($_POST) {
  // Validar informações

  // Preparar consulta de atualização na base
  $dbc->prepare("UPDATE
                  oss
                SET
                  ENDERECO=:ENDERECO,
                  ID_BAIRRO=:ID_BAIRRO,
                  id_tipo=:id_tipo,
                WHERE ID=:ID");
  // Executar consulta

  // Redirecionar para a lista de OSs (index.php);
  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
</head>
<body>
<?php
include "./includes/dbc.php";

$id = $_GET['id'];

// Preparando consulta para levantar OS de ID $id
$query = $dbc->prepare("SELECT
                          o.*,
                          b.nome,
                          t.nome
                        FROM (
                        oss o
                          inner join bairros b on o.id_bairro=b.id
                          inner join tipos_de_os t on o.id_tipo=t.id
                        ) WHERE o.id=:id;");

// Executando a consulta preparada
$query->execute([
    ':id' => $id,
]);

// Capturando o resultado da minha consulta (só a primeira linha)
$os = $query->fetchAll(PDO::FETCH_ASSOC)[0];

// Preparar a consulta para levantar os bairros
$query = $dbc->prepare("SELECT id, nome FROM bairros");

// Executar a consulta
$query->execute();

// Capturar o resultado da minha consulta
$bairros = $query->fetchAll(PDO::FETCH_ASSOC);

// Preparar a consulta para levantar os tipos
$query = $dbc->prepare("SELECT id, nome FROM tipos_de_os");

// Executar a consulta
$query->execute();

// Capturar o resultado da minha consulta
$tipos = $query->fetchAll(PDO::FETCH_ASSOC);

?>
  <main class="container">
    <div class="row">
      <div class="col-8 offset-2">
        <form action="" method="post">

          <div class="form-group">
            <label for="endereco">Endereço</label>
            <input type="text" class="form-control" id="endereco" aria-describedby="endereco" value="<?=$os['endereco']?>">
          </div>

          <div class="form-group">
            <label for="bairros">Bairros</label>
            <select class="form-control">
              <option disabled>Selecione um bairro</option>
              <?php foreach ($bairros as $b): ?>
              <option
                <?=$b['id'] == $os['id_bairro'] ? 'selected' : ''?>
                value="<?=$b['id']?>">
                <?=$b['nome']?>
              </option>
              <?php endforeach;?>
            </select>
          </div>

          <div class="form-group">
            <label for="tipos">Tipos</label>
            <select class="form-control">
              <option disabled>Selecione um tipo</option>
              <?php foreach ($tipos as $t): ?>
              <option
                <?=$t['id'] == $os['id_tipo'] ? 'selected' : ''?>
                value="<?=$t['id']?>">
                <?=$t['nome']?>
              </option>
              <?php endforeach;?>
            </select>
          </div>

          <div class="form-group">
            <label for="valor">Valor</label>
            <input type="number" class="form-control" id="valor" value="<?=$os['valor']?>">
          </div>

          <div class="form-group">
            <label for="dprev">Duração Prev.</label>
            <input type="number" class="form-control" id="dprev" value="<?=$os['duracao_prev']?>">
          </div>

          <div class="form-group">
            <label for="dreal">Duração Real</label>
            <input type="number" class="form-control" id="dreal" value="<?=$os['duracao_real']?>">
          </div>
          <input type="hidden" name="id" value="<?=$id?>">
          <button class="btn btn-primary float-right" type="submit">Salvar</button>

        </form>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>
</body>
</html>