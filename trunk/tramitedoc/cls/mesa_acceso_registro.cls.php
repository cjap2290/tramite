<?

class Registro {

function RegistraCabecera(){	

	$sql_usu = "SELECT `u`.`login_usuario`,`u`.`password_usuario`,`uap`.`id_axo_poa`,`u`.`nombre_usuario` as nombre
				FROM
				`usuarios` AS `u`,
				`usuario_axo_poa` AS `uap` 
				WHERE
				`u`.`id_usuario` = `uap`.`id_usuario` AND
				`u`.`id_usuario` = '1'";
	
	$query_pa=new Consulta($sql_usu);	

	$row_usu=$query_pa->ConsultaVerRegistro(); ?>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<style type="text/css">
<!--
.Estilo1 {color: #F1FAFE}
-->
</style>
<body>
<script type="text/javascript" src="../../js/ajax/ajax.js"></script>
<p align="center"><img src="../imgs/cabecera.jpg" width="900" height="80" /></p>

	<table width="90%" border="0">
		<tr>
			<td width="100%"><div align="right" class="Estilo2">Usuario del Sistema: <?=$row_usu[nombre]?></div></td>
		</tr>
	</table>
	
	<span class="Estilo9">DOCUMENTOS EN MESA DE PARTES </span>
<?
}

function Busqueda($campo, $valor){	

	if($campo == "nombre_remitente"){
		$where = $campo == "nombre_remitente" ? " AND r.nombre_remitente like '%$valor%' " : "";
	}else{
		$where = $campo != "" ? " AND d.$campo like '%$valor%' " : ""  ;
	}

	$sql_reg="SELECT *
			FROM
			documentos AS d
			Inner Join remitentes AS r ON r.id_remitente = d.id_remitente
			Inner Join estados AS e ON e.id_estado = d.id_estado
			".$where."
			ORDER BY d.id_documento DESC";
	$query_reg=new Consulta($sql_reg);		
	?>

	<table width="99%" border="1" align="center" class="formularios">
		<tr bgcolor="#6699CC" class="Estilo7">
		  <td width="9%"><div align="center"><span class="msgok1">Reg. N&ordm; </span></div></td>
		 <!---<td width="10%"><div align="center"><span class="msgok1">Tipo de Doc.</span></div></td>--->
		  <td width="28%"><div align="center"><span class="msgok1">Remitente</span></div></td>
		  <td width="28%"><div align="center"><span class="msgok1">Documento</span></div></td>
		  <td width="14%"><div align="center"><span class="msgok1">Fecha de Registro</span></div></td>
		  <td width="5%" align="center">Estado</td>
		  <td width="13%"><div align="center" class="msgok1"> Ubicacion</div></td>
	  </tr>
    
	<? while($row_reg=$query_reg->ConsultaVerRegistro()){
	$ids=$row_reg[0];
	$_POST[remi]=$row_reg[nombre_remitente];?>
    <tr class="Estilo7">
      <td <?php if(!empty($row_reg['asunto_documento'])){ ?>  onmouseover="toolTips('<?php echo $row_reg['asunto_documento']?>',this)" <?php } ?> ><div align="center"><a href="mesa_acceso_registro.php?opcion=despachar&ids=<?=$ids?>">
        <?=$row_reg[1]?>
      </a></div></td>
      <!---<td ><=$row_reg[nombre_tipo_documento]?></td>--->
      <td ><input size="48" value="<?=$row_reg[nombre_remitente]?>"/></td>
      <td ><input size="43" value="<?=$row_reg[numero_documento]?>"/></td>
     <td > <?php echo date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?></td>
     <td align="center" ><?=$row_reg['abrev_nombre_estado']?></td>
    <!----   <td > <php echo $row_reg['fecha_registro_documento']?></td>--->
     <?php
		$sql_ultimo="SELECT Max(`hd`.`id_historial_documento`) AS `ultimo`
		FROM
		`historial_documentos` AS `hd`
		where hd.id_documento='".$row_reg['id_documento']."'
		GROUP BY
		`hd`.`id_historial_documento`";
		$query_ultimo=new Consulta($sql_ultimo);		
		$ultimo=$query_ultimo->ConsultaVerRegistro();
		
		$sql_data=" SELECT hd.id_documento,a.nombre_area, a.abve_nombre_area FROM historial_documentos AS hd 
		Inner Join areas AS a ON a.id_area = hd.id_area 
		where hd.id_historial_documento='".$ultimo['ultimo']."'";
		$query_data=new Consulta($sql_data);		
		$data=$query_data->ConsultaVerRegistro();
		
		$sql_usu="SELECT Max(`ha`.`id_historial_atencion`) AS `ultimo`, `ha`.`id_documento`
				FROM
				`historial_atencion` AS `ha`
				WHERE
				ha.original_historial_atencion =  '1' and
				ha.id_documento='".$row_reg['id_documento']."' 
				GROUP BY
				`ha`.`id_historial_atencion`	";
		$query_usu=new Consulta($sql_usu);		
		$usu=$query_usu->ConsultaVerRegistro();


		$susu="SELECT `u`.`login_usuario`, `a`.`abve_nombre_area`
				FROM
				`historial_atencion` AS `ha`
				Inner Join `usuarios` AS `u` ON `u`.`id_usuario` = `ha`.`id_usuario_destino`
				Inner Join `areas` AS `a` ON `a`.`id_area` = `u`.`id_area`
				WHERE
				`ha`.`id_historial_atencion` = '".$usu['ultimo']."' ";
				$qusu=new Consulta($susu);		
				$u=$qusu->ConsultaVerRegistro();
?>
      <td >
	<?  if ($row_reg['id_estado']==4){ echo $u['abve_nombre_area'].' '.$u['login_usuario'];
	}
	 else {	  echo $data[2];}?></td>
    </tr><? }?>
</table>
<!-----<a href="<=$_SESSION['PHP_SELF']?>?opcion=add"class="Estilo34" >Registrar Nuevo</a>---->
<? }

function RegistraListado($ide){	 
if ($ide==''){
	$sql_reg="SELECT
			d.id_documento,
			d.codigo_documento,
			r.nombre_remitente,
			d.numero_documento,
			e.nombre_estado,
			e.abrev_nombre_estado,
			d.fecha_registro_documento,
			d.id_estado,
			d.asunto_documento
			FROM
			documentos AS d
			Inner Join remitentes AS r ON r.id_remitente = d.id_remitente
			Inner Join estados AS e ON e.id_estado = d.id_estado
			ORDER BY d.id_documento DESC";
	$query_reg=new Consulta($sql_reg);		
	//$row_reg=$query_reg->ConsultaVerRegistro();
}
else 
{ $sql_reg="SELECT
			d.id_documento,
			d.codigo_documento,
			r.nombre_remitente,
			d.numero_documento,
			e.nombre_estado,
			e.abrev_nombre_estado,
			d.fecha_registro_documento,
			d.id_estado,
			d.asunto_documento
			FROM
			documentos AS d
			Inner Join remitentes AS r ON r.id_remitente = d.id_remitente
			Inner Join estados AS e ON e.id_estado = d.id_estado
			Where
			d.id_estado='".$ide."'
			ORDER BY d.id_documento DESC";
	$query_reg=new Consulta($sql_reg);		
	}
	?>
<table width="99%" border="1" align="center" class="formularios">
    <tr bgcolor="#6699CC" class="Estilo7">
      <td width="9%"><div align="center"><span class="msgok1">Reg. N&ordm; </span></div></td>
     <!---<td width="10%"><div align="center"><span class="msgok1">Tipo de Doc.</span></div></td>--->
      <td width="28%"><div align="center"><span class="msgok1">Remitente</span></div></td>
      <td width="28%"><div align="center"><span class="msgok1">Documento</span></div></td>
      <td width="14%"><div align="center"><span class="msgok1">Fecha de Registro</span></div></td>
      <td width="5%" align="center">Estado</td>
      <td width="13%"><div align="center" class="msgok1"> Ubicacion</div></td>
  </tr>
    <? while($row_reg=$query_reg->ConsultaVerRegistro()){
	$ids=$row_reg[0];
	$_POST[remi]=$row_reg[nombre_remitente];?>
    <tr class="Estilo7">
      <td <?php if(!empty($row_reg['asunto_documento'])){ ?>  onmouseover="toolTips('<?php echo $row_reg['asunto_documento']?>',this)" <?php } ?> ><div align="center"><a href="mesa_acceso_registro.php?opcion=despachar&ids=<?=$ids?>">
        <?=$row_reg[1]?>
      </a></div></td>
      <!---<td ><=$row_reg[nombre_tipo_documento]?></td>--->
      <td ><input size="48" value="<?=$row_reg[nombre_remitente]?>"/></td>
      <td ><input size="43" value="<?=$row_reg[numero_documento]?>"/></td>
     <td > <?php echo date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?></td>
     <td align="center" ><?=$row_reg['abrev_nombre_estado']?></td>

    <!----   <td > <php echo $row_reg['fecha_registro_documento']?></td>--->
     <?php
		$sql_ultimo="SELECT Max(`hd`.`id_historial_documento`) AS `ultimo`
		FROM
		`historial_documentos` AS `hd`
		where hd.id_documento='".$row_reg['id_documento']."'
		GROUP BY
		`hd`.`id_historial_documento`";
		$query_ultimo=new Consulta($sql_ultimo);		
		$ultimo=$query_ultimo->ConsultaVerRegistro();
		$sql_data=" SELECT hd.id_documento,a.nombre_area, a.abve_nombre_area FROM historial_documentos AS hd 
		Inner Join areas AS a ON a.id_area = hd.id_area 
		where hd.id_historial_documento='".$ultimo['ultimo']."'";
		$query_data=new Consulta($sql_data);		
		$data=$query_data->ConsultaVerRegistro();
	

		$sql_usu="SELECT Max(`ha`.`id_historial_atencion`) AS `ultimo`, `ha`.`id_documento`
				FROM
				`historial_atencion` AS `ha`
				WHERE
				ha.original_historial_atencion =  '1' and
				ha.id_documento='".$row_reg['id_documento']."' 
				GROUP BY
				`ha`.`id_historial_atencion`	";
		$query_usu=new Consulta($sql_usu);		
		$usu=$query_usu->ConsultaVerRegistro();

		$susu="SELECT `u`.`login_usuario`, `a`.`abve_nombre_area`
				FROM
				`historial_atencion` AS `ha`
				Inner Join `usuarios` AS `u` ON `u`.`id_usuario` = `ha`.`id_usuario_destino`
				Inner Join `areas` AS `a` ON `a`.`id_area` = `u`.`id_area`
				WHERE
				`ha`.`id_historial_atencion` = '".$usu['ultimo']."' ";
				$qusu=new Consulta($susu);		
				$u=$qusu->ConsultaVerRegistro();

		
?>
      <td >
	<?  if ($row_reg['id_estado']==4){ echo $u['abve_nombre_area'].' '.$u['login_usuario'];
	}
	 else {
	  echo $data[2];}?></td>
    </tr><? }?>
</table>
<!-----<a href="<=$_SESSION['PHP_SELF']?>?opcion=add"class="Estilo34" >Registrar Nuevo</a>---->
<? }







function RegistraEditar(){



echo 'Pagina en Desarrollo';







 }



function RegistraAgrega(){



echo 'Pagina en Desarrollo';



 }



	



function RegistraUpdate($id){



}







function RegistraEliminar($id){



}











function ConsultarDocumento($ids){

	$sql_resumen="SELECT
				documentos.id_documento,
				documentos.codigo_documento,
				remitentes.nombre_remitente,
				tipos_documento.nombre_tipo_documento,
				documentos.numero_documento,
				documentos.referencia_documento,
				documentos.anexo_documento,
				documentos.numero_folio_documento,
				documentos.fecha_documento,
				documentos.fecha_registro_documento
				FROM
				documentos
				Inner Join remitentes ON remitentes.id_remitente = documentos.id_remitente
				Inner Join tipos_documento ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento
				WHERE
				documentos.id_documento = '".$ids."'";

	$query_resumen=new Consulta($sql_resumen);
	$row_resumen=$query_resumen->ConsultaVerRegistro(); 

	$_POST['nombre']=$row_resumen[2];
	$_POST['ids']=$row_resumen[0];

	$documento = new Documento($ids);
		?>


<fieldset>

  <legend class="Estilo9">DATOS DEL DOCUMENTO</legend>
  <table width="98%" border="0" align="center" bordercolor="#000000" bgcolor="#ffffff">
    <tbody>
      <tr>
        <td width="223" class="Estilo22"><div align="left">N&ordm; Registro</div></td>
        <td width="10" class="Estilo22"><div align="center">:</div></td>
        <td width="98" bgcolor="#ffffff"><?=$row_resumen[1]?></td>
        <td width="139" bordercolor="#D6D3CE" bgcolor="#ffffff">&nbsp;</td>
        <td width="113" bgcolor="#ffffff">&nbsp;</td>
        <td colspan="2" bordercolor="#D6D3CE" bgcolor="#ffffff">&nbsp;</td>
        <td width="164" >&nbsp;</td>
      </tr>
      <tr>
        <td width="223"class="Estilo22"><div align="left">Remitente</div></td>
        <td width="10" bgcolor="#ffffff" class="Estilo22"><div align="center">:</div></td>
        <td colspan="3" bgcolor="#ffffff"><?=$row_resumen[2]?></td>
        <td width="142" class="Estilo22"><div align="left"><span>Nro de Folios</span></div></td>
        <td width="12" class="Estilo22"><div align="center">:</div></td>
        <td><?=$row_resumen[numero_folio_documento]?></td>
      </tr>
      <tr>
        <td width="223" bgcolor="#ffffff"><div align="right">
            <div align="left" class="Estilo22">Nro. Documento</div>
        </div></td>
        <td width="10" class="Estilo22" ><div align="center">:</div></td>
        <td colspan="3" bgcolor="#ffffff"><?=$row_resumen[numero_documento]?></td>
        <td class="Estilo22"><div align="left">Fecha de Doc </div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td><?php echo date('d/m/Y H:i',strtotime($row_resumen[fecha_documento]))?></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Tipo de Documento</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="6"><?=$row_resumen[nombre_tipo_documento]?></td>
      </tr>
      <tr>
        <td  width="223" class="Estilo22"><div align="right">
            <div align="left">Referencia</div>
        </div></td>
        <td  width="10" class="Estilo22"><div align="center">:</div></td>
        <td colspan="6"><?=$row_resumen[referencia_documento]?></td>
      </tr>
      <tr>
        <td  width="223" class="Estilo22"><div align="right">
            <div align="left">Anexos</div>
        </div></td>
        <td  width="10" class="Estilo22"><div align="center">:</div></td>
        <td colspan="6"><?=$row_resumen[anexo_documento]?></td>
      </tr>
      <tr>
        <td class="Estilo22"><div align="left">Documento Digitalizado </div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="6">
			  <span class="Estilo7">
	      		<?
					$escaneo = "SELECT * 
								from documentos_escaneados de
								where de.id_documento = ".$ids;
							
					$qescaneo = new Consulta($escaneo);
				
			  		$index = 1;
			
					while($row_reg = $qescaneo->ConsultaVerRegistro()){?>
						<a href="Escaneo/<?=$row_reg['nombre_documento_escaneado']?>" 
						id="<?=$row_reg["id_documento_escaneado"]?>" target="_blank">
						<?=$index?>
						</a>				
					<?
						$index++;
            		}
				  	?>               
    		  </span>		</td>
      </tr>
      <tr>
        <td height="28" ><div align="right" class="Estilo22">
          <div align="left">Fecha y Hora de Registro</div>
        </div></td>
        <td height="28"  class="Estilo22"><div align="center">:</div></td>
        <td height="28" ><?php echo date('d/m/Y H:i',strtotime($row_resumen[fecha_registro_documento]))?></td>
        <td height="28" >&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" bordercolor="#D6D3CE" bgcolor="#ffffff">&nbsp;</td>
		<td></td>
      </tr>
      <tr>
  	<? $edi="SELECT
			`td`.`asunto_documento`,
			`td`.`observacion_documento`,
			`td`.`id_prioridad`
			FROM
			`documentos` AS `td`
			WHERE
			`td`.`id_documento` =  '".$ids."'";
			$qedit=new Consulta($edi);	
			$row_edit=$qedit->ConsultaVerRegistro();
			$cboprioridad=$row_edit['id_prioridad'];
			?>    

      <td height="28" bgcolor="#ffffff" class="Estilo22"><div align="left">Observaci&oacute;n de Registro</div></td>
      <td height="28" bgcolor="#ffffff" class="Estilo22"><div align="center">:</div></td>
      <td colspan="6"><textarea name="textarea2" id="textarea2" rows="3" cols="100"><?=$row_edit[1]?>
      </textarea></td>
      </tr>
    </tbody>
</table>
</fieldset>

 <form name="form_despacho" id="form_despacho" method="post"  action="<?php echo $_SERVER['PHP_SELF']?>?opcion=des_guard&ids=<?= $_POST['ids']?>" >  
<!-- <form name="form9"  method="post"  action="" >  -->
  <fieldset>
  <legend >ESTABLECER ASUNTO Y PRIORIDAD</legend>
  <table width="99%" border="0" align="center" bordercolor="#000000" bgcolor="#ffffff" class="formularios">
    <tr>
      <td width="24" height="56" bgcolor="#ffffff" class="Estilo22">&nbsp;</td>
      <td width="193" height="56" bgcolor="#ffffff" class="Estilo22"><div align="left">Asunto:</div></td>
      <td width="8" bgcolor="#ffffff" class="Estilo22"><div align="center">:</div></td>
      <td colspan="6"><textarea name="textfield2" id="textfield2" rows="3" cols="100"><?=$row_edit[0]?></textarea></td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#ffffff" class="Estilo22">&nbsp;</td>
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" class="Estilo21"> <span class="Estilo26" style="vertical-align:middle">(*)</span></td>
      <td bgcolor="#ffffff" class="Estilo22"><div align="right" style="width:75px;">
        <div align="left">Priorida</div>
      </div></td>
      <td bgcolor="#ffffff" class="Estilo22"><div align="center">:</div></td>
      <td width="260" >
		<?
		$sql_prioridad="SELECT prioridades.id_prioridad, prioridades.nombre_prioridad, prioridades.tiempo_horas_respuesta_prioridad
						FROM prioridades
						ORDER BY prioridades.id_prioridad ASC";
		$query_prioridad=new Consulta($sql_prioridad);
		?>
        <select name="cboprioridad"  id="cboprioridad" onChange="cambia_saldo(this.value)" style="width:200px;">
          <option value="">--- Seleccione Prioridad ---</option>
          <? while($row_prioridad=$query_prioridad->ConsultaVerRegistro()){?>
          <option value="<?=$row_prioridad[0]?>"<? if($row_prioridad[0]==$cboprioridad){ /*echo "selected";*/ } ?>>
          <?=$row_prioridad[1]?>
          </option>
          <? } ?>
        </select>
		
	  <input type="hidden" name="id_documento" id="id_documento" value="<?php echo $ids ?>" ></td>
      <td width="244" class="Estilo22"><div align="left">Tiempo de Respuesta</div></td>
      <td width="6" class="Estilo22"><div align="center">:</div></td>
      <td width="34" align="left"> <div align="left" id="capa_saldo"></div></td>
      <td width="141" align="left"><?php echo'- Días.'?></td>
    </tr>
    <tr>
      <td colspan="4" ></td>
      <td class="Estilo22"><div align="left">Fecha Estimada de Respuesta</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td height="21" colspan="2" class="Estilo23"><div id="fecha_respuesta"></div></td>
    </tr>
  </table>
  </fieldset>

  <fieldset>
  <legend>ESTABLECER DESTINO Y ACCION A REALIZAR</legend>
  <table width="99%" height="106" border="0" align="center">
    <tbody>
      <tr>
        <td width="3%" height="25" class="Estilo21" > (*)<!-- <input name="Submit4" value="Agregar" type="button">--->        </td>
        <td width="7%" bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle"><span class="Estilo22" style="vertical-align:middle">Pase A<span class="Estilo22" style="vertical-align:middle"><span class="Estilo22" style="vertical-align:middle"><?
	      	$sql_areas="SELECT areas.id_area, areas.nombre_area FROM areas";
    		$query_areas=new Consulta($sql_areas);
			?>
        </span></span></span></td>
        <td width="1%" bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle"><div align="center">:</div></td>
        <td width="25%" bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle"><span class="Estilo22" style="vertical-align:middle"><span class="Estilo22" style="vertical-align:middle"><span class="Estilo22" style="vertical-align:middle"><span class="Estilo22" style="vertical-align:middle"><span class="Estilo22" style="vertical-align:middle">
          <select name="cboareas"  id="cboareas" style="width:200px;">
            <option value="">--- Seleccione Destino---</option>
            <? while($row_areas=$query_areas->ConsultaVerRegistro()) {?>
            <option value="<? echo $row_areas[0]?>"><? echo $row_areas[1]?></option>
            <? } ?>
          </select>
        </span></span></span><span class="Estilo22" style="vertical-align:middle">
          <?
			$sql_accion="SELECT accion.id_accion, accion.nombre_accion, accion.categoria_accion FROM accion WHERE 		
						accion.categoria_accion='DA' ORDER BY
						accion.nombre_accion ASC";
			$query_accion=new Consulta($sql_accion);
		?>
        </span>        </span></span></td>
        <td width="34%" rowspan="4" bgcolor="#ffffff" class="Estilo22" ><div align="left">Observaci&oacute;n de Despacho:</div>

        <textarea name="textfield4" id="textfield4" rows="4" cols="50"></textarea>      
        <td height="24" align="center" class="Estilo21"><div align="center"><span >(*)</span></div></td>
        <td width="3%" align="center"><div align="center"><span class="Estilo22" style="vertical-align:middle">
            <input name="radiobutton" value="1" type="radio" id="0">
        </span></div></td>
        <td width="25%" align="center" class="Estilo22"><div align="left">Original</div></td>
      </tr>
	  <tr>
	    <td class="Estilo21">(*)</td>
	    <td bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle"><span class="Estilo22" style="vertical-align:middle">Acc&iacute;on</span></td>
	    <td bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle"><div align="center">:</div></td>
	    <td bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle"><span class="Estilo22" style="vertical-align:middle"><span class="Estilo22" style="vertical-align:middle">
	      <select name="cboaccion" id="cboaccion" style="width:200px;">
            <option value="">--- Accion a Realizar---</option>
            <? while($row_accion=$query_accion->ConsultaVerRegistro()) {?>
            <option value="<? echo $row_accion[0]?>"><? echo $row_accion[1]?></option>
            <? } ?>
          </select>
	    </span></span></td>
	    <td width="2%" height="24" align="center" class="Estilo21">&nbsp;</td>
        <td height="21" align="center"><div align="center"><span class="Estilo22" style="vertical-align:middle">
            <input name="radiobutton" value="2" type="radio" id="1">
        </span></div></td>
        <td height="21" align="center" class="Estilo22"><div align="left">Copia</div></td>
	  </tr>
	  <tr>
	    <td class="Estilo21">&nbsp;</td>
	    <td colspan="2" bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle">&nbsp;</td>
	    <td bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle">&nbsp;</td>
	    <td height="21" colspan="3" align="center"><div align="center"></div></td>
      </tr>
	  <tr>
	   <td width="3%" class="Estilo21">&nbsp;</td> 
         <td colspan="2" bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle">&nbsp;</td>
        <td width="25%" bgcolor="#ffffff" class="Estilo22" style="vertical-align:middle">&nbsp;</td>
         <td height="26" colspan="3" align="center"><!--<div align="center"><a href="acceso_registro.php?opcion=des_guard" onClick="submit()" >Cargar Lista</a></div>-->           
	       <div align="right">
	         <input type="submit" name="Cargar Lista2" value="Cargar Lista" class="boton"/>   
        </div></td>
      </tr>
    </tbody>
  </table>
  </fieldset>
</form>
  <? }

function DespacharListarDestino($ids)  {  ?>

<table width="99%" border="1" align="center" id="tabla_despacho" class="formularios">
    <tr bgcolor="#6699CC" class="Estilo7">
        <td width="3%" height="25" ><div align="center" class="msgok1">Nro</div></td>
        <td width="23%"><div align="center" class="msgok1">ORIGEN</div></td>
        <td width="24%"><div align="center" class="msgok1">DESTINO</div></td>
        <td width="13%"><div align="center" class="msgok1">Fecha y Hora </div></td>
        <td width="13%"><div align="center" class="msgok1">Accion</div></td>
        <td width="11%"><div align="center" class="msgok1">Categor&iacute;a</div></td>
        <td width="13%"><div align="center" class="msgok1">Opciones </div></td>
  </tr>

	<?
	$sql_origen="SELECT * FROM

`historial_documentos` AS `th`
Inner Join `estados` AS `te` ON `te`.`id_estado` = `th`.`id_estado`
Inner Join `accion` AS `tac` ON `tac`.`id_accion` = `th`.`id_accion`
Inner Join `areas` AS `ta` ON `ta`.`id_area` = `th`.`id_area`
WHERE
`th`.`id_documento` =  '".$ids."'
ORDER BY
th.original_historial_documento ASC,
th.fecha_historial_documento DESC";

   		$query_origen=new Consulta($sql_origen);
		$hayOriginal=0;
		while($row_org=$query_origen->ConsultaVerRegistro()){
		$id=$row_org[0];
		


	  ?>	
      <tr>
        <td bgcolor="#ffffff"><input type="hidden" value="<?=$id?>"><div align="center"><?=$row_org[1]?></div></td>
        <td bgcolor="#ffffff"><?=$row_org[2]?><?=$_POST[nombre]?></td>
        <td bgcolor="#ffffff"><?=$row_org['nombre_area']?></td>
        <td bgcolor="#ffffff"><div align="center"><?=$row_org['fecha_historial_documento']?></div></td>
        <td bgcolor="#ffffff"><div align="center"><?=$row_org['nombre_accion']?></div></td>
        <td bgcolor="#ffffff"><div align="center">
			<? if($row_org['original_historial_documento']=='1'){
					echo 'ORIGINAL'; 
					$hayOriginal++;
				} else {
					echo 'COPIA';
				}?></div>        </td>
        <td bgcolor="#ffffff"><div align="center"><a href="mesa_acceso_registro.php?opcion=eliminar&ids=<?=$ids?>&id=<?=$id?>"><img src="imgs/b_drop.png" alt="Eliminar" width="16" height="16" border="0"></a>&nbsp;</div></td>
      </tr>
     <? } ?>
</table> 
<?
	if($hayOriginal > 0){
	?>
		<script>javascript:deshabilitado();</script>
	<?
    }
}

function DespacharGuardarDestino($ids) {

//$ids=$_POST['ids'];
$nombre=$_POST['nombre'];
$fecha=date("Y-m-d h:m:s");
$cboareas=$_POST['cboareas'];
$radiobutton=$_POST['radiobutton'];
$cboaccion=$_POST['cboaccion'];
$cboprioridad=$_POST['cboprioridad'];
$textfield2=$_POST['textfield2'];
$textarea=$_POST['textfield4'];
$estado='3';
$guades="Insert INTO historial_documentos values('','".$ids."','".$nombre."','".$cboareas."','".$fecha."','".$radiobutton."','".$cboaccion."','','".$estado."','".$textarea."')";
$qdest=new Consulta($guades);	

			$s_act="Update documentos SET id_prioridad='".$cboprioridad."', asunto_documento='".$textfield2."',id_estado='".$estado."'
				WHERE id_documento='".$ids."'";
			$qact=new Consulta($s_act);	


}







function DespacharEliminarDestino($id,$ids){

	$ids=$_POST['ids'];
	$fecha=date("Y-m-d h:m:s");
	$sst="Delete from historial_documentos where id_historial_documento='".$id."'";
	$qt=new Consulta($sst);	
	$actua="Update documentos SET id_prioridad='', asunto_documento='',observacion_documento=''
			WHERE id_documento='".$ids."'";
			$q_actua=new Consulta($actua);	
			$act2="Update historial_documentos SET observacion=''
			WHERE id_documento='".$ids."'";
			$q_actua=new Consulta($actua);	
	}

function DespacharEditarDestino($ids) {

    $edi = " SELECT
            `td`.`asunto_documento`,
            `td`.`observacion_documento`,
            `td`.`id_prioridad`
            FROM
            `documentos` AS `td`
            WHERE
            `td`.`id_documento` =  '".$ids."'";

    $qedit=new Consulta($edi);
    $row_edit=$qedit->ConsultaVerRegistro();
?>

<form name="form10"  method="post"  action="<?php echo $_SERVER['PHP_SELF']?>?opcion=des_editar&ids=<?=$_POST['ids']?>" >  

  <fieldset>
  <legend class="Estilo9">ESTABLECER ASUNTO Y PRIORIDAD</legend>

    <select name="cboprioridad2"  id="cboprioridad2" onChange="cambia_saldo(this.value)">
    <option value="" selected="selected">--- Seleccione Prioridad ---</option>
	    <? 
					while($row_prioridad=$query_prioridad->ConsultaVerRegistro())
		{?>
    <option value="<?=$row_prioridad[0]?>"<? if($id_total==$row_prioridad[0]){ echo "selected"; } ?>>
	    <?=$row_prioridad[1].'-'.$row_prioridad[2]?>
    </option>
    <? } ?>
  </select>

  <table width="100%" border="0" align="center" bordercolor="#000000" bgcolor="#ffffff" clas="formularios">
    <tr>
      <td width="89" height="56" bgcolor="#ffffff" class="Estilo22"><div align="right">Asunto:</div></td>
      <td colspan="3"><textarea name="textfield"  id="textfield" rows="5" cols="138"><?=$row_edit[0]?>
      </textarea></td>
    </tr>
    <tr>
      <td bgcolor="#ffffff" class="Estilo22"><div align="right">Observaci&oacute;n:</div></td>
      <td colspan="3"><textarea name="textarea"  id="textarea" rows="3" cols="138"><?=$row_edit[1]?></textarea></td>
    </tr>
    <tr>
   	  <td bgcolor="#ffffff" class="Estilo22"><div align="right">Prioridad:</div></td>
	    <td width="370">
	  <?
      		$sql_prioridad="SELECT prioridades.id_prioridad, prioridades.nombre_prioridad, prioridades.tiempo_horas_respuesta_prioridad 
							FROM prioridades
							where
							prioridades.id_prioridad='".$row_edit[2]."'
							ORDER BY prioridades.id_prioridad ASC";
			    			$query_prioridad=new Consulta($sql_prioridad);
		?></td>

      	<td width="234" bgcolor="#ffffff" class="Estilo22"><div align="right">Tiempo de Respuesta:</div></td>
		<td width="245"> <div align="right" id="capa_saldo"></div></td>
    </tr>
    <tr>
<td colspan="2" bgcolor="#ffffff" class="Estilo22">&nbsp;</td>
<td>
	  <div align="right" class="Estilo22">Fecha Estimada de Respuesta:	  </div></td>

<td><?php echo $documento->getFechaRespuesta(); ?></td>
    </tr>
  </table>
  </fieldset>

  <fieldset>
  <legend class="Estilo9">ESTABLECER DESTINO Y ACCION A REALIZAR</legend>

  <table width="99%" align="center" border="1">
    <tbody>
      <tr>
        <td width="35%" bgcolor="#ffffff" class="Estilo22"><div align="left">Pase A:
          <?
			$sql_areas="SELECT areas.id_area, areas.nombre_area FROM areas";
			$query_areas=new Consulta($sql_areas);
		?>
	      <select name="cboareas"  id="cboareas">
            <option value="">--- Seleccione Destino---</option>
            <? while($row_areas=$query_areas->ConsultaVerRegistro()) {?>
            <option value="<? echo $row_areas[0]?>"><? echo $row_areas[1]?></option>
            <? } ?>
          </select>        
		  <?
        $sql_accion="SELECT accion.id_accion, accion.nombre_accion, accion.categoria_accion FROM accion";
    	$query_accion=new Consulta($sql_accion);
		?>
        </div>
		</td>
        <td width="32%" class="Estilo22"><div align="left">Acc&iacute;on:
            <select name="cboaccion" id="cboaccion">
            <option value="">--- Accion a Realizar---</option>
            <? while($row_accion=$query_accion->ConsultaVerRegistro()) {?>
            <option value="<? echo $row_accion[0]?>"><? echo $row_accion[1]?></option>
            <? } ?>
          </select>
        </div>
		</td>
        <td width="22%" bgcolor="#ffffff" class="Estilo22">
		<div align="center">
          <input name="radiobutton" value="1" type="radio" id="0">
          Original
          <input name="radiobutton" value="2" type="radio" id="1">
          Copia
        <td width="11%" align="center">
        <input type="submit" name="Cargar Lista" value="Cargar Lista" />
        </td>
      </tr>

    </tbody>
  </table>
  </fieldset>
</form>

<?

}

function RegistraFiltrar(){

    $sql_estado="SELECT *
        		FROM
    			`estados` AS `e`
    			ORDER BY
    			`e`.`nombre_estado` ASC";
    $q_estado=new Consulta($sql_estado);
    ?>

<form name="f5" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=list&ide=<?=$ide?>">

    <table width="100%" height="50" border="0" >
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center">
			<select name="ide">
              <option value="">---Estado---</option>
              <?
                        while($row_estado=$q_estado->ConsultaVerRegistro()){
                    		$ide=$row_estado[0];?>
              <option value="<?=$row_estado[0]?>"<? if(isset($ide) && $ide== $row_estado[0]){ echo "selected";} ?>>
              <?=$row_estado[1]?>
              </option>
              <?}?>
            </select></td>
        </tr>
        <tr>
              <td align="center" ><input name="Filtrar" type="submit"  value="Filtrar"/></td>
        </tr>
</table>
</form>
<?
}
}
?>
