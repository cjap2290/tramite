<?php 
class Accion{
	
	var $_id;
	var $_nombre;
	var $_categoria;
	
	function Accion($id = 0){
		$this->_id = $id;
		if( $this->_id > 0 ){
			$sql = "SELECT * FROM accion WHERE categoria_accion='A' and id_accion = '".$this->_id."'";
			$query = new Consulta($sql);
			if($query->NumeroRegistros()){	
				$row = $query->VerRegistro();		
				 $this->_nombre = $row['nombre_accion'];
				 $this->_categoria = $row['categoria_accion'];
			}
		}	
	}
	
	function getId(){
		return $this->_id;
	}
	
	function getNombre(){
		return $this->_nombre;
	}
	
	function getCategoria(){
		return $this->_categoria;
	}	
}
?>