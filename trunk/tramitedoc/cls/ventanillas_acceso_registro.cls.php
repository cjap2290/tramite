<?php

class Registro {

function RegistraCabecera(){	

	$sql_usu = "SELECT `u`.`login_usuario`,
				`u`.`password_usuario`,
				`uap`.`id_axo_poa`,
				`u`.`nombre_usuario` as nombre 
				FROM 
				`usuarios` AS `u`,
				`usuario_axo_poa` AS `uap` 
				WHERE 
				`u`.`id_usuario` = `uap`.`id_usuario` AND 
				`u`.`id_usuario` = '1'";

	$query_pa=new Consulta($sql_usu);		
	$row_usu=$query_pa->ConsultaVerRegistro(); 

}

function RegistraListado($ide){	
 
	if ($ide == ''){
		
        $sql_reg =  "SELECT * FROM 
					documentos 
					Inner Join remitentes 
					ON remitentes.id_remitente = documentos.id_remitente 
					Inner Join estados 
					ON estados.id_estado = documentos.id_estado 
					Inner Join tipos_documento 
					ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento 
					ORDER BY 
					documentos.id_documento DESC";
	
		$query_reg = new Consulta($sql_reg);

	}
	else 
	{
		$sql_reg = "SELECT * FROM 
					documentos 
					Inner Join remitentes 
					ON remitentes.id_remitente = documentos.id_remitente 
					Inner Join estados 
					ON estados.id_estado = documentos.id_estado 
					Inner Join tipos_documento 
					ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento 
					Where estados.id_estado='".$ide."'  
					ORDER BY documentos.id_documento DESC";
					
		$query_reg=new Consulta($sql_reg);		
	}
	//$row_reg=$query_reg->ConsultaVerRegistro();
?>
      <!----<div align="center"><a href="<=$_SESSION['PHP_SELF']?>?opcion=add"class=" Estilo2" >Registrar Nuevo</a></div>--->
	<table width="100%" border="1"  align="center" class="formularios">
		<tr bgcolor="#6699CC" class="Estilo7">
			<td width="10%"><div align="center"><span class="msgok1">Reg. N&ordm; </span></div></td>
		  	<!----<td width="8%"><div align="center"><span class="msgok1">Tipo de Doc.</span></div></td>--->
		  	<td width="29%"><div align="center"><span class="msgok1">Remitente</span></div></td>
			<td width="28%"><div align="center"><span class="msgok1"> Documento</span></div></td>
			<!--<td width="31%"><div align="center"><span class="msgok1">Referencia</span></div></td>--->
		  	<td width="14%"><div align="center">Registrado</div></td>
			<td width="5%" align="center">Estado</td>
			<td width="14%"><div align="center" class="msgok1">Ubicacion  </div></td>
	  	</tr>
		    <? while($row_reg=$query_reg->ConsultaVerRegistro()){
                    $id=$row_reg[0];
                    $estado = $row_reg["id_estado"];
                    ?>
	   <tr <?echo ($estado==12)?"class='Estilo2 fila_finalizada'":"class='Estilo2'";?>>
	   		<td onmouseover="toolTips('<?php echo $row_reg['asunto_documento']?>',this)">
				<div align="center">
                <?php 
                $cod = $row_reg[1];
                if($estado != 12){ ?>
                    <a href="Ventanillas_acceso_registro.php?opcion=edit&id=<?=$id?>">
                    <?=$cod?></a>
                <?}
                    else{
                        echo $cod;
                    }
                ?>
		        </div></td>
	      	<td ><input size="48"  value="<?=$row_reg[nombre_remitente]?>"/></td>
		    <td ><input size="43" value="<?=$row_reg[3]?>"/></td>		    
		    <td > <?php echo date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?></td>
      		<td align="center" ><?=$row_reg['abrev_nombre_estado']?></td>

      		<?php 

		  		$sql_ultimo="SELECT Max(`hd`.`id_historial_documento`) AS `ultimo` 
							FROM `historial_documentos` AS `hd` 
							where hd.id_documento='".$row_reg['id_documento']."' 
							GROUP BY `hd`.`id_documento`";

				$query_ultimo=new Consulta($sql_ultimo);		
				$ultimo=$query_ultimo->ConsultaVerRegistro();
				
				$sql_data = "SELECT hd.id_documento,
							a.nombre_area, 
							a.abve_nombre_area 
							FROM historial_documentos AS hd 
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
				GROUP BY `ha`.`id_documento`	";

		$query_usu=new Consulta($sql_usu);		
		$usu=$query_usu->ConsultaVerRegistro();

		$susu = "SELECT `u`.`login_usuario`, `a`.`abve_nombre_area`
                FROM `historial_atencion` AS `ha`
                Inner Join `usuarios` AS `u` ON `u`.`id_usuario` = `ha`.`id_usuario_destino`
				Inner Join `areas` AS `a` ON `a`.`id_area` = `u`.`id_area`
				WHERE `ha`.`id_historial_atencion` = '".$usu['ultimo']."' ";

        $qusu=new Consulta($susu);
    	$u=$qusu->ConsultaVerRegistro();
?>
<td >
	<?  if ($row_reg['id_estado']<4){ echo $data[2];
	}
	 else {
	  echo $u['abve_nombre_area'].' '.$u['login_usuario'];}?></td>
    </tr><? }?>
</table> <?php 
}

function Busqueda($campo, $valor){	 


	if($campo == "nombre_remitente"){
		$where = $campo == "nombre_remitente" ? " AND remitentes.nombre_remitente like '%$valor%' " : "";
	}else{
		$where = $campo != "" ? " AND d.$campo like '%$valor%' " : "";
	}

	$sql_reg=" SELECT * FROM documentos d
		Inner Join remitentes ON remitentes.id_remitente = d.id_remitente
		Inner Join estados ON estados.id_estado = d.id_estado
		Inner Join tipos_documento ON tipos_documento.id_tipo_documento = d.id_tipo_documento 
		 ".$where."
		ORDER BY d.id_documento DESC";

	$query_reg=new Consulta($sql_reg);		
	//$row_reg=$query_reg->ConsultaVerRegistro();

?>

      <!----<div align="center"><a href="<=$_SESSION['PHP_SELF']?>?opcion=add"class=" Estilo2" >Registrar Nuevo</a></div>--->

<table width="100%" border="1"  align="center" class="formularios">
<tr bgcolor="#6699CC" class="Estilo7">
      <td width="10%"><div align="center"><span class="msgok1">Reg. N&ordm; </span></div></td>
      <!----<td width="8%"><div align="center"><span class="msgok1">Tipo de Doc.</span></div></td>--->
      <td width="29%"><div align="center"><span class="msgok1">Remitente</span></div></td>
    <td width="28%"><div align="center"><span class="msgok1"> Documento</span></div></td>
<!----<td width="31%"><div align="center"><span class="msgok1">Referencia</span></div></td>--->
      <td width="14%"><div align="center">Registrado</div></td>
    <td width="5%" align="center">Estado</td>
    <td width="14%"><div align="center" class="msgok1">Ubicacion  </div></td>
  </tr>
    <? while($row_reg=$query_reg->ConsultaVerRegistro()){
	$id=$row_reg[0];
    $estado = $row_reg["id_estado"];
    ?>
	   <tr <?echo ($estado==12)?"class='Estilo2 fila_finalizada'":"class='Estilo2'";?>>
	   		<td onmouseover="toolTips('<?php echo $row_reg['asunto_documento']?>',this)">
				<div align="center">
                <?php
                $cod = $row_reg[1];
                if($estado != 12){ ?>
                    <a href="Ventanillas_acceso_registro.php?opcion=edit&id=<?=$id?>">
                    <?=$cod?></a>
                <?}
                    else{
                        echo $cod;
                    }
                ?>
	</div></td>
      <!---<td ><=$row_reg[nombre_tipo_documento]?></td>--->
      <td ><input size="48"  value="<?=$row_reg[nombre_remitente]?>"/></td>
      <td ><input size="43" value="<?=$row_reg[3]?>"/></td>
      <!---<td ><?=$row_reg[4]?></td>--->
      <td > <?php echo date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?></td>
      <td align="center" ><?=$row_reg['abrev_nombre_estado']?></td>
      <?php 
	  	$sql_ultimo="SELECT Max(`hd`.`id_historial_documento`) AS `ultimo`
		FROM
		`historial_documentos` AS `hd`
		where hd.id_documento='".$row_reg['id_documento']."'
		GROUP BY
		`hd`.`id_documento`";
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
				`ha`.`id_documento`	";
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
	<?  if ($row_reg['id_estado']<4){ echo $data[2];
	}
	 else {  echo $u['abve_nombre_area'].' '.$u['login_usuario'];}?></td>
    </tr><? }?>
</table>


<? }



function RegistraAgregar(){ ?>

<link href="style.css" type="text/css" rel="stylesheet">
<link href="style.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="../libs/calendar/calendar-green.css" title="win2k-cold-1" /> 

<!---<span class="Estilo12 Estilo8 Estilo8 Estilo12">---->

<script language="javascript" src="js/js.js"> </script>
<script language="javascript" src="../js/js.js"> </script>	

<form id="form_registrar_documento" name="form_registrar_documento" method="post" action="<?php echo	$_SERVER['PHP_SELF']?>?opcion=guardar">



  <table width="90%" border="0" align="center" class="formularios">

    <tr class="Estilo2">
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22">&nbsp;</td>
      <td >&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
    </tr>
    <tr class="Estilo2">
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22">&nbsp;</td>
      <td >&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
    </tr>
    <tr class="Estilo2">
      <td width="22" class="Estilo22"><div align="left" class="Estilo21" >(*) </div></td>
      <td width="190" class="Estilo22"><div align="left">Remitente</div></td>
      <td width="8" class="Estilo22"><div align="center">:</div></td>
      <td width="337" ><span class="Estilo2">
      <?
		$sql_remit="select * FROM remitentes ORDER BY remitentes.nombre_remitente ASC";
    	$query_remit=new Consulta($sql_remit);		
		//$row_remit=$query_remit->ConsultaVerRegistro(); 
?>
      <select name="remit" id="registrar_doc_remitente" class="doc_remitente">
        <option value="">--- Seleccione Remitente ---</option>
        <? while($row_remit=$query_remit->ConsultaVerRegistro()){?>
        <option value="<? echo $row_remit[0]?>"<? if(isset($_POST['remit']) && $_POST['remit']==$row_remit[0]){ echo "selected";} ?>><? echo $row_remit[2]?></option>
        <?  } ?>
      </select>
      <a  href="<?=$_SESSION['PHP_SELF']?>?opcion=newremi" class="Estilo2">Agregar</a>

      </span></td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
    </tr>
   		<tr>
   		  <td class="Estilo22"><span class="Estilo21">(*)</span></td>
   		  <td class="Estilo22"><div align="left"><span class="Estilo22"> Tipo de Documento</span></div></td>
   		  <td class="Estilo22"><div align="center">:</div></td>
   		  <td bgcolor="#FFFFFF"><span class="Estilo2">
   		    <?
      $sql_tipo="SELECT * FROM tipos_documento ORDER BY tipos_documento.nombre_tipo_documento ASC";
    	$query_tipo=new Consulta($sql_tipo);	
		?>
   		    <select name="tipo" class="tipo_doc">
              <option value="">---Tipo de Documento---</option>
              <?
        while($row_tipo=$query_tipo->ConsultaVerRegistro()){?>
              <option value="<?=$row_tipo[0]?>"<? if(isset($_POST['tipo']) && $_POST['tipo']== $row_tipo[0]){ echo "selected";} ?>>
                <?=$row_tipo[1]?>
              </option>
              <?  } ?>
            </select>
   		  </span></td>
   		  <td class="Estilo2">&nbsp;</td>
   		  <td class="Estilo2"><div align="left" class="Estilo22"> Folios</div></td>
   		  <td class="Estilo2"><input name="num_folio" type="text" size="12" /></td>
   		  <td width="83" class="Estilo2">&nbsp;</td>
    </tr>
   		<tr>
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22"><div align="left" class="Estilo22">Documento</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo2">
        <input name="num_doc" type="text" id="num_doc" value="" size="48" />
      </span></td>
      <td width="20" class="Estilo2"><div align="left" class="Estilo21">(*)</div></td>
      <td width="70" class="Estilo22"> Fecha </td>
      <td width="98" class="Estilo2"><input name="date_registrar" type="text" id="date_registrar" class="inputbox" size="12" value="" readonly="readonly"/></td>
      <td class="Estilo2"><input name="image2" type="image" id="trigger_registrar" src="public_root/imgs/calendar.png" width="20" height="20" hspace="1"  border="0" />        
	  <script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "date_registrar",
      ifFormat    : "%d/%m/%Y",
	  weekNumbers: false,
      button      : "trigger_registrar"
    }
  );
	    </script></td>
    </tr> 
    <tr>
      <td class="Estilo2">&nbsp;</td>
      <td class="Estilo2"><div align="left" class="Estilo22">Referencia</div></td>
      <td class="Estilo2"><div align="center">:</div></td>
      <td colspan="6"><input name="refe" value="" type="text" size="103" /></td>
    </tr>
    <tr>
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22"><div align="left" class="Estilo22">Anexos</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="6"><span class="Estilo2">
        <input name="anexo" value="" type="text" size="103" />
      </span></td>
    </tr>
    <tr>
      <td class="Estilo2">&nbsp;</td>
      <td class="Estilo2"><div align="left" class="Estilo22">Observacion</div></td>
      <td class="Estilo2"><div align="center">:</div></td>
      <td colspan="6"><textarea name="observ" cols="100" rows="4" value="" ></textarea></td>
    </tr>
    <tr>
      <td  height="60" colspan="8" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="boton" name="Guardar2" type="submit" value="Guardar" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!----<input name="Limpiar" type="reset" value="Limpiar"/>--->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="Limpiar" type="reset" value="Limpiar" class="boton"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ficha_registro.php" ><!---<input name="imprimir"  type="button" onClick="Ventanillas/ficha_registro.php&id=<=$id?>" value="Imprimir" /></a>
      <a href="<=$_SESSION['PHP_SELF']?>?opcion=guardar" onClick="submit()" class="Estilo34">Guardar</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onClick="reset()" class="Estilo34">Limpiar</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Imprimir</a>--->      </td></tr>
  </table>
