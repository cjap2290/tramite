<?php include("includes.php");

require_once("cls/class.documentos.php");

require_once("cls/class.escaneos.php");

$usuario = new Usuario($_SESSION['session'][0]);

$menu = array(0,1,1,0,0,0); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<?php include("includes/inc.header.php"); ?>

<title>Administraci&oacute;n</title>

</head>

<body >

<span id="toolTipBox" width="200"></span>

<table  id="principal" align="center" cellpadding="0" cellspacing="0" >

	<tr>		

		<td colspan="2"><?php Plantilla::PlantillaEncabezado("ESCANEO DE DOCUMENTOS")?></td>		

	</tr> 

	<tr>

		<td class="menu"><?php Plantilla::PlantillaIzquierdo()?></td>	

		<td>

			<?php  Plantilla::menuSuperior("escaneo_acceso_registro.php",$menu,$_GET['id']);?>

			<div id="contenido" > 

				<?php 

					$escaneos = new Escaneos();

					switch($_GET['opcion']){

						case 'add':											

							$escaneos->EscaneaGuardar();

							$escaneos->EscaneaEditar($_GET['id']);															

						break;	

						case 'edit':																			

							$escaneos->EscaneaEditar($_GET['id']);	

						break;								

						case 'detalle':		

							$documento = new Documento($_GET['id']);																	

							$docs->detalleDocumentosPorUsuario($usuario, $documento);	

						break;

						case 'addha':

							$documento = new Documento($_GET['id']);

							$documento->addHistorialAtencion();	?> 

							<script type="text/javascript"> 

								location.replace("atencion_acceso_registro.php?opcion=detalle&id=<?php echo $_GET['id']?>");

							</script><?php 	

						break;

						case 'list':											

							//$docs->listarDocumentosPorUsuario($usuario);		

							Escaneos::EscaneaListado($_GET['ide']);				

						break;

						case 'activar':	

							$documento = new Documento($_GET['id']);												

							$documento->ActivarDocumento($usuario);	

							$docs->listarDocumentosPorUsuario($usuario);		

						break;

						case 'busqueda';

							Escaneos::Busqueda($campo, $valor);

							//Registro::RegistraListado($ide);	

							break;	

						default:											

							//$docs->listarDocumentosPorUsuario($usuario);

							Escaneos::EscaneaListado($_GET['ide']);											

						break;

					}

				/*	switch($_GET['opcion']){

						case 'new':											

							Escaneos::EscaneaAgregar();												

						break;									

						case 'edit':																			

							Escaneos::EscaneaEditar($_GET['id']);	

						break;

						case 'update':											

							Escaneos::EscaneaUpdate($_GET['id']);

							Escaneos::EscaneaListado($_GET['ide']);											

						break;

						case 'delete':

							Escaneo::EscaneaDelete($_GET['id']);													

						break;

						case 'list':	

							Escaneos::EscaneaListado($_GET['ide']);	

						break;	

						case 'x':

							Escaneos::EscaneaListado($_GET['ide']);

						break;

						case 'guardar':											

							Escaneos::EscaneaGuardar();

							Escaneos::EscaneaListado($_GET['ide']);		

						break;	

						case 'agre':											

							Escaneos::EscaneaAgrega();											

						break;	

						case 'listremi':											

							Escaneos::EscaneaListRemitente();

						break;	

						case 'newremi':											

							Escaneos::EscaneaNewRemitente();

						break;	

						case 'editremi':

							

							Escaneos::EscaneaEditRemitente($_GET['id']);

							//Escaneo::EscaneaUpdateRemitente($_GET['id']);

						break;	

						case 'Updateremi':											

							Escaneos::EscaneaUpdateRemitente($_GET['id']);

							Escaneos::EscaneaListRemitente();

						break;	

						case 'guardremi':											

							Escaneos::EscaneaGuardarRemitente();

							Escaneos::EscaneaAgregar();

							

						break;	

						case 'filtrar':

							Escaneos::EscaneaFiltrar();

							//Escaneo::EscaneaListado($_GET['id']e);	

						break;								

						default:	

							Escaneos::EscaneaListado($_GET['ide']);

						break;

					}*/ ?>							

						

			</div>	

		</td>		

	</tr>

	<tr>

		<td colspan="2" class="pie"><?php Plantilla::PlantillaPie();?>	</td>

	</tr>	

</table>	

</body>

</html>