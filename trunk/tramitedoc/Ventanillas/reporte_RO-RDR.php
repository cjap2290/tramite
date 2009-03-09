<?php 
	include("../../includes.php");
	require_once("../../libs/lib.php");
	require_once("../../segoper_ejec/libs/verificar.inc.php");
	require_once("cls/reporte_RO-RDR.cls.php");
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
<title>Reporte Ejecuci&oacute;n/Rendici&oacute;n</title>
<link href="../style.css" type="text/css" rel="stylesheet">
<link href="../../style.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="../../libs/calendar/calendar-green.css" title="win2k-cold-1" /> 
<script language="javascript" src="../../js/jquery.js"> </script>
<script type="text/javascript" src="../../libs/calendar/calendar.js"></script> 
<script type="text/javascript" src="../../libs/calendar/calendar-es.js"></script>   
<script type="text/javascript" src="../../libs/calendar/calendar-setup.js"></script> 
<script language="javascript" src="../js/js.js"> </script>
<script language="javascript" src="../../js/js.js"> </script>

<script type="text/javascript">
<!--
function cambia_saldo(id,ids){
	$("#capa_saldo").load("carga_saldo.php?id_total="+id+"&ids="+ids).fadeIn("slow");
}

-->
</script>
<style type="text/css">
<!--
SPAN{
color:#FF0000;}
-->
</style>
</head>
<body>
	<table  width='100%' border='0' height='100%' bgcolor='white' id="tabla">
		<tr>
<td class="submodulo"> MODULO EJECUCION / RENDICION &nbsp;&nbsp;<span><?=anp($idanp)?></span></td>
		</tr>
		<tr>
		<td valign="top" align="center">
<!--  PAGINA -->	<?
	
		 if($_SESSION['acceso']['lectura']=="S" ){?>
					<table id="cuerpo" width="100%" align="center">
						<!--<tr> <td class="titulo"> ADMINISTRACION DE  USUARIOS</td></tr>-->
						<TR>
						  <TD align="center" ><?										
						  			/*if(isset($opcion)){
										Remesas::RemesasCabezera($idanp);
									}	*/	
									
									switch($opcion){
									case 'anp_rep':
										Reporte::RegistraReporteANP($ids,$idcons);
									break;
									case 'add_sol':
										$idcons=Reporte::AddReporteANP();
										Reporte::RegistraReporteANP($ids,$idcons);
									break;
									case 'del_sol':
										Reporte::DelReporteANP();
										Reporte::RegistraReporteANP($ids,'');
									break;
									case 'reg_rep':
											Reporte::RegistraReporte($ids,$idcons);
									break;
									case 'add_req':
										Reporte::AddReporte($ids,$idcons);
										
										//Reporte::RegistraReporteANP($ids,$idcons);
									break;
									case 'gua_ren':
										Reporte::GuardarRendicion();
										Reporte::RegistraReporteANP($ids,$idcons);
										//Reporte::RegistraReporte($ids,'');
									break;
									case 'del_rep':
										Reporte::DelReporte();
										Reporte::RegistraReporteANP($ids,$idcons);
									break;
									} ?>						  </TD>
						</TR>
					</table>
					<?
					}else if($_SESSION['acceso']['lectura']=="N") {
						echo "<div id=error align=\"center\"> Usted es usuario pero no esta autorizado para ver esta información </div><br><br>";
					}else{
						echo " <div id=error align=\"center\">ERROR: Usted esta tratando de entrar de manera incorrecta o su session a caducado</div><br><br>" ;
					} ?>
			<!--  FIN DE CONTENIDO -->
	</td></tr></table>				

</body>
</html>
