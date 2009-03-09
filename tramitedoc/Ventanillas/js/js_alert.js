// JavaScript Document

function dif_fechas(hoy,est) { //alert(est);
 if(est==1){
	 //alert(est);
   //Obtiene los datos del formulario
   CadenaFecha2 = document.f1.FchR.value;
   CadenaFecha1 =hoy; 
   //alert(CadenaFecha2);
   //Obtiene dia, mes y año
   var fecha1 = new fecha( CadenaFecha1 )   
   var fecha2 = new fecha( CadenaFecha2 )
   
   //Obtiene objetos Date
   var miFecha1 = new Date( fecha1.anio, fecha1.mes, fecha1.dia )
   var miFecha2 = new Date( fecha2.anio, fecha2.mes, fecha2.dia )

   //Resta fechas y redondea
   var diferencia = miFecha1.getTime() - miFecha2.getTime()
   var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24))
   var segundos = Math.floor(diferencia / 1000)
   //alert ('La diferencia es de ' + dias + ' dias,\no ' + segundos + ' segundos.')
   if(dias<0) dias=0;
   document.f1.n_dias.value=dias;
   	var color="";
	if(dias>=8&&dias<15) color="#FFCC00";
	else if(dias>=15) color="#FF0000";
	else color="#00CC33";
	
	//alert()
	document.f1.n_dias.style.background=color;
    return false;
  } 
}

function fecha( cadena ) {
//Separador para la introduccion de las fechas
   var separador = "/"
   //Separa por dia, mes y año
   if ( cadena.indexOf( separador ) != -1 ) {
        var posi1 = 0
        var posi2 = cadena.indexOf( separador, posi1 + 1 )
        var posi3 = cadena.indexOf( separador, posi2 + 1 )
        this.dia = cadena.substring( posi1, posi2 )
        this.mes = cadena.substring( posi2 + 1, posi3 )
        this.anio = cadena.substring( posi3 + 1, cadena.length )
   } else {
        this.dia = 0
        this.mes = 0
        this.anio = 0   
   }
}

function activador(x){
	var form=eval('document.f1');
	var mon;
	if(x.value=='s'){ 
		form.soles.disabled=false;
		form.dolares.disabled=true;
		form.soles.focus();
	}
	else{
		form.soles.disabled=true;
		form.dolares.disabled=false;
		form.dolares.focus();
	} 
}

function validar(dir){
	var form=eval("document.f1");
	
	if(form.FchR.value==""){
		alert("Debe ingresar una Fecha para el envio"); return false;
	} 
	
	form.action="alerta_remision.php?opcion=add&ids="+dir;
	form.submit(); return true;
}

function validar_dt(dir){
	var form=eval("document.f1");
	if(form.soles.value>0){
			form.soles.disabled=false;
			form.action="alerta_remision.php?opcion=add_dt&ids="+dir;
			form.submit(); return true;
	}else{
		alert("No puede Guardar si no ha ingresado Montos de algun Tipo");
		return false;
	}
}

function mant(opc,dir){
	var form=eval("document.f1");
	if(opc=='del_dt'&&!confirm("Esta Seguro que desea Eliminar la Remisión")){
		return false;
	}else{
		form.action="alerta_remision.php?opcion="+opc+"&ids="+dir;
		form.submit(); return true;
	}	
}

	
function verif(x){
	if(x.value=="") x.value=0;
	else{
		var form=eval("document.f1");
		var mon;
		for (var i=0;i<form.moneda.length;i++){ 
       			if (form.moneda[i].checked){
					mon=form.moneda[i].value;
				break; }
    	}	 
    	//alert("-".mon); 
		if(mon=='s'){ 
			if(form.tc.value==0) form.dolares.value='Falta VC';
			else form.dolares.value=parseFloat(form.soles.value/form.tc.value);
		}
		if(mon=='d'){
			if(form.tc.value==0) form.soles.value='Falta VC';
			else form.soles.value=parseFloat(form.dolares.value*form.tc.value);
		}
	}
}