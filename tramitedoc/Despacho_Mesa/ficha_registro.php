<? 
 
///http://localhost/std/php-barcode-0.3pl1/barcode.php
session_start();
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	
	ob_start();
}
?><?  	include("../includes.php");
		require_once("cls/acceso_registro.cls.php");
		
		$link=new Conexion();
	

?>

<title> Reporte de Tramite Documentario - Solicitud de Registro </title>
<link rel="stylesheet" type="text/css" href="../../std/style.css">
<script language="javascript" src="../../std/js/js.js"></script> 
<style type="text/css">
<!--
.LinePri {
	border-right-width: 1px;
	border-right-style: solid;
	border-right-color: #000000;
	border-top-width: 1px;
	border-top-style: solid;
	border-top-color: #000000;
	border-left-width: 1px;
	border-left-style: solid;
	border-left-color: #000000;
}
.LineSeg {
	border-right-width: 1px;
	border-left-width: 1px;
	border-right-style: solid;
	border-left-style: solid;
	border-right-color: #000000;
	border-left-color: #000033;
	border-top-width: 1px;
	border-top-style: solid;
	border-top-color: #000000;
}
.LineTer {
	border: 1px solid #000000;
}
.LineS1 {
	border-top-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-left-style: solid;
	border-top-color: #000000;
	border-left-color: #000000;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #000000;
}
.LineCompleto {
	border: 1px solid #000000;
}
.LineIzq{
border-right:1px solid #000000;
border-bottom: 1px solid #000000;}
.LineL {
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-bottom-style: solid;
	border-left-style: solid;
	border-bottom-color: #000000;
	border-left-color: #000000;
}
.Line_ {
	border-bottom-width: 1px;	
	border-bottom-style: solid;
	border-bottom-color: #000000;
	padding-left:3px;
	padding-right:3px;
}
.LineU {
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
}
.LineZ {
	border-top-width: 1px;
	border-bottom-width: thin;
	border-top-style: solid;
	border-bottom-style: solid;
	border-top-color: #000000;
	border-bottom-color: #000000;
}
.LineI {
border-left:1px solid #000000;
}
.Estilo1 {font-size: 12px}
.Estilo2 {font-size: 16px}
body {
	background-color: #FFFFFF;
}

-->
</style>

<body topmargin="0" leftmargin="0">
<div id="barraBotones" name="barraBotones">
<?
$med_t='100%';
if($_GET[pdf]!='ok'){ $med_t='90%';
	///pdf
	$dir_pdf=$_SERVER['PHP_SELF'].'?idcons='.$idcons.'&md='.$md.'&pdf=ok';
	?>
	<table width="100%"><tr><td align="left">
	<!--<a href="<?=$dir_pdf?>" ><img src="../../imgs/icon-pdf.gif" width="18" height="20" border="0" title="Descargar PDF"></a>-->
	</td>
	<td align="right">
	<a href="#" onClick="salida_impresora()" title="Imprimir">
	<img src="../../std/imgs/b_print.png" width="20" height="20" border="0"></a>	</td>
	</tr></table>
<? }?>
</div>
<?

///busqueda reporte
?>
</div>
<table width="30%"  border="0" align="center">
      <tr>
        <td width="60%" align="center"><sup>MINISTERIO DEL AMBIENTE</sup><br>
              <sup>SERVICIO NACIONAL DE AREAS NATURALES PROTEGIDAS</sup></td>
      </tr>
      <tr>
        <td align="center" valign="top"><p class="Estilo0">SECRETARIA GENERAL</p>
        <p class="Estilo0">SOLICITUD DE REGISTRO N&deg; <?=$row_rpt[nro_sol_fondos]?></p>
        <p class="Estilo1"><?=$nom_anp?></p></td>
      </tr>
</table>
        
        <table width="30%"  border="0" align="center">
      
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><? echo 'Estamos Trabajando';?></td>
        </tr>
        <tr>
           <td align="center" >Gracias</td>
        </tr>
        <tr>
          <td align="center">
<?         
require("../php-barcode-0.3pl1/php-barcode.php");
function getvar($name){
    global $_GET, $_POST;
    if (isset($_GET[$name])) return $_GET[$name];
    else if (isset($_POST[$name])) return $_POST[$name];
    else return false;
}

if (get_magic_quotes_gpc()){
    $code=stripslashes(getvar('code'));
} else {
    $code=getvar('code');
}
if (!$code) $code='123456789012';

echo $code;
barcode_print($code,getvar('encoding'),getvar('scale'),getvar('mode')); ?>
</td>
        </tr>
      </table>
<br>
      
<script language="javascript">
FullScreen();
</script>
</body>
<? 
if($_GET[pdf]=='ok'){
$htmlbuffer=ob_get_contents();
ob_end_clean();
	header("Content-type: application/pdf");
$pdf = new HTML2FPDF();
$pdf->ubic_css="../../../style.css"; //agreg mio
	$pdf->DisplayPreferences('HideWindowUI');
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
  // $pdf->setBasePath("../../../");
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('constancia_desembolso.pdf','D');
}?>