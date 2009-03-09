<?php
require_once("../includes.php");
require_once("../cls/login.cls.php");
session_start();
$link=new Conexion();
if ($_GET[ver]!=1){
//die ("sistema en manteniento");
}
?>
<HTML>
<title>Login</title>
<style type="text/css">
<!--
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo3 {font-size: 10px}
.Estilo4 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
<HEAD>
<?php
$cn=new Login();
$usuarios=$cn->LoginUsuarios();
$axo=$cn->ListarAxo();
$axorelacionado=$cn->LoginAxoUsuario();
if(is_array($usuarios)){?>
<script language="javascript">	

		var id_ope = new Array()
		var login = new Array()
		var CLAVEcmd5 = new Array()
		var axo_id = new Array()
		var axo = new Array()
		var axo_aso = new Array()
		var ope_aso = new Array()
		<?	
		for($c=0;$c<sizeof($axorelacionado);$c++){ ?>
			axo_aso['<?=$c?>']="<?=$axorelacionado[$c][id_axo_poa]?>"
			ope_aso['<?=$c?>']="<?=$axorelacionado[$c][id_usuario]?>"
		<?	}
		for($c=0;$c<sizeof($axo);$c++){	?>
			axo_id['<?=$c?>']="<?=$axo[$c][id_axo_poa]?>"
			axo['<?=$c?>']="<?=$axo[$c][axo]?>"
		<? }
		for($c=0;$c<sizeof($usuarios);$c++){ ?>
			id_ope['<?=$c?>']="<?=$usuarios[$c][id_usuario]?>"
			login['<?=$c?>']="<?=$usuarios[$c][usuario]?>"
			CLAVEcmd5['<?=$c?>']="xXxXxXSapoxXxXxX"
		<? }
}
?></script>

<script language="javascript" src="../js/js.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>


<script language="javascript">
function BorrarLista( ) {
	f = document.forms["form1"]
	f.axo_ingreso.length = 0
}

function buscar_asociados(id){
	var pos=1
	for(x=0; x<ope_aso.length; x++){
		if(ope_aso[x]==id){
			for(i=0; i<axo_id.length; i++){
				if(axo_id[i]==axo_aso[x]){					
					var opcion = new Option(axo[i],axo_id[i])
					f.axo_ingreso.options[pos]=opcion
					pos++
				}
			}
		}
	}
}

function Update_select(){
	BorrarLista( )
	f = document.forms["form1"] 	
	valor1 =  f.T1.value;
	valor2 =  f.T2.value;
	var confi_log=false
	var confi_pass=false
	
	for(x=0; x<login.length; x++){
		if(login[x]==valor1){	
			confi_log=true
				confi_pass=true
				usuario=id_ope[x]
			
		}
	}
	
	if(confi_log){
		if(confi_pass){			
			buscar_asociados(usuario)
		}
	}	
}
/*********************************************************************************************************/
function Cargar(){	
	forma = document.forms["form1"]
	with (forma){
  	valor1 =  T1.value;
  		valor2 =  T2.value;
		valor3 = axo_ingreso.value
		err=0
		msg="Estos son los errores : \n\n"
		if(valor1==''){
			msg+="Ingrese su Login...\n"
			err++
		}
		if(valor2==''){
			msg+="Ingrese su Contraseña...\n"
			err++
		}
		if(valor3==''){
			msg+="Seleccione un año...\n"
			err++
		}
		
		if(err>0){
			alert(msg)
			return false
		}else{
			var confi_log=false
			var confi_pass=false
			var usuario = ''
			for(x=0; x<login.length; x++){				
				if(login[x]==valor1){	
					confi_log=true
						confi_pass=true
						usuario=id_ope[x]
				}
			}

			if(confi_log){
				forma.submit()
			}else{
				alert("el login no existe")
				T1.value=""
				T2.value=""
				T1.focus()
			}
		}

	}
	return false
}
function enfocar(){
  document.form1.T1.focus();
}
</script>
<html>
<head>

<script language = "JavaScript" >
var message = "" ; 
function clickIE (){
if ( document . all ){
( message );
return false ;
}
}

