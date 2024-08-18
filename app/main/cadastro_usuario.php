<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Monitoramento do tempo</title>
</head>
<header>
<div class="breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="http://localhost/app/main/">Home</a></li>
            <li class="breadcrumb-item"><a href="geolocalizacao.php">GeoLocalização</a></li>
            <li class="breadcrumb-item"><a href="geolocalizacao.php">Tempo</a></li>
            <li class="breadcrumb-item"><a href="cadastro_usuario.php">Cadastro Usuario</a></li>
        </ol>
    </nav>
</div>
</header>
<div class="card" style="max-width:18rem;">
    <div class="card-header">
        Usuario Cadastro
    </div>
    <div class="card-body">
      <form method="post">
        <h5 class="card-title">Nome</h5>
            <input type="text" id="nome" name="nome" />
            
            <h5 class="card-title">Casa_Cep</h5>
            <input type="text" id="casa_cep" name="casa_cep"/>
        
            <h5 class="card-title">Email</h5>
            <input type="email" id="email" name="email" />
            <h5 class="card-title">Senha</h5>
            
            <input type="password" id="senha" name="senha"/>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <input type="submit" value="Submit" />    
        </form>
    </div>

</div>
<?php

    $url = "http://localhost/api/public/criar_usuario";
    $nome = $_POST['nome'];
    $casa_cep = $_POST['casa_cep'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];    
    
    $data = array(
        "nome" => $nome,
        "casa_cep" => $casa_cep,
        "email" => $email,
        "senha" => $senha,
    );

    // Cria o contexto de stream para uma solicitação POST
    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        // Trate o erro aqui
        echo 'Erro na solicitação';
    }

    echo $result;
    
?>