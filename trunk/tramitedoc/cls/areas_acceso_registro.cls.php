<?php

class Registro {
function RegistraCabecera(){	
$sql_usu="SELECT `u`.`login_usuario`,`u`.`password_usuario`,`uap`.`id_axo_poa`,`u`.`nombre_usuario` as nombre
FROM
`usuarios` AS `u`,
 `usuario_axo_poa` AS `uap` 
WHERE
`u`.`id_usuario` = `uap`.`id_usuario` AND
`u`.`id_usuario` = '".$_SESSION['session'][1]."'
";

$query_pa=new Consulta($sql_usu);		
$row_usu=$query_pa->ConsultaVerRegistro(); 
$_POST[tai]=$row_usu[id_area];
$_POST['usu']=$row_usu['id_usuario'];
?><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Documento sin t&iacute;tulo</title>





<?php

}

function RegistraListado($ide){	

$tai=$_POST[tai];

// echo $tai;



if ($ide==''){



	$sql_reg="SELECT  *



FROM

`historial_documentos` AS `hd`

Inner Join `documentos` AS `d` ON `d`.`id_documento` = `hd`.`id_documento`

Inner Join `estados` AS `e` ON `e`.`id_estado` = `hd`.`id_estado`

Inner Join `accion` AS `a` ON `a`.`id_accion` = `hd`.`id_accion`

Inner Join `remitentes` AS `r` ON `r`.`id_remitente` = `d`.`id_remitente`

Inner Join `areas` AS `ar` ON `ar`.`id_area` = `hd`.`id_area`

Inner Join `tipos_documento` AS `td` ON `d`.`id_tipo_documento` = `td`.`id_tipo_documento`

WHERE



d.id_estado >  '1' AND

hd.id_area =  '".$_SESSION['session'][5]."'

ORDER BY

	d.codigo_documento DESC

";



$query_reg=new Consulta($sql_reg);	

//$row_reg=$query_reg->ConsultaVerRegistro();

}

else{





$sql_reg="SELECT  *



FROM

`historial_documentos` AS `hd`

Inner Join `documentos` AS `d` ON `d`.`id_documento` = `hd`.`id_documento`

Inner Join `estados` AS `e` ON `e`.`id_estado` = `hd`.`id_estado`

Inner Join `accion` AS `a` ON `a`.`id_accion` = `hd`.`id_accion`

Inner Join `remitentes` AS `r` ON `r`.`id_remitente` = `d`.`id_remitente`

Inner Join `areas` AS `ar` ON `ar`.`id_area` = `hd`.`id_area`

Inner Join `tipos_documento` AS `td` ON `d`.`id_tipo_documento` = `td`.`id_tipo_documento`

WHERE

d.id_estado >  '1' AND

hd.id_area =  '".$_SESSION['session'][5]."' and

hd.id_estado='".$ide."'

ORDER BY

	d.codigo_documento DESC

";



$query_reg=new Consulta($sql_reg);	

}



	?>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
<table width="100%" border="1" align="center" id="tabla_despacho">

    <tr bgcolor="#6699CC" class="Estilo22">
		<td width="9%"height="25" ><div align="center" class="msgok1">Reg. Nro</div></td>
		<!---<td width="10%"><div align="center"><span class="msgok1">Tipo de Doc.</span></div></td>--->
		<td width="25%"><div align="center"><span class="msgok1">Remitente</span></div></td>
		<td width="34%"><div align="center"><span class="msgok1">Documento</span></div></td>
		<td width="13%"><div align="center"><span class="msgok1">Fecha de Registro</span></div></td>
		<td width="3%" align="center">Estado</td>
		<td width="2%" align="center">Cat</td>
		<td width="10%"><div align="center" class="msgok1"> Ubicacion</div></td>
	</tr>

    <? while($row_reg=$query_reg->ConsultaVerRegistro()){

		$ids=$row_reg[id_documento];
		$_POST[remi]=$row_reg[t_remitentenombre];
		$_POST[ohd]=$row_reg['observacion_historial_documento'];
        $estado=$row_reg["id_estado"];
        ?>

    <tr <?echo ($estado==12)?"class='Estilo7 fila_finalizada'":"class='Estilo7'";?>>
		<td   onmouseover="toolTips('<?=$row_reg['asunto_documento']?>',this)" >
			<a href="areas_acceso_registro.php?opcion=despachar&ids=<?=$ids?>"> <?=$row_reg['codigo_documento']?></a>
		</td>
      <!--<td ><?=$row_reg['nombre_tipo_documento']?></td>--->
		<td ><?=$row_reg['nombre_remitente']?></td>
		<td ><?=$row_reg['numero_documento']?></td>
		<td > <?php echo date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?></td>
		<td align="center" ><?=$row_reg['abrev_nombre_estado']?></td>
		<td align="center" ><? if($row_reg['original_historial_documento']=='1'){echo 'O';} else {echo 'C';}?></td>

      <?php

		$sql_data=" SELECT `a`.`abve_nombre_area`
					FROM
					`areas` AS `a` 
					WHERE
					`a`.`id_area` =  '".$_SESSION['session'][5]."' ";

		$query_data=new Consulta($sql_data);		
		$data=$query_data->ConsultaVerRegistro();

		$sql_usu="SELECT Max(`ha`.`id_historial_atencion`) AS `ultimo`, 		
				`ha`.`id_documento`,ha.original_historial_atencion,`usuarios`.`id_area`
				FROM
				`historial_atencion` AS `ha`
				Inner Join `usuarios` ON `usuarios`.`id_usuario` = `ha`.`id_usuario_destino`
				WHERE
				ha.id_documento='".$row_reg['id_documento']."' and
				usuarios.id_area =  '".$_SESSION['session'][5]."'
				GROUP BY
				`ha`.`id_historial_atencion`	";
	
		$query_usu=new Consulta($sql_usu);		

		$usu=$query_usu->ConsultaVerRegistro();

		

		$susu="SELECT `u`.`login_usuario` 
				FROM 
				`historial_atencion` AS `ha` 
				Inner Join `usuarios` AS `u` ON `u`.`id_usuario` = `ha`.`id_usuario_destino` 
				WHERE 
				`ha`.`id_historial_atencion` = '".$usu['ultimo']."'  ";

				$qusu=new Consulta($susu);		
				$u=$qusu->ConsultaVerRegistro();
?>

      <td>

	<?  if ($row_reg['id_estado']='4'){echo $data['abve_nombre_area'];

				if($usu['original_historial_atencion']=='1'){
						 echo ' '.$u['login_usuario'];}
	 			else{ echo ' '.' ';	}

	}

	 else { echo $data['abve_nombre_area']; }?>
	 </td>
    </tr>
	<? }?>
</table>

<?php }

function Busqueda($campo, $valor){	

	if($campo == "nombre_remitente"){
		$where = $campo == "nombre_remitente" ? " AND r.nombre_remitente like '%$valor%' " : "";
	}else{
		$where = $campo != "" ? " AND d.$campo like '%$valor%' " : ""  ;
	}

	$sql_reg = "SELECT  *	FROM
				`historial_documentos` AS `hd`
				Inner Join `documentos` AS `d` ON `d`.`id_documento` = `hd`.`id_documento`
				Inner Join `estados` AS `e` ON `e`.`id_estado` = `hd`.`id_estado`
				Inner Join `accion` AS `a` ON `a`.`id_accion` = `hd`.`id_accion`
				Inner Join `remitentes` AS `r` ON `r`.`id_remitente` = `d`.`id_remitente`
				Inner Join `areas` AS `ar` ON `ar`.`id_area` = `hd`.`id_area`
				Inner Join `tipos_documento` AS `td` ON `d`.`id_tipo_documento` = `td`.`id_tipo_documento`
				WHERE
				d.id_estado >  '1' AND
				hd.id_area =  '".$_SESSION['session'][5]."'".$where."
				ORDER BY d.codigo_documento DESC ";
	
	$query_reg = new Consulta($sql_reg);	
	
?>

	<table width="100%" border="1" align="center" id="tabla_despacho">
	<tr bgcolor="#6699CC" class="Estilo22">
		  <td width="9%"height="25" ><div align="center" class="msgok1">Reg. Nro</div></td>
		  <td width="25%"><div align="center"><span class="msgok1">Remitente</span></div></td>
		  <td width="34%"><div align="center"><span class="msgok1">Documento</span></div></td>
		  <td width="13%"><div align="center"><span class="msgok1">Fecha de Registro</span></div></td>
		  <td width="3%" align="center">Estado</td>
		  <td width="2%" align="center">Cat</td>
		  <td width="10%"><div align="center" class="msgok1"> Ubicacion</div></td>      
	  </tr>

		<?php while($row_reg=$query_reg->ConsultaVerRegistro()){
				$ids=$row_reg[id_documento];
				$_POST[remi]=$row_reg[t_remitentenombre];
				$_POST[ohd]=$row_reg['observacion_historial_documento'];
                $estado=$row_reg["id_estado"];
        ?>

        <tr <?echo ($estado==12)?"class='Estilo7 fila_finalizada'":"class='Estilo7'";?>>
		<td   onmouseover="toolTips('<?=$row_reg['asunto_documento']?>',this)" >
			<a href="areas_acceso_registro.php?opcion=despachar&ids=<?=$ids?>"> <?=$row_reg['codigo_documento']?></a>
		</td>  
		  <td ><?=$row_reg['nombre_remitente']?></td>
		  <td ><?=$row_reg['numero_documento']?></td>
		  <td > <?php echo date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?></td>
		  <td align="center" ><?=$row_reg['abrev_nombre_estado']?></td>
		  <td align="center" ><? if($row_reg['original_historial_documento']=='1'){echo 'O';} else {echo 'C';}?></td>

		  <?php
			$sql_data ="SELECT `a`.`abve_nombre_area`
						FROM `areas` AS `a` 
						WHERE
						`a`.`id_area` =  '".$_SESSION['session'][5]."' ";

			$query_data=new Consulta($sql_data);		
			$data=$query_data->ConsultaVerRegistro();
			
			$sql_usu = "SELECT 
						Max(`ha`.`id_historial_atencion`) AS `ultimo`, 			
						`ha`.`id_documento`, 
						ha.original_historial_atencion, 
						`usuarios`.`id_area`  
						FROM  
						`historial_atencion` AS `ha` 
						Inner Join `usuarios` ON `usuarios`.`id_usuario` = `ha`.`id_usuario_destino` 
						WHERE 
						ha.id_documento='".$row_reg['id_documento']."' and 
						usuarios.id_area =  '".$_SESSION['session'][5]."'
						GROUP BY
						`ha`.`id_historial_atencion`	";

		$query_usu=new Consulta($sql_usu);		
		$usu=$query_usu->ConsultaVerRegistro();

		$susu = "SELECT `u`.`login_usuario`
				FROM
				`historial_atencion` AS `ha`
				Inner Join `usuarios` AS `u` ON `u`.`id_usuario` = `ha`.`id_usuario_destino`
				WHERE
				`ha`.`id_historial_atencion` = '".$usu['ultimo']."'  ";

				$qusu=new Consulta($susu);		
				$u=$qusu->ConsultaVerRegistro();
?>

      <td>

	<?  if ($row_reg['id_estado']='4'){echo $data['abve_nombre_area'];

				if($usu['original_historial_atencion']=='1'){
					echo ' '.$u['login_usuario'];}
	 			else{ echo ' '.' ';	}

	}

	 else { echo $data['abve_nombre_area']; }?></td>

    </tr><? }?>
</table>

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

	$tai=$_POST[tai];

	$sql_resumen="SELECT *
				FROM
				documentos
				Inner Join remitentes ON remitentes.id_remitente = documentos.id_remitente
				Inner Join tipos_documento ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento
				WHERE
				documentos.id_documento = '".$ids."'";
				
				$query_resumen=new Consulta($sql_resumen);
				$row_resumen=$query_resumen->ConsultaVerRegistro(); 

				$edi="SELECT
				`td`.`asunto_documento`,
				`td`.`observacion_documento`,
				`td`.`id_prioridad`,
				`hd`.`observacion_historial_documento`,
				`td`.`id_documento`,
				 hd.id_historial_documento,
				`hd`.`original_historial_documento`
				FROM
				`documentos` AS `td`
				Inner Join `historial_documentos` AS `hd` ON `hd`.`id_documento` = `td`.`id_documento`
				WHERE
				`td`.`id_documento` =  '".$ids."' and
				hd.id_area =  '".$_SESSION['session'][5]."'";

				$qedit=new Consulta($edi);	
				$row_edit=$qedit->ConsultaVerRegistro();

				$_POST['idhd']=$row_edit['id_historial_documento']; 

				$escaneo = "SELECT * 
							from documentos_escaneados de
							where de.id_documento = ".$ids;
							
				$qescaneo = new Consulta($escaneo);

				?>
		

	

<fieldset>

  <legend class="Estilo9">DATOS DEL DOCUMENTO</legend>



  <table border="0" align="center" bordercolor="#000000" bgcolor="#ffffff">
    <tbody>
    
      <tr>
      <td colspan="2" class="Estilo22"><div align="left">Registro Nro</div></td>
      <td width="10"   class="Estilo22"><div align="center">:</div></td>
      <td width="238"  class="Estilo23"><?=$row_resumen[1]?></td>
      <td width="157"   class="Estilo22">Categoria</td>
      <td width="11"  ><div align="center">:</div></td>
      <td width="203"  ><span class="Estilo23">
        <? if($row_edit['original_historial_documento']=='1'){echo 'ORIGINAL';} else {echo 'COPIA';}?>
      </span></td>
      </tr>
      <tr>
        <td height="22" colspan="2" class="Estilo22"><div align="left">Remitente</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td class="Estilo23"><?=$row_resumen[nombre_remitente]?></td>
        <td class="Estilo22">Nro de Folios</td>
        <td ><div align="center">:</div></td>
        <td class="Estilo23" ><?=$row_resumen[numero_folio_documento]?></td>
      </tr>
      <tr>
        <td colspan="2"  class="Estilo22"><div align="left">Nro. Doc</div></td>
        <td  class="Estilo22"><div align="center">:</div></td>
        <td class="Estilo23"><?=$row_resumen[numero_documento]?></td>
      
        <td><div align="left"><span class="Estilo22">Fecha de Doc</span></div></td>
        <td><div align="center">:</div></td>
        <td class="Estilo23"><?php echo date('d-m-Y',strtotime($row_resumen[fecha_documento]))?></td>
      </tr>
      <tr>
        <td colspan="2" class="Estilo22"><div align="left">Referencia</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="4" class="Estilo23"><?=$row_resumen[referencia_documento]?></td>
      </tr>
      <tr>
        <td colspan="2" class="Estilo22"><div align="left">Anexos</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="4" class="Estilo23"><?=$row_resumen[anexo_documento]?>
          <? if($row_edit['original_historial_documento']=='1'){ ?>
          <? } else { "null" ;}?></td>
      </tr>
      <tr>
          <td colspan="2" bgcolor="#ffffff" class="Estilo22"><div align="left">Documento Digitalizado</div></td>
          <td bgcolor="#ffffff" class="Estilo22"><div align="center">:</div></td>
        <td colspan="4"><span class="Estilo23">
      <?
	  		$index = 1;
			
			while($row_reg = $qescaneo->ConsultaVerRegistro()){?>
				<a href="Escaneo/<?=$row_reg['nombre_documento_escaneado']?>" id="<?=$row_reg["id_documento_escaneado"]?>" target="_blank"><?=$index?></a>				
		<?
				$index++;
            }
	  	?>               
      </span><?=$id?>
      <? if($row_edit['original_historial_documento']=='1'){ ?>
        <? } else { "null" ;}?></td>
      </tr>
      <tr>
        <td colspan="2" class="Estilo22"><div align="left">Fecha y Hora de Registro</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td class="Estilo23"><?php echo date('d-m-Y H:I:s',strtotime($row_resumen["fecha_registro_documento"]))?></td>
        <td align="left" class="Estilo22"><div align="left">Tipo de Documento</div></td>
          <td align="left" ><div align="center">:</div></td>
          <td align="left" class="Estilo23"><?=$row_resumen["nombre_tipo_documento"]?></td>
      </tr>
          
      <tr>
        <td colspan="2" class="Estilo22"><div align="left">Asunto</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="4"><textarea name="textfield2" id="textfield2" rows="3" cols="100"><?=$row_edit[0]?>
        </textarea></td>
      </tr>
      <tr>
        <td colspan="2" class="Estilo22"><div align="left">Observaci&oacute;n Registro</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="4"><textarea name="textarea2" id="textarea2" rows="3" cols="100"><?=$row_edit[1]?>
        </textarea></td>
      </tr>
      <tr>
      <td colspan="2" class="Estilo22"><div align="left">Observaci&oacute;n Despacho</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="4"><textarea name="textarea3" id="textarea3" rows="3" cols="100"><?=$row_edit[3]?>
        </textarea></td>
      </tr>
      <tr>
      <td colspan="2" class="Estilo22"><div align="left">Prioridad</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="4"><span class="Estilo23">
        <?
	  
	  $sql_prioridad = "SELECT prioridades.id_prioridad, 
	  					prioridades.nombre_prioridad, 
						prioridades.tiempo_horas_respuesta_prioridad 
						FROM prioridades 
						where 
						prioridades.id_prioridad='".$row_edit[id_prioridad]."' 
						ORDER BY prioridades.id_prioridad ASC";
    	
		$query_prioridad=new Consulta($sql_prioridad);
		$row_prioridad=$query_prioridad->ConsultaVerRegistro();
		
		?>
        <?=$row_prioridad["nombre_prioridad"]?>
        
		</span></td>
	  </tr>
      <tr>
        <td colspan="2" class="Estilo22"><div align="left">Tiempo de Respuesta:</div></td>
        <td bgcolor="#ffffff" class="Estilo22"><div align="center"></div></td>
        <td colspan="4"><input name="Input" value="<?php echo $row_prioridad[tiempo_horas_respuesta_prioridad]/24 ?><?php echo '  Dias'?>" align="center"/></td>
      </tr>
      <tr>
        <td colspan="2" class="Estilo22"><div align="left">Fecha Estimada de Respuesta</div></td>
        <td class="Estilo22"><div align="center">:</div></td>
        <td colspan="4">&nbsp;</td>
      </tr>
    </tbody>
</table>

</fieldset>
<table width="22%" border="0" align="center">
  <tr>
    <td width="48%" height="39"><form id="f7" name="f7" method="post" action="<?php areas_acceso_registro.php?>?opcion=devol&amp;ids=<?=$row_edit['id_documento']?>">
      <div align="center">
        <input  border="#0099FF" name="devolver" type="submit" class="boton" id="devolver" value="Devolver" />
        </div>
    </form></td>
    <td width="6%" >&nbsp;</td>
    <td width="46%" ><form id="f8" name="f8" method="post" action="<?php areas_acceso_registro.php?>?opcion=arch&amp;ids=<?=$row_edit['id_documento']?>">
      <div align="center">
        <input  border="#0099FF" name="archivar" type="submit" class="boton" id="button" value="Archivar" />
        </div>
    </form></td>
  </tr>
</table>


<form name="form_despacho_area" id = "form_despacho_area" method="post"  action="<?php echo $_SERVER['PHP_SELF']?>?opcion=des_guard&ids=<?=$ids?>" >  

	<?
		$td="SELECT
		`td`.`id_documento`,
		`td`.`observacion_historial_atencion`
		FROM
		`historial_atencion` AS `td`
		WHERE
		`td`.`id_documento` =  '".$ids."'";
		$qtd=new Consulta($td);	
		$row_td=$qtd->ConsultaVerRegistro();
	?>

<fieldset>
  <legend class="Estilo9">ESTABLECER DESTINO Y ACCION A REALIZAR</legend>
  <table align="center" border="0" class="formularios">
    <tbody>
      <tr>
        <td height="27" class="Estilo21" ><div align="center">(*)</div></td>
        <td class="Estilo22" ><div align="left">Pase A</div></td>
        <td ><div align="center">:</div></td>
        <td width="26%" ><?
    		$sql_areas="SELECT * FROM usuarios where usuarios.id_area='".$_SESSION['session'][5]."' ";
	    	$query_areas=new Consulta($sql_areas);
		?>
          <input type="hidden" value="<?=$_SESSION['session'][5]?>" id="idArea"/>
          <select name="destino" id="destino" style="width:200px" class="usuarios">
            <option value="" selected="selected">--- Seleccione un Usuario---</option>
            <? while($row_areas=$query_areas->ConsultaVerRegistro()) {?>
            <option value="<? echo $row_areas[0]?>"<? if(isset($_POST['destino']) && $_POST['destino']==$row_areas[0]){ echo "selected";} ?>><? echo $row_areas[nombre_usuario]?><? echo $row_areas[apellidos_usuario]?></option>
            <? } ?>
        </select>
        <a href="javascript:void(0);" id="cambiar_destino">Areas</a>
        </td>

        <td width="37%" rowspan="3" class="Estilo22" >Observaci&oacute;n Area:
        <textarea name="textarea4" id="textarea4" rows="3" cols="55"><?=$row_td[1]?>
          </textarea></td>

      <td width="3%"  bgcolor="#ffffff" class="Estilo21"><div align="center">(*)
      </div>      
      <td width="3%"  bgcolor="#ffffff" class="Estilo22"><div align="center">
        <input name="radiobutton" value="1" type="radio" id="0" />      
      </div>
      <td bgcolor="#ffffff" class="Estilo22"><div align="left">Original      </div>
      <td bgcolor="#ffffff" class="Estilo22">      </tr>
      <tr>
        <td height="21" colspan="3" >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center"></td>
        <td  align="center"><div align="center"><span class="Estilo22">
          <input name="radiobutton" value="2" type="radio" id="1"/>
        </span></div></td>
        <td  align="center"><div align="left"><span class="Estilo22">Copia </span> </div></td>
      <td bgcolor="#ffffff" class="Estilo22">      </tr>
      <tr>

       <?

        $sql_accion="SELECT accion.id_accion, accion.nombre_accion, accion.categoria_accion FROM accion WHERE accion.categoria_accion='DA' ORDER BY

accion.nombre_accion ASC";

    	$query_accion=new Consulta($sql_accion);

		?>

      

        <td width="3%" height="26" class="Estilo21"><div align="center">(*)</div></td>

        <td width="8%" height="26" class="Estilo22" ><div align="left">Acc&iacute;on</div></td>
        <td width="3%" height="26" ><div align="center">:</div></td>
        <td ><select name="cboaccion2" style="width:200px" >
          <option value="">--- Accion a Realizar---</option>
          <? while($row_accion=$query_accion->ConsultaVerRegistro()) {?>
          <option value="<? echo $row_accion[0]?>"><? echo $row_accion[1]?></option>
          <? } ?>
        </select></td>

        <td  align="center">
        <td  align="center">
        <td width="6%"  align="center">
        <td width="11%" bgcolor="#ffffff" class="Estilo22">
          <div align="right">
            <input type="submit" name="Cargar Lista2" value="Cargar Lista" class="boton" />
        </div>      </tr>
    </tbody>
  </table>

  </fieldset>

</form>

  

  <? }

function DespacharListarDestino($ids)  {  ?>

  

<table width="100%" border="1" align="center" bgcolor="#ffffff"  id="tabla_despacho" >

   

      <tr bgcolor="#6699CC" class="Estilo7">

        <td width="5%" height="25" ><div align="center" class="msgok1">Nro</div></td>

        <td width="21%"><div align="center" class="msgok1">ORIGEN</div></td>

        <td width="24%"><div align="center" class="msgok1 Estilo1">DESTINO</div></td>

        <td width="13%"><div align="center" class="msgok1">Fecha y Hora </div></td>

        <td width="13%"><div align="center" class="msgok1">Acci&oacute;n</div></td>

        <td width="11%"><div align="center" class="msgok1">Categor&iacute;a</div></td>

        <td width="13%"><div align="center" class="msgok1">Opciones </div></td>

      </tr>

	<?

	$sql_origen="Select th.id_historial_atencion,

				th.id_historial_documento,

				th.id_documento,

				th.id_usuario_destino,

				th.id_area,

				th.fecha_historial_atencion,

				th.original_historial_atencion,

				th.id_accion,

				th.id_usuario,

				th.id_estado,

				th.observacion_historial_atencion,

				tac.nombre_accion,

				ud.nombre_usuario as nom_destino,

				ud.apellidos_usuario as ape_destino,

				u.nombre_usuario,

				u.apellidos_usuario,

				u.id_area

				FROM

				historial_atencion AS th

				Inner Join accion AS tac ON tac.id_accion = th.id_accion

				Inner Join usuarios AS u ON u.id_usuario = th.id_usuario

				Inner Join usuarios AS ud ON ud.id_usuario = th.id_usuario_destino

				WHERE

				th.id_documento =  '".$ids."' and

				u.id_area='".$_SESSION['session'][5]."'

				ORDER BY

				th.id_historial_documento DESC";

			   	$query_origen=new Consulta($sql_origen);
				
				$hayOriginal = 0;
				
				while($row_org=$query_origen->ConsultaVerRegistro()){

		

		$idp=$row_org[0]	  ;

	  ?>	

      <tr>

        <td bgcolor="#ffffff"><input type="hidden" value="<?=$idp?>"><div align="center"><?=$row_org[0]?></div></td>

        <td bgcolor="#ffffff"><?=$row_org['nombre_usuario']?><? echo ' ';?><?=$row_org['apellidos_usuario']?></td>

        <td bgcolor="#ffffff"><?=$row_org['nom_destino']?><? echo ' ';?><?=$row_org['ape_destino']?></td>

        <td bgcolor="#ffffff"><div align="center"><?=date('d/m/Y H:i',strtotime($row_org[5]))?></div></td>

        <td bgcolor="#ffffff"><div align="center"><?=$row_org['nombre_accion']?></div></td>

        <td bgcolor="#ffffff"><div align="center"><? if($row_org['original_historial_atencion']=='1'){echo 'ORIGINAL'; $hayOriginal++;} else {echo 'COPIA';}?></div></td>

        <td bgcolor="#ffffff"><div align="center"><a href="areas_acceso_registro.php?opcion=eliminar&ids=<?=$ids?>&idp=<?=$idp?>"><img src="imgs/b_drop.png" alt="Eliminar" width="16" height="16" border="0"></a>&nbsp;</div></td>

      </tr>
     <? } ?>
      </tr>    

</table> 
  
<?
	if($hayOriginal > 0){
	?>
		<script>deshabilitado();</script>
	<?
    }
}

function DespacharGuardarDestino($ids) {

//$ids=$_POST['ids'];

$nombre=$_POST['nombre'];

$fecha=date("d-m-Y H:i");

$destino=$_POST['destino'];

$radiobutton=$_POST['radiobutton'];

$cboaccion2=$_POST['cboaccion2'];

$cboprioridad=$_POST['cboprioridad'];

$textarea4=$_POST['textarea4'];

$textarea=$_POST['textarea'];

$idhd=$_POST['idhd'];

$usu=$_SESSION['session'][0];

$idarea= $_SESSION['session'][5];

$estado='4';

$guades="Insert INTO historial_atencion values('','".$idhd."','".$ids."','".$destino."','".$idarea."','".$fecha."','".$radiobutton."','".$cboaccion2."','".$usu."','".$estado."','".$textarea4."')";

$qdest=new Consulta($guades);	



			$s_act="Update documentos SET id_estado='".$estado."'

				WHERE id_documento='".$ids."'";

			$qact=new Consulta($s_act);	

		if(	$radiobutton=='1'){	

			$s_ma="Update historial_documentos SET id_estado='".$estado."'

				WHERE id_documento='".$ids."'";

			$sma=new Consulta($s_ma);	}

}

function DespacharEliminarDestino($idp){

	$ids=$_POST['ids'];

	//$fecha=date("Y-m-d h:m:s");
	$fecha=date("d-m-Y H:i");

	$sst="Delete from historial_atencion where id_historial_atencion='".$idp."'";

	$qt=new Consulta($sst);	

	

				$actua="Update documentos SET id_prioridad='', observacion_documento=''

					WHERE id_documento='".$ids."'";

				$q_actua=new Consulta($actua);	

					

	}

function DespacharDevolverDestino($ids){

	//$ids=$_POST['ids'];

	$fecha=date("d-m-Y H:i");
			$dev="Update documentos SET id_estado='5'
					WHERE id_documento='".$ids."'";
					$q_dev=new Consulta($dev);	
			$dev_1="Update historial_documentos SET id_estado='5', fecha_historial_documento='".$fecha."'
					WHERE id_documento='".$ids."'";
					$q_dev_1=new Consulta($dev_1);	
			$dev_2="Update historial_atencion SET id_estado='5', fecha_historial_atencion='".$fecha."'
					WHERE id_documento='".$ids."'";
					$q_dev_2=new Consulta($dev_2);	
	}

function DespacharArchivarDestino($ids){

	//$ids=$_POST['ids'];

	$fecha=date("d-m-Y H:i");
			$dev="Update documentos SET id_estado='11'
					WHERE id_documento='".$ids."'";
					$q_dev=new Consulta($dev);	
			$dev_1="Update historial_documentos SET id_estado='11', fecha_historial_documento='".$fecha."'
					WHERE id_documento='".$ids."'";
					$q_dev_1=new Consulta($dev_1);	
			$dev_2="Update historial_atencion SET id_estado='11', fecha_historial_atencion='".$fecha."'
					WHERE id_documento='".$ids."'";
					$q_dev_2=new Consulta($dev_2);	
	}

function DespacharEditarDestino($ids) {



$edi="SELECT

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

  <table width="100%" border="0" align="center" bordercolor="#000000" bgcolor="#ffffff">

    <tr>

      <td width="85" height="56" bgcolor="#ffffff" class="Estilo22"><div align="right"><strong>Asunto:</strong></div></td>

      <td colspan="3"><textarea name="textfield"  id="textfield" rows="3" cols="140"><?=$row_edit[0]?>

      </textarea></td>
    </tr>

    <tr>

      <td bgcolor="#ffffff" class="Estilo22"><div align="right"><strong>Observaci&oacute;n:</strong></div></td>

      <td colspan="3"><textarea name="textarea"  id="textarea" rows="3" cols="140"><?=$row_edit[1]?></textarea></td>
    </tr>

    <tr>

      <td bgcolor="#ffffff" class="Estilo22"><div align="right"><strong>Prioridad:</strong></div></td>

      <td width="542"><?

      $sql_prioridad="SELECT prioridades.id_prioridad, prioridades.nombre_prioridad, prioridades.tiempo_horas_respuesta_prioridad

						FROM prioridades

						where

						prioridades.id_prioridad='".$row_edit[2]."'

						ORDER BY prioridades.id_prioridad ASC";

    	$query_prioridad=new Consulta($sql_prioridad);



		?>

        

         

			<select name="cboprioridad"  id="cboprioridad" onChange="cambia_saldo(this.value)">

            <option value="1"></option>

            <? 

					while($row_prioridad=$query_prioridad->ConsultaVerRegistro())

					{?>

          <option value="<?=$row_prioridad[0]?>"<? if($id_total==$row_prioridad[0]){ echo "selected"; } ?>>

            <?=$row_prioridad[1].'-'.$row_prioridad[2]?>
            </option>

            <? } ?>
      </select></td>

      <td width="309" bgcolor="#ffffff" class="Estilo22"><div align="right"><strong>Tiempo de Respuesta:</strong></div></td>

      <td width="0"> <div align="right" id="capa_saldo">

    </div></td>
    </tr>

    <tr>

      <td colspan="4" bgcolor="#ffffff" class="Estilo22"><div align="right"><strong>Fecha Estimada de Respuesta:</strong></div></td>
    </tr>
  </table>

  </fieldset>

  

  <fieldset>

  

  <legend class="Estilo9">ESTABLECER DESTINO Y ACCION A REALIZAR</legend>

 

  <table width="100%" align="center" border="1">

    <tbody>

      <tr>
        <td bgcolor="#ffffff" class="Estilo22"><div align="left">Pase A:
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
                <!-- <input name="Submit4" value="Agregar" type="button">--->
        </div></td>
        <td bgcolor="#ffffff" class="Estilo22"><div align="left">Acc&iacute;on
          <select name="cboaccion" id="cboaccion">
                  <option value="">--- Accion a Realizar---</option>
                  <? while($row_accion=$query_accion->ConsultaVerRegistro()) {?>
                  <option value="<? echo $row_accion[0]?>"><? echo $row_accion[1]?></option>
                  <? } ?>
                </select>
        </div></td>
        <td bgcolor="#ffffff" class="Estilo22">
          <div align="center">
            <input name="radiobutton" value="1" type="radio" id="0" />
            </div></td>
        <td bgcolor="#ffffff" class="Estilo22"><div align="left">Original </div></td>
        <td align="center"><!--<div align="center"><a href="acceso_registro.php?opcion=des_guard" onClick="submit()" >Cargar Lista</a></div>-->        </td>
        <!---<td width="12%"><div align="center"><a href="#" ><input name="Cargar Lista"  value="Cargar Lista" type="submit" ></a></div></td>--->
      </tr>
      <tr>

        <td width="35%" bgcolor="#ffffff" class="Estilo22">&nbsp;</td>

        <td width="30%" bgcolor="#ffffff" class="Estilo22">&nbsp;</td>

        <td width="4%" bgcolor="#ffffff" class="Estilo22"><div align="center">
          <input name="radiobutton" value="2" type="radio" id="1" />
          
        </div>
        <td width="16%" bgcolor="#ffffff" class="Estilo22"><div align="left">Copia
        </div>
        <td width="15%" align="center"><div align="center">
          <input name="Cargar Lista" type="submit" class="boton" value="Cargar Lista" />
        </div></td>

        <!---<td width="12%"><div align="center"><a href="#" ><input name="Cargar Lista"  value="Cargar Lista" type="submit" ></a></div></td>--->
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

<td align="center">

 

    <select name="ide">

      

      

      <option value="">---Estado---</option>

      

       <?



        while($row_estado=$q_estado->ConsultaVerRegistro()){

		$ide=$row_estado[0];?>

      

                 <option value="<?=$row_estado[0]?>"<? if(isset($ide) && $ide== $row_estado[0]){ echo "selected";} ?>>

                 <?=$row_estado[1]?>
          </option> 

      <?  } ?>	
    </select></td>
    </tr>

 <tr>

  <td align="center" ><input name="Filtrar" type="submit" class="boton"  value="Filtrar"/></td>
  </tr>
</table>

    

</form>

        <?

}







 }

 ?>

