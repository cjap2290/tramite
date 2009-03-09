<?
class Registro {
	function RegistraCabecera(){	
		$sql_usu="SELECT `u`.`usuario_usuario`,`u`.`password_usuario`,`uap`.`id_axo_poa`,`u`.`nombre_usuario` as nombre 
				FROM `usuarios` AS `u`, `usuario_axo_poa` AS `uap` 
				WHERE `u`.`id_usuario` = `uap`.`id_usuario` AND `u`.`id_usuario` = '1' ";
		$query_pa=new Consulta($sql_usu);		
		$row_usu=$query_pa->ConsultaVerRegistro(); ?>
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<title>Documento sin t&iacute;tulo</title>
			<style type="text/css">
				<!--
				.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; }
				.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; font-weight: bold; }
				.Estilo22 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: xx-small; }
				.Estilo24 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: xx-small; font-weight: bold; }
				.Estilo25 { color: #FFFFFF; font-weight: bold; }
				-->
			</style>
		</head>
		<body>
		<script type="text/javascript" src="../../js/ajax/ajax.js"></script>
		<p align="center"><img src="../imgs/CABEZERA.JPG"/></p>
		<table width="800" border="0" align="center">
		  <tr>
			
			<td width="100%"><div align="right" class="Estilo9">Usuario del Sistema: <?=$row_usu[nombre]?></div></td>
		  </tr>
		</table>
		<div>
		  <p><span class="Estilo9">MANTENIMIENTO DE TABLAS</span> </p>
		  <ul>
            <li>Personal</li>
		    <li>Cargos</li>
		    <li>Estados</li>
		    <li>Prioridades</li>
		    <li>Remitente</li>
		    <li>Acciones</li>
		    <li>Areas de Sernanp</li>
		    <li>Remitentes</li>
		    <li>Tipos de Documentos</li>
		    <li>Usuario</li>
	      </ul>
		</div>

	

		  <?
	}
}?>		
	    
		</body>
		</html> 