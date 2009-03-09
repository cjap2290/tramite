<?php  
	include("includes.php");
	require_once("libs/lib.php");
	require_once("cls/areas_acceso_registro.cls.php");
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
$menu = array(0,1,0,0,1,0); 
?>
<html>
<head>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("includes/inc.header.php"); 
?>

<title>M&Oacute;DULO DE TRAMITE DOCUMENTARIO/ DESPACHO DE <?=$row_td['nombre_area']?></title>
</head>
<body <?php if(!$_SESSION['session'] && $_GET['opcion']!='recuperar'){?> onload='cargar(document.f1.usuario)' <?php }?> >
<span id="toolTipBox" width="200"></span>

<table  id="principal"  align="center"cellpadding="0" cellspacing="0" >
	<tr>		
		<td  align="center" colspan="2"> <?php Plantilla::PlantillaEncabezado("DESPACHO DE AREA ");?></td>		
	</tr>
	<tr>
		<td class="menu"><?php Plantilla::PlantillaIzquierdo();?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0">	
             <tr>
					<td><?php  Plantilla::menuSuperior("areas_acceso_registro.php",$menu,$_GET['id']);?></td>
				</tr>									
												
				<tr>								
					<td style="width:100%; height:417px">								
					<?php 									
							switch($opcion){
										case 'add':
											Registro::RegistraAgregar();
										break;									

										case 'edit':	
											Registro::RegistraEditar($id);	
										break;

										case 'update':
											Registro::RegistraUpdate($id);
											Registro::RegistraListado($ide);	
										break;

										case 'delete':
											Registro::RegistraDelete($idcons);
										break;

										case 'list':
											Registro::RegistraListado($ide);		
										break;	

										case 'x':
											Registro::RegistraListado($ide);	
										break;

										case 'guardar':
											Registro::RegistraGuardar();
											Registro::RegistraListado($ide);			
										break;	

										case 'agre':
											Registro::RegistraAgrega();
										break;	

										case 'despachar':	
											Registro::ConsultarDocumento($ids);	
											Registro::DespacharListarDestino($ids);			
										break;	

										case 'des_list':	
											Registro::ConsultarDocumento($ids);									
											Registro::DespacharListarDestino($ids);			
										break;	

										case 'des_guard':	
											Registro::DespacharGuardarDestino($ids);
											Registro::ConsultarDocumento($ids);		
											Registro::DespacharListarDestino($ids);		
										break;	

										case 'eliminar':	
											Registro::DespacharEliminarDestino($idp,$ids);
											Registro::ConsultarDocumento($ids);		
											Registro::DespacharListarDestino($ids);		
										break;		

										case 'filtrar';
											Registro::RegistraFiltrar();
										break;	

										case 'busqueda';
											Registro::Busqueda($campo, $valor);
										break;	

										case 'devol';
											Registro::DespacharDevolverDestino($ids);
											Registro::RegistraListado($ide);	
										break;		

										case 'arch';
											Registro::DespacharArchivarDestino($ids);
											Registro::RegistraListado($ide);	
										break;			

										default:	
											Registro::RegistraListado($ide);	
										break;
										}
							?>							
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