</form>
  <? }

function RegistraEditar($id){
//echo 'Pagina en Desarrollo';

$Query= new Consulta($sql = " SELECT * FROM `documentos` AS `d` WHERE d.id_documento='".$id."'");
			$Row= $Query->VerRegistro();
			$remit=$Row['id_remitente'];
			$tipo=$Row['id_tipo_documento'];

?>

<link href="style.css" type="text/css" rel="stylesheet">

<link href="style.css" type="text/css" rel="stylesheet">
<!---<span class="Estilo2">--->
<script language="javascript" src="js/js.js"> </script>

<script language="javascript" src="../js/js.js"> </script>	

<form id="form_editar_documento" name="form_editar_documento" method="post" action="<?php echo	$_SERVER['PHP_SELF']?>?opcion=update&id=<?=$id?>">
  <table border="0" align="center" class="formularios" width="90%">
    <tr class="Estilo2">
      <td colspan="3" class="Estilo22">&nbsp;</td>
      <td >&nbsp;</td>
      <td colspan="2" class="Estilo22">&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
    </tr>
    <tr class="Estilo2">
      <td colspan="3" class="Estilo22">&nbsp;</td>
      <td >&nbsp;</td>
      <td colspan="2" class="Estilo22">&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
    </tr>
    <tr class="Estilo2">
      <td width="18" class="Estilo21">(*)</td>
      <td width="196" class="Estilo22"><div align="left" class="Estilo22" > Remitente</div></td>
      <td width="9" class="Estilo22"><div align="center"></div></td>
      <td width="315" ><span class="Estilo2">
        <div align="left">
          <?
		$sql_remit="select * FROM remitentes ORDER BY remitentes.nombre_remitente ASC";
    	$query_remit=new Consulta($sql_remit);		
		///$row_remit=$query_remit->ConsultaVerRegistro();
	?> 
          <!-----<input name="nom_remi" type="text" id="nom_remi" value="<?=$row_remit['nombre_remitente']?>" size="48" />----->
          <select name="remit1" id="modificar_doc_remitente" class="doc_remitente" style="width:200px;">
            <option value="">--- Seleccione Remitente ---</option>
            <? while($row_remit=$query_remit->ConsultaVerRegistro()){?>
            <option value="<?php echo $row_remit[0]?>"<? if($row_remit[0]==$remit){ echo "selected";} ?>><?php echo $row_remit[2]?>		</option>
            <? } ?>
          </select>
          
      <a  href="<?=$_SESSION['PHP_SELF']?>?opcion=newremi" class="Estilo2">&nbsp;Agregar</a></div></td>
      <td colspan="2" class="Estilo22">&nbsp;</td>
      <td colspan="2" class="Estilo2">&nbsp;</td>
<?     $sql_1="SELECT * FROM documentos AS td WHERE td.id_documento =  '".$id."'"; 
		$query_1=new Consulta($sql_1);
		$row_1=$query_1->ConsultaVerRegistro();
		//$Fech=$row_1['fecha_documento'];
?>
    </tr>
   		<tr>
   		  <td class="Estilo21">(*)</td>
   		  <td class="Estilo22"><div align="left"> Tipo de Documento </div></td>
   		  <td class="Estilo22"><div align="center">:</div></td>
   		  <td bgcolor="#FFFFFF"><span class="Estilo2">
   		    <?
      $sql_tipo="SELECT * FROM tipos_documento ORDER BY tipos_documento.nombre_tipo_documento ASC";
    	$query_tipo=new Consulta($sql_tipo);	
		?>
   		    <select name="tipo" class="tipo_doc" style="width:200px;">
              <option value="">---Tipo de Documento---</option>
              <? while($row_tipo=$query_tipo->ConsultaVerRegistro()){?>
              <option value="<?php echo $row_tipo[0]?>"<? if($row_tipo[0]==$tipo){ echo "selected";} ?>><?php echo $row_tipo[1]?> </option>
              <?  } ?>
            </select>
   		  </span></td>
   		  <td bgcolor="#FFFFFF">&nbsp;</td>
   		  <td bgcolor="#FFFFFF"><div align="left" class="Estilo22">Folios:</div></td>
   		  <td colspan="2" bgcolor="#FFFFFF"><span class="Estilo2">
   		    <input name="num_folio" type="text" value="<?=$row_1[6]?>" size="10" />
   		  </span></td>
    </tr>
   		
   		<tr>
   		  <td width="18" class="Estilo22">&nbsp;</td>
      <td width="196" class="Estilo22"><div align="left" class="Estilo2">Documento</div></td>
      <td width="9" class="Estilo22"><div align="center">:</div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo2">
        <input name="num_doc2" type="text" id="num_doc2" value="<?=$row_1[3]?>" size="48" />
      </span></td>
      <td width="21" bgcolor="#FFFFFF"><div align="left" class="Estilo21">(*)</div></td>
      <td width="58" bgcolor="#FFFFFF"><span class="Estilo22"> Fecha:</span></td>
      <td width="97" bgcolor="#FFFFFF"><input name="date" type="text" id="date" class="inputbox" size="12" value="<? echo formato_slash('-',$row_1['fecha_documento']); ?>" readonly="readonly"/></td>
      <td width="114" bgcolor="#FFFFFF"><input name="image" type="image" id="trigger" src="public_root/imgs/calendar.png" width="20" height="20" hspace="1"  border="0" />
        <script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "date",
      ifFormat    : "%d/%m/%Y",
	  weekNumbers: false,
      button      : "trigger"
    }
  );
        </script>
	
	
        <!--     	<input name="FechaSol2" id="FechaSol2" type="text" value="" readonly="true" size="12" style="background-color:#EEEEEE"/>-->

        <!--       	<input name="button" type="button" id="lanzador" value="..." />--></td>
      <!---<td width="244" bgcolor="#FFFFFF"><input name="destino" type="text" value="<=$row_1['destino_documento']?>" size="40" /></td>--->
    </tr> 
    <tr>
      <td width="18" class="Estilo22">&nbsp;</td>
      <td width="196" class="Estilo22"><div align="left" class="Estilo2">Referencia</div></td>
      <td width="9" class="Estilo22"><div align="center">:</div></td>
      <td colspan="6"><input name="refe" value="<?=$row_1[4]?>" type="text" size="103" /></td>
    </tr>
    <tr>
      <td width="18" class="Estilo22">&nbsp;</td>
      <td width="196" class="Estilo22"><div align="left" class="Estilo2">Anexos</div></td>
      <td width="9" class="Estilo2"><div align="center">:</div></td>
      <td colspan="6"><span class="Estilo23">
        <input name="anexo" value="<?=$row_1[5]?>" type="text" size="103" />
      </span></td>
    </tr>
    <tr>
      <td class="Estilo22">&nbsp;</td>
      <td class="Estilo22"><div align="left" class="Estilo2">Observacion</div></td>
      <td class="Estilo22"><div align="center">:</div></td>
      <td colspan="6"><textarea name="observ1" cols="100" rows="4" ><?=$row_1[observacion_documento]?></textarea></td>
    </tr>
    <tr>
      <td  height="60" colspan="8" align="center"><input name="Guardar" type="submit" value="Actualizar" class="boton"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!----<input name="Limpiar" type="reset" value="Limpiar"/>--->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="boton" name="imprimir"  type="button" onClick="javascript:window.open('Ventanillas/ficha_registro.php?id=<?php echo $id?>','popup','width=500' , 'height=250')" value="Imprimir" />      </td>
    </tr>
  </table>
