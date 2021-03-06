// JavaScript Document

var request = false;

$(document).ready(function(){

esta_habilitado_copia();

$("#form_despacho").validate({
	error: "error",
	rules: {
		cboprioridad: "required",
		cboareas: "required",
		cboaccion: "required",
		radiobutton: "required"
	},
	messages: {
		cboprioridad: "",
		cboareas: "",
		cboaccion: "",
		radiobutton: ""

	}

});

$("#form_despacho_area").validate({
	error: "error",
	rules: {
		destino: "required",
		cboaccion2: "required",
		radiobutton: "required"
	},
	messages: {
		destino: "",
		cboaccion2: "",
		radiobutton: ""
	}

});

$("#form_editar_documento").validate({
	error: "error",
	rules: {
		remit1: "required",
		tipo: "required",
		date: "required"
	},
	messages: {
		remit1: "",
		tipo: "",
		date: ""
	}

});

$("#form_registrar_documento").validate({
	error: "error",
	rules: {
		remit: "required",
		tipo: "required",
		date_registrar: "required"
	},
	messages: {
		remit: "",
		tipo: "",
		date_registrar: ""
	}

});

$("#form_nueva_area").validate({
	error: "error",
	rules: {
		txtnombre: "required",
		txtabreviatura: "required"
	},
	messages: {
		txtnombre: "�Debe ingresar un nombre de area!",
		txtabreviatura: "�Debe ingresar una abreviatura!"
	}

});

$("#form_borrador_respuesta").validate({
	error: "error",
	rules: {
		area: "required",
		comentario: "required",
		accion: "required",
		usuario: "required",
		categoria: "required"
	},
	messages: {
		area: "",
		comentario: "",
		accion: "",
		usuario: "",
		categoria: ""
	}
	});

$("#form_finalizar_documento").validate({
	error: "error",
	rules: {
		borrador: "required"
	},
	messages: {
		borrador: ""
	}

});

if($("#cambiar_destino")){
    $("#cambiar_destino").click(function(){
        if($("#destino").attr("class")=="usuarios"){
            listarAreas($("#idArea").val());
            $("#destino").attr("class","areas");
            $("#cambiar_destino").text("Usuarios");
        }
        else{
            listarUsuariosArea($("#idArea").val());
            $("#destino").attr("class","usuarios");
            $("#cambiar_destino").text("Areas");
        }
    }
    );
}

$("#images a").click( function(){
		var title = $(this).attr("title");
		$("#imgp").hide();
		$("#imgp").attr("src", title).fadeIn('slow');
	});

	$("input[type=radio][name=tcar]").click( function(){
		$("#carac").empty();
		$("#cantidad").val(0);
	});

	$("#clb").click( function(){
		$("#cbusqueda").toggle('slow');
		$("#cfiltrar").hide('slow');
	});

	$("#fil").click( function(){
		$("#cfiltrar").toggle('slow');
		$("#cbusqueda").hide('slow');
	});

});

if (window.XMLHttpRequest) {

	request = new XMLHttpRequest();

}

function listarAreas(id_area){

    $.ajax({
      type: "POST",
      url: "Ajax/Ajax.php",
      data: "metodo=cargar_areas&areas="+id_area,
      dataType: "xml",
      success: function(xml){
        $("#destino").html("");

        $(xml).find('option').each(function(){
            var id = $(this).attr('value')
            var name = $(this).text();
            $("#destino").append('<option value="'+id+'">'+name+'</option>');
        });
      }
    });
}

function listarUsuariosArea(id_area){

    $.ajax({
      type: "POST",
      url: "Ajax/Ajax.php",
      data: "metodo=cargar_usuarios_area&areas="+id_area,
      dataType: "xml",
      success: function(xml){
        $("#destino").html("");

        $(xml).find('option').each(function(){
            var id = $(this).attr('value')
            var name = $(this).text();
            $("#destino").append('<option value="'+id+'">'+name+'</option>');
        });
      }
    });
}

function mostrarDetalle(id){

    $("#borrador"+id).toggle("fast");
    $("#detalle"+id).slideToggle("slow");
}

function verDetalleDoc(){

	$("#detalle_documento").slideToggle("slow");
    if($("#control").attr("class")=="v"){
        $("#control").text("Ocultar Detalles");
        $("#control").removeAttr("class");
        $("#control").attr("class","o");
    }else{
        $("#control").text("Ver Detalles");
        $("#control").removeAttr("class");
        $("#control").attr("class","v");
    }

}

