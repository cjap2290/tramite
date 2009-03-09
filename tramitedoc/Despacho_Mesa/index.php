<?
require("../includes.php");
require("../cls/index.cls.php");
///////////
//if(empty($_SESSION[acc])&&empty($_POST)) require("error_s.php");
/////////
$link= new Conexion();
?>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<script language="javascript" src="js/js_index.js"></script>
<script language="javascript" src="js/js.js"></script>
<script language = "JavaScript">
function cargar_win(id){
	cuerpo = centrar_popup(800,600);
  	//window.open('validate.php?cod='+id,'Validar',cuerpo);
	window.open('validate.php?cod='+id,'_blank',cuerpo);
	top.window.moveTo(0,0);
}
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: verdana, arial, helvetica;
	color: #006633;
	font-weight: bold;
}
-->
</style>
<title>&Iacute;ndice SELPO</title><form method="post" name="form1" action="">
<? 
if(!empty($_POST[T1])&&!empty($_POST[T2])&&!empty($_POST[axo_ingreso])){
	$_SESSION[acc][0]=true; $_SESSION[acc][1]=$_POST[T1]; 
	$_SESSION[acc][2]=$_POST[T2]; $_SESSION[acc][3]=$_POST[axo_ingreso];
}

$usu=$_SESSION[acc][1]; $pass=$_SESSION[acc][2]; $axo_ingreso=$_SESSION[acc][3];

$sql="Select * from usuarios u, submodulo s, modulos m, submodulo_usuario su
			WHERE usuario_usuario='".$usu."' AND password_usuario='".$pass."' AND
			su.id_usuario=u.id_usuario AND m.id_modulo=s.id_modulo AND su.id_submodulo=s.id_submodulo 
			AND m.id_modulo in (1,2,4) Group By m.id_modulo";
$query=new Consulta($sql);
$nro=$query->numregistros();
if(empty($nro)){
	if(empty($AuthVar['intentos'])) $AuthVar['intentos']=0;
	$AuthVar['intentos'] = $AuthVar['intentos'] + 1;
	$indice=0;
	if($AuthVar['intentos']>=3){ $indice=1; $AuthVar['intentos']=0;}
?> 
		<script>
			verificaru('<?=$indice?>');
			location.replace('acceso_registro.php');	
		</script>
<? } 
else{ ?>
<table border=0 class=table height=100% bgcolor=white cellpadding=1 cellspacing=2   align=center >
<tr align=center>
  <td height=120 bgcolor=white valign=top >
    <p><img src='imgs/logo.jpg' width=180 height=80><br>
        <span class="Estilo1">Sistema en L&iacute;nea  <br>de&nbsp;Planificaci&oacute;n Operativa</span><br>
        <br>
        <strong>SELPO</strong><br>
        <br>
    </p>
    <p>&nbsp;</p></td>
</tr><?
	while($row=$query->ConsultaVerRegistro()){
	?>
		<tr align=left height=25>
		<td bgcolor=lavender onMouseOver="this.style.background='#CCFF33';" onMouseOut="this.style.background='lavender'">
		<a href="#" onClick="cargar_win('<?=$row[id_modulo]?>')">
		<img src="imgs/s_process.png" border=0>
		<?=$row[nombre_modulo]?>
		</a>		</td>
	</tr><?
		
	}
?>
	
	<tr>
	  <td align="center"><br>
	    <br>
			<a href="JavaScript:acercade()">Cr&eacute;ditos</a><br>
	  <a href="http://www.areasprotegidasperu.com/ayuda/wakka.php?wakka=Start" title="Manual de sistema">Manual de Usuario</a><br></td>
	</tr>
</table>
<script>
  /*screen_height = screen.height;
  screen_width = screen.width;
  left_y = parseInt(screen_width / 2) - parseInt(800 / 2); 
  top_x = parseInt(screen_height / 2) - parseInt(600 / 2); 
	window.moveTo(left_y,top_x);
	if (document.all){
		top.window.resizeTo(811,620);
	}else if (document.layers||document.getElementById) {
		if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
			top.window.outerWidth = 808;
			top.window.outerHeight = 634;
		}
	}*/FullScreen();
</script>
<? }?>
</form>
</html>