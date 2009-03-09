<?php include("includes.php");
require_once("cls/class.documentos.php");
$usuario = new Usuario($_SESSION['session'][0]);
$menu = array(0,1,0,0,0,0); ?>
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
		<td colspan="2"><?php Plantilla::PlantillaEncabezado("ATENCION DE DOCUMENTOS")?></td>		
	</tr> 
	<tr>
		<td class="menu"><?php Plantilla::PlantillaIzquierdo()?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0">
				<tr>
					<td><?php  Plantilla::menuSuperior("atencion_acceso_registro.php",$menu,$_GET['id']);?></td>
				</tr>										
				<tr>								
					<td style="width:100%;height:417px"><?php 
					$docs = new Documentos();
					switch($_GET['opcion']){
						case 'add_historia':											
							$docs->RegistraAgregar();												
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
							$docs->listarDocumentosPorUsuario($usuario);				
						break;
						case 'activar':	
							$documento = new Documento($_GET['id']);												
							$documento->ActivarDocumento($usuario);	
							$docs->listarDocumentosPorUsuario($usuario);		
						break;
						case 'fin':	
							$documento = new Documento($_REQUEST['id']);
                            $documento->finalizarDocumento($_REQUEST['borrador']);
                            $docs->listarDocumentosPorUsuario($usuario);
							?>
                            <script>alert("Se Finalizo el documento");</script>
                            <?
						break;
						case 'busqueda': 
							$docs->listarDocumentosPorUsuario($usuario);
						break;		
						default:											
							$docs->listarDocumentosPorUsuario($usuario);
						break;
					} ?>							
					</td>					
				</tr>			
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="2" class="pie"><?php Plantilla::PlantillaPie();?>	</td>
	</tr>	
</table>	
</body>
</html>