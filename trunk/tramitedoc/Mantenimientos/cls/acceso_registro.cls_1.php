<?
class Registro {



function RegistraCabecera(){	
$sql_usu="SELECT `u`.`usuario_usuario`,`u`.`password_usuario`,`uap`.`id_axo_poa`,`u`.`nombre_usuario` as nombre
FROM
`usuarios` AS `u`,
 `usuario_axo_poa` AS `uap` 
WHERE
`u`.`id_usuario` = `uap`.`id_usuario` AND
`u`.`id_usuario` = '1'
";
$query_pa=new Consulta($sql_usu);		
$row_usu=$query_pa->ConsultaVerRegistro(); ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; }
.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; font-weight: bold; }
.Estilo14 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
.Estilo15 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo19 {font-size: 9}
.Estilo21 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9; }
.Estilo22 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: xx-small; }
.Estilo23 {color: #000000}
-->
</style>




<body>
<p align="center"><img src="../imgs/CABEZERA.JPG" width="921" height="78" /></p>
<table width="90%" border="0">
  <tr>
    
    <td width="100%"><div align="right" class="Estilo9">Usuario del Sistema: <?=$row_usu[nombre]?></div></td>
  </tr>
</table>
<span class="Estilo9">REGISTRO DE DOCUMENTOS </span>
  <p></p>
  
  
  <?

}

function RegistraListado(){	 ?>
<? 
	$sql_reg=" SELECT * FROM
t_documento
Inner Join t_remitente ON t_remitente.t_remitenteID = t_documento.t_remitente_t_remitenteID
Inner Join t_estado ON t_estado.t_estado_ID = t_documento.t_estado_t_estado_ID
Inner Join t_tipodocumento ON t_tipodocumento.t_tipodocumento_ID = t_documento.t_tipodocumento_t_tipodocumento_ID ORDER BY
t_documento.t_documento_tramiteID DESC";
	$query_reg=new Consulta($sql_reg);		
	//$row_reg=$query_reg->ConsultaVerRegistro();
	
	?>
    
<table width="90%" border="1" align="center">
    <tr bgcolor="#00FF00" class="Estilo7">
      <td width="6%"><div align="center"><span class="msgok1">Reg. N&ordm; </span></div></td>
      <td width="10%"><div align="center"><span class="msgok1">Tipo de Doc.</span></div></td>
      <td width="16%"><div align="center"><span class="msgok1">Procedencia</span></div></td>
      <td width="12%"><div align="center"><span class="msgok1">N. de Documento</span></div></td>
      <td width="27%"><div align="center"><span class="msgok1">Referencia</span></div></td>
      <td width="17%"><div align="center"><span class="msgok1">Estado</span></div></td>
      <td width="12%"><div align="center" class="msgok1">Fecha y Hora </div></td>
    </tr>
    <? while($row_reg=$query_reg->ConsultaVerRegistro()){
	$id=$row_reg[0]?>
    <tr class="Estilo7">
      <td ><a href="acceso_registro.php?opcion=edit&id=<?=$id?>"><?=$row_reg[1]?></a></td>
      <td ><?=$row_reg[t_tipodocumento_nombre]?></td>
      <td ><?=$row_reg[t_remitentenombre]?></td>
      <td ><?=$row_reg[3]?></td>
      <td ><?=$row_reg[4]?></td>
      <td ><?=$row_reg[t_estado_descrip]?></td>
      <td ><?=$row_reg[t_documento_tramitefechahoraregistro]?></td> 
    </tr><? }?>
</table>

<a href="<?=$_SESSION['PHP_SELF']?>?opcion=add"class="Estilo34" >Registrar Nuevo</a>



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

<form name="f3" method="post" action="acceso_registro.php?opcion=guardar">
  
  <div align="right" class="Estilo22"></div>
  <table width="93%" border="1" align="center" >
    <tr class="Estilo22">
      <td width="53" class="Estilo22"><div align="left" class="Estilo22" >Instituci&oacute;n:</div></td>
      <td width="315" ><span class="Estilo22">
      <?
      
		$sql_remit="select * FROM t_remitente ORDER BY t_remitente.t_remitentenombre ASC";
    	$query_remit=new Consulta($sql_remit);		
		//$row_remit=$query_remit->ConsultaVerRegistro(); 
	
?>
<select name="remit">
				    
				   <option value="">--- Seleccione Remitente ---</option>
				    <?
					while($row_remit=$query_remit->ConsultaVerRegistro()){?>
				    <option value="<? echo $row_remit[0]?>"<? if(isset($_POST['remit']) && $_POST['remit']== $row_remit[0]){ echo "selected";} ?>><? echo $row_remit[1]?></option> <?  } ?>			
        </select>
        <input type="button" name="Submit4" value="Agregar" />
      </span></td>
      <td width="90" class="Estilo22">Tipo de Documento :</td>
      <td width="240" class="Estilo22"><span class="Estilo22">
      
    
<?
      $sql_tipo="SELECT * FROM t_tipodocumento ORDER BY t_tipodocumento.t_tipodocumento_nombre ASC";
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
      <td width="77" bgcolor="#FFFFFF"><div align="left" class="Estilo22">Nro de Folios</div>        </td>
      <td ><span class="Estilo22"><span class="Estilo22">
        <input name="num_folio" type="text" size="10" />
      </span></span></td>
    	</tr>
   		<tr>
      <td width="53" class="Estilo22"><div align="left" class="Estilo22">Nro. Doc:</div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo23">
        <input name="num_doc2" type="text" value="" size="48" />
      </span></td>
      <td width="90" class="Estilo22">Destino :</td>
      <td width="240" bgcolor="#FFFFFF"><input name="destino" type="text" value="" size="40" /></td>
      <td width="77" bgcolor="#FFFFFF" class="Estilo22"><div align="left" class="Estilo22">Fecha de Doc </div></td>
      <td width="111"> 
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
      <td width="53" class="Estilo22"><div align="left" class="Estilo22">Referencia:</div></td>
      <td colspan="6"><input name="refe" value="" type="text" size="100" /></td>
    </tr>
    <tr>
      <td width="53" class="Estilo22"><div align="left" class="Estilo22">Anexos:</div></td>
      <td colspan="6"><span class="Estilo23">
        <input name="anexo" value="" type="text" size="100" />
      </span></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left" class="Estilo22">Observacion:</div></td>
      <td colspan="6"><textarea name="observ" cols="140" rows="4" value="" ></textarea></td>
    </tr>
    <tr>
    <?=$_POST["num_folio"]?>
	<?=$_POST["remit"]?> 
	<?=$_POST["tipo"]?>
	<?=$_POST["num_doc"]?>
	<?=$_POST["FechaSol"]?>
	<?=$_POST["refe"]?>
	<?=$_POST["anexo"]?>
	<?=$_POST["observ"]?>
      <td colspan="7" align="center">
        <p>&nbsp;        </p>
        <p>
          <input type="submit" name="guardar" value="Guardar" />
           </p></td>
    </tr>
  </table>
  
 
</form><? }

