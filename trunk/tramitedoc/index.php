<?php include("includes.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("includes/inc.header.php"); ?>
<title>Administraci&oacute;n</title>
</head>
<body <?php if(!$_SESSION['session'] && $_GET['opcion']!='recuperar'){?> onload='cargar(document.f1.usuario)' <?php }?> >
<table  id="principal"  align="center"cellpadding="0" cellspacing="0" >
	<tr>		
		<td colspan="2"> <?php Plantilla::PlantillaEncabezado("ACCESO AL SISTEMA");?> </td>		
	</tr>
	<tr>
		<td class="menu"><?php Plantilla::PlantillaIzquierdo();?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0">										
				<tr>								
					<td style="width:100%; height:417px">								
					<?php 
					if($_GET['opcion'] == 'recuperar'){
						include("recuperar_acceso.php");
					}else if($_SESSION['session']){
						include("inicio.php");
					}else(
						include("acceso.php")
					) ?>							
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