function imprimir(direccion){

	window.open(direccion,'nada','width=380,height=520,resizable=no,scrollbars=no,toolbar=no,status=no,top=5000');

}

function validar_finalizar(){

if(!$("#form_finalizar_documento").valid()){
	alert("Debe seleccionar un borrador");
}else{
		document.form_finalizar_documento.submit();
}
}

function habilitar_finalizar(){
	if($("#mantenimientod")!=null){

		var filas = document.getElementById("mantenimientod").rows.length;
		if(filas<2){
			$("#mantenimientod").css("display","none");
		}
	}
}

function esta_habilitado_copia(){

	if(document.getElementById("tabla_despacho")!=null){

		tam = document.getElementById("tabla_despacho").rows.length;

		if(tam == 1){
				document.getElementById("1").disabled = "disabled";
		}
		else{
				$("#1").removeAttr("disabled");
		}
	}

}

function deshabilitado(){
	document.getElementById("0").disabled = "disabled";
}

function busca_coincidencias(field){

	var aleatorio = Math.random();

	if (window.ActiveXObject) {

    	try {

            request = new ActiveXObject("Msxml2.XMLHTTP");

        } catch(e) {

            try {

                request = new ActiveXObject("Microsoft.XMLHTTP");

            } catch(e){

                request = false;

            }

        }

    }



    if (request){

        request.onreadystatechange = processReqChange;

        request.open("GET", "busca_clientes.php?aleatorio="+aleatorio+"&phrase=" + encodeURIComponent(field));

        request.send(null);

    }

}

function checkName(field) {

	if(field.value!=""){

		if (window.ActiveXObject) {

    		try {

            	request = new ActiveXObject("Msxml2.XMLHTTP");

       		 } catch(e) {

            	try {

                	request = new ActiveXObject("Microsoft.XMLHTTP");

            	} catch(e) {

                	request = false;

            	}

        	}

		}



    	if (request) {

    	    request.onreadystatechange = processReqChange;

    	    request.open("GET", "busca_usuario.php?usuario=" + encodeURIComponent(field.value));

    	    request.send(null);

    	}

	}else{

		alert("Tienes que ingresar un valor");

		field.focus();

	}

}



function processReqChange() {

    var result = document.getElementById("result");



    if (request.readyState == 4) {

        if (request.status == 200) {

            result.innerHTML = request.responseText;

        }

    } else {

        result.innerHTML = "Buscando Usuarios Existentes...";

    }

}

function cargar(Obj){
		Obj.focus()
}

