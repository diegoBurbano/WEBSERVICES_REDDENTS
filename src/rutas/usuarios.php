<?php  
	
	class Usuarios
	{
	    /**
	     * summary
	     */
	    public function __construct()
	    {
	        
	    }

	    /**
	     * Método para obtener todos los usuarios de la BD
	     * @param
	     * @return Json con la lista de todos los usurios o false en caso de 
	     * 			no existir los ningún usuario
	     */
	    public function listaDeUsuarios()
	    {
	    	try {
				$objCrud = new Crud();
				$objCrud->setTablas("usuarios");
				$objCrud->setExpresion("*");
				$resultado = $objCrud->read();

				if ($resultado > 0) {
					echo json_encode($objCrud->getFilas());
				}else {
					echo json_encode(false);
				}

			} catch (PDOException $e) {
				echo '{"Error": {"text":'.$e->getMessage().'}';
			}
	    }


	    /**
	     * Método para obtener un usuario de la BD
	     * @param int id de usuario 
	     * @return Json con los datos del usurio requerido o false en caso de 
	     * 			no existir el usuario con el id indicado
	     */
	    public function obtenerUsuarioPorId($id)
	    {
	    	try {
				$objCrud = new Crud();
				$objCrud ->setTablas("usuarios");
				$objCrud ->setExpresion("*");
				$objCrud ->setCondicion("USU_ID = '$id'");
				$resultado = $objCrud->read();

				if ($resultado > 0) {
					echo json_encode($objCrud->getFilas());
				}else {
					echo json_encode(false);
				}

			} catch (PDOException $e) {
				echo '{"Error": {"text":'.$e->getMessage().'}';
			}
	    }

	    /**
	     * Método para obtener el id de un usuario de la BD
	     * @param String email de usuario 
	     * @return Json con el id del usuario requerido o false en caso de 
	     * 			no existir el usuario con el email indicado
	     */
	    public function obtenerUsuarioPorEmail($email)
	    {
	    	try {
				$objCrud = new Crud();
				$objCrud ->setTablas("usuarios");
				$objCrud ->setExpresion("*");
				$objCrud ->setCondicion("USU_EMAIL = '$email'");
				$resultado = $objCrud->read();

				if ($resultado > 0) {
					echo json_encode($objCrud->getFilas());
				}else {
					echo json_encode(false);
				}

			} catch (PDOException $e) {
				echo '{"Error": {"text":'.$e->getMessage().'}';
			}
	    }

	    /**
	     * Método para registrar un usuario de la BD
	     * @param array con los datos del usuario
	     * @return true en caso de que el registro sea exitoso, o false en caso contrario 
	     */
	    public function registrarUsuario($datos)
	    {
	    	$nombre = $datos['nombre'];
	    	$email = $datos['email'];
	    	$telefono = $datos['telefono'];
	    	$pass = $datos['pass'];
	    	$rol = $datos['rol'];

	    	try {
				$objCrud = new Crud();
				$objCrud ->setTablas("usuarios");
				$objCrud ->setCampos("USU_NOMBRE, USU_EMAIL, USU_TELEFONO, USU_PASSWORD, USU_ROL");
				$objCrud ->setValores("'$nombre','$email','$telefono','$pass','$rol'");
				$resultado = $objCrud ->create();

				echo json_encode($resultado);

			} catch (PDOException $e) {
				echo '{"Error": {"text":'.$e->getMessage().'}';
			}
	    }

	    /*{"nombreUsuario":"Paco",
		  "emailUsuario":"paco@mail.com",
		  "telefonoUsuario":"55555",
		  "passUsuario":"321",
		  "rolUsuario":"Usuario"
		 }*/

		/**
	     * Método para actualizar los datos un usuario de la BD
	     * @param int id de usuario, array con los datos del usuario
	     * @return true en caso de que la actualización sea exitosa, o false en caso contrario 
	     */
		public function actualizarUsuario($id,$datos)
		{
			$nombre = $datos['nombre'];
	    	$email = $datos['email'];
	    	$telefono = $datos['telefono'];
	    	/*$pass = $datos['pass'];
	    	$rol = $datos['rol'];
			, USU_PASSWORD = '$pass', USU_ROL = '$rol'
	    	*/

			try {
				$objCrud = new Crud();
				$objCrud ->setTablas("usuarios");
				$objCrud ->setCampos(" USU_NOMBRE = '$nombre', USU_EMAIL = '$email', USU_TELEFONO = '$telefono'");
				$objCrud ->setCondicion("USU_ID = '$id'");
				$resultado = $objCrud ->update();

				echo json_encode($resultado);
				

			} catch (PDOException $e) {
				echo '{"Error": {"text":'.$e->getMessage().'}';
			}
		}

		/**
	     * Método para eliminar un usuario de la BD
	     * @param int id de usuario
	     * @return true en caso de que se elimine, o false en caso contrario 
	     */
		public function eliminarUsuario($id)
		{
			try {
				$objCrud = new Crud();
				$objCrud ->setTablas("usuarios");
				$objCrud ->setCondicion("USU_ID = '$id'");
				$resultado = $objCrud ->delete();

				echo json_encode($resultado);

			} catch (PDOException $e) {
				echo '{"Error": {"text":'.$e->getMessage().'}';
			}
		}



	}

?>