</form>

  <? }


function RegistraAgrega(){

	echo 'Pagina en Desarrollo';
 }


function RegistraGuardar(){

	$num_folio=$_POST["num_folio"];
	$remit=$_POST["remit"]; 
	$tipo=$_POST["tipo"]; 
	$num_doc=$_POST["num_doc"]; 
	$FechaSol=$_POST["date_registrar"]; 
	$refe=$_POST["refe"]; 
	$anexo=$_POST["anexo"]; 
	$destino=$_POST["destino"]; 
	$observ=$_POST["observ"]; 

	$query="SELECT `ttd`.`abreviatura_tipo_documento` as codigo1 
			FROM `tipos_documento` AS `ttd` 
			WHERE `ttd`.`id_tipo_documento` =  '".$tipo."'";
			
	$query_codigo=new Consulta($query);		
	$row_codigo=$query_codigo->ConsultaVerRegistro();
	$codigo1=$row_codigo['codigo1'];

	$sql_cod1 = "SELECT `tr`.`abreviatura_remitente` as codigo2 
				 FROM remitentes AS `tr` 
				 WHERE `tr`.`id_remitente` =  '".$remit."'";
				 
	$query_codigo1=new Consulta($sql_cod1);		
	$row_codigo1=$query_codigo1->ConsultaVerRegistro();
	$codigo2=$row_codigo1['codigo2'];
	
	$sql_cod2 = "SELECT Max(`td`.`id_documento`) AS `codigo3` 
				FROM `documentos` AS `td`";
				
	$query_codigo2=new Consulta($sql_cod2);		
	$row_codigo2=$query_codigo2->ConsultaVerRegistro();
	$codigo21=$row_codigo2['codigo3'];
	$codigo3=$codigo21+1;
	
	$codigo='0'.$codigo3.'-2009';
	
	/*if ($codigo3<9){$codigo='S-0000'.$codigo3.'-'.'2009';
		if ($codigo3>9&&$codigo3<=99){$codigo='S-000'.$codigo3.'-'.'2009';
			if ($codigo3>99&&$codigo3<=999){$codigo='S-00'.$codigo3.'-'.'2009';
				if ($codigo3>999&&$codigo3<=9999){$codigo='S-0'.$codigo3.'-'.'2009';
					}
			}
		}
	}*/
	//echo $codigo;
	//$codigo=$row_codigo["codigo"];
	//Con esto se indica de que esta registrado
	
	$var_estado=1;
	$guarda="INSERT INTO documentos VALUES ('',
	'".$codigo."',
	'".$tipo."',
	'".$num_doc."',
	'".$refe."',
	'".$anexo."',
	'".$num_folio."',
	'".formato_date('/',$FechaSol)."',
	'',
	'".date("Y-m-d H:i:s")."',
	'".$observ."',
	'',
	'',
	'".$remit."',
	'".$var_estado."')";
	$q_guarda=new Consulta($guarda);		
	///$row_guarda=$q_guarda->ConsultaVerRegistro();
	//echo $q_guarda;
