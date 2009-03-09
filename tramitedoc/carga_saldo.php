<?php  include("includes.php");

	require_once("libs/lib.php");

	require_once("cls/mesa_acceso_registro.cls.php");



if(isset($_GET['horas'])){		

					

 $sql_prioridad="SELECT prioridades.id_prioridad, prioridades.nombre_prioridad, prioridades.tiempo_horas_respuesta_prioridad/24 AS dias, prioridades.tiempo_horas_respuesta_prioridad


						FROM prioridades

						where 

						prioridades.id_prioridad='".$_GET['id_total']."'

						

						ORDER BY prioridades.id_prioridad ASC";

    	

					$d_prioridad=new Consulta($sql_prioridad);

					$dol_prio=$d_prioridad->ConsultaVerRegistro(); 

					

		

			///$saldo=number_format($sal_tot,2,".",",");

			 ?>

      <input name="saldo" type="text" bgcolor="#999999" value="<?=$dol_prio[2]?>" size="1" readonly="" id="saldo" />

<?php 



}else if(isset($_GET['fechar'])){

	

	$sql_prioridad="SELECT prioridades.id_prioridad, prioridades.nombre_prioridad, prioridades.tiempo_horas_respuesta_prioridad

						FROM prioridades

						WHERE prioridades.id_prioridad='".$_GET['fechar']."'

						ORDER BY prioridades.id_prioridad ASC";

    	

					$d_prioridad=new Consulta($sql_prioridad);

					$dol_prio=$d_prioridad->ConsultaVerRegistro(); 

					

	$documento = new Documento($_GET['id']);

	echo $documento->setFechaRespuesta($dol_prio[2]);

}

?> 