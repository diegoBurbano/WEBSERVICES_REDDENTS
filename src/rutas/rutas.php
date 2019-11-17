<?php  

	// require 'usuarios.php';

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	
	$app = new \Slim\App;


	/*==============================================================*/
	/* Rutas para el crud de Usuario                                */
	/*==============================================================*/

	$app->get('/usuarios/getAll', function (Request $request, Response $response) {

		$usuario = new Usuarios();
		$usuario->listaDeUsuarios();
		
	});

	$app->get('/usuarios/getForId/{id}', function (Request $request, Response $response) {

		$id = $request->getAttribute('id');
		$usuario = new Usuarios();
		$usuario->obtenerUsuarioPorId($id);
		
	});

	$app->get('/usuarios/getForEmail/{email}', function (Request $request, Response $response) {

		$email = $request->getAttribute('email');
		$usuario = new Usuarios();
		$usuario->obtenerUsuarioPorEmail($email);
		
	});

	$app->post('/usuarios/insert', function (Request $request, Response $response) {
		$datos = [
		    "nombre" => $request->getParam('nombreUsuario'),
		    "email" => $request->getParam('emailUsuario'),
		    "telefono" => $request->getParam('telefonoUsuario'),
		    "pass" => $request->getParam('passUsuario'),
		    "rol" => $request->getParam('rolUsuario')
		];
		$usuario = new Usuarios();
		$usuario->registrarUsuario($datos);
	});

	$app->put('/usuarios/update/{id}', function (Request $request, Response $response) {

		$id = $request->getAttribute('id');
		$datos = [
		    "nombre" => $request->getParam('nombreUsuario'),
		    "email" => $request->getParam('emailUsuario'),
		    "telefono" => $request->getParam('telefonoUsuario')
		];
		$usuario = new Usuarios();
		$usuario->actualizarUsuario($id,$datos);
	});

	$app->delete('/usuarios/delete/{id}', function (Request $request, Response $response) {

		$id = $request->getAttribute('id');
		$usuario = new Usuarios();
		$usuario->eliminarUsuario($id);
	});


	/*==============================================================*/
	/* Rutas para el crud de Consultorios                           */
	/*==============================================================*/

	$app->get('/consultorios/getAll', function (Request $request, Response $response) {

		$consultorio = new Consultorios();
		$consultorio->listaDeConsultorios();
		
	});

	$app->get('/consultorios/get/{id}', function (Request $request, Response $response) {

		$id = $request->getAttribute('id');
		$consultorio = new Consultorios();
		$consultorio->obtenerConsultorio($id);
		
	});

	$app->post('/consultorios/insert', function (Request $request, Response $response) {
		$datos = [
		    "nit" => $request->getParam('nitConsultorio'),
		    "nombre" => $request->getParam('nombreConsultorio'),
		    "direccion" => $request->getParam('direccionConsultorio'),
		    "telefono" => $request->getParam('telefonoConsultorio'),
		    "foto" => $request->getParam('fotoConsultorio'),
		    "idUsuario" => $request->getParam('idUsuario')
		];
		$consultorio = new Consultorios();
		$consultorio->registrarConsultorio($datos);
	});

	$app->put('/consultorios/update/{id}', function (Request $request, Response $response) {

		$id = $request->getAttribute('id');
		$datos = [
		   	"nit" => $request->getParam('nitConsultorio'),
		    "nombre" => $request->getParam('nombreConsultorio'),
		    "direccion" => $request->getParam('direccionConsultorio'),
		    "telefono" => $request->getParam('telefonoConsultorio'),
		    "foto" => $request->getParam('fotoConsultorio')
		];
		$consultorio = new Consultorios();
		$consultorio->actualizarConsultorio($id,$datos);
	});

	$app->delete('/consultorios/delete/{id}', function (Request $request, Response $response) {

		$id = $request->getAttribute('id');
		$usuario = new Usuarios();
		$usuario->eliminarUsuario($id);
	});

?>