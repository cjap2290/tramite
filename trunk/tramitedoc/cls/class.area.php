<?php 

class Area{
	
	var $_id;
	var $_nombre;
	
	function Area($id = 0){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM areas WHERE id_area = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){	
				$row = $query->VerRegistro();		
				 $this->_nombre 	= $row['nombre_area'];
			}
		}	
	}
	
	function getId(){
		return $this->_id;
	}
	
	function getNombre(){
		return $this->_nombre;
	}
	
	function getUsuarios(){
		$return;
		$sql = " SELECT * FROM usuarios WHERE id_area= '".$this->_id."'";
		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$return[] = array(
				'id' => $row['id_usuario'],
				'nombre' => $row['nombre_usuario'],
				'apellidos' => $row['apellidos_usuario'],
				'email' => $row['email_usuario']				
			); 		
			
		}	
		return $return;
				
	}	
}
?>