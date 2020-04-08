<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;
use App\Database;

$container = new Container();
$container->set('renderer', function () {
    // Параметром передается базовая директория в которой будут храниться шаблоны
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return $this->get('renderer')->render($response, 'show.phtml');
});

$app->get('/update', function ($request, $response) {
    $data = new Database();
    $text = $data->select();
    $params = [
        'text' => $text
    ];
    return $this->get('renderer')->render($response, 'updateShow.phtml', $params);
});

$app->post('/update', function ($request, $response) {
    $data = new Database();
    $text = $request->getParsedBodyParam('text');
    $data->update($text);
    return $response->withRedirect('/article');
});

$app->get('/article', function ($request, $response) {
    var_dump($_FILES);
    $data = new Database();
    $text = $data->select();
    $params = [
        'text' => $text
    ];
    return $this->get('renderer')->render($response, 'articleShow.phtml', $params);
});

$app->post('/article', function ($request, $response) {
    $data = new Database();
    $text = $request->getParsedBodyParam('text');
    $data->insert($text);
    return $response->withRedirect('/article');
});

$app->run();