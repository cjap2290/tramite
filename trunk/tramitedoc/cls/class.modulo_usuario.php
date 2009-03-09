<?php 
class SeccionAdmin{

	function SeccionAdminCabezera(){ ?>
		<table width="60%" style="margin:10px 0px 4px 0px">
			<tr>
				<td><div id="opciones"><a href="index.php"> INICIO </a></div></td>				 
				<td><div id="opciones"><a href="usuarios.php?opcion=list"> IR A USUARIOS</a></div></td>
			</tr>
		</table><?php 		
	}

	function SeccionAdminAdd($id, $_POST){
		if(!$_POST){
			echo "<div id=error>ERROR: No se pudo Agregar Usuario por falta de datos </div>";		
		}else{
			$DelQuery=new Consulta($sql="DELETE FROM usuarios_paginas WHERE id_usuario=".$id."");		
			for($j=0; $j<sizeof($_POST['seccion']);$j++){
				if($_POST['seccion'][$j]){
					$Query= new Consulta($sql = "INSERT INTO usuarios_paginas VALUES('".$id."' ,'".$_POST['seccion'][$j]."') "		);
				}		
			}		
				echo "<div id=error> Se Activaron las Paginas al Usuario Correctamente </div>";			
				Usuarios::UsuariosList();
		}
		
	}

	function SeccionAdminList($id=""){ 
		if(!$id){
			echo "<div id=error>ERROR: no se encontro ningun usuario con ese Id ó le falta Id  </div>";	
		}else{
			$Query= new Consulta($sql = "SELECT id_pagina, nombre_pagina AS PAGINAS, url_pagina AS URL
										FROM paginas ");	?>
			<form name="f1" action="" method="post">		
				<table id="reporte"><tr> <?			
					for($i = 1; $i < $Query->NumeroCampos(); $i++){ ?>
						<td class="subtitulo"><b><?php echo $Query->nombrecampo($i)?></b></td><?php
					}	?>
					<td class="subtitulo">Activar</td></tr><?php
					$x=0;
					while($row = mysql_fetch_row($Query->Consulta_ID)){ ?>
						<tr <?php if($x==0){ ?>class="reg1" <?php }else{ ?> class="reg2" <?php }?> > <?php
						for ($i = 1; $i < $Query->NumeroCampos(); $i++){?>
							<td align=left class="celda"><?php echo $row[$i]?></td><?php
						}
						$Query_SA = mysql_query("SELECT * FROM usuarios_paginas 
												WHERE id_usuario=".$id." AND id_pagina=".$row[0]."");
						$NUM=mysql_num_rows($Query_SA);
						?>
						<td><input type="checkbox" name="seccion[]" value="<?php echo $row[0]?>" <?php if($NUM==1){ echo "checked"; }?>></td></tr><?php
						if($x==0){$x++;}else{$x=0;} 
					}	?>
					
				<tr  bgcolor="#EEEEEE">
					<td colspan="4" align="center"  style="padding-top:20px; padding-bottom:20px" >
						<input type="submit" name="guardar" value="GUARDAR" onClick="void(document.f1.action='modulo_usuario.php?id=<?php echo $id?>&opcion=add');void(document.f1.submit())"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="reset" name="cancelar" value="CANCELAR"></td></tr>
					
				</table>
			</form>	<?php
		}
	}

}


?>