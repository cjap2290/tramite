<? 
 
///http://localhost/std/php-barcode-0.3pl1/barcode.php
session_start();
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	
	ob_start();
}
?><?  	include("../includes.php");
		require_once("../cls/ventanillas_acceso_registro.cls.php");
		$link=new Conexion();
	
	
	$sql="Select * from documentos as d where d.id_documento='".$id."'";
	$q_reg=new Consulta($sql);		
	$rowreg=$q_reg->ConsultaVerRegistro();
	
	$tipo=$rowreg[id_tipo_documento];
	$remitente=$rowreg[id_remitente];
	

	

?>

<title> Reporte de Tramite Documentario - Registro de Documentos </title>
<link rel="stylesheet" type="text/css" href="../../std/style.css">
<script language="javascript" src="../../std/js/js.js"></script> 

<style type="text/css">
<!--
.primeracolumna {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;	
}
.titulo {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;	
}
.detalle {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.numero{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
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
	?><!--
	<table width="100%"><tr><td align="left">-->
	<!--<a href="<?=$dir_pdf?>" ><img src="../../imgs/icon-pdf.gif" width="18" height="20" border="0" title="Descargar PDF"></a>-->
<!--	</td>
	<td align="right">
	<a href="#" onClick="salida_impresora()" title="Imprimir">
	<img src="../../std/imgs/b_print.png" width="20" height="20" border="0"></a>	</td>
	</tr></table>-->
<? }?>
</div>
<p>
  <?

///busqueda reporte
?>
</p>
<table width="62%"  border="0" align="left">
      <tr>
        <td><p><img src="../imgs/cabecera.jpg" width="110%" height="60" /></p></td>
      </tr>
</table>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <table   bordercolor=" " width="36%"  border="0" align="left">
        <tr class="Estilo1">
          <td height="23" colspan="3" align="right" ><span class="numero">SERNANP N&deg;</span> </td>
          <td width="11%"><span><b>
            <?=$rowreg[1]?>
          </b></span></td>
        </tr>
        <tr class="Estilo33">
          <td height="20" colspan="4" align="center"><span class="titulo">Hoja de Tramite</span></td>
        </tr>
        <tr class="Estilo1">
          <?
		$sql_remi="Select * FROM remitentes AS r Inner Join tipo_remitente AS tr ON tr.id_tipo_remitente = r.id_tipo_remitente where r.id_remitente='".$rowreg['id_remitente']."'
		";
		$q_remi=new Consulta($sql_remi);		
	$rowremi=$q_remi->ConsultaVerRegistro();
		?>
          <td width="38%" align="left" class="primeracolumna" ><span class="Estilo15">Origen</span></td>
          <td colspan="3" align="left" class="detalle" ><span class="Estilo16">
            <?=$rowremi['tipo_remitente_nombre']?>
            &nbsp;</span><span class="Estilo16"></span></td>
        </tr>
        <tr class="Estilo1">
          <td width="38%" align="left" class="primeracolumna" ><span class="Estilo15">Fecha de Registro</span></td>
          <td colspan="3" align="left" class="detalle" ><span class="Estilo16">
            <?=$rowreg['fecha_registro_documento']?>
          </span> <span class="Estilo16"></span></td>
        </tr>
        <tr class="Estilo1">
          <td width="38%" align="left" class="primeracolumna" ><span class="Estilo15">Remitente</span></td>
          <td colspan="3" align="left" class="detalle" ><span class="Estilo17">
            <?=$rowremi['nombre_remitente']?>
          </span></td>
        </tr>
        <tr class="Estilo1">
          <td width="38%" align="left" class="primeracolumna" ><span class="Estilo15">Nro. Documento</span></td>
          <td colspan="3" align="left" class="detalle" ><span class="Estilo17">
            <?=$rowreg['numero_documento']?>
          </span> </td>
        </tr>
        <tr>
          <td height="21" colspan="4" align="left"><p>_______________________________________</p></td>
        </tr>
        <tr>
          <td width="38%" align="left" class="primeracolumna" ><span class="Estilo3">Derivado a:</span></td>
          <td width="24%" align="right" class="primeracolumna" ><span class="Estilo3">Fecha:</span></td>
          <td width="27%" align="right" class="primeracolumna" ><span class="Estilo3">Accion:</span></td>
          <td width="11%" align="center" class="primeracolumna" >&nbsp;</td>
        </tr>
        <tr>
          <td height="16" colspan="4" align="left" class="detalle"><p>___________________________________________</p></td>
        </tr>
        <tr>
          <td height="16" colspan="4" align="left" class="detalle"><p>___________________________________________</p></td>
        </tr>
        <tr>
          <td height="16" colspan="4" align="left" class="detalle"><p>___________________________________________</p></td>
        </tr>
        <tr>
          <td height="16" colspan="4" align="left" class="detalle"><p>___________________________________________</p></td>
        </tr>
        <tr>
          <td height="16" colspan="4" align="left" class="detalle"><p>___________________________________________</p></td>
        </tr>
        <tr>
          <td height="16" colspan="4" align="left" class="detalle"><p>___________________________________________</p></td>
        </tr>
        <tr>
          <td height="16" colspan="4" align="left" class="detalle"><p>___________________________________________</p></td>
        </tr>
        <tr class="primeracolumna">
          <td colspan="4" align="left" class="detalle"><span class="Estilo3">Observacion:</span></td>
        </tr>
  <td height="16" colspan="4" align="left" class="detalle"><p>___________________________________________</p></td>
  </tr>
  <tr>
    <td height="16" colspan="4" align="left" class="detalle"><p>___________________________________________</p></td>
  </tr>
  <tr>
    <td height="34" colspan="4" align="left" class="detalle"><div align="right"><img src="../php-barcode-0.3pl1/barcode.php?code=012345678901&encoding=EAN&scale=1&mode=png" alt=""/> </div></td>
  </tr>
</table>
<p>
  </div>
</p>
<br>
</body>
<? 
/*if($_GET[pdf]=='ok'){
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
}*/?>
<script>
	javascript:salida_impresora();
	window.close();
</script>