function clickNS( e ){
	if ( document . layers || ( document . getElementById && ! document . all )){
		if ( e . which == 2 || e . which == 3 ){
			( message );
			return false ;
		}
	}
}

if ( document . layers ){
document . captureEvents ( Event . MOUSEDOWN );
document . onmousedown = clickNS ;
} else {
document . onmouseup = clickNS ;
document . oncontextmenu = clickIE ;
}
document . oncontextmenu = new Function( "return false" )

function win_acceso(){
	screen_height = screen.height;
	screen_width = screen.width;
	left_y = parseInt(screen_width / 2) - parseInt(400 / 2); 
	top_x = parseInt(screen_height / 2) - parseInt(250 / 2); 
	window.moveTo(left_y,top_x);
	if (document.all) {
		top.window.resizeTo(570,375);
	}else if (document.layers||document.getElementById) {
		if (top.window.outerHeight<screen.availHeight || top.window.outerWidth<screen.availWidth){
			top.window.outerWidth = 409;
			top.window.outerHeight = 265;
		}
	}
	window.focus();
}
</script>
</head> 

<BODY leftmargin="0" topmargin="0" onLoad="enfocar();">
<form name="form1" method="post" action="procesa_usuario.php">
 
  <TABLE class=table height="61" cellSpacing=0 cellPadding=0 width="61" align=center bgColor=white border=0>
  <TBODY>
  <tr>
    <th height="2%" valign="top" scope="col"><IMG height="62" src="imgs/CABEZERA.JPG" width="534"></th>
  </tr>			
  <TR>
    <TD bgColor=#66FF66>			
      <table align="center" width="2%">
			  <TR bgcolor="#66FF66">
			    <TD colspan="3" align="right" nowrap><div align="center"><span class="Estilo4">BIENVENIDOS AL SISTEMA DE TRAMITE DOCUMENTARIO</span></div></TD>
		    </TR>
			  <TR bgcolor="#66FF66">
  			  <TD colspan="3" align="right" nowrap><div align="center" class="Estilo2 Estilo3"> Ingrese los datos para su  identificaci&oacute;n y acceso al sistema </div></TD>
			</TR>
			  <TR align=center bgcolor="#66FF66" >
    			<TD width="36%" align="right"><span class="Estilo3"></span></TD>
				<TD width="3%"><span class="Estilo3"></span></TD>
				<TD width="61%" align="left" ><span class="Estilo3"></span></TD>
			</TR>
			  <TR bgcolor="#66FF66">
                <TD align="right"><span class="Estilo2">Usuario</span></TD>
                <TD><span class="Estilo3"></span></TD>
                <TD align="left">
                  <div align="left" class="Estilo2">
                    <input name="T1" type="text" onBlur="Update_select();" onKeyPress="ValidCode(this)">
                </div></TD>
		    </TR>
			  <TR align=center bgcolor="#66FF66" >
                <TD align="right"><span class="Estilo2">Contrase&ntilde;a</span></TD>
                <TD><span class="Estilo3"></span></TD>
                <TD align="left" >
                  <div align="left" class="Estilo2">
                    <input name="T2" type="password" onBlur="Update_select();" onKeyPress="ValidCode(this)">
                </div></TD>
		    </TR>
			  <TR align=center bgcolor="#66FF66" >
                <TD align="right"><span class="Estilo2">A&ntilde;o </span></TD>
                <TD><span class="Estilo3"></span></TD>
                <TD align="left" >
    <div align="left" class="Estilo2">
                      <select name="axo_ingreso">
                        <option>
                        <pre>                  
                        </pre>
                        </option>
                      </select>
                </div></TD>
		    </TR>
			  <TR align=center bgcolor="#66FF66" >
			    <TD colspan="3" align="right"><div align="center" class="Estilo2"><input name="button" type="submit"  value="Ingresar">
			      <!----<a href="Ventanillas/acceso_registro.php?opcion=list"></a> --->
		        </div></TD>
		    </TR>
		  </table>			
		</TD>
	</TR>	
	</TBODY>
</TABLE>
<script> //win_acceso();</script>
</form>
</BODY></HTML>