//	header("location: Ventanillas/ficha_registro.php?id=$codigo3");	
?>

<script type="text/javascript"> 
<!--javascript:window.open('Ventanillas/ficha_registro.php?id=<?php echo $codigo3?>','popup','width=600,height=500');-->
	javascript:imprimir("Ventanillas/ficha_registro.php?id=<?php echo $codigo3?>");
<!---javascript:window.print('Ventanillas/ficha_registro.php?id=<php echo $codigo21?>','popup','width=600,height=500');--->
</script>
<?
  }

 function RegistraUpdate($id){
 
    $num_folio=$_POST["num_folio"];
	$remit1=$_POST["remit1"]; 
	$tipo=$_POST["tipo"]; 
	$num_doc2=$_POST["num_doc2"]; 
	$FechaSol2=$_POST["date"];
	$refe=$_POST["refe"]; 
	$anexo=$_POST["anexo"]; 
	$destino=$_POST["destino"]; 
	$observ1=$_POST["observ1"]; 
 	$var_estado=1;
	
	$actualiza="UPDATE documentos SET 
				documentos.id_tipo_documento='".$tipo."', 
				documentos.`numero_documento`='".$num_doc2."',
				documentos.`referencia_documento`='".$refe."',
				documentos.`anexo_documento`='".$anexo."',
				documentos.`numero_folio_documento`='".$num_folio."',
				documentos.`fecha_documento`='".formato_date('/',$FechaSol2)."',
				documentos.`observacion_documento`='".$observ1."',
				documentos.`id_remitente`='".$remit1."' 
				Where documentos.id_documento='".$id."'";
				
	$actua=new Consulta($actualiza);	
	
}

