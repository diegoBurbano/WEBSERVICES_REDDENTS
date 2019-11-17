<?php  

	class Consultorios
	{
	    /**
	     * summary
	     */
	    public function __construct()
	    {
	        
	    }

	    /**
	     * Método para obtener todos los Consultorios de la BD
	     * @param
	     * @return Json con la lista de todos los consultorios o false en caso de 
	     * 			no existir los ningún consultorio
	     */
	    public function listaDeConsultorios()
	    {
	    	try {
				$objCrud = new Crud();
				$objCrud->setTablas("consultorios");
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
	     * Método para obtener un consultorio de la BD a través de su id
	     * @param int id de consultorio
	     * @return Json con los datos del consultorio requerido o false en caso de 
	     * 			no existir el consultorio con el id indicado
	     */
	    public function obtenerConsultorio($id)
	    {
	    	try {
				$objCrud = new Crud();
				$objCrud ->setTablas("consultorios");
				$objCrud ->setExpresion("*");
				$objCrud ->setCondicion("CONS_ID = $id");
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
	     * Método para obtener un consultorio de la BD a través de su nit
	     * @param String nit de consultorio
	     * @return array con el id del consultorio o 0 en caso de no encontrarlo
	     */
	    public function obtenerIdConsultorio($nit)
	    {
	    	try {
				$objCrud = new Crud();
				$objCrud ->setTablas("consultorios");
				$objCrud ->setExpresion("CONS_ID");
				$objCrud ->setCondicion("CONS_NIT = '$nit'");
				$resultado = $objCrud->read();

				if ($resultado > 0) {
					return $objCrud->getFilas();
				}else {
					return 0;
				}

			} catch (PDOException $e) {
				echo '{"Error": {"text":'.$e->getMessage().'}';
			}
	    }

	    /**
	     * Método para registrar un consultorio de la BD
	     * @param array con los datos del consultorio
	     * @return true en caso de que el registro sea exitoso, o false en caso contrario 
	     */
	    public function registrarConsultorio($datos)
	    {
	    	$nit = $datos['nit'];
	    	$nombre = $datos['nombre'];
	    	$direccion = $datos['direccion'];
	    	$telefono = $datos['telefono'];
	    	$foto = $datos['foto'];
	    	$idUsuario = $datos['idUsuario'];

	    	try {
				$objCrud = new Crud();
				$objCrud ->setTablas("consultorios");
				$objCrud ->setCampos("CONS_NIT, CONS_NOMBRE, CONS_DIRECCION, CONS_TELEFONO, CONS_FOTO, USU_ID");
				$objCrud ->setValores("'$nit','$nombre','$direccion','$telefono','$foto','$idUsuario'");
				$resultado = $objCrud ->create();
				$id = -1;

				if($resultado){
					$id = $this->obtenerIdConsultorio($nit);
					$id = $id[0]['CONS_ID'];
					if ($id>0) {	
						$objCrud ->esquema($id);
					}
				}

				echo json_encode($resultado);

			} catch (PDOException $e) {
				echo '{"Error": {"text":'.$e->getMessage().'}';
			}
	    }

	    /*{"nitConsultorio":"12345",
		  "nombreConsultorio":"Sonria",
		  "direccionConsultorio":"calle 8 # 3-4",
		  "telefonoConsultorio":"55555",
		  "idUsuario":"1"
		 }*/

		/**
	     * Método para actualizar los datos un consultorio de la BD
	     * @param int id de consultorio, array con los datos del consultorio
	     * @return true en caso de que la actualización sea exitosa, o false en caso contrario 
	     */
		public function actualizarConsultorio($id,$datos)
		{
			$nit = $datos['nit'];
	    	$nombre = $datos['nombre'];
	    	$direccion = $datos['direccion'];
	    	$telefono = $datos['telefono'];
	    	$foto = $datos['foto'];

			try {
				$objCrud = new Crud();
				$objCrud ->setTablas("consultorios");
				$objCrud ->setCampos(" CONS_NIT = '$nit', CONS_NOMBRE = '$nombre', CONS_DIRECCION = '$direccion', CONS_TELEFONO = '$telefono', CONS_FOTO = '$foto'");
				$objCrud ->setCondicion("CONS_ID = '$id'");
				$resultado = $objCrud ->update();

				echo json_encode($resultado);
				

			} catch (PDOException $e) {
				echo '{"Error": {"text":'.$e->getMessage().'}';
			}
		}

		/**
	     * Método para eliminar un consultorio de la BD
	     * @param int id de consultorio
	     * @return true en caso de que se elimine, o false en caso contrario 
	     */
		public function eliminarConsultorio($id)
		{
			try {
				$objCrud = new Crud();
				$objCrud ->setTablas("consultorios");
				$objCrud ->setCondicion("CONS_ID = '$id'");
				$resultado = $objCrud ->delete();

				echo json_encode($resultado);

			} catch (PDOException $e) {
				echo '{"Error": {"text":'.$e->getMessage().'}';
			}
		}



	}

?>