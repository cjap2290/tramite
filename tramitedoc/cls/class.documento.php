<?php 
class Documento{
	
	var $_id;
	var $_codigo;
	var $_tipo;
	var $_numero;
	var $_referencia;
	var $_anexo;
	var $_numero_folio;
	var $_fecha;
	var $_fecha_registro;
	var $_asunto;
	var $_observacion;
	var $_prioridad;
	var $_destino;
	var $_remitente;
	var $_estado;
	var $_historial; 
	var $_historiala; 
	var $_borradores_respuesta;
	var $_escaneos;

	function Documento($id = 0 ){
		
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM documentos WHERE id_documento = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){
				$row = $query->VerRegistro();
				 $this->_codigo 	= $row['codigo_documento'];
				 $this->_tipo 		= new TipoDocumento($row['id_tipo_documento']);
				 $this->_remitente 	= new Remitente($row['id_remitente']);
				 $this->_estado 	= new Estado($row['id_estado']);
				 $this->_prioridad 	= new Prioridad($row['id_prioridad']);
				 $this->_numero	 	= $row['numero_documento'];
				 $this->_asunto 	= $row['asunto_documento'];
				 $this->_referencia = $row['referencia_documento'] ;
				 $this->_anexo 		= $row['anexo_documento'] ;
				 $this->_numero_folio = $row['numero_folio_documento'] ;
				 $this->_fecha 		= $row['fecha_documento'] ;
				 $this->_fecha_registro = $row['fecha_registro_documento'] ;
				 $this->_observacion= $row['observacion_documento'] ;				 
				 $this->_destino 	= $row['destino_documento'] ;
				 
				 
				 $sql_historial = "SELECT * FROM historial_documentos WHERE id_documento = '".$this->_id."' ";
				 $query_historial = new Consulta($sql_historial);
				 while($rowh = $query_historial->VerRegistro()){
				 	
					$this->_historial[] = array(
						'id'            =>	$rowh['id_historial_documento'],
						'area'          =>	new Area($rowh['id_area']),
						'destino'       =>	new Usuario($rowh['id_usuario_destino']),
						'fecha'         =>	$rowh['fecha_historial_documento'] ,
						'original'      =>	$rowh['original_historial_documento'] ,
						'accion'        =>	new Accion($rowh['id_accion']) ,
						'estado'        =>	new Estado($rowh['id_estado']),
                        'observacion' 	=>	$rowh['observacion_historial_documento'],
						'usuario'       =>	new Usuario($rowh['id_usuario'])
					); 
				}
				
				$sql_ahistorial = "SELECT * FROM historial_atencion WHERE id_documento = '".$this->_id."' ";
				 $query_ahistorial = new Consulta($sql_ahistorial);
				 while($rowha = $query_ahistorial->VerRegistro()){
				 	
					$this->_historiala[] = array(
						'id' 		=>	$rowha['id_historial_documento'],
						'area' =>	new Area($rowha['id_area']),
						'destino' 	=>	new Usuario($rowha['id_usuario_destino']),
						'fecha' 	=>	date('d-m-Y H:i:s',strtotime($rowha['fecha_historial_atencion'])),	
						'original'	=>	$rowha['original_historial_atencion'] ,
						'accion' 	=>	new Accion($rowha['id_accion']) ,
						'estado' 	=>	new Estado($rowha['id_estado']),
						'usuario' 	=>	new Usuario($rowha['id_usuario'])								
					); 
				}				
				
				$sql_br = "SELECT * FROM borradores_respuesta WHERE id_documento = '".$this->_id."' ";
				 $query_br = new Consulta($sql_br);
				 while($rowbr = $query_br->VerRegistro()){
				 	
					$this->_borradores_respuesta[] = array(
						'id' 		=>	$rowbr['id_borrador_respuesta'],
						'fecha' 	=>	$rowbr['fecha_borrador_respuesta'] ,
						'aprobacion'=>	$rowbr['aprobacion_borrador_respuesta'] ,
						'fecha' 	=>	$rowbr['vobo_borrador_respuesta'] ,
						'descripcion'=>	$rowbr['descripcion_borrador_respuesta'] ,
						'usuario' 	=>	new Usuario($rowbr['id_usuario'])								
					); 
				}
				
				$sql_de = "SELECT * FROM documentos_escaneados WHERE id_documento = '".$this->_id."' ";
				 $query_de = new Consulta($sql_de);
				 while($rowde = $query_de->VerRegistro()){
				 				 	
					$this->_escaneos[] = array(
						'id' 		=>	$rowde['id_documento_escaneado'],
						'nombre' 	=>	$rowde['nombre_documento_escaneado']
					);					 
				}								 				 
			}
		}	
	}

	
	function getFechaRespuesta(){
		
		$fecha_exacta = strtotime($this->_fecha_registro);		
		$tiempo_extra = ($this->_prioridad->getTiempoHorasRespuesta() * 3600);		
		$fecha_respuesta =  date("d-m-Y H:i",$fecha_exacta + $tiempo_extra); 
		
		return $fecha_respuesta;
	}
	
	function setFechaRespuesta($horas){
		
		$fecha_exacta = strtotime($this->_fecha_registro);		
		$tiempo_extra = ($horas * 3600);		
		$fecha_respuesta =  date("d-m-Y H:i",$fecha_exacta + $tiempo_extra); 
		
		return $fecha_respuesta;
	}	
	
	function getId(){
		return $this->_id;
	} 
	
	function getTipoDocumento(){
		return $this->_tipo;
	
	}
	
	function getEscaneos(){
		return $this->_escaneos;
	
	}	
	
	function getPrioridad(){
		return $this->_prioridad;
	}
	
	function getAccion(){
		return $this->_accion;
	}
	
	function getEstado(){
		return $this->_estado;
	}
	
	function getAsunto(){
		return $this->_asunto;
	}
	
	function getNumero(){
		return $this->_numero;
	}
	
	function getNumeroFolio(){
		return $this->_numero_folio;
	}
	
	function getRemitente(){
		return $this->_remitente;
	}
	
	function getHistorial(){
		return $this->_historial;
	}
	
	function getHistorialAtencion(){
		return $this->_historiala;
	}
	
	function getCodigo(){
		return $this->_codigo;
	}
	
	function getReferencia(){
		return $this->_referencia;
	}
	
	function getAnexo(){
		return $this->_Anexo;
	}
	
	function getFecha(){
		return date('d-m-Y',strtotime($this->_fecha));
	}
	
	function getFechaRegistro(){
		return date('d-m-Y',strtotime($this->_fecha_registro));
	}
	
	function getHoraRegistro(){
		return date('H:i:s',strtotime($this->_fecha_registro));
	}
	
	function getBorradoresRespuesta(){
		return $this->_borradores_respuesta;
	}

    function getObservacion(){
		return $this->_observacion;
	}
	
	function isOriginalCopia($original){
		$return;
		if( $original == 1){
			$return = "Original";
		}else{
			$return = "Copia";
		}
		return $return;		
	}
	
		
	function ActivarDocumento($usuario){
		$sql = "INSERT INTO documentos_usuario VALUES( '".$this->_id."', '".$usuario->getId()."', '','".date('Y-m-d H:i:s')."')";
		$query = new Consulta($sql);		
	}
	
	function getAtencion($usuario, $id_documento){
		if( $usuario->verificarDocumentoAtendido($id_documento) == TRUE ){
			echo "Activado";
		}else{
		  	echo "<a href='".$_SERVER['PHP_SELF']."?opcion=activar&id=".$id_documento."'>Activar</a>";
		}		
	} 	
	
	function addHistorialAtencion(){
		
		$sql = "INSERT INTO historial_atencion VALUES('','','".$this->_id."','".$_POST['usuario']."','".$_POST['area']."','".date('Y-m-d H:i:s')."','".$_POST['categoria']."','".$_POST['accion']."','".$_POST['user']."','4','')";
		$query = new Consulta($sql);
		
		$sql2 = "INSERT INTO borradores_respuesta VALUES('','".date('Y-m-d H:i:s')."','".$this->_id."','','','".$_POST['comentario']."','".$_POST['user']."' )";
		$query2 = new Consulta($sql2);
		
		
	}

    function finalizarDocumento($id_borrador){

        //borrador como elegido
       $sql_borr = "Update borradores_respuesta
                    set aprobacion_respuesta_borrador = 1
                    where id_borrador_respuesta= ".$id_borrador;

        //modificar documento
        $sql_doc = "Update documentos set id_estado=12 where id_documento = ".$this->_id;

        //modificar historial_documentos
        $fecha=date("Y-m-d h:m:s");
        $sql_hist_doc = "Update historial_documentos set id_estado=12 where id_documento = ".$this->_id;

        //modificar historial_atencion
        $fecha=date("Y-m-d h:m:s");
        $sql_hist_ate = "Update historial_atencion set id_estado=12 where id_documento = ".$this->_id;

        $query1 = new Consulta($sql_borr);
        $query2 = new Consulta($sql_doc);
        $query3 = new Consulta($sql_hist_doc);
        $query4 = new Consulta($sql_hist_ate);
        
    }
}
?>