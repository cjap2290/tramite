<?php 

class Menu{

	function MenuIzquierdo(){

	if($_SESSION['session'][0]){

		/* SECCIONES */

		$array=Acceso::AccesoSecciones($_SESSION['session'][0]);

		if(is_array($array)){ ?>

			<table cellpadding="0" cellspacing="0"  width="100%" id="menu_izquierdo" >

				<tr>

					<td class="date"> MODULOS DEL SISTEMA</td>

				</tr>

				<!----<tr>

					<td width="198" height="20"  class="item">

						<a href="index.php">Inicio </a>

					</td>--->

				</tr><?php

			for($c=0;$c<sizeof($array);$c++){?>

				<!--<tr>

					<td bgcolor="lavender" class="titulo" ><?php echo $array[$c]['seccion']?></td></tr>--><?php

					/*   PAGINAS  */

					$paginas=Acceso::AccesoPaginasSecciones($array[$c]['id_modulo'], $_SESSION['session'][0]);

					if(is_array($paginas)){ 

						for($z=0;$z<sizeof($paginas);$z++){?>

							<tr>

								<td width="198" height="20"  class="item">

								<a href="<?php echo $paginas[$z]['url']?>"> <?php echo $paginas[$z]['pagina']?></a>

									</td></tr>	<?php

						} 

					}

					

			} ?>

			</table><?php

		}

	}

}

}
 ?>