function RegistraEliminar($id){
}

function RegistraGuardarRemitente(){

	$nom_remi=$_POST[nom_remi];
	$abrev=$_POST[abrev];
	$tipo_remi=$_POST[tipo_remi];
	
	$sql_re="Insert Into remitentes Values('','".$tipo_remi."','".$nom_remi."','".$abrev."','')";
	
	$q_remite=new Consulta($sql_re);		

}

function RegistraEditRemitente($id){

	$sql_editremi = "SELECT 
					remitentes.`id_remitente`, 
					remitentes.`nombre_remitente`, 
					remitentes.`abreviatura_remitente`, 
					remitentes.`id_tipo_remitente` 
					FROM 
					remitentes 
					WHERE remitentes.id_remitente='".$id."'";

	$editremi = new Consulta($sql_editremi);
	$e = $editremi->ConsultaVerRegistro();
	$tipo_remi=$rowe['id_tipo_remitente'];
	
?>

<form id="f42" name="f42" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=Updateremi&id=<?=$id?>">

  <table width="445" border="0" align="center">
    <tr>
      <td colspan="3" class="Estilo22">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" class="Estilo22">&nbsp;</td>
    </tr>
    <tr>
      <td width="180" class="Estilo22"><div align="left">Codigo</div></td>
      <td width="17" class="Estilo22"><div align="left">:</div></td>
      <td width="234"><input name="codigo" value="<?=$rowe[0]?>" type="text"/></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left">Nombre de Remitente</div></td>
      <td class="Estilo22"><div align="left">:</div></td>
      <td><input name="nom_remi2" value="<?=$rowe[1]?>" type="text"/></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left">Abreviatura</div></td>
      <td class="Estilo22"><div align="left">:</div></td>
      <td><input name="abrev2" value="<?=$rowe[2]?>" type="text"/></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left">Tipo de Remitente</div></td>
      <td class="Estilo22"><div align="left">:</div></td>
      <?php 
	  $remitente="SELECT tr.id_tipo_remitente, tr.tipo_remitente_nombre FROM tipo_remitente AS tr "; 
	  $Newremi=new Consulta($remitente);
	  ?>
      <td> <select name="tipo_remi2">
     <option value="">---Tipo de Remitente---</option>

	  <?
        while($row_tremi=$Newremi->ConsultaVerRegistro()){?>
		    <option value="<?=$row_tremi[id_tipo_remitente]?>"<? if($row_tremi[id_tipo_remitente]==$tipo_remi){ echo "selected";} ?>><?=$row_tremi[tipo_remitente_nombre]?>
        </option> <?  } ?>	
        </select>      </td> 
    </tr>
    <tr>
      <td class="Estilo2">&nbsp;</td>
      <td class="Estilo2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><div align="center">
        <input name="Actualizar2" type="submit" value="Actualizar" class="boton"/>
      </div></td>
    </tr>
  </table>
</form>

<?
}

