<?php include("includes.php"); 
	$id = isset($_GET['id']) ? $_GET['id'] : 0; 
			
	$sql = " DELETE FROM documentos_escaneados WHERE id_documento_escaneado = '".$id."' ";
	$query = new Consulta($sql);
	echo "Se eliminaron correctamente lo(s) documentos escaneados";
?>