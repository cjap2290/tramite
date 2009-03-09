<?  include("../includes.php");
	require_once("../libs/lib.php");
	require_once("cls/acceso_registro.cls.php");
	$link=new Conexion();
	//if($lectura){
		///session_register('acceso');
		//$_SESSION['acceso']['lectura']=$lectura;
		//$_SESSION['acceso']['escritura']=$escritura;
	//}
	
	$table="registro";
	if(!isset($pag)){ $pag = 1; } 
	$tampag = 20;
	$reg1 = ($pag-1) * $tampag;
	 
	$pags=array($pag,$tampag,$table,$reg1);
	set_time_limit(100);
	
?>
<html>
<head>
<title>Sistema de Tramite Documentario - SERNANP</title>


<link href="../style.css" type="text/css" rel="stylesheet">
<link href="../../style.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="../../libs/calendar/calendar-green.css" title="win2k-cold-1" /> 
<script type="text/javascript" src="../../libs/calendar/calendar.js"></script> 
<script type="text/javascript" src="../../libs/calendar/calendar-es.js"></script>   
<script type="text/javascript" src="../../libs/calendar/calendar-setup.js"></script> 
<script language="javascript" src="../js/js.js"> </script>
<script language="javascript" src="../../js/js.js"> </script>
<style type="text/css">
<!--
SPAN{
color:#FF0000;}
.Estilo1 {color: #003300}
-->
</style>
</head>
<body>

	<table  width='100%' border='0' height='100%' bgcolor='white' id="tabla">
		<tr>
			<td bgcolor="#00FF00" class="msgok1"> M&Oacute;DULO DE TRAMITE DOCUMENTARIO/ LISTADO DE DOCUMENTOS PARA DESPACHAR  </td>
</tr>
		<tr>
		<td valign="top" align="center">
<!--  PAGINA -->	<?
	
		 //if($_SESSION['acceso']['lectura']=="N" ){?>
					<table id="cuerpo" width="100%" align="center">
						<TR>
							<TD align="center" ><br>
							<form action="" method="post" name="f1">
							  <?	
									
									switch($opcion){
										case 'add':
											Registro::RegistraCabecera();
											Registro::RegistraAgregar();
												
										break;									
										case 'edit':	
											Registro::RegistraCabecera();									
											Registro::RegistraEditar($id);	
										break;
										case 'update':
											Registro::RegistraUpdate($id);
											Registro::RegistraListado();	
											
										break;
										case 'delete':
											Registro::RegistraDelete($idcons);
													
										break;
										case 'list':
											Registro::RegistraCabecera();	
										break;	
										case 'x';
											Registro::RegistraListado();
										break;
										case 'guardar';
											Registro::RegistraGuardar();
											Registro::RegistraCabecera();
											Registro::RegistraListado();		
										break;	
										case 'agre';
											Registro::RegistraCabecera();
											Registro::RegistraAgrega();
										case 'despachar':	
											Registro::RegistraCabecera();									
											Registro::ConsultarDocumento($id);	
										break;			
										default:	
											Registro::RegistraCabecera();
										break;
										}
									///Registro::RegistraListado();
								 	
								
							?>
							</form>							</TD>
						</TR>
					</table><?
				 /*}else if($_SESSION['acceso']['lectura']=="S") {
						echo "<div id=error align=\"center\"> Usted es usuario pero no esta autorizado para ver esta información </div><br><br>";
					}else{
						echo " <div id=error align=\"center\">ERROR: Usted esta tratando de entrar de manera incorrecta o su session a caducado</div><br><br>" ;
					}*/ ?>
    <!--  FIN DE CONTENIDO -->	</td></tr></table>				
<script language="javascript">
FullScreen();
</script>
</body>
</html>
