<?php 
	header ("content-type: text/xml");

    require_once("../includes.php");

    if($_REQUEST["metodo"]){
        $met = $_REQUEST["metodo"];
    }
    ?>
    <raiz>
    <?
    switch($met){
            case "cargar_usuarios":
                $query = cargar_usuarios();
                ?>
                <usuarios>
                <option value="">-Seleccione un Usuario-</option>
                <?php
                while($row_usuario = $query->ConsultaVerRegistro()){
                ?>
                <option value="<?=$row_usuario["id"]?>"><?=$row_usuario["nombre"]?></option>
                <?php
                } ?>
                </usuarios>
                <?php
                break;
     }
     ?>
    </raiz>

<?php 

function cargar_usuarios(){
    
 $id_areas=$_REQUEST["areas"];
 
    if ($id_areas){
        
        $sql_usuario = "SELECT u.id_usuario AS id,
                        concat(u.nombre_usuario,' ',u.apellidos_usuario) AS nombre
                        FROM usuarios AS u
                        WHERE u.id_area = $id_areas";

        $query_usuario = new Consulta($sql_usuario);

        return $query_usuario;
    }
}
?>