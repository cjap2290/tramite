<?php 



class Escaneos {



function EscaneaListRemitente(){ 



$sql_r = "Select * FROM remitentes AS r Inner Join tipo_remitente AS tr ON tr.id_tipo_remitente = r.id_tipo_remitente  ORDER BY r.`id_remitente` DESC";

$query_r=new Consulta($sql_r);		 ?>



<div align="center"><a href="<?php echo $_SESSION['PHP_SELF']?>?opcion=newremi"class="Estilo2" >Nuevo Remitente</a></div>

<form id="f4" name="f4" method="post" action="<?php echo $_SESSION['PHP_SELF']?>?opcion=newremi">

 <table width="100%" height="117" border="1" align="center" cellpadding="1" cellspacing="1">

		<tr bgcolor="#6699CC" class="Estilo2">

		  <td width="50" class="Estilo2"><div align="center">Codigo</div></td>

		  <td width="240" class="Estilo2"><div align="center">Remitente</div></td>

		  <td width="160" class="Estilo2"><div align="center">Abreviatura</div></td>

		  <td width="310" class="Estilo2"><div align="center">Tipo Remitente </div></td>

		</tr>    

 <?php while($row_r=$query_r->ConsultaVerRegistro()){

 		  $id=$row_r[0];?>

		  <tr>

		  <td><div align="center" class="Estilo2"><a href="<?php echo $_SESSION['PHP_SELF']?>?opcion=editremi&id=<?php echo $id?>"><?php echo $id?></a></div></td>

		  <td class="Estilo2"><?php echo $row_r['nombre_remitente']?></td>

		  <td class="Estilo2"><?php echo $row_r['abreviatura_remitente']?></div></td>

		  <td class="Estilo2"><?php echo $row_r['tipo_remitente_nombre']?></div></td>

		  </tr><?php 

	   } ?>

  </table>

</form>

<?php

}

function EscaneaEditar($id){

$doc = new Documento($id);

$escaneos = $doc->getEscaneos();  ?>



<form id="fe" name="fe" method="post" action="<?php echo	$_SERVER['PHP_SELF']?>?opcion=add&id=<?php echo $id?>" enctype="multipart/form-data">

  <br />
<div style="float:left; width:30%;">
<fieldset style="width:100%; margin:0px 0px 15px 10px; padding:8px;">
	<legend>DATOS DOCUMENTO</legend>
	<p><label class="primera_columna Estilo22" >N&ordm; Registro:</label>
	    <?php echo $doc->getCodigo()?>
    </p>
	<p>  <label class="primera_columna Estilo22">Remitente:</label>
	    <?php $remitente = $doc->getRemitente();?>
	    <? echo $remitente->getNombre();?>
    </p>
	<p><label class="primera_columna Estilo22">N&ordm; Documento:</label>
	    <?php echo $doc->getNumero()?>
    </p>
	<p>	    <label class="primera_columna Estilo22">Folios:</label>
	    <?php echo $doc->getNumeroFolio()?>
    </p>
	<p><label class="primera_columna Estilo22">Fecha:</label>
	    <?php echo cambiar_caracter('-','/',$doc->getFecha())?>
    </p>
	
</fieldset>
</div>
   <fieldset id="marco_file">

   		<legend>SUBIR ARCHIVOS ESCANEADOS</legend>

		<div class="ileft_img" style="margin-top:0.5em;">	

			<div id='cp_item_0' ><label for="imagen" class="Estilo22">Documento : </label><input id="doc[]" type="file" name="doc[]" size="40" /></div>			

		</div>		

		<div class="iright_img"> <span onclick="crearCarchivo()"> [ + Agregar ] </span> </div>

		<div class="iright_img"> <span onclick="quitarCarchivo()">  [ - Quitar ] </span> </div>

		<div class="both"></div>

		<p onclick="javascript: return valida_archivos()"> SUBIR ARCHIVO(S)</p>					

  </fieldset>

  <fieldset >

   		<legend>LISTA DE DOCUMENTOS ESCANEADOS</legend>

		

		<ul > <?php 			

			for($d = 0; $d < count($escaneos); $d++ ){ ?>

				<li class="escaneo<?php echo  $escaneos[$d]['id'];?>"><input type="checkbox" name="qdocumento" id="qdocumento" value="<?php echo  $escaneos[$d]['id'];?>" /> <?php echo  $escaneos[$d]['nombre'];?> </li> <?php				

			} ?>

		</ul>

   </fieldset>

   <div id="images" style="margin-left:40px">

		<div class="bottom"><img src="public_root/imgs/arrow_ltr.png" border="0" height="13"/> Para eliminar un archivo activa su(s) respectiva(s) casilla de verificacion y haz cilck en [ <span onclick="javascript: delete_escaneo()" >ELIMINAR <img src="public_root/imgs/b_deltbl.png" width="16" height="16" /> </span>  ].		</div>

   </div> 

</form>  <?php 

}

function EscaneaGuardar(){ 		 

	$keys = array_keys($_FILES['doc']);

	$destino = "Escaneo/";

	echo  "<div id='error'>";

	for($u=0; $u < count($keys); $u++){

		if(!empty($_FILES['doc']['name'][$u])){

			//$upload->uploadFile($nombre, $temp, $destino, $tarchivo, $tamano );

			if(!move_uploaded_file($_FILES['doc']['tmp_name'][$u], $destino.$_FILES['doc']['name'][$u])){

				echo "ocurrio error al subir archivo " . $_FILES['doc']['name'][$u] ;			 				

			}else{

				$sql = " INSERT INTO documentos_escaneados VALUES( '', '".$_GET['id']."','".$_FILES['doc']['name'][$u]."') ";

				$query = new Consulta($sql);

				echo "se subio el archivo <b>" . $_FILES['doc']['name'][$u] . "</b> satisfactoriamente <br>" ;	

			}	

			

		}

	}

	echo "</div>"; 	

}