function RegistraEditar($id){
?>


<link href="style.css" type="text/css" rel="stylesheet">
<link href="style.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="../libs/calendar/calendar-green.css" title="win2k-cold-1" /> 
<span class="Estilo12 Estilo8 Estilo8 Estilo12">
<script type="text/javascript" src="../libs/calendar/calendar.js"></script> 
<script type="text/javascript" src="../libs/calendar/calendar-es.js"></script>   
<script type="text/javascript" src="../libs/calendar/calendar-setup.js"></script> 
<script language="javascript" src="js/js.js"> </script>
<script language="javascript" src="../js/js.js"> </script>	

<form name="f4" method="post" action="acceso_registro.php?opcion=edit">
  
  <div align="right" class="Estilo22"></div>
  <table width="93%" border="1" align="center" >
    <tr class="Estilo22">
      <td width="58" class="Estilo22"><div align="left" class="Estilo22" >Instituci&oacute;n:</div></td>
      <td width="291" ><span class="Estilo22">
      <?
      
		$sql_remit="select * FROM t_remitente ORDER BY t_remitente.t_remitentenombre ASC";
    	$query_remit=new Consulta($sql_remit);		
		//$row_remit=$query_remit->ConsultaVerRegistro(); 
	
?>
<select name="remit">
				    
				   <option value="">--- Seleccione Remitente ---</option>
				    <?
					while($row_remit=$query_remit->ConsultaVerRegistro()){?>
				    <option value="<? echo $row_remit[0]?>"<? if(isset($_POST['remit']) && $_POST['remit']== $row_remit[0]){ echo "selected";} ?>><? echo $row_remit[1]?></option> <?  } ?>			
        </select>
        <input type="button" name="Submit4" value="Agregar" />
      </span></td>
      <td width="94" class="Estilo22">Tipo de Documento :</td>
      <td width="201" class="Estilo22"><span class="Estilo22">
      
    
<?
      $sql_tipo="SELECT * FROM t_tipodocumento ORDER BY t_tipodocumento.t_tipodocumento_nombre ASC";
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
      <td bgcolor="#FFFFFF"><div align="left" class="Estilo22">Nro de Folios</div>        </td>
      <td ><span class="Estilo22"><span class="Estilo22">
        <input name="num_folio" type="text" size="10" />
      </span></span></td>
    	</tr>
   		<tr>
      <td width="58" class="Estilo22"><div align="left" class="Estilo22">Nro. Doc:</div></td>
      <td colspan="3" bgcolor="#FFFFFF"><span class="Estilo23">
        <input name="num_doc" type="text" value="" size="80" />
      </span></td>
      <td width="90" bgcolor="#FFFFFF" class="Estilo22"><div align="left" class="Estilo22">Fecha de Doc </div></td>
      <td width="115"> 
      	<input name="FechaSol" id="FechaSol" type="text" value="" readonly="true" size="12" style="background-color:#EEEEEE"/>
       	<input name="button" type="button" id="lanzador" value="." />
        
    <script type="text/javascript"> 
					   Calendar.setup({ 
						 inputField: "FechaSol",     
						 ifFormat  : "%d/%m/%Y",   
						 button    : "lanzador" 
						});			
					</script>  </td>
    </tr> 
    <tr>
      <td width="58" class="Estilo22"><div align="left" class="Estilo22">Referencia:</div></td>
      <td colspan="5"><input name="refe" value="" type="text" size="100" /></td>
    </tr>
    <tr>
      <td width="58" class="Estilo22"><div align="left" class="Estilo22">Anexos:</div></td>
      <td colspan="5"><span class="Estilo23">
        <input name="anexo" value="" type="text" size="100" />
      </span></td>
    </tr>
    <tr>
      <td class="Estilo22"><div align="left" class="Estilo22">Observacion:</div></td>
      <td colspan="5"><textarea name="observ" cols="140" rows="4" value="" ></textarea></td>
    </tr>
    <tr>
    <?=$_POST["num_folio"]?>
	<?=$_POST["remit"]?> 
	<?=$_POST["tipo"]?>
	<?=$_POST["num_doc"]?>
	<?=$_POST["FechaSol"]?>
	<?=$_POST["refe"]?>
	<?=$_POST["anexo"]?>
	<?=$_POST["observ"]?>
      <td colspan="6" align="center">
        <input type="submit" name="actualizar" value="Actualizar" />
        
     </td>
    </tr>
  </table>
  
 
</form><? }

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
	$observ=$_POST["observ"]; 
	
	$query="SELECT `ttd`.`t_tipodocumento_abreviatura` as codigo1 FROM `t_tipodocumento` AS `ttd` WHERE `ttd`.`t_tipodocumento_ID` =  '1'
