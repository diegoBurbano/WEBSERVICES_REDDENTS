<?php 
	
	require_once 'conexion.php';


	/**
	 * Clase con la que se va a ejecutar cada uno de los crud
	 */
	class Crud
	{
		private $tablas;
		private $campos;
		private $expresion;
		private $condicion;
		private $agrupamiento;
		private $ordenamiento;
		private $valores;
		private $filas; 
	

	    /**
	     * Metodo Constructor
	     */
	    public function __construct()
	    {
	       	$this->tablas = null;
			$this->campos = null;
			$this->valores = null;
			$this->filas = null;
			$this->expresion = null;
			$this->condicion = null;
			$this->ordenamiento = null;
			$this->agrupamiento = null;
			$this->filas = null; 
	    }


	    /**
	     * Metodos Get de los atributos
	     */

	    public function getTablas()
	    {
	        return $this->tablas;
	    }

	    public function getCampos()
	    {
	        return $this->campos;
	    }

	    public function getValores()
	    {
	        return $this->valores;
	    }

	    public function getFilas()
	    {
	        return $this->filas;
	    }

	    public function getExpresion()
	    {
	        return $this->expresion;
	    }

	    public function getCondicion()
	    {
	        return $this->condicion;
	    }

	    public function getOrdenamiento()
	    {
	        return $this->ordenamiento;
	    }

	    public function getAgrupamiento()
	    {
	        return $this->agrupamiento;
	    }

	    /**
	     * Metodos Set de los atributos
	     */

	    public function setTablas($tablas)
	    {
	        $this->tablas = $tablas;
	    }

	    public function setCampos($campos)
	    {
	        $this->campos = $campos;
	    }

	    public function setValores($valores)
	    {
	        $this->valores = $valores;
	    }

	    public function setFilas($filas)
	    {
	        $this->filas = $filas;
	    }

	    public function setExpresion($expresion)
	    {
	        $this->expresion = $expresion;
	    }

	    public function setCondicion($condicion)
	    {
	        $this->condicion = $condicion;
	    }

	    public function setOrdenamiento($ordenamiento)
	    {
	        $this->ordenamiento = $ordenamiento;
	    }

    	public function setAgrupamiento($agrupamiento)
    	{
    	    $this->agrupamiento = $agrupamiento;
    	}	

    	/**
	     * Metodo para insertar
	     */

    	public function create(){

			$tablas = $this->tablas;
			$campos = $this->campos;
			$valores = $this->valores;

			$objconexion = new conexion();
			$idenlace = $objconexion->conectar();
			

			$sSQL = "INSERT INTO $tablas($campos) VALUES ($valores)";

			$pst = $idenlace ->prepare($sSQL);

			$resultado = $pst->execute();

			return $resultado;
		}

		public function read(){
			$tabla = $this->tablas;
			$expresion = $this->expresion;
			$condicion = $this->condicion;
			$agrupamiento = $this->agrupamiento;
			$ordenamiento = $this->ordenamiento;

			$sSQL = "SELECT $expresion FROM $tabla ";


			if (isset($condicion)) {
				$sSQL = $sSQL ." WHERE $condicion";
			}

			if (isset($agrupamiento)) {
				$sSQL = $sSQL." GROUP BY $agrupamiento";
			}

			if (isset($ordenamiento)) {
				$sSQL = $sSQL. " ORDER BY $ordenamiento";
			}

			//echo $sSQL;

			$objconexion = new conexion();
			$idenlace = $objconexion->conectar();

			$pst = $idenlace->prepare($sSQL);
			$pst -> execute();

			$numfil  = $pst->rowCount();

			if ($numfil>0) {
				
				//recorre los registros de un arreglo asociativo donde se devuelve el nombre de los campos de la tabla como un indice y se muestra en un arreglo con la funcion FETH_ASSOC

				while ($registro=$pst->fetch(PDO::FETCH_ASSOC)) {
				    $this->filas[]=$registro;
				}

				return $this->filas;
			}

			return $numfil;
		}

		// Metodo delete()

 		public function delete(){ 
 			$tablas = $this->tablas;
 			$condicion = $this->condicion;
 			
			$sSQL = "DELETE FROM $tablas WHERE $condicion";

			$objconexion = new conexion();
			$idenlace = $objconexion->conectar();

			$pst = $idenlace->prepare($sSQL);
			$resultado = $pst -> execute();

			return $resultado;			
 		}

 		// Metodo update()

 		public function update(){
 			$tablas = $this->tablas;
 			$campos =$this->campos;
 			$condicion = $this->condicion;
			$sSQL = "UPDATE $tablas SET $campos WHERE $condicion";
			//echo $sSQL;

			$objconexion = new conexion();
			$idenlance = $objconexion->conectar();

			$pst = $idenlance->prepare($sSQL);
			$resultado = $pst -> execute();

			return $resultado;
 		}

		// Metodo crear el esquema de un consultorio odontologico

		 public function esquema($idConsultorio){
			$scritp = " 
			
			/*==============================================================*/
			/* Table: AGENDAS                                               */
			/*==============================================================*/
			create table AGENDAS_".$idConsultorio."
			(
			   AGE_ID               int not null auto_increment,
			   ODO_ID               int not null,
			   AGE_FECINICIO        date not null,
			   AGE_FECFIN           date not null,
			   AGE_ESTADO           varchar(0),
			   primary key (AGE_ID)
			);

			/*==============================================================*/
			/* Table: ANTECEDENTES                                          */
			/*==============================================================*/
			create table ANTECEDENTES_".$idConsultorio."
			(
			   ANT_ID               int not null auto_increment,
			   ANT_NOMBRE           varchar(50) not null,
			   primary key (ANT_ID)
			);

			/*==============================================================*/
			/* Table: CARA_DIENTE                                           */
			/*==============================================================*/
			create table CARA_DIENTE_".$idConsultorio."
			(
			   CAR_ID               varchar(10) not null,
			   DIEN_ID              varchar(10) not null,
			   CAR_NOMBRE           varchar(50) not null,
			   CAR_ESTADO           varchar(100) not null,
			   primary key (CAR_ID)
			);

			/*==============================================================*/
			/* Table: CITAS                                                 */
			/*==============================================================*/
			create table CITAS_".$idConsultorio."
			(
			   CIT_ID               int not null auto_increment,
			   ODO_ID               int not null,
			   PAC_ID               int not null,
			   CIT_HORAINICIO       time,
			   CIT_HORAFIN          time,
			   CIT_FECHA            date,
			   CIT_ESTADO           varchar(40),
			   CIT_DESCRIPCION      varchar(200),
			   primary key (CIT_ID)
			);

			/*==============================================================*/
			/* Table: CONVENCIONES                                          */
			/*==============================================================*/
			create table CONVENCIONES_".$idConsultorio."
			(
			   CON_ID               varchar(10) not null,
			   CON_NOMBRES          varchar(50) not null,
			   primary key (CON_ID)
			);

			/*==============================================================*/
			/* Table: DIAGNOSTICOS                                          */
			/*==============================================================*/
			create table DIAGNOSTICOS_".$idConsultorio."
			(
			   DIAG_ID              int not null auto_increment,
			   HIS_ID               int not null,
			   ODONT_ID             int not null,
			   DIAG_NOMBRE          varchar(50) not null,
			   DIAG_FECHA           date not null,
			   DIAG_DESCRIPCION     varchar(500) not null,
			   primary key (DIAG_ID)
			);

			/*==============================================================*/
			/* Table: DIENTE                                                */
			/*==============================================================*/
			create table DIENTE_".$idConsultorio."
			(
			   DIEN_ID              varchar(10) not null,
			   ODONT_ID             int not null,
			   DIEN_NOMBRE          varchar(50) not null,
			   DIEN_NUMERO          varchar(10) not null,
			   DIEN_TIPO_DIENTE     varchar(50) not null,
			   primary key (DIEN_ID)
			);

			/*==============================================================*/
			/* Table: HABITOS_ORALES                                        */
			/*==============================================================*/
			create table HABITOS_ORALES_".$idConsultorio."
			(
			   HA_ID                int not null,
			   HA_NOMBRE            varchar(50) not null,
			   primary key (HA_ID)
			);

			/*==============================================================*/
			/* Table: HISTORIA_CLINICA                                      */
			/*==============================================================*/
			create table HISTORIA_CLINICA_".$idConsultorio."
			(
			   HIS_ID               int not null auto_increment,
			   PAC_ID               int not null,
			   HIS_FECATENCION      date not null,
			   HIS_HORATENCION      time not null,
			   HIS_MOTIVOCONSULTA   varchar(500) not null,
			   HIS_OBSERVACION      varchar(500) not null,
			   primary key (HIS_ID)
			);

			/*==============================================================*/
			/* Table: HORARIOS                                              */
			/*==============================================================*/
			create table HORARIOS_".$idConsultorio."
			(
			   HOR_ID               int not null auto_increment,
			   AGE_ID               int not null,
			   JORNADA              varchar(10) not null,
			   HOR_HORAINICIO       time not null,
			   HOR_HORAFINAL        time not null,
			   HOR_FECHA            date not null,
			   HOR_ESTADO           varchar(50) not null,
			   primary key (HOR_ID)
			);

			/*==============================================================*/
			/* Table: ODONTOGRAMA                                           */
			/*==============================================================*/
			create table ODONTOGRAMA_".$idConsultorio."
			(
			   ODONT_ID             int not null auto_increment,
			   ODONT_TIPO_ID        varchar(50) not null,
			   ODONT_FECHA          date not null,
			   primary key (ODONT_ID)
			);

			/*==============================================================*/
			/* Table: ODONTOLOGOS                                           */
			/*==============================================================*/
			create table ODONTOLOGOS_".$idConsultorio."
			(
			   ODO_ID               int not null auto_increment,
			   ODO_DOCUMENTO       	varchar(10) not null,
			   ODO_TIPO_DOCUMENTO   varchar(30) not null,
			   ODO_PRIMER_NOMBRE    varchar(50) not null,
			   ODO_SEGUNDO_NOMBRE   varchar(50),
			   ODO_PRIMER_APELLIDO  varchar(50) not null,
			   ODO_SEGUNDO_APELLIDO varchar(50),
			   ODO_DIRECCION        varchar(50) not null,
			   ODO_TELEFONO         varchar(10) not null,
			   ODO_ESPECIALIDAD     varchar(50) not null,
			   ODO_FECNACIMIENTO    date not null,
			   ODO_FECREGISTRO      date not null,
			   ODO_GENERO           char(1) not null,
			   ODO_FOTO             varchar(100),
			   primary key (ODO_ID)
			);

			/*==============================================================*/
			/* Table: PACIENTES                                             */
			/*==============================================================*/
			create table PACIENTES_".$idConsultorio."
			(
			   PAC_ID               int not null auto_increment,
			   PAC_DOCUMENTO		varchar(10) not null,
			   PAC_TIPO_DOCUMENTO   varchar(30) not null,
			   PAC_PRIMER_NOMBRE    varchar(50) not null,
			   PAC_SEGUNDO_NOMBRE   varchar(50),
			   PAC_PRIMER_APELLIDO  varchar(50) not null,
			   PAC_SEGUNDO_APELLIDO varchar(50),
			   PAC_DIRECCION        varchar(50) not null,
			   PAC_TELEFONO         varchar(10) not null,
			   PAC_FECNACIMIENTO    date not null,
			   PAC_REGISTRO         date not null,
			   PAC_GENERO           char(1) not null,
			   PAC_FOTO             varchar(100),
			   primary key (PAC_ID)
			);

			/*==============================================================*/
			/* Table: REL_CARADIENTE_CONVENCIONES                           */
			/*==============================================================*/
			create table REL_CARADIENTE_CONVENCIONES_".$idConsultorio."
			(
			   RCC_ID               int not null,
			   CAR_ID               varchar(10) not null,
			   CON_ID               varchar(10) not null,
			   primary key (RCC_ID)
			);

			/*==============================================================*/
			/* Table: REL_HISTORIA_ANTECEDENTES                             */
			/*==============================================================*/
			create table REL_HISTORIA_ANTECEDENTES_".$idConsultorio."
			(
			   RHA_ID               int not null auto_increment,
			   HIS_ID               int not null,
			   ANT_ID               int not null,
			   RHA_TIPO_ANTECEDENTE varchar(50),
			   primary key (RHA_ID)
			);

			/*==============================================================*/
			/* Table: REL_HISTORIA_HABITOS                                  */
			/*==============================================================*/
			create table REL_HISTORIA_HABITOS_".$idConsultorio."
			(
			   RHH_ID               int not null auto_increment,
			   HIS_ID               int not null,
			   HA_ID                int not null,
			   primary key (RHH_ID)
			);

			/*==============================================================*/
			/* Table: TRATAMIENTOS                                          */
			/*==============================================================*/
			create table TRATAMIENTOS_".$idConsultorio."
			(
			   TRA_ID               int not null auto_increment,
			   DIAG_ID              int not null,
			   TRA_NOMBRE           varchar(50) not null,
			   TRA_DESCRIPCION      varchar(200) not null,
			   TRA_FECINICIO        date not null,
			   TRA_FECFINAL         date not null,
			   primary key (TRA_ID)
			);

			alter table AGENDAS_".$idConsultorio." add constraint FK_CREA foreign key (ODO_ID)
			      references ODONTOLOGOS_".$idConsultorio." (ODO_ID) on delete cascade on update cascade;

			alter table CARA_DIENTE_".$idConsultorio." add constraint FK_VISUALIZA foreign key (DIEN_ID)
			      references DIENTE_".$idConsultorio." (DIEN_ID) on delete restrict on update restrict;

			alter table CITAS_".$idConsultorio." add constraint FK_RELATIONSHIP_3 foreign key (ODO_ID)
			      references ODONTOLOGOS_".$idConsultorio." (ODO_ID) on delete cascade on update cascade;

			alter table CITAS_".$idConsultorio." add constraint FK_RESERVA foreign key (PAC_ID)
			      references PACIENTES_".$idConsultorio." (PAC_ID) on delete cascade on update cascade;

			alter table DIAGNOSTICOS_".$idConsultorio." add constraint FK_LLEVA foreign key (HIS_ID)
			      references HISTORIA_CLINICA_".$idConsultorio." (HIS_ID) on delete restrict on update restrict;

			alter table DIAGNOSTICOS_".$idConsultorio." add constraint FK_RELACIONA foreign key (ODONT_ID)
			      references ODONTOGRAMA_".$idConsultorio." (ODONT_ID) on delete restrict on update restrict;

			alter table DIENTE_".$idConsultorio." add constraint FK_GUARDA foreign key (ODONT_ID)
			      references ODONTOGRAMA_".$idConsultorio." (ODONT_ID) on delete restrict on update restrict;

			alter table HISTORIA_CLINICA_".$idConsultorio." add constraint FK_TIENE foreign key (PAC_ID)
			      references PACIENTES_".$idConsultorio." (PAC_ID) on delete restrict on update restrict;

			alter table HORARIOS_".$idConsultorio." add constraint FK_INCLUYE foreign key (AGE_ID)
			      references AGENDAS_".$idConsultorio." (AGE_ID) on delete cascade on update cascade;

			alter table REL_CARADIENTE_CONVENCIONES_".$idConsultorio." add constraint FK_REL_CARADIENTE_CONVENCIONES foreign key (CON_ID)
			      references CONVENCIONES_".$idConsultorio." (CON_ID) on delete restrict on update restrict;

			alter table REL_CARADIENTE_CONVENCIONES_".$idConsultorio." add constraint FK_REL_CARADIENTE_CONVENCIONES2 foreign key (CAR_ID)
			      references CARA_DIENTE_".$idConsultorio." (CAR_ID) on delete restrict on update restrict;

			alter table REL_HISTORIA_ANTECEDENTES_".$idConsultorio." add constraint FK_REL_HISTORIA_ANTECEDENTES foreign key (ANT_ID)
			      references ANTECEDENTES_".$idConsultorio." (ANT_ID) on delete restrict on update restrict;

			alter table REL_HISTORIA_ANTECEDENTES_".$idConsultorio." add constraint FK_REL_HISTORIA_ANTECEDENTES2 foreign key (HIS_ID)
			      references HISTORIA_CLINICA_".$idConsultorio." (HIS_ID) on delete restrict on update restrict;

			alter table REL_HISTORIA_HABITOS_".$idConsultorio." add constraint FK_REL_HISTORIA_HABITOS foreign key (HA_ID)
			      references HABITOS_ORALES_".$idConsultorio." (HA_ID) on delete restrict on update restrict;

			alter table REL_HISTORIA_HABITOS_".$idConsultorio." add constraint FK_REL_HISTORIA_HABITOS2 foreign key (HIS_ID)
			      references HISTORIA_CLINICA_".$idConsultorio." (HIS_ID) on delete restrict on update restrict;

			alter table TRATAMIENTOS_".$idConsultorio." add constraint FK_PRODUCE foreign key (DIAG_ID)
			      references DIAGNOSTICOS_".$idConsultorio." (DIAG_ID) on delete restrict on update restrict;

			
			";
			
			$objconexion = new conexion();
			$idenlace = $objconexion->conectar();

            $pst = $idenlace->prepare($scritp);
			$resultado = $pst -> execute();
			return $resultado;

        }
	}

?>