<?php
 
 use Psr\Http\Message\ResponseInterface as Response;
 use Psr\Http\Message\ServerRequestInterface as Request;
 
require '../vendor/autoload.php';
require 'lib/connect_db.php';

$conexion = DataBase::getConexion();

$app = new \Slim\App();

$app->get('/', function (Request $request, Response $response, $args) {
    $datos = array('status' => 'done', 'data' => "Hola! Bienvenido al API Rest");
    return $response->withJson($datos, 200);
});

$app->group('/api', function () use ($app) {
    $app->post('/farmacias/login', 'login');
    $app->post('/farmacias/create', 'crearFarmacia');
    $app->get('/farmacias/{id}', 'obtenerFarmacia');
    $app->post('/farmacias/mascercana', 'obtenerFarmaciaCercana');
});
 

function login(Request $request, Response $response)
{
    global $conexion;

    $headers = $request->getHeaders();
	$json = json_decode(utf8_encode($request->getBody()));
	if ($json=="")
	{
		$datos = array('status' => 'error', 'data' => "Debe enviar el formato correcto en el Body");
        return $response->withJson($datos, 404);
	}

    $syscore01_user=$json->user;
    $syscore01_pass=md5($json->pass);

    if($syscore01_user=="" || $syscore01_pass=="")
	{
        $datos = array('status' => 'error', 'data' => "Debes completar todos los campos");
        return $response->withJson($datos, 404);
	}

    try 
    {
        $stmt = $conexion->prepare('Select * from sys_core_cab_01_users where syscore01_user=? AND syscore01_pass=?') ;
        $stmt->bindParam(1, $syscore01_user);
        $stmt->bindParam(2, $syscore01_pass);
        $stmt->execute(); 
        if ($stmt->rowCount() != 0) 
        {

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_syscore01=$row['id_syscore01']; 
           
            $stmt = $conexion->prepare('UPDATE sys_core_cab_01_users SET syscore01_last_login = NOW() where id_syscore01=?') ;
            $stmt->bindParam(1, $id_syscore01);
            $stmt->execute(); 

            $datos = array('status' => 'done', 'data' => "Usuario Logueado correctamente.");
            return $response->withJson($datos, 200);
        }
        else 
        {
            $datos = array('status' => 'error', 'data' => "Error al iniciar sesión");
            return $response->withJson($datos, 404);
        }
    } 
    catch (PDOException $e) 
    {
        $datos = array('status' => 'error', 'data' => $e->getMessage());
        return $response->withJson($datos, 500);
    }
}

function crearFarmacia(Request $request, Response $response)
{
    global $conexion;

    $headers = $request->getHeaders();
	$json = json_decode(utf8_encode($request->getBody()));
	if ($json=="")
	{
		$datos = array('status' => 'error', 'data' => "Debe enviar el formato correcto en el Body");
        return $response->withJson($datos, 404);
	}
 
    $id_sysfarm01=$json->idFarmacia;
	$sysfarm01_nombre=($json->nombre);
	$sysfarm01_direccion=($json->direccion);
    $sysfarm01_latitud=$json->latitud;
    $sysfarm01_longitud=$json->longitud;

    if($id_sysfarm01=="" || $sysfarm01_nombre=="" || $sysfarm01_direccion=="" || $sysfarm01_latitud=="" || $sysfarm01_longitud=="")
	{
		$datos = array('status' => 'error', 'data' => "Debes completar todos los campos");
        return $response->withJson($datos, 404);
	}

    try 
    {
        $stmt = $conexion->prepare("select * from sys_farm_cab_01_farmacias where id_sysfarm01=?");
        $stmt->bindParam(1, $id_sysfarm01);
        $stmt->execute();
        if ($stmt->rowCount() != 0) 
        {
            $datos = array('status' => 'error', 'data' => "Ya existe una Farmacia con el ID: $id_sysfarm01");
            return $response->withJson($datos, 404);
        }
        else
        {
            $stmt = $conexion->prepare("INSERT INTO sys_farm_cab_01_farmacias(id_sysfarm01,sysfarm01_nombre,sysfarm01_direccion,sysfarm01_latitud,sysfarm01_longitud) values(?,?,?,?,?)");
            $stmt->bindParam(1, $id_sysfarm01);
            $stmt->bindParam(2, $sysfarm01_nombre);
            $stmt->bindParam(3, $sysfarm01_direccion);
            $stmt->bindParam(4, $sysfarm01_latitud);
            $stmt->bindParam(5, $sysfarm01_longitud);
            $stmt->execute();

            $datos = array('status' => 'done', 'data' => "Farmacia agregada correctamente.");
            return $response->withJson($datos, 200);
        }
    } 
    catch (PDOException $e) 
    {
        $datos = array('status' => 'done', 'data' => $e->getMessage());
        return $response->withJson($datos, 404);
    }
}