";
	$query_codigo=new Consulta($query);		
	$row_codigo=$query_codigo->ConsultaVerRegistro();
	$codigo1=$row_codigo['codigo1'];
	
	echo $codigo1;
	$sql_cod1="SELECT `tr`.`t_remitenteabreviatura` as codigo2 FROM `t_remitente` AS `tr` WHERE `tr`.`t_remitenteID` =  '1'";
	$query_codigo1=new Consulta($sql_cod1);		
	$row_codigo1=$query_codigo1->ConsultaVerRegistro();
	$codigo2=$row_codigo1['codigo2'];
	echo $codigo2;
	$sql_cod2="SELECT Max(`td`.`t_documento_tramiteID`) AS `codigo3` FROM `t_documento` AS `td`";
	$query_codigo2=new Consulta($sql_cod2);		
	$row_codigo2=$query_codigo2->ConsultaVerRegistro();
	$codigo21=$row_codigo2['codigo3'];
	$codigo3=$codigo21+1;
	echo $codigo3;
	$codigo=$codigo1+$codigo2;
	echo $codigo;
	//$codigo=$row_codigo["codigo"];
	//Con esto se indica de que esta registrado
	$var_estado=1;
	$guarda="INSERT INTO t_documento VALUES ('','".$codigo."','".$tipo."','".$num_doc."','".$refe."','".$anexo."','".$num_folio."','".$FechaSol."','','','".date("Y-m-d h:m:s")."','','','".$remit."','".$var_estado."')";
	$q_guarda=new Consulta($guarda);		
	///$row_guarda=$q_guarda->ConsultaVerRegistro();
	//echo $q_guarda;
	///header("location: acceso_registro.cls.php");	



  
  }
 function RegistraUpdate($id){
 
 
}
function RegistraEliminar($id){
}
}

 ?>
</body>
</html> 