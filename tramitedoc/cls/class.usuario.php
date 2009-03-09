<?php 

class Usuario{
	
	var $_id; 
	var $_rol;
	var $_area;
	var $_nombre;
	var $_apellidos;
	var $_email;
	var $_login;
	var $_password;
	var $_fecha_ingreso;
	var $_lectura;  
	var $_estructura;  
	
	function Usuario($id){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM usuarios WHERE id_usuario = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){
				$row = $query->VerRegistro();
				$this->_rol = new Rol($row['id_rol']);
				$this->_area = new Area($row['id_area']);
				$this->_nombre = $row['nombre_usuario'];
				$this->_apellidos = $row['apellidos_usuario'];
				$this->_email = $row['email_usuario'];
				$this->_login = $row['login_usuario'];
				$this->_password = $row['password_usuario'] ;
				$this->_fecha_ingreso = $row['fecha_ingreso_usuario'];
				$this->_lectura = $row['lectura_usuario'];
				$this->_estructura = $row['estructura_usuario'];				
			}
		}	 
	} 
	
	function getIdDocumentos(){
		
		$return;
		
		$sql = "SELECT * FROM historial_documentos 
				WHERE id_usuario = '".$this->_id."' 
				GROUP BY id_documento 
				ORDER BY id_documento ";
		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$return[]['id'] = $row['id_documento'];	
		}
		
		return $return;		
	}	
	
	function getIdAtencion(){
		
		$return;
		
		$sql = "SELECT * FROM historial_atencion
				WHERE id_usuario_destino = '".$this->_id."' 
				GROUP BY id_documento 
				ORDER BY id_documento ";
		$query = new Consulta($sql);

        $c = 0;
		while($row = $query->VerRegistro()){
			$return[$c]['id'] = $row['id_documento'];
            $return[$c]['original'] = $row['original_historial_atencion'];
            $c++;
		}
		
		return $return;		
	}
	
	
	function getIdAtencionPorFiltro($campo="", $valor=""){
			
		$return;
		if($campo == "nombre_remitente"){
			$where = $campo == "nombre_remitente" ? " AND r.nombre_remitente like '%$valor%' " : "";
		}else{
			$where = $campo != "" ? " AND d.$campo like '%$valor%' " : ""  ;
		}
		   		
		
		$sql = "SELECT * FROM historial_atencion ha, documentos d, remitentes r 
				WHERE ha.id_usuario_destino = '".$this->_id."' AND
					d.id_documento= ha.id_documento AND
					r.id_remitente = d.id_remitente 	".
				$where." 
				GROUP BY d.id_documento 
				ORDER BY d.id_documento ";
				//echo $sql;
		$query = new Consulta($sql);

        $cont = 0;
		while($row = $query->VerRegistro()){
			$return[$cont]['id'] = $row['id_documento'];
            $return[$cont]['original'] = $row['original_historial_atencion'];
		}
		
		return $return;		
	}
	
	function verificarDocumentoAtendido($id_documento){
		
		$return;
		
		$sql = "SELECT * FROM documentos_usuario WHERE id_usuario = '".$this->_id."' AND id_documento = '".$id_documento."'";
		$query = new Consulta($sql);
		if($query->NumeroRegistros() > 0){
			$return = TRUE; 
		}else{
			$return = FALSE; 
		} 
		
		return $return;		
	}
		
	function getId(){
		return $this->_id;
	}
		
	function getNombre(){
		return $this->_nombre;
	}
		
	function getApellidos(){
		return $this->_apellidos;
	}
	
	function getNombreCompleto(){
		return $this->_nombre.' '.$this->_apellidos;
	}	
}

?>