function obtenerFarmacia(Request $request, Response $response)
{
    global $conexion;
    try 
    {
        $stmt = $conexion->prepare("select * from sys_farm_cab_01_farmacias where id_sysfarm01=?");
        $id = $request->getAttribute('id');
        $stmt->bindParam(1, $id);
        $stmt->execute();
        if ($stmt->rowCount() != 0) 
        {
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $response->withJson($resultados, 200);
        }
        else 
        {
            $datos = array('status' => 'error', 'data' => "No se ha encontrado la Farmacia con ID: $id.");
            return $response->withJson($datos, 404);
        }
    } 
    catch (PDOException $e) 
    {
        $datos = array('status' => 'error', 'data' => $e->getMessage());
        return $response->withJson($datos, 500);
    }
}

function obtenerFarmaciaCercana(Request $request, Response $response)
{
    global $conexion;

    $headers = $request->getHeaders();
	$json = json_decode(utf8_encode($request->getBody()));
	if ($json=="")
	{
		$datos = array('status' => 'error', 'data' => "Debe enviar el formato correcto en el Body");
        return $response->withJson($datos, 404);
	}

    $sysfarm01_latitud=$json->latitud;
    $sysfarm01_longitud=$json->longitud;
    $sysfarm01_distancia_km=$json->distancia_km;

    if($sysfarm01_latitud=="" || $sysfarm01_longitud=="" || $sysfarm01_distancia_km=="")
	{
		$datos = array('status' => 'error', 'data' => "Debe enviar el formato correcto en el Body");
        return $response->withJson($datos, 404);
	}

    try 
    {
        $stmt = $conexion->prepare("SELECT * FROM (SELECT *,(((acos(sin(( ? * pi() / 180))*sin(( `sysfarm01_latitud` * pi() / 180)) +
         cos(( ? * pi() /180 ))*cos(( `sysfarm01_latitud` * pi() / 180)) * cos((( ? - `sysfarm01_longitud`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344)
        as distancia_km FROM sys_farm_cab_01_farmacias) sys_farm_cab_01_farmacias WHERE distancia_km <= ? ORDER BY distancia_km ASC LIMIT 1") ;
        $stmt->bindParam(1, $sysfarm01_latitud);
        $stmt->bindParam(2, $sysfarm01_latitud);
        $stmt->bindParam(3, $sysfarm01_longitud);
        $stmt->bindParam(4, $sysfarm01_distancia_km);
        $stmt->execute(); 
        if ($stmt->rowCount() != 0) 
        {
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $response->withJson($resultados, 200);
        }
        else 
        {
            $datos = array('status' => 'error', 'data' => "No se ha encontrado una Farmacia dentro de los $sysfarm01_distancia_km kms.");
            return $response->withJson($datos, 404);
        }
    } 
    catch (PDOException $e) 
    {
        $datos = array('status' => 'error', 'data' => $e->getMessage());
        return $response->withJson($datos, 500);
    }
}

$app->run();

?>