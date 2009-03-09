<?php 
class Usuarios{

	function UsuariosNew(){				
		$QueryRol= new Consulta(" SELECT * FROM rol ");
		$QueryArea= new Consulta(" SELECT * FROM areas ");?>
	<form name="f1" action="" method="post">
				<table align="center" width="50%" id="mantenimiento">
					<TR>
					  <TD colspan="6" class='subtit'><div align="center">NUEVO USUARIO</div></TD>
					</TR>
					<tr>
					  <td colspan="5" align="right" class="Estilo22">&nbsp;</td>
				  </tr>
					<tr>
					  <td width="29%" align="right" class="Estilo22"><div align="left">Nombre</div></td>
				      <td width="3%" align="right" class="Estilo22"><div align="center">:</div></td>
				      <td colspan="3" align="right" class="Estilo22"><div align="left">
				        <input type="text" size="40" name="nombre">
			          </div></td>
			      </tr>
					
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Apellidos</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="40"  name="apellidos" ></td></tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Email </div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="40"  name="email" ></td></tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Rol</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><select name="rol" style="width:220px;">
							<option value="">--------- Seleccione Rol --------</option><?php
							while($RowRol= $QueryRol->VerRegistro()){ ?>
								<option value="<?php echo $RowRol[0] ?>" ><?php echo $RowRol[1] ?></option><?php			
							} ?>
							</select></td>
					</tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Area</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><select name="area" style="width:220px;">
							<option value="">--------- Seleccione Area --------</option><?php
							while($RowArea= $QueryArea->VerRegistro()){ ?>
								<option value="<?php echo $RowArea[0] ?>" <?php if($RowArea[0]==$area){ echo "Selected";}?>><?php echo $RowArea[1] ?></option><?php			
							} ?>
							</select></td>
					</tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Usuario</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="40" id="usuario"  name="usuario" >&nbsp;<a href="#" onClick="checkName(usuario)" title="Ver Disponibilidad de usuario" style="text-decoration:none">Disponible</a>
						<div id="result"></div></td></tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Passwor</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="40"  name="password" ></td></tr>
					<tr>
					  <td align="right" class="Estilo22"><div align="left">Lectura</div></td>
					  <td align="right"><div align="center"></div></td>
						<td width="10%" align="left"><input type="checkbox" name="lectura" value="SI" ></td>
					  	<td width="28%" align="right" class="Estilo22">Escritura :</td>
					  	<td width="30%" align="left"><input type="checkbox" name="escritura" value="SI"></td>
					</tr>
					<tr><td colspan="5">&nbsp;</td></tr>
					<tr>
						<td colspan="6" align="center"><input class="boton" type="submit" name="enviar2" value="Guardar" onclick="return  validar_usuarios('add')" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    <input class="boton"  type="reset" name="cancelar" value="Cancelar" onClick="javascript:window.history.go(-1)"></td>
						</tr>
				</table>
</form><?php
		
	}


	function UsuariosAdd(){
		if(!$_POST){
			echo "<div id=error>ERROR: No se pudo Agregar Usuario por falta de datos </div>";		
		}else{
			if(!$_POST['lectura']){$_POST['lectura']="NO";}
			if(!$_POST['escritura']){$_POST['escritura']="NO";}
			
			$sq=new Consulta("SELECT * FROM usuarios WHERE nombre_usuario='".$_POST['nombre']."' AND apellidos_usuario='".$_POST['apellidos']."' AND email_usuario='".$_POST['email']."' ");
			
			$sq_bu=new Consulta("SELECT * FROM usuarios WHERE login_usuario='".$_POST['usuario']."'");			
			if($sq->NumeroRegistros()==0){
				$sql = "INSERT INTO usuarios 
				VALUES( '',
				'".$_POST['rol']."',
				'".$_POST['area']."',
				'".$_POST['nombre']."' ,
				'".$_POST['apellidos']."',
				'".$_POST['email']."',
				'".$_POST['usuario']."',
				'".$_POST['password']."',
				'".date('Y-m-d')."',
				'".$_POST['lectura']."',
				'".$_POST['escritura']."') ";
				$Query= new Consulta($sql);			
				echo "<div id=error> Se Ingreso el Nuevo Usuario Correctamente </div>";			
			}else if($sq_bu->NumeroRegistros()){?>
				<script>
					alert(" El usuario ya existe, por favor ingrese otro nombre de usuario ");
					location.replace("usuarios.php?opcion=new")	
				</script><?php					
			}else{
				echo "<div id=error> ERROR: no se puedo ingresar el usuario </div>";
							
			}			
		}
		
	}

