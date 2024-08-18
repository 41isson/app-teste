<?php
require __DIR__ . '/../vendor/autoload.php';  // Caminho correto para o autoload
use Controller\TempoController;
use Controller\UserController;
use Slim\Factory\AppFactory;
use DAO\Connection;

$app = AppFactory::create();

// Define o caminho base se necessário
$app->setBasePath('/api/public');

// Rotas
$app->get('/', function ($request, $response, $args) {
    $response->getBody()->write("Página Inicial");
    return $response;
});

$app->get('/teste', function ($request, $response, $args) {
    $response->getBody()->write("teste");
    return $response;
});

$app->get('/conexao', function ($request, $response, $args) {
    $connection = new Connection();  // Instanciar a classe Connection
    $connectionMessage = $connection->getConnection();  // Chamar o método getConnection()
    $response->getBody()->write($connectionMessage);  // Escrever a mensagem na resposta
    return $response;
});

$app->get('/tempo', function ($request, $response, $args) {
    $controller = new TempoController();
    $data = $controller->getData();  
    $response->getBody()->write($data);  
    return $response;  
});


$app->get('/lista_usuario', function ($request, $response, $args) {
    $controller = new UserController();
    $data = $controller->getUser();  
    
    $response->getBody()->write($data);  
    return $response;  
});



$app->post('/criar_usuario', function ($request, $response, $args) {
    $controller = new UserController();

    // Extrair os dados da requisição como um array associativo
    $data = $request->getParsedBody();
    
    // Passar o array associativo para o controlador
    $result = $controller->postUser($data);

    // Codificar a resposta em JSON e definir o cabeçalho Content-Type
    $response->getBody()->write(json_encode($result));
    return $response->withHeader('Content-Type', 'application/json');
});


$app->run();
