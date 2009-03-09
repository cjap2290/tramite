<?php
class Registro {

function RegistraCabecera(){	
$sql_usu="SELECT `u`.`login_usuario`,`u`.`password_usuario`,`uap`.`id_axo_poa`,`u`.`nombre_usuario` as nombre
FROM
`usuarios` AS `u`,
 `usuario_axo_poa` AS `uap` 
WHERE
`u`.`id_usuario` = `uap`.`id_usuario` AND
`u`.`id_usuario` = '1'
";
$query_pa=new Consulta($sql_usu);		
$row_usu=$query_pa->ConsultaVerRegistro(); 
}

function RegistraListado(){	 ?>
<? 
	$sql_reg=" SELECT * FROM
documentos
Inner Join remitentes ON remitentes.id_remitente = documentos.id_remitente
Inner Join estados ON estados.id_estado = documentos.id_estado
Inner Join tipos_documento ON tipos_documento.id_tipo_documento = documentos.id_tipo_documento ORDER BY
documentos.id_documento DESC";
	$query_reg=new Consulta($sql_reg);		
	//$row_reg=$query_reg->ConsultaVerRegistro();
	
	?>
   
      <div align="center"><a href="<?=$_SESSION['PHP_SELF']?>?opcion=add"class=" Estilo2" >Registrar Nuevo</a></div>

<table width="100%" border="4"  bordercolor="#6699CC" align="center">
    <tr bgcolor="#6699CC" class="Estilo2">
   
      <td width="10%"><div align="center"><span class="msgok1">Reg. N&ordm; </span></div></td>
      <!----<td width="8%"><div align="center"><span class="msgok1">Tipo de Doc.</span></div></td>--->
      <td width="29%"><div align="center"><span class="msgok1">Remitente</span></div></td>
      <td width="36%"><div align="center"><span class="msgok1"> Documento</span></div></td>
      <!----<td width="31%"><div align="center"><span class="msgok1">Referencia</span></div></td>--->
      <td width="14%"><div align="center"><span class="msgok1">Fecha de Registro</span></div></td>
      <td width="11%"><div align="center" class="msgok1">Estado  </div></td>
  </tr>
    <? while($row_reg=$query_reg->ConsultaVerRegistro()){
	$id=$row_reg[0]?>
    <tr class="Estilo2">
      <td ><a href="Ventanillas_acceso_registro.php?opcion=edit&id=<?=$id?>"><?=$row_reg[1]?></a></td>
      <!---<td ><=$row_reg[nombre_tipo_documento]?></td>--->
      <td ><?=$row_reg[nombre_remitente]?></td>
      <td ><?=$row_reg[3]?></td>
      <!---<td ><?=$row_reg[4]?></td>--->
      <td ><?=$row_reg[fecha_registro_documento]?></td>
      <td ><?=$row_reg[nombre_estado]?></td> 
    </tr><? }?>
</table>

<? }

function RegistraAgregar(){ ?>
<link href="style.css" type="text/css" rel="stylesheet">
<link href="style.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="../libs/calendar/calendar-green.css" title="win2k-cold-1" /> 
<span class="Estilo12 Estilo8 Estilo8 Estilo12">
<script type="text/javascript" src="../libs/calendar/calendar.js"></script> 
<script type="text/javascript" src="../libs/calendar/calendar-es.js"></script>   
<script type="text/javascript" src="../libs/calendar/calendar-setup.js"></script> 
<script language="javascript" src="js/js.js"> </script>
<script language="javascript" src="../js/js.js"> </script>	

<form id="f3" name="f3" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?opcion=guardar">
  
  <div align="right" class="Estilo2"></div>
  <table width="93%" border="1" align="center" >
    <tr class="Estilo2">
      <td width="57" class="Estilo2"><div align="left" class="Estilo2" >Instituci&oacute;n:</div></td>
      <td width="326" ><span class="Estilo2">
      <?
      
		$sql_remit="select * FROM remitentes ORDER BY remitentes.nombre_remitente ASC";
    	$query_remit=new Consulta($sql_remit);		
		//$row_remit=$query_remit->ConsultaVerRegistro(); 
	
?>
<select name="remit">
				    
				   <option value="">--- Seleccione Remitente ---</option>
				    <?
					while($row_remit=$query_remit->ConsultaVerRegistro()){?>
				    <option value="<? echo $row_remit[0]?>"<? if(isset($_POST['remit']) && $_POST['remit']== $row_remit[0]){ echo "selected";} ?>><? echo $row_remit[1]?></option> <?  } ?>			
        </select>
       
        <a  href="<?=$_SESSION['PHP_SELF']?>?opcion=listremi" class="Estilo2">Agregar</a>
      </span></td>
      <td width="105" class="Estilo2">Tipo de Documento :</td>
      <td width="244" class="Estilo2"><span class="Estilo2">
      
    
<?
      $sql_tipo="SELECT * FROM tipos_documento ORDER BY tipos_documento.nombre_tipo_documento ASC";
    	$query_tipo=new Consulta($sql_tipo);	
		
		?> 
        
<select name="tipo">
				    
				   <option value="">---Tipo de Documento---</option>
				  <?
        while($row_tipo=$query_tipo->ConsultaVerRegistro()){?>
	    <option value="<?=$row_tipo[0]?>"<? if(isset($_POST['remit']) && $_POST['remit']== $row_tipo[0]){ echo "selected";} ?>><?=$row_tipo[1]?>
        </option> <?  } ?>	
        </select>
      </span> </td>
      <td width="43" bgcolor="#FFFFFF"><div align="left" class="Estilo2"> Folios</div>        </td>
      <td ><span class="Estilo2">
        <input name="num_folio" type="text" size="10" />
      </span></td>
    	</tr>
   		<tr>
      <td width="57" class="Estilo2"><div align="left" class="Estilo2">Nro. Doc:</div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo2">
        <input name="num_doc" type="text" id="num_doc" value="" size="48" />
      </span></td>
      <td width="105" class="Estilo2">Destino :</td>
      <td width="244" bgcolor="#FFFFFF"><input name="destino" type="text" value="" size="40" /></td>
      <td width="43" bgcolor="#FFFFFF" class="Estilo2"><div align="left" class="Estilo2">Fecha </div></td>
      <td width="195"> 
      	<input name="FechaSol" id="FechaSol" type="text" value="" readonly="true" size="12" style="background-color:#EEEEEE"/>
       	<input name="button" type="button" id="lanzador" value="..." />
        
    <script type="text/javascript"> 
					   Calendar.setup({ 
						 inputField: "FechaSol",     
						 ifFormat  : "%d/%m/%Y",   
						 button    : "lanzador" 
						});			
					</script>  </td>
    </tr> 
    <tr>
      <td width="57" class="Estilo2"><div align="left" class="Estilo2">Referencia:</div></td>
      <td colspan="6"><input name="refe" value="" type="text" size="100" /></td>
    </tr>
    <tr>
      <td width="57" class="Estilo2"><div align="left" class="Estilo2">Anexos:</div></td>
      <td colspan="6"><span class="Estilo2">
        <input name="anexo" value="" type="text" size="100" />
      </span></td>
    </tr>
    <tr>
      <td class="Estilo2"><div align="left" class="Estilo2">Observacion:</div></td>
      <td colspan="6"><textarea name="observ" cols="140" rows="4" value="" ></textarea></td>
    </tr>
    <tr>
   
      <td  class="Estilo2" height="60" colspan="6" align="center"><input name="Guardar" type="submit" value="Guardar" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="Limpiar" type="reset" value="Limpiar"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="ficha_registro.php" ><!---<input name="imprimir"  type="button" onClick="Ventanillas/ficha_registro.php&id=<=$id?>" value="Imprimir" /></a>
      <a href="<=$_SESSION['PHP_SELF']?>?opcion=guardar" onClick="submit()" class="Estilo34">Guardar</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onClick="reset()" class="Estilo34">Limpiar</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Imprimir</a>--->
      </td>
    </tr>
  </table></form>
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
<link rel="stylesheet" type="text/css" media="all" href="../libs/calendar/calendar-green.css" title="win2k-cold-1" /> 
<span class="Estilo2">
<script type="text/javascript" src="../libs/calendar/calendar.js"></script> 
<script type="text/javascript" src="../libs/calendar/calendar-es.js"></script>   
<script type="text/javascript" src="../libs/calendar/calendar-setup.js"></script> 
<script language="javascript" src="js/js.js"> </script>
<script language="javascript" src="../js/js.js"> </script>	

<form id="f3" name="f3" method="post" action="<?php echo	$_SERVER['PHP_SELF']?>?opcion=update&id=<?=$id?>">
  
  <div align="right" class="Estilo2"></div>
  <table width="93%" border="1" align="center" >
    <tr class="Estilo2">
      <td width="57" class="Estilo2"><div align="left" class="Estilo2" >Instituci&oacute;n:</div></td>
      <td width="324" ><span class="Estilo2">
      <?
      
		$sql_remit="select * FROM remitentes ORDER BY remitentes.nombre_remitente ASC";
    	$query_remit=new Consulta($sql_remit);		
		///$row_remit=$query_remit->ConsultaVerRegistro();
	
?> <!-----<input name="nom_remi" type="text" id="nom_remi" value="<?=$row_remit['nombre_remitente']?>" size="48" />----->
<select name="remit">
				    
				   <option value="">--- Seleccione Remitente ---</option>
				    <?
					while($row_remit=$query_remit->ConsultaVerRegistro()){?>
				    <option value="<? echo $row_remit[0]?>"<? if($row_remit[0]==$remit){ echo "selected";} ?>><? echo $row_remit[1]?></option> <?  } ?>			
        </select>
       
        <a  href="<?=$_SESSION['PHP_SELF']?>?opcion=listremi" class="Estilo2">Agregar</a>
      </span></td>
      <td width="105" class="Estilo2">Tipo de Documento :</td>
      <td width="244" class="Estilo2"><span class="Estilo2">
      
    
<?
      $sql_tipo="SELECT * FROM tipos_documento ORDER BY tipos_documento.nombre_tipo_documento ASC";
    	$query_tipo=new Consulta($sql_tipo);	
		
		?> 
      
<select name="tipo">
				    
				   <option value="">---Tipo de Documento---</option>
				  <?
        while($row_tipo=$query_tipo->ConsultaVerRegistro()){?>
	    <option value="<?=$row_tipo[0]?>"<? if($row_tipo[0]==$tipo){ echo "selected";} ?>><?=$row_tipo[1]?>
        </option> <?  } ?>	
        </select>
      </span> </td>
<?     $sql_1="SELECT * FROM documentos AS td WHERE td.id_documento =  '".$id."'"; 
		$query_1=new Consulta($sql_1);
		$row_1=$query_1->ConsultaVerRegistro();

?>
      <td width="45" bgcolor="#FFFFFF"><div align="left" class="Estilo2"> Folios</div>        </td>
      <td ><span class="Estilo2"><span class="Estilo2">
        <input name="num_folio" type="text" value="<?=$row_1[6]?>" size="10" />
      </span></span></td>
    	</tr>
   		<tr>
      <td width="57" class="Estilo2"><div align="left" class="Estilo2">Nro. Doc:</div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo2">
        <input name="num_doc" type="text" id="num_doc" value="<?=$row_1[3]?>" size="48" />
      </span></td>
      <td width="105" class="Estilo2">Destino :</td>
      <td width="244" bgcolor="#FFFFFF"><input name="destino" type="text" value="<?=$row_1['destino_documento']?>" size="40" /></td>
      <td width="45" bgcolor="#FFFFFF" class="Estilo2"><div align="left" class="Estilo2">Fecha</div></td>
      <td width="195"> 
      	<input name="FechaSol" id="FechaSol" type="text" value="<?=$row_1[7]?>" readonly="true" size="12" style="background-color:#EEEEEE"/>
       	<input name="button" type="button" id="lanzador" value="..." />
        
    <script type="text/javascript"> 
					   Calendar.setup({ 
						 inputField: "FechaSol",     
						 ifFormat  : "%d/%m/%Y",   
						 button    : "lanzador" 
						});			
					</script>  </td>
    </tr> 
    <tr>
      <td width="57" class="Estilo2"><div align="left" class="Estilo2">Referencia:</div></td>
      <td colspan="6"><input name="refe" value="<?=$row_1[4]?>" type="text" size="100" /></td>
    </tr>
    <tr>
      <td width="57" class="Estilo2"><div align="left" class="Estilo2">Anexos:</div></td>
      <td colspan="6"><span class="Estilo23">
        <input name="anexo" value="<?=$row_1[5]?>" type="text" size="100" />
      </span></td>
    </tr>
    <tr>
      <td class="Estilo2"><div align="left" class="Estilo2">Observacion:</div></td>
      <td colspan="6"><textarea name="observ" cols="140" rows="4" ><?=$row_1[observacion_documento]?></textarea></td>
    </tr>
    <tr>
    
      <td  height="60" colspan="6" align="center"><input name="Guardar" type="submit" value="Actualizar" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="Limpiar" type="reset" value="Limpiar"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="imprimir"  type="button" onClick="javascript:window.open('Ventanillas/ficha_registro.php?id=<?php echo $id?>','popup','width=600,height=500')" value="Imprimir" />
      </td>
    </tr>
  </table></form>
  <? }



function RegistraAgrega(){
echo 'Pagina en Desarrollo';

 }
function RegistraGuardar(){?>
<!---<p align="center" class="Estilo25">Este documento ya existe con el siguiente registro <a href="#">XXX </a></p>
  <p align="center" class="Estilo25">
    <input type="button" name="Submit2" value="Limpiar" />
    <input type="button" name="Submit3" value="Salir" />
  </p>---><?PHP 

	//echo "Prueba";
	//echo die();
	
	$num_folio=$_POST["num_folio"];
	$remit=$_POST["remit"]; 
	$tipo=$_POST["tipo"]; 
	$num_doc=$_POST["num_doc"]; 
	$FechaSol=$_POST["FechaSol"]; 
	$refe=$_POST["refe"]; 
	$anexo=$_POST["anexo"]; 
	$destino=$_POST["destino"]; 
	$observ=$_POST["observ"]; 
	
	$query="SELECT `ttd`.`abreviatura_tipo_documento` as codigo1 FROM `tipos_documento` AS `ttd` WHERE `ttd`.`id_tipo_documento` =  '".$tipo."'
";
	$query_codigo=new Consulta($query);		
	$row_codigo=$query_codigo->ConsultaVerRegistro();
	$codigo1=$row_codigo['codigo1'];
	
	//echo $codigo1;
	$sql_cod1="SELECT `tr`.`abreviatura_remitente` as codigo2 FROM remitentes AS `tr` WHERE `tr`.`id_remitente` =  '".$remit."'";
	$query_codigo1=new Consulta($sql_cod1);		
	$row_codigo1=$query_codigo1->ConsultaVerRegistro();
	$codigo2=$row_codigo1['codigo2'];
	//echo $codigo2;
	$sql_cod2="SELECT Max(`td`.`id_documento`) AS `codigo3` FROM `documentos` AS `td`";
	$query_codigo2=new Consulta($sql_cod2);		
	$row_codigo2=$query_codigo2->ConsultaVerRegistro();
	$codigo21=$row_codigo2['codigo3'];
	$codigo3=$codigo21+1;
	//echo $codigo3;
	//$codigo=$codigo1.$codigo2.$codigo3;
	$codigo='0000'.$codigo3.'-2009';
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
	'".date("Y-m-d h:m:s")."',
	'".$observ."',
	'',
	'".$destino."',
	'".$remit."',
	'".$var_estado."')";
	$q_guarda=new Consulta($guarda);		
	///$row_guarda=$q_guarda->ConsultaVerRegistro();
	//echo $q_guarda;
	///header("location: acceso_registro.cls.php");	

?>
<script type="text/javascript"> 
<!---javascript:window.open('Ventanillas/ficha_registro.php?id=<?php echo $codigo21?>','popup','width=600,height=500');--->
javascript:window.print('Ventanillas/ficha_registro.php?id=<?php echo $codigo21?>','popup','width=600,height=500');
</script>
<?

  
  }
 function RegistraUpdate($id){
 	
	$num_folio=$_POST["num_folio"];
	$remit=$_POST["remit"]; 
	$tipo=$_POST["tipo"]; 
	$num_doc=$_POST["num_doc"]; 
	$FechaSol=$_POST["FechaSol"]; 
	$refe=$_POST["refe"]; 
	$anexo=$_POST["anexo"]; 
	$destino=$_POST["destino"]; 
	$observ=$_POST["observ"]; 
 	$var_estado=1;
	$actualiza="UPDATE documentos SET
	documentos.id_tipo_documento='".$tipo."',
	documentos.`numero_documento`='".$num_doc."',
	documentos.`referencia_documento`='".$refe."',
	documentos.`anexo_documento`='".$anexo."',
	documentos.`numero_folio_documento`='".$num_folio."',
	documentos.`fecha_documento`='".formato_date('/',$FechaSol)."',
	
	documentos.`fecha_registro_documento`='".date("Y-m-d h:m:s")."',
	documentos.`observacion_documento`='".$observ."',
	documentos.`destino_documento`='".$destino."',
	documentos.`id_remitente`='".$remit."',
	documentos.`id_estado`='".$var_estado."'
	Where documentos.`id_documento`='".$id."'";
	$actua=new Consulta($actualiza);	
}
function RegistraEliminar($id){
}
function RegistraGuardarRemitente(){

$nom_remi=$_POST[nom_remi];
$abrev=$_POST[abrev];
$tipo_remi=$_POST[tipo_remi];
$sql_re="Insert Into remitentes Values('','".$nom_remi."','".$abrev."','".$tipo_remi."')";


	$q_remite=new Consulta($sql_re);		
}