function RegistraUpdateRemitente($id){

	$nom_remi2=$_POST[nom_remi2];
	$abrev2=$_POST[abrev2];
	$tipo_remi2=$_POST[tipo_remi2];
	$act_remi=" UPDATE remitentes set 
				remitentes.`nombre_remitente`='".$nom_remi2."',
				remitentes.`id_tipo_remitente`='".$tipo_remi2."',
				remitentes.`abreviatura_remitente`='".$abrev2."'
				where remitentes.`id_remitente`='".$id."'
				";

	$Uremi=new Consulta($act_remi);

}

function RegistraNewRemitente(){?>

<form id="f41" name="f41" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=guardremi">
  <table width="449" border="0" align="center">
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td width="192" class="Estilo22"><div align="left">Nombre de Remitente</div></td>
      <td width="26" class="Estilo22"><div align="left">:</div></td>
      <td width="217"><input name="nom_remi" type="text"/></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left">Abreviatura</div></td>
      <td class="Estilo22"><div align="left">:</div></td>
      <td><input name="abrev" type="text"/></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left">Tipo de Remitente</div></td>
      <td class="Estilo22"><div align="left">:</div></td>
      <?php 
		  $remitente = "SELECT
						tr.id_tipo_remitente,
						tr.tipo_remitente_nombre
						FROM
						tipo_remitente AS tr ";

		  $Newremi=new Consulta($remitente);
	  ?>
      <td> <select name="tipo_remi">
     <option value="">---Tipo de Remitente---</option>
	  <?
        while($row_tremi=$Newremi->ConsultaVerRegistro()){?>
	    <option value="<?=$row_tremi[id_tipo_remitente]?>"<? if($row_tremi[id_tipo_remitente]==$tipo_remi){ echo "selected";} ?>><?=$row_tremi[tipo_remitente_nombre]?>
        </option> <?  } ?>	
        </select>      </td> 
    </tr>
    <tr>
      <td class="Estilo2">&nbsp;</td>
      <td class="Estilo2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><div align="center">
        <input name="Guardar3" type="submit" value="Guardar" class="boton" />
      </div></td>
    </tr>
  </table>
</form>

<?
}