 function EscaneaUpdate($id){



	$num_folio	= $_POST["num_folio"];

	$remit1		= $_POST["remit1"]; 

	$tipo		= $_POST["tipo"]; 

	$num_doc2	= $_POST["num_doc2"]; 

	$FechaSol2	= $_POST["FechaSol2"]; 

	$refe		= $_POST["refe"]; 

	$anexo		= $_POST["anexo"]; 

	$destino	= $_POST["destino"]; 

	$observ1	= $_POST["observ1"]; 

 	$var_estado = 1;

	$actualiza  = "UPDATE documentos SET

					documentos.id_tipo_documento='".$tipo."',

					documentos.`numero_documento`='".$num_doc2."',

					documentos.`referencia_documento`='".$refe."',

					documentos.`anexo_documento`='".$anexo."',

					documentos.`numero_folio_documento`='".$num_folio."',

					documentos.`fecha_documento`='".$FechaSol2."',

					documentos.`observacion_documento`='".$observ1."',

					documentos.`id_remitente`='".$remit1."'

				Where documentos.id_documento='".$id."'";



	$actua = new Consulta($actualiza);	

}

function EscaneaListado($ide){	  



$where = $ide=='' ? "" : " WHERE estados.id_estado='".$ide."' "  ;

$sql = "SELECT * FROM documentos

			Inner Join remitentes ON remitentes.id_remitente = documentos.id_remitente

			Inner Join estados ON estados.id_estado = documentos.id_estado

			Inner Join tipos_documento ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento 	

			".$where."	

		ORDER BY documentos.id_documento DESC";

$query = new Consulta($sql); ?>

<table width="100%" border="4"  bordercolor="#6699CC" align="center" class="formularios">

    <tr bgcolor="#6699CC" class="Estilo2">

      <td width="9%"><div align="center"><span class="msgok1">Reg. N&ordm; </span></div></td>    

      <td width="30%"><div align="center"><span class="msgok1">Remitente</span></div></td>

      <td width="30%"><div align="center"><span class="msgok1"> Documento</span></div></td>     

      <td width="12%"><div align="center"><span class="msgok1">Fecha</span></div></td>

      <td width="4%" align="center">Estado</td>

      <td width="10%"><div align="center" class="msgok1">Ubicacion  </div></td>

  </tr>

    <?php while($row_reg=$query->ConsultaVerRegistro()){

	$id = $row_reg[0];
    $estado = $row_reg["id_estado"];
    ?>
    <tr <?echo ($estado==12)?"class='Estilo2 fila_finalizada'":"class='Estilo2'";?>>
    <td onmouseover="toolTips('<?php echo $row_reg['asunto_documento']?>',this)"  ><div align="center">
    <?php
           $cod = $row_reg[1];
           if($estado != 12){?>
            <a href="Ventanillas_acceso_registro.php?opcion=edit&id=<?=$id?>">
                <?=$cod?>
            </a>
            <?}
           else{
              echo $cod;
           }
      ?></div>
      </td>
      <td><input size="50" value="<?php echo $row_reg[nombre_remitente]?>"/></td>

      <td><input size="45" value="<?php echo $row_reg[3]?>"/></td> 

      <td > <?php echo date('d/m/Y H:i',strtotime($row_reg['fecha_registro_documento']))?></td>

      <td align="center" ><?php echo $row_reg['abrev_nombre_estado']?></td> <?php   

	  	$sql_ultimo = " SELECT Max(`hd`.`id_historial_documento`) AS `ultimo`

						FROM `historial_documentos` AS `hd`

						WHERE hd.id_documento='".$row_reg['id_documento']."'

						GROUP BY `hd`.`id_documento`";

		$query_ultimo = new Consulta($sql_ultimo);		

		$ultimo = $query_ultimo->ConsultaVerRegistro();

	  

	  

	  

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

				$u=$qusu->ConsultaVerRegistro(); ?>

      <td >

	<?php  if ($row_reg['id_estado']<4){ echo $data[2];

	

	}

	 else {

	  

	  echo $u['abve_nombre_area'].' '.$u['login_usuario'];}?></td>

    </tr><?php }?>

</table><?php 

}

function EscaneaGuardarRemitente(){

$nom_remi=$_POST[nom_remi];
$abrev=$_POST[abrev];
$tipo_remi=$_POST[tipo_remi];
$sql_re="Insert Into remitentes Values('','".$tipo_remi."','".$nom_remi."','".$abrev."','')";
$q_remite=new Consulta($sql_re);		

}

function EscaneaEditRemitente($id){

$sql_editremi="SELECT
remitentes.`id_remitente`,
remitentes.`nombre_remitente`,
remitentes.`abreviatura_remitente`,
remitentes.`id_tipo_remitente`
FROM
remitentes
WHERE remitentes.id_remitente='".$id."'
";

$editremi=new Consulta($sql_editremi);
$rowe=$editremi->ConsultaVerRegistro();
$tipo_remi=$rowe['id_tipo_remitente'];
?>











<form id="f42" name="f42" method="post" action="<?php echo $_SESSION['PHP_SELF']?>?opcion=Updateremi&id=<?php echo $id?>">



  <table width="800" border="0" align="center">



    <tr>



      <td class="Estilo2"><div align="right">Codigo: </div></td>



      <td><input name="codigo" value="<?php echo $rowe[0]?>" type="text"/></td>



    </tr>



    <tr>



      <td class="Estilo2"><div align="right">Nombre de Remitente: </div></td>



      <td><input name="nom_remi2" value="<?php echo $rowe[1]?>" type="text"/></td>



    </tr>



    <tr>



      <td class="Estilo2"><div align="right">Abreviatura:</div></td>



      <td><input name="abrev2" value="<?php echo $rowe[2]?>" type="text"/></td>



    </tr>



    <tr>



      <td class="Estilo2"><div align="right">Tipo de Remitente: </div></td>



      <?php 

	  $remitente="SELECT tr.id_tipo_remitente, tr.tipo_remitente_nombre FROM tipo_remitente AS tr "; 

	  $Newremi=new Consulta($remitente);

	  ?>

      <td> <select name="tipo_remi2">

     <option value="">---Tipo de Remitente---</option>



				  <?



        while($row_tremi=$Newremi->ConsultaVerRegistro()){?>



	    <option value="<?php echo $row_tremi[id_tipo_remitente]?>"<?php if($row_tremi[id_tipo_remitente]==$tipo_remi){ echo "selected";} ?>><?php echo $row_tremi[tipo_remitente_nombre]?>

        </option> <?php  } ?>	

        </select>



      </td> 

      

      

    



    </tr>



    <tr>



      <td class="Estilo2">&nbsp;</td>



      <td>&nbsp;</td>



    </tr>



    <tr>



      <td colspan="2"><div align="center">



        <input name="Actualizar2" type="submit" value="Actualizar" />



      </div></td>



    </tr>



  </table>



</form>







<?



}

function EscaneaUpdateRemitente($id){

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

function EscaneaNewRemitente(){?>

<form id="f41" name="f41" method="post" action="<?php echo $_SESSION['PHP_SELF']?>?opcion=guardremi">
  <table width="800" border="0" align="center">
    <tr>
      <td width="400">&nbsp;</td>
      <td width="390">&nbsp;</td>
    </tr>
    <tr>
      <td class="Estilo2"><div align="right">Nombre de Remitente: </div></td>
      <td><input name="nom_remi" type="text"/></td>
    </tr>
    <tr>
      <td class="Estilo2"><div align="right">Abreviatura:</div></td>
      <td><input name="abrev" type="text"/></td>
    </tr>
    <tr>
      <td class="Estilo2"><div align="right">Tipo de Remitente: </div></td>
      <?php 

	  $remitente="SELECT

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



	    <option value="<?php echo $row_tremi[id_tipo_remitente]?>"<?php if($row_tremi[id_tipo_remitente]==$tipo_remi){ echo "selected";} ?>><?php echo $row_tremi[tipo_remitente_nombre]?>

        </option> <?php  } ?>	

        </select>



      </td> 

      



    </tr>



    <tr>



      <td class="Estilo2">&nbsp;</td>



      <td>&nbsp;</td>



    </tr>



    <tr>



      <td colspan="2"><div align="center">



        <input name="Guardar3" type="submit" value="Guardar" />



      </div></td>



    </tr>



  </table>



</form>







<?







}

function Busqueda($campo, $valor){	 


	if($campo == "nombre_remitente"){
		$where = $campo == "nombre_remitente" ? " AND remitentes.nombre_remitente like '%$valor%' " : "";
	}else{
		$where = $campo != "" ? " AND d.$campo like '%$valor%' " : ""  ;
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
      <td width="14%"><div align="center"><span class="msgok1">Fecha</span></div></td>
    <td width="5%" align="center">Estado</td>
    <td width="14%"><div align="center" class="msgok1">Ubicacion  </div></td>
  </tr>
    <? while($row_reg=$query_reg->ConsultaVerRegistro()){
	$id=$row_reg[0];
    $estado = $row_reg["id_estado"];
    ?>
    <tr <?echo ($estado==12)?"class='Estilo2 fila_finalizada'":"class='Estilo2'";?>>
    <td onmouseover="toolTips('<?php echo $row_reg['asunto_documento']?>',this)"  ><div align="center">
    <?php
           $cod = $row_reg[1];
           if($estado != 12){?>
            <a href="Ventanillas_acceso_registro.php?opcion=edit&id=<?=$id?>">
                <?=$cod?>
            </a>
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

}







 ?>