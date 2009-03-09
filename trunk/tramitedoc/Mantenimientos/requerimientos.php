<?  include("../../includes.php");
	require_once("../../libs/lib.php");
	require_once("cls/requerimientos.cls.php");
	$link=new Conexion();
	if($lectura){
		session_register('acceso');
		$_SESSION['acceso']['lectura']=$lectura;
		$_SESSION['acceso']['escritura']=$escritura;
	}
	
	$table="requerimientos";
	if(!isset($pag)){ $pag = 1; } 
	$tampag = 20;
	$reg1 = ($pag-1) * $tampag;
	 
	$pags=array($pag,$tampag,$table,$reg1);
	set_time_limit(100);
	
?>
<html>
<head>
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
-->
</style>
</head>
<body>
<script>
<!-- Deshabilita click derecho
var message="";
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if 
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers) 
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
// --> 
</script>
	<table  width='100%' border='0' height='100%' bgcolor='white' id="tabla">
		<tr>
			<td class="submodulo"> M&Oacute;DULO EJECUCI&Oacute;N / RENDICION		  <?="-".anp($idanp)?></td>
		</tr>
		<tr>
		<td valign="top" align="center">
<!--  PAGINA -->	<?
	
		 if($_SESSION['acceso']['lectura']=="S" ){?>
					<table id="cuerpo" width="100%" align="center">
						<TR>
							<TD align="center" ><br>
							<form action="" method="post" name="f1">
							  <?	
									if(isset($opcion)){
										Requerimientos::RequerimientosCabezera($idanp,$id);
								switch($_GET['opcion']){
									case 'new':
											Requerimientos::RequerimientosNew($idanp,$ids);													
										break;
										case 'add':
											$ids=Requerimientos::RequerimientosAdd($idanp);
											//Requerimientos::RequerimientosNew($idanp,$ids);	
											Requerimientos::RequerimientosANPList($idanp);		
										break;									
										case 'edit':										
											Requerimientos::RequerimientosEdit($id);	
										break;
										case 'update':
											Requerimientos::RequerimientosUpdate($id);
											Requerimientos::RequerimientosANPList($idanp,$idff);	
											//Requerimientos::RequerimientosNew($idanp,$id);
										break;
										case 'delete':
											Requerimientos::RequerimientosDelete($idcons);
											///$idanp=Requerimientos::RequerimientosANPList($id_ff);					
										break;
										case 'list':
											Requerimientos::RequerimientosList();	
										break;	
										case 'x';
											Requerimientos::RequerimientosANPList();
										break;
										default:	
											Requerimientos::RequerimientosANPList();
										break; 
								}}
								Requerimientos::RequerimientosANPList();
							?>
							</form>							</TD>
						</TR>
					</table><?
					}else if($_SESSION['acceso']['lectura']=="N") {
						echo "<div id=error align=\"center\"> Usted es usuario pero no esta autorizado para ver esta información </div><br><br>";
					}else{
						echo " <div id=error align=\"center\">ERROR: Usted esta tratando de entrar de manera incorrecta o su session a caducado</div><br><br>" ;
					} ?>
			<!--  FIN DE CONTENIDO -->
	</td></tr></table>				
<script language="javascript">
//FullScreen();
</script>
</body>
</html>