	function UsuariosUpdate($id, $_POST){
		if(empty($id)){
			echo "<div id=error>La actualizacion no se puede efectuar por falta de Id </div>";	
		}else if(!$_POST){
			echo "<div id=error>La actualizacion no se puede efectuar por que no pasaron los datos </div>";	
		}else{
			
			if(!$_POST['lectura']){$_POST['lectura']="NO";}
			if(!$_POST['escritura']){$_POST['escritura']="NO";}
			
			$Query = new Consulta( 	 " UPDATE usuarios
										SET nombre_usuario='".$_POST['nombre']."' ,
											apellidos_usuario='".$_POST['apellidos']."',
											email_usuario='".$_POST['email']."',
											id_rol='".$_POST['rol']."',
											id_area='".$_POST['area']."',
											login_usuario='".$_POST['usuario']."',
											password_usuario='".$_POST['password']."',
											lectura_usuario='".$_POST['lectura']."',
											escritura_usuario='".$_POST['escritura']."'
									    WHERE id_usuario='".$id."'");
			echo  " UPDATE usuarios
										SET nombre_usuario='".$_POST['nombre']."' ,
											apellidos_usuario='".$_POST['apellidos']."',
											email_usuario='".$_POST['email']."',
											id_rol='".$_POST['rol']."',
											id_area='".$_POST['area']."',
											login_usuario='".$_POST['usuario']."',
											password_usuario='".$_POST['password']."',
											lectura_usuario='".$_POST['lectura']."',
											escritura_usuario='".$_POST['escritura']."'
									    WHERE id_usuario='".$id."'";							
			echo "<div id=error>La actualizacion se realizo Correctamente </div>";	
		}
	}


	function UsuariosEdit($id){ 
		if(!$id){
			echo "<div id=error>ERROR: no se encontro ningun usuario con ese Id ó le falta Id  </div>";	
		}else{
			$Query	= new Consulta(" SELECT * FROM usuarios WHERE id_usuario='".$id."'");
			$Row	= $Query->VerRegistro();
			$QueryRol= new Consulta(" SELECT * FROM rol ");
			$QueryArea= new Consulta(" SELECT * FROM areas ");				
			$rol	=	$Row['id_rol'];			
			$area	=	$Row['id_area']; ?>
			<form name="f1" action="" method="post">
				<table width="51%" align="center" id="mantenimiento">
					<TR>
						<TD colspan="6" class='subtit'><div align="center">EDITAR DATOS DE USUARIO</div></TD></TR>
					<tr>
					  <td colspan="5" align="right">&nbsp;</td>
				  </tr>
					<tr>
					  <td width="31%" align="right" class="Estilo22"><div align="left">Nombre</div></td>
					  <td width="3%" align="right" class="Estilo22"><div align="center">:</div></td>
					  <td colspan="3" align="left"><input type="text" size="40" name="nombre" value="<?php echo $Row['nombre_usuario']?>" /></td>
				  </tr>
					
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Apellidos</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="40"  name="apellidos" value="<?php echo $Row['apellidos_usuario']?>"></td></tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Email</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="40"  name="email" value="<?php echo $Row['email_usuario']?>"></td></tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Rol</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><select name="rol"style="width:220px;">
							<option value="">--------- Seleccione Rol --------</option><?php
							while($RowRol = $QueryRol->VerRegistro()){ ?>
								<option value="<?php echo $RowRol[0] ?>" <?php if($RowRol[0] == $rol){ echo "Selected";}?>><?php echo $RowRol[1];?></option><?php			
							}	?>		
							</select></td>
					</tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Area</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><select name="area"style="width:220px;">
							<option value="">--------- Seleccione Area --------</option><?php
							while($RowArea = $QueryArea->VerRegistro()){ ?>
								<option value="<?php echo $RowArea[0] ?>" <?php if($RowArea[0] == $area){ echo "Selected";}?>><?php echo $RowArea[1];?></option><?php			
							}	?>		
							</select></td></tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Usuario</div></td>
					  <td align="right" class="Estilo22" ><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="40"  name="usuario" value="<?php echo $Row['login_usuario']?>"></td></tr>
					<tr>
					  <td align="right" class="Estilo22"> <div align="left">Password</div></td>
					  <td align="right" class="Estilo22"><div align="center">:</div></td>
						<td colspan="3" align="left"><input type="text" size="40"  name="password" value="<?php echo $Row['password_usuario']?>"></td></tr>
					<tr>
					  <td  align="right" class="Estilo22"><div align="left">Lectura</div></td>
					  <td  align="right">&nbsp;</td>
						<td width="8%" align="left"><input type="checkbox" name="lectura" value="SI" <?php if($Row['lectura_usuario']=="SI"){  echo "checked";} ?> />                    
					  <td width="20%" align="right" class="Estilo22">Escritura </td>                      
					  <td width="37%" align="left"><input type="checkbox" name="escritura" value="SI"  <?php if($Row['escritura_usuario']=="SI"){  echo "checked";} ?>/></td>                      
					</tr>
					<tr><td colspan="5">&nbsp;&nbsp;&nbsp;</tr>
					<tr>
						<td colspan="6" align="center"><input class="boton" type="submit" name="enviar2" value="GUARDAR" onclick="return  validar_usuarios('update', <?php echo $id?>)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    <input class="boton" type="reset" name="cancelar" value="CANCELAR" onClick="javascript:window.history.go(-1)"></td></tr>
				</table>
			</form>	<?php
		}
	}

	function UsuariosDelete($id){
		if(empty($id)){
			echo "<div id=error>La actualizacion no se puede efectuar por falta de Id </div>";	
		}else{		
			
			$Query= new Consulta($sql = "DELETE FROM usuarios WHERE id_usuario='$id'");
			echo "<div id=error>Se elimino el registro Correctamente </div>";
		}
	}

	function UsuariosList(){
		$sql = "SELECT a.id_usuario, CONCAT(a.nombre_usuario,' ',a.apellidos_usuario) AS Usuario, 
					a.email_usuario AS Email, 
					r.nombre_rol as Rol , 
					lectura_usuario AS Lectura, 
					escritura_usuario AS Escritura
				FROM usuarios a, rol r WHERE a.id_rol=r.id_rol "; 
		$query = new Consulta($sql);			
		echo $query->VerListado("usuarios.php","modulo_usuario.php"); 
	}	
}


?>