function nuevoAjax(){

  var xmlhttp=false;

  try {

   // Creaci?n del objeto ajax para navegadores diferentes a Explorer

   xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

  } catch (e) {

   // o bien

   try {

     // Creaci?n del objet ajax para Explorer

     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (E) {

     xmlhttp = false;

   }

  }



  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {

   xmlhttp = new XMLHttpRequest();

  }

  return xmlhttp;

}



function valida(){

	if(document.f1.usuario.value==""){

		alert("ERROR: Por favor ingrese Usuario");

		document.f1.usuario.focus();

		return false();

	}else if(document.f1.password.value==""){

		alert("ERROR: Por favor ingrese Password");

		document.f1.password.focus();

		return false();

	}



	document.f1.action='validacion.php';

	document.f1.submit();

}

function validar_opciones(opcion,id){

	if(document.f1.productos.value==""){

		alert("ERROR: Por favor selecione el producto");

		document.f1.productos.focus();

		return false

	}else if(document.f1.atributos.value==""){

		alert("ERROR: Por favor selecione el atributo");

		document.f1.atributos.focus();

		return false

	}else if(document.f1.atributos_valores.value==""){

		alert("ERROR: Por favor selecione el valor del atributo");

		document.f1.atributos_valores.focus();

		return false

	}else if(document.f1.precio.value==""){

		alert("ERROR: Por favor ingrese el precio");

		document.f1.precio.focus();

		return false

	}else if(document.f1.prefijo.value==""){

		alert("ERROR: Por favor ingrese el prefijo");

		document.f1.prefijo.focus();

		return false

	}else{

		document.f1.action="opciones.php?opcion=add";

		document.f1.submit();

	}

}



function validar_usuarios(opcion, id){

	if(document.f1.nombre.value==""){

		alert(" ERROR: Por favor ingrese el nombre ");

		document.f1.nombre.focus();

		return false

	}else if(document.f1.apellidos.value==""){

		alert(" ERROR: Por favor ingrese el apellido ");

		document.f1.apellidos.focus();

		return false

	}else if(document.f1.email.value==""){

		alert(" ERROR: Por favor ingrese el email ");

		document.f1.email.focus();

		return false

	}else if(document.f1.rol.value==""){

		alert(" ERROR: Por favor Seleccione un rol ");

		document.f1.rol.focus();

		return false

	}else if(document.f1.usuario.value==""){

		alert(" ERROR: Por favor ingrese un admin \n que le servira para logearse en el sistema ");

		document.f1.usuario.focus();

		return false

	}else if(document.f1.password.value==""){

		alert(" ERROR: Por favor ingrese el password \n que le servira para ingresar al sistema ");

		document.f1.password.focus();

		return false;

	}else{

		document.f1.action='usuarios.php?opcion='+opcion+'&id='+id;

		document.f1.submit();

	}

}

function validar_categorias(opcion, id1, id){

	if(document.f1.nombre.value==""  ){
		alert(" ERROR: Por favor ingrese el nombre de categoria ");
		document.f1.imagen.focus();
		return false

	}else if(document.f1.imagen.value=="" && opcion =="addc"){
		alert(" ERROR: Por favor ingrese la imagen de categoria ");
		document.f1.imagen.focus();
		return false

	}else{
		document.f1.action='productos.php?opcion='+opcion+'&id1='+id1+'&id='+id
		document.f1.submit();
	}

}



function validar_roles(opcion, id){

	if(document.f1.nombre.value==""){
		alert(" ERROR: Por favor ingrese el nombre del Rol ");
		document.f1.nombre.focus();
		return false

	}else{
		document.f1.action='roles.php?opcion='+opcion+'&id='+id;
		document.f1.submit();
	}

}



function validar_fabricantes(opcion, id){

	if(document.f1.nombre.value==""){

		alert(" ERROR: Por favor ingrese el nombre del Rol ");

		document.f1.nombre.focus();

		return false;

	}else{

		document.f1.action='fabricantes.php?opcion='+opcion+'&id='+id;

		document.f1.submit();

	}

}



function validar_novedades(opcion, id){

	if(document.f1.disponible.value==""){

		alert(" ERROR: Por favor ingrese la fecha de lanzamiento ");

		document.f1.disponible.focus();

		return false;

	}else{

		document.f1.action='novedades.php?opcion='+opcion+'&id='+id;

		document.f1.submit();

	}

}



function validar_ofertas(opcion, id){

	if(document.f1.precio.value==""){

		alert(" ERROR: Por favor ingrese el precio");

		document.f1.precio.focus();

		return false;

	}else{

		document.f1.action='ofertas.php?opcion='+opcion+'&id='+id;

		document.f1.submit();

	}

}



function validar_atributos(opcion, id){
		if(document.f1.nombre.value==""){
			alert(" ERROR: Por favor ingrese el nombre del Atributo ");
			document.f1.nombre.focus();
			return false
		}else{
			document.f1.action = 'atributos.php?opcion='+opcion+'&id='+id;
			document.f1.submit();
		}
}


function validar_atributos_valores(opcion, id1, id){
	if(document.f1.nombre.value==""){
		alert(" ERROR: Por favor ingrese el nombre del Valor ");
		document.f1.nombre.focus();
		return false
	}else{
		document.f1.action = 'atributos_valores.php?opcion='+opcion+'&id1='+id1+'&id='+id;
		document.f1.submit();
	}
}



function validar_productos(opcion, id1, id){
	if(document.f1.nombre.value==""){
		alert(" ERROR: Por favor ingrese el nombre del producto ");
		document.f1.nombre.focus();
		return false
	}else if(document.f1.descripcion.value==""){
		alert(" ERROR: Por favor ingrese la descripcion del producto ");
		document.f1.descripcion.focus();
		return false
	}else if(document.f1.categoria.value==""){
		alert(" ERROR: Por favor ingrese la categoria del producto ");
		document.f1.categoria.focus();
		return false
	}else{
		document.f1.action='productos.php?opcion='+opcion+'&id1='+id1+'&id='+id
		document.f1.submit();
	}
}



function recuperar_acceso(){
		location.replace('index.php?opcion=recuperar');
}

function eliminar_sesion(){
	location.replace('salir.php');
}

function mantenimiento_categoria(url,opcion,id1,id){
	if(opcion!="deletep" && opcion!="deletec"){
		location.replace(url+'?id='+id+'&opcion='+opcion+'&id1='+id1);
	}else if(opcion=="delete"){
		if(!confirm("Esta Seguro que desea Eliminar el Registro")){
			return false;
		}else{
			location.replace(url+'?id='+id+'&opcion='+opcion+'&id1='+id1);

		}

	}

}



function mantenimiento(url,id,opcion){
	if(opcion!="delete"){
		location.replace(url+'?id='+id+'&opcion='+opcion);
	}else if(opcion=="delete"){
		if(!confirm("Esta Seguro que desea Eliminar el Registro")){
			return false;
		}else{
			location.replace(url+'?id='+id+'&opcion='+opcion);

		}

	}

}



function pasa_precio(Obj, receptor, oferta){
	if(Obj.value!=""){
		var indice= Obj.selectedIndex;
		var texto=Obj.options[indice].text;
		var precio=texto.split("US$");
		receptor.value=precio[1];
		oferta.readOnly="";
		oferta.focus();
	}else{
		receptor.value="";
		oferta.readOnly="true";
	}

}



function compara_monto(precio, oferta){
	if(precio.value!=""){
		if(parseFloat(oferta.value) >= parseFloat(precio.value)){
			alert("El precio de la oferta tiene que ser menor al precio del producto: "+precio.value );
			oferta.value="";
			oferta.focus();
		}

	}

}

function mantenimiento_det(url, id1){
			location.replace(url+'?id1='+id1);
}

function validar_delete(){
	if(!confirm("Esta Seguro que desea Eliminar el Registro")){
		return false;
	}else{
		return true;
	}

}

function doRound(x, places) {
  return Math.round(x * Math.pow(10, places)) / Math.pow(10, places);
}



function suma_impuesto(precio, impuesto, precioi){
		if(impuesto.value!="" && precio.value!=""){
			if(impuesto.value==0){
				precioi.value = parseFloat(precio.value);
			}else{
				prec = parseFloat(precio.value),
				indice = impuesto.selectedIndex;
				imp = impuesto.options[indice].value;
				impu = imp.split("-");
				preci = parseFloat(prec + ((parseFloat(impu[1]) * prec) / 100));
				precioi.value = doRound(preci,4);
			}

		}else{

			return false;

		}

	}



	function calcula_precio(total, impuesto, precio){
		if(impuesto.value!="" && total.value!=""){
			if(impuesto.value==0){
				precio.value=total.value
			}else{
				tot = parseFloat(total.value);
				indice = impuesto.selectedIndex;
				imp = impuesto.options[indice].value;
				impu = imp.split("-");
				//preci = parseFloat(tot - ((parseFloat(impu[1]) * tot) / 100));
				preci = parseFloat(tot / ((parseFloat(impu[1]) / 100) + 1) )
				precio.value = doRound(preci, 8);
			}

		}

	}



	function pasarEmail(repositorio, destinatarios){

		var rep = repositorio;
		var emails;
		var coincidencias = 0;
		for(var i=0; i < rep.length; i++){
			if(rep.options[i].selected == 1){
				if(destinatarios.value == ""){
					destinatarios.value = rep.options[i].value;
				}else{
					emails = destinatarios.value.split(",")
					coincidencias = 0;
					for(var x = 0; x < emails.length; x++){
						if(rep.options[i].value == emails[x]){
						coincidencias++;
						}

					}

					if(coincidencias == 0){

						destinatarios.value += "," + rep.options[i].value;

					}

				}

			}

		}

	}



	function validar_boletin(){

		if(document.f1.destinatarios.value==""){
			alert("ERROR: por favor ingrese los destinatarios");
			document.f1.destinatarios.focus();
			return false
		}else if(document.f1.asunto.value==""){
			alert("ERROR: por favor ingrese el asunto");
			document.f1.asunto.focus();
			return false
		}else if(document.f1.mensaje.value==""){
			alert("ERROR: por favor ingrese el mensaje");
			document.f1.mensaje.focus();
			return false
		}else{
			return true
		}

	}



	function cargar_reporte(){
		window.open();
	}


function validnum(e) {
	tecla = (document.all) ? e.keyCode : e.which;
	//alert(tecla)
    if (tecla == 8 || tecla == 46) return true; //Tecla de retroceso (para poder borrar)
    // dejar la l?nea de patron que se necesite y borrar el resto
    //patron =/[A-Za-z]/; // Solo acepta letras
    patron = /\d/; // Solo acepta n?meros
    //patron = /\w/; // Acepta n?meros y letras
    //patron = /\D/; // No acepta n?meros
    // patron = /[\d.-]/; numeros el punto y el signo -
    te = String.fromCharCode(tecla);
    return patron.test(te);
	// uso  onKeyPress="return validnum(event)"
}



function removerDiv(HijoE){
	$("#"+HijoE).fadeOut('slow', function() { $(this).remove();});
}

function mantenimiento_det(url, id1){
	location.replace(url+'?id1='+id1);
}

function delete_escaneo(){
	var f1 = eval("document.fe");
	$("#msg_delete").hide();
	if(f1.qdocumento.length > 0){

		for(var i=0; i < f1.qdocumento.length; i++){
			if(f1.qdocumento[i].checked == 1){
				var id = f1.qdocumento[i].value;
				$(".escaneo" + id).fadeOut('slow');
				$("#msg_delete").load("delete_escaneo.php?id="+id).fadeIn("slow");

			}

		}

	}else{

		if(f1.qdocumento.checked == 1){

			var id = f1.qdocumento.value;

			$(".escaneo" + id).fadeOut('slow');

			$("#msg_delete").load("delete_escaneo.php?id="+id).fadeIn("slow");

		}

	}

}



function valida_archivos(){

	var f1 = eval("document.fe");
	var tot	= document.fe.elements['doc[]'];

	if(tot.length > 0){
		for(var t = 0; t < tot.length; t++){
			if(tot[t].value == ""){
				alert(" Ingrese la ruta del archivo a subir ");
				tot[t].focus();
				return false;
			}

		}

	}else if(tot.value == ""){
		alert(" Ingrese la ruta del archivo ");
		tot.focus();
		return false;
	}

	f1.submit();
}



function checkTheKey(keyCode){

	if(event.keyCode==13){
		valida();
		return true ;
	}
	return false ;

}



function validar_historial_atencion(id){
		document.f1.action = 'atencion_acceso_registro.php?opcion=addha&id='+id;
		document.f1.submit();
}



var theObj="";

function toolTips(text,me){



	   theObj=me;

       theObj.onmousemove=updatePos;

       document.getElementById('toolTipBox').innerHTML=text;

       document.getElementById('toolTipBox').style.display="block";

       window.onscroll=updatePos;

}



function updatePos() {

       var ev=arguments[0]?arguments[0]:event;

       var x=ev.clientX;

       var y=ev.clientY;

       diffX=24;

       diffY=0;

       document.getElementById('toolTipBox').style.top  = y-2+diffY+document.body.scrollTop+ "px";

       document.getElementById('toolTipBox').style.left = x-2+diffX+document.body.scrollLeft+"px";

       theObj.onmouseout=hideMe;

}



function hideMe() {

	document.getElementById('toolTipBox').style.display="none";

}



num_cp = 0;

function crearCarchivo(){


	var tot_atrib = document.fe.elements['doc[]'];
	if(typeof tot_atrib == 'undefined'){
		var tota = 0;
	}else if(tot_atrib.value == ""){
		var tota = 1;
	}else{
		var tota = tot_atrib.length;
	};


	$(".ileft_img").append("<div id='cp_item_"+ tota + "' class='desc'></div>");

	$("#cp_item_"+ tota).append("<label for='imagen'>Documento :</label><input type='file' id='doc[]' name='doc[]' size='41' />");

	$("#cp_item_"+ tota).fadeIn("slow");



	num_cp ++;

}



function quitarCarchivo(){



	var tot_atrib = document.fe.elements['doc[]'];

	if(typeof tot_atrib == 'undefined'){

		var tota = 0;

	}else if(tot_atrib.value == ""){

		var tota = 0;

	}else {

		var tota = parseInt(tot_atrib.length - 1);

	}

	var div = "cp_item_"+ tota;

	removerDiv(div);

	num_cp--;

	//alert(div);

}



function removerDiv(HijoE){

	$("#"+HijoE).fadeOut('slow', function() { $(this).remove();});

}