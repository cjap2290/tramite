<?php
require_once("includes.php");
require_once("acceso.php");
require_once("cls/login.cls.php");
$link=new Conexion();

$sql_usu="SELECT `u`.`usuario_usuario`,`u`.`password_usuario`,`uap`.`id_axo_poa`, CONCAT(`u`.`nombre_usuario`,'',
`u`.`apellidos_usuario`) as nombre
FROM
`usuarios` AS `u`,
 `usuario_axo_poa` AS `uap` 
WHERE
`u`.`id_usuario` = `uap`.`id_usuario` AND
`u`.`usuario_usuario` =  '".$_POST[T1]."' AND
`u`.`password_usuario` =  '".$_POST[T2]."' And
`uap`.`id_axo_poa`='".$_POST[axo_ingreso]."'";
$query_pa=new Consulta($sql_usu);		
$row_usu=$query_pa->ConsultaVerRegistro();


?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; }
.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; font-weight: bold; }
.Estilo12 {font-size: small}
.Estilo14 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
-->
</style>
</head>

<body>
<p align="center"><img src="imgs/CABEZERA.JPG" width="921" height="78" /></p>
<table width="100%" border="0">
  <tr>
    <td width="71%" class="Estilo9"><span class="breadcrumbs pathway"><a href="http://www.minam.gob.pe/" class="pathway">SERNANP</a> &gt;<a href="http://www.minam.gob.pe/" class="pathway">Sistema de Tr&aacute;mite Documentario</a>&gt;Registrar Documentos </span></td>
    <td width="29%"><div align="right" class="Estilo9">Usuario del Sistema: <?=$row_usu[nombre]?></div></td>
  </tr>
</table>
<p><span class="Estilo9">LISTADO DE DOCUMENTOS </span></p>
<table width="100%" border="1" align="center">
    <tr>
      <td width="5%"><div align="center"><span class="Estilo9">Reg. N&ordm; </span></div></td>
      <td width="8%"><div align="center"><span class="Estilo9">Tipo de Doc.</span></div></td>
      <td width="22%"><div align="center"><span class="Estilo9">Documento</span></div></td>
      <td width="47%"><div align="center"><span class="Estilo9">Referencia</span></div></td>
      <td width="18%"><div align="center" class="Estilo9">Fecha y Hora de Ingreso </div></td>
    </tr>
    <tr>
      <td><span class="Estilo9"><a href="#">0006</a></span></td>
      <td><span class="Estilo14">INFORME</span></td>
      <td><span class="Estilo7">015-11-2008-JD</span></td>
      <td class="Estilo7">PRFNP-C-CON-010-2008-PAN</td>
      <td><span class="Estilo7">12/10/2008 3:00pm </span></td>
    </tr>
</table>


<form id="form1" name="form1" method="post" action="file:///D|/Compartido/BORRADOR STD SERNANP/IngresarDatos.html">
    <div align="center"><span class="Estilo9"><a href="../IngresarDatos.php">
      <input type="submit" name="Submit" value="Registrar Nuevo" />
    </a></span></div>
</form>
</body>
</html>
