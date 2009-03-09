<?php 
class Acciones{
	
 
	
	function Acciones($id = 0){ 
	}
	
 
	
 
	
	function getAcciones(){
		$return;
		$sql = " SELECT * FROM accion WHERE categoria_accion='A' and id_accion ";
		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$return[] = array(
				'id' => $row['id_accion'],
				'nombre' => $row['nombre_accion']			
			); 		
			
		}	
		return $return;
	}	
}
?>