<?php  
	include("includes.php");
	require_once("cls/class.usuarios.php");
	require_once("cls/class.modulo_usuario.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("includes/inc.header.php"); ?>
<title>Administraci&oacute;n</title>
</head>
<body>
<table  id="principal"  align="center"cellpadding="0" cellspacing="0" >
	<tr>		
		<td colspan="2"> <?php  Plantilla::PlantillaEncabezado("ADMINISTRACION DE ACCESO A PAGINAS");?> </td>		
	</tr>
	<tr>
		<td class="menu"><?php  Plantilla::PlantillaIzquierdo();?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0">										
				<tr>								
					<td style="width:585px; height:417px">
					<div id="cuerpo"><?php
					if($_SESSION['session'][3]=="SI" ){ 
						SeccionAdmin::SeccionAdminCabezera();
						switch($_GET['opcion']){																	
							case 'add':										
								SeccionAdmin::SeccionAdminAdd($_GET['id'], $_POST);
							break;
							case 'list':
								SeccionAdmin::SeccionAdminList($_GET['id1']);	
							break;					
							default:	
								SeccionAdmin::SeccionAdminList($_GET['id1']);
							break; 
						}	 
					}else if($_SESSION['session'][3]=="NO") {
						echo "<div id=error> CUIDADO: Usted es Usuario del sistema pero no esta Autorizado para ver esta información </div><br><br>";		

					}else{
						echo " ERROR: Usted esta entrando de manera Incorrecta !!! " ;
					}	?>	
					</div>					
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


