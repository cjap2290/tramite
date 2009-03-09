<? include("includes.php"); $link=new Conexion();?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<?
if($q=new Consulta("ALTER TABLE anp ADD descripcion_solicitud LONGTEXT NOT NULL")){
	$query=new Consulta("select desc_resp,id_anp from anp_responsable");
	while($rows=$query->ConsultaVerRegistro()){
		$sql="Update anp set descripcion_solicitud='$rows[0]' where id_anp='$rows[1]'";
		echo $sql.'<br>';
		$q_=new Consulta($sql);
	}
}
?>
</body>
</html>