function RegistraListRemitente(){

	$sql_r="Select * 
			FROM remitentes AS r 
			Inner Join tipo_remitente AS tr 
			ON tr.id_tipo_remitente = r.id_tipo_remitente  
			ORDER BY r.`id_remitente` DESC";

    	$query_r=new Consulta($sql_r);		
		//$row_remit=$query_remit->ConsultaVerRegistro(); ?>

	<div align="center"><a href="<?=$_SESSION['PHP_SELF']?>?opcion=newremi"class="Estilo2" >Nuevo Remitente</a></div>					

	<form id="f4" name="f4" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=newremi">
	 <table width="100%" height="101" border="1" align="center">
	    <tr bgcolor="#6699CC" class="Estilo2">
		  <td width="57" height="34" class="Estilo2"><div align="center">Codigo</div></td>
	      <td width="247" class="Estilo2"><div align="center">Remitente</div></td>
	      <td width="162" class="Estilo2"><div align="center">Abreviatura</div></td>
	      <td width="316" class="Estilo2"><div align="center">Tipo Remitente </div></td>
		</tr>
	    <tr>
			 <?  while($row_r=$query_r->ConsultaVerRegistro()){
				 $id=$row_r[0];
			 ?>
			 <td >
		  		<div align="center" class="Estilo2">
					<a href="<?=$_SESSION['PHP_SELF']?>?opcion=editremi&id=<?=$id?>"><?=$id?></a>
				</div>
			</td>
	    	<td class="Estilo2"><?=$row_r['nombre_remitente']?></td>
	      	<td class="Estilo2"><?=$row_r['abreviatura_remitente']?></div></td>
		    <td class="Estilo2"><?=$row_r['tipo_remitente_nombre']?></div></td>
      </tr><? }?>
	  <tr>
	      <td colspan="5">
	      <!----<div align="center"><p></p>
	        <input type="submit" name="Submit" value="Nuevo Remitente" />
	      </div>
	      <div align="center"></div></td>--->
    </tr>
  </table>
</form>

<? 
}

function RegistraFiltrar(){

	$sql_estado =  "SELECT * 
					FROM `estados` AS `e` 
					ORDER BY 
					`e`.`nombre_estado` ASC";

	$q_estado=new Consulta($sql_estado);		
	?>

	<form name="f5" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=list&ide=<?=$ide?>">
		<table width="100" height="50" border="0" >
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
		      <?  } ?>	
				    </select>
				</td>
    </tr>
 <tr>
  <td align="center" ><input name="Filtrar" type="submit"  value="Filtrar" class="boton" /></td>
  </tr>
</table>
</form>

<?
}
}

?>