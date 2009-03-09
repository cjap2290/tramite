<?php 
require_once("../includes.php");
session_start();
$link=new Conexion();

$sql = " SELECT * FROM usuarios WHERE usuario_usuario = '".$_POST['T1']."' and password_usuario = '".$_POST['T2']."' ";
$query = new Consulta($sql);

if( $query->numregistros() == 0 ){
	header("location: login.php");
}else{
	
	$row = $query->ConsultaVerRegistro();
	$_SESSION['usuario']['id'] = $row['id_usuario'];
	$_SESSION['usuario']['nombres'] = $row['nombre_usuario'].' '. $row['apellidos_usuario'];
	header("location: listado_documentos.php");
}

?>