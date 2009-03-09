<?php 

class Plantilla{

	function PlantillaEncabezado($title){

		$area = new Area($_SESSION['session'][5]); ?>

	<table id="cabecera" cellpadding="0" cellspacing="0">
		<tr>
			<td class="superior"><img src="public_root/imgs/cabecera.jpg" alt="cabecera" width="100%" height="100%" /> </td>
		</tr>
		<tr>
			<td class="vertical_line">

			<table  cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td class="home">  </td>
					<td align="left" class="usuario"><?php echo ucwords($_SESSION['session'][1])?></td> 
					<td align="center" class="titulo"><?php echo $title ?> - <?php echo $area->getNombre()?></td>
					<td align="right" class="cerrar_sesion">
						<a href="#" onClick="javascript:eliminar_sesion()">CERRAR SESION</a>
					</td>
				</tr>
			</table>
			</td>
		</tr>			
	</table>
	<?php 
}

	function menuSuperior($url, $menu, $id){ ?>

		<table width="100%" id="menuSuperior">
			<tr>
				<td width="13%" class="item"><?php if($menu[0]==1){?>
					<a href="<?php echo $url?>?opcion=new"> NUEVO </a>
				<?php }else{?> NUEVO				<?php  }?></td>
				<td width="13%" class="item"><?php if($menu[1]==1){?><a href="<?php echo $url?>?opcion=list"> LISTAR </a><?php }else{?> LISTAR <?php  }?></td>

				<td width="28%" class="item"> <a href="#" id="clb"> BUSCAR </a> 
				  <div id="cbusqueda">
					<form name="f3" method="post" action="?opcion=busqueda">
						<label>Campo: </label> 
							<select name="campo" class="inpb">
								<option>--Seleccione un campo--</option>
								<option value="codigo_documento"> Nro Registro.</option>
								<option value="nombre_remitente"> Remitente</option>
								<option value="numero_documento"> Documento</option>
								<option value="asunto_documento"> Asunto</option>
							</select>
							 <br/>

							<label>Buscar: </label> <input type="text" name="valor" class="inpb" />	
							<input type="submit" name="buscar" value="BUSCAR" />			 
					</form>
				</div>			</td>
            <td width="30%" class="item"><a href="#" id="fil"> FILTRAR </a> 

	  	<div id="cfiltrar">
		
				<form action="<?=$_SESSION['PHP_SELF']?>?opcion=filtra">

				<label>Estado: </label> 
	                <?php 
						$sql_estado="SELECT *
									FROM
									`estados` AS `e`
									ORDER BY
									`e`.`nombre_estado` ASC";
									
									$q_estado=new Consulta($sql_estado);
					?>

						<select name="ide" style="width:200px">
							<option >--Tipo de Estado--</option>

					<?
        						while($row_estado=$q_estado->ConsultaVerRegistro()){
									$ide=$row_estado[0];
					?>
	                 		<option value="<?=$row_estado[0]?>"<? if(isset($ide) && $ide== $row_estado[0]){ echo "selected";} ?>>
					                		<?=$row_estado[1]?> 
							</option> <?  } ?>	
						</select>

					<input type="submit" name="filtro" value="FILTRAR" />
				</form>
			</div>			</td>

			<td width="7%" class="item" style="cursor:help"><?php  if($menu[5]==1){?><a href="<?php echo $url?>?opcion=help"> AYUDA </a><?php  }else{?> AYUDA <?php  }?></td>
		</tr>
		</table>

	<?php 	

	}

	function PlantillaIzquierdo(){?>

		<table cellpadding="0" cellspacing="0" width="100%"> 
			<tr>
				<td><?php Menu::MenuIzquierdo();?></td>
			</tr>
			<tr>
				<td class="inferior">&nbsp; </td>
			</tr>	
		</table><?php
	}	

	function PlantillaPie(){?>

		<table align="center" cellpadding="0"  width="765">
			<tr>
				<td align="center" > SERNANP &copy; <?php  echo date('Y'); ?>  </td>
			</tr>
		</table>
	<?php
	}

}
?>