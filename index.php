<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Allow from any origin
if(isset($_SERVER["HTTP_ORIGIN"]))
{
    // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}
else
{
    //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
    header("Access-Control-Allow-Origin: *");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600");    // cache for 10 minutes

if($_SERVER["REQUEST_METHOD"] == "OPTIONS")
{
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}
//Autoload
$loader = require 'vendor/autoload.php';

//Instanciando objeto
$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

//Listando todos fornecedores
$app->get('/fornecedores/', function() use ($app){
	(new \controllers\Fornecedor($app))->lista();
});
//get fornecedor
$app->get('/fornecedor/:id', function($id) use ($app){
	(new \controllers\Fornecedor($app))->get($id);
});
$app->post('/fornecedor/', function() use ($app){
	(new \controllers\Fornecedor($app))->nova();
});
$app->delete('/fornecedor/:id', function($id) use ($app){
	(new \controllers\Fornecedor($app))->excluir($id);
});

$app->put('/fornecedor/:id', function($id) use ($app){
	(new \controllers\Fornecedor($app))->editar($id);
});


//Listando todos fornecedores
$app->get('/marcas/', function() use ($app){
	(new \controllers\Marca($app))->lista();
});
//get fornecedor
$app->get('/marca/:id', function($id) use ($app){
	(new \controllers\Marca($app))->get($id);
});
$app->post('/marca/', function() use ($app){
	(new \controllers\Marca($app))->nova();
});
$app->delete('/marca/:id', function($id) use ($app){
	(new \controllers\Marca($app))->excluir($id);
});

$app->put('/marca/:id', function($id) use ($app){
	(new \controllers\Marca($app))->editar($id);
});

//Listando categorias
$app->get('/categorias/', function() use ($app){
	(new \controllers\Categoria($app))->lista();
});
//get fornecedor
$app->get('/categoria/:id', function($id) use ($app){
	(new \controllers\Categoria($app))->get($id);
});
$app->post('/categoria/', function() use ($app){
	(new \controllers\Categoria($app))->nova();
});
$app->delete('/categoria/:id', function($id) use ($app){
	(new \controllers\Categoria($app))->excluir($id);
});

$app->put('/categoria/:id', function($id) use ($app){
	(new \controllers\Categoria($app))->editar($id);
});

//Listando categorias
$app->get('/subcategorias/', function() use ($app){
	(new \controllers\SubCategoria($app))->lista();
});
//get fornecedor
$app->get('/subcategoria/:id', function($id) use ($app){
	(new \controllers\SubCategoria($app))->get($id);
});
$app->post('/subcategoria/', function() use ($app){
	(new \controllers\SubCategoria($app))->nova();
});
$app->delete('/subcategoria/:id', function($id) use ($app){
	(new \controllers\SubCategoria($app))->excluir($id);
});

$app->put('/subcategoria/:id', function($id) use ($app){
	(new \controllers\SubCategoria($app))->editar($id);
});


//Rodando aplicação
$app->run();