function RegistraEditRemitente($id){


$sql_editremi="SELECT
remitentes.`id_remitente`,
remitentes.`nombre_remitente`,
remitentes.`abreviatura_remitente`,
remitentes.`tipo_remitente`
FROM
remitentes
WHERE remitentes.id_remitente='".$id."'

";
$editremi=new Consulta($sql_editremi);
$rowe=$editremi->ConsultaVerRegistro();

?>


<form id="f42" name="f42" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=Updateremi&id=<?=$id?>">
  <table width="800" border="0" align="center">
    <tr>
      <td class="Estilo2"><div align="right">Codigo: </div></td>
      <td><input name="codigo" value="<?=$rowe[0]?>" type="text"/></td>
    </tr>
    <tr>
      <td class="Estilo2"><div align="right">Nombre de Remitente: </div></td>
      <td><input name="nom_remi" value="<?=$rowe[1]?>" type="text"/></td>
    </tr>
    <tr>
      <td class="Estilo2"><div align="right">Abreviatura:</div></td>
      <td><input name="abrev" value="<?=$rowe[2]?>" type="text"/></td>
    </tr>
    <tr>
      <td class="Estilo2"><div align="right">Tipo de Remitente: </div></td>
      <td><input name="tipo_remi" value="<?=$rowe[3]?>" stype="text"/></td>
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
function RegistraUpdateRemitente($id){

$nom_remi=$_POST[nom_remi];
$abrev=$_POST[abrev];
$tipo_remi=$_POST[tipo_remi];

$actualiza_remi=" UPDATE remitentes set

remitentes.`nombre_remitente`='".$nom_remi."',
remitentes.`abreviatura_remitente`='".$abrev."',
remitentes.`tipo_remitente`='".$tipo_remi."'
where remitentes.`id_remitente`='".$id."'
";
$Uremi=new Consulta($actualiza_remi);

}
function RegistraNewRemitente(){?>

<form id="f41" name="f41" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=guardremi">
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
      <td><input name="tipo_remi" stype="text"/></td>
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
function RegistraListRemitente(){

$sql_r="select * FROM remitentes ORDER BY remitentes.`id_remitente` DESC";
    	$query_r=new Consulta($sql_r);		
		//$row_remit=$query_remit->ConsultaVerRegistro(); ?>
		
<div align="center"><a href="<?=$_SESSION['PHP_SELF']?>?opcion=newremi"class="Estilo2" >Nuevo Remitente</a></div>					

<form id="f4" name="f4" method="post" action="<?=$_SESSION['PHP_SELF']?>?opcion=newremi">
 <table width="100%" height="117" border="1" align="center">
    <tr bgcolor="#6699CC" class="Estilo2">
      <td width="57" class="Estilo2"><div align="center">Codigo</div></td>
      <td width="247" class="Estilo2"><div align="center">Remitente</div></td>
      <td width="162" class="Estilo2"><div align="center">Abreviatura</div></td>
      <td width="316" class="Estilo2"><div align="center">Tipo Remitente </div></td>
    </tr>
    <tr>
 <?  while($row_r=$query_r->ConsultaVerRegistro()){
 $id=$row_r[0];
 ?>

      <td ><div align="center" class="Estilo2"><a href="<?=$_SESSION['PHP_SELF']?>?opcion=editremi&id=<?=$id?>"><?=$id?></a></div></td>
      <td class="Estilo2"><?=$row_r[1]?></td>
      <td class="Estilo2"><?=$row_r[2]?></div></td>
      <td class="Estilo2"><?=$row_r[3]?></div></td>
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
}

 ?>
