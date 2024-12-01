/*======================================================================================================*/
/*							estas lineas son para utilizar el ajax										*/
/*======================================================================================================*/
function getXMLHTTPRequest(){
		try{
			xhttp = new XMLHttpRequest();
		}catch(err1){
			try {
				xhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}catch (err2) {
				try {
					xhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}catch (err3) {
					xhttp = false;
				}
			}
		}
		return xhttp;
	}
	
	var http = getXMLHTTPRequest();



$(document).ready(function(){
	var oculto = false;
	
	function Ocultar(){
		//$("#divRES").html("")  esto limpia el div Res desde el inicio de cada pagina
        $('#divBusqueda').slideUp("normal");
        $("#Mostrar").css({"visibility":"visible"})
        $("#up-down").attr("src","../../img/down.png")
		oculto = !oculto
	}
	$("#Activo, #Inactivo, #Eliminado, #Todos").click(function(){
       Ocultar();
	})
	
	Ocultar();
	/*
	$("#NttyActivo, #NttyInactivo, #NttyEliminado").click(function(){
       Ocultar();
	})
	$("#BDActivo, #BDInactivo, #BDEliminado").click(function(){
       Ocultar();
	})
	$("#MsgDActivo, #MsgDInactivo, #MsgDEliminado").click(function(){
       Ocultar();
	})*/
	
	$("#Mostrar").click(function(e){
        e.preventDefault()
        if(oculto){
            $('#divBusqueda').slideDown("normal")
            $("#up-down").attr("src","../../img/up.png")
        }
        else{
            $('#divBusqueda').slideUp("normal")
            $("#up-down").attr("src","../../img/down.png")
        }
        oculto = !oculto
    })
	
	$("#cerrar").live("click",function(){
		$("#base").fadeOut("normal");
		if(Existe('base2')){
			$("#base2").fadeOut("normal");
		}
		if(Existe('base3')){
			$("#base3").fadeOut("normal");
		}
		if(Existe('base4')){
			$("#base4").fadeOut("normal");
		}
	})
        $(".cerrarDM").live("click",function(){
		$("#base").fadeOut("normal");
		if(Existe('base2')){
			$("#base2").fadeOut("normal");
		}
		if(Existe('base3')){
			$("#base3").fadeOut("normal");
		}
		if(Existe('base4')){
			$("#base4").fadeOut("normal");
		}
                BuscaDepositoManual();
                if(Existe("hindice")){
                                document.getElementById("hindice").value = 0;
                }
	})
        $(".cerrarDA").live("click",function(){
		$("#base").fadeOut("normal");
		if(Existe('base2')){
			$("#base2").fadeOut("normal");
		}
		if(Existe('base3')){
			$("#base3").fadeOut("normal");
		}
		if(Existe('base4')){
			$("#base4").fadeOut("normal");
		}
                BuscaDepositoAutomatico();
                if(Existe("hindice")){
                                document.getElementById("hindice").value = 0;
                }
	})
        
       //Check para ocultar el filtro de busqueda
                $(".area_contenido").mouseover(function(){
                                $("#chkfiltro").css({"display":"inline"})
                })
                $(".area_contenido").mouseout(function(){
                                $("#chkfiltro").css({"display":"none"})
                })
                
                $("#chkfiltro").click(function(){
                                if($("#chkfiltro").is(":checked")){
                                     $("#tbusqueda").fadeIn("normal");           
                                }else{
                                     $("#tbusqueda").fadeOut("normal");           
                                }
                })
        
        
 //FUNCIONES PARA MOSTRAR LOS DIVS DE ANTERIOR - SIGUIENTE FLECHAS

                
$(".ulPrealta li").live("click",function(){
                $("#nomdat").html($(this).text()); 
                  if(Existe("PA"+index))
                    $("#PA"+index).css({"display":"none"})
     			  if(Existe("Aux"+index))
					$("#Aux"+index).css({"display":"none"})
                  index = $(".ulPrealta li").index($(this));
                  if(index > 0){
                    if(Existe("PA"+index))
                      $("#PA"+index).fadeIn("normal");
                }
})
        
        
})


var index = 1;
function Anterior(){
  if(Existe("PA"+index))
    $("#PA"+index).css({"display":"none"})
  if(Existe("Aux"+index))
    $("#Aux"+index).css({"display":"none"})
  index-= 1;
  if(index > 0){
    if(Existe("PA"+index))
      $("#PA"+index).fadeIn("normal");     
  }else{
    index+= 1;
    if(Existe("PA"+index))
      $("#PA"+index).fadeIn("normal"); 
  }
}

function Siguiente(){
  var t = $(".ulPrealta li").size();
  if(Existe("PA"+index))
    $("#PA"+index).css({"display":"none"})
  if(Existe("Aux"+index))
    $("#Aux"+index).css({"display":"none"})
  index+= 1;
  if(index < t){
    if(Existe("PA"+index))
      $("#PA"+index).fadeIn("normal");    
  }else{
    index-= 1;
    if(Existe("PA"+index))
      $("#PA"+index).fadeIn("normal");
  }
}





/*=====================================================================*/
/*                           Validaciones                              */
/*=====================================================================*/
function validaNumeroEntero(e){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
	if((tecla==8) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){ return true;}else{return false;} 	
}

function validaNumeroDouble(e,txt){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
	
	if((tecla==8) || (tecla==46) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){
		txt =  document.getElementById(txt).value;
		if(txt.indexOf(".") > -1 && (tecla==46))
			return false;
			
		return true;
	}
	return false;
}
function validaNumeroDoubleRegex(txt){
	
	txt =  document.getElementById(txt);
	
	if(txt != null)
	{
		var RegExPattern = /(^\d*\.?\d{0,4}$)|(^[1-9]+\d*\.\d{0,4}$)$/;
		
		if ((txt.value!='') && (txt.value.match(RegExPattern))) {
			return true;
		}
	}
	return false;
}

function validarEmail(valor) {
	valor = document.getElementById(valor).value;
	re=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
     if(re.exec(valor))    {
          //alert("Si");
		  return true;
     }else{
         //alert("No");
		 return false;
     }
}

function validaTelefono(valor) {
	valor = document.getElementById(valor).value;
	re=/\d{2}\-\d{3}\-\d{3}\-\d{4}$/
     if(re.exec(valor))    {
          //alert("Si");
		  return true;
     }else{
         //alert("No");
		 return false;
     }
}

function validaTelefono1(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el keypress						  	  */
	/*====================================================================================================*/
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
		
	/*la tecla 47 es el Diagonal [ / ]    la tecla  45 es el Guio  [ - ]  */
	var separador = 45;
	if((tecla==8) || (tecla==separador) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){
		txt =  document.getElementById(txt).value;
		switch(txt.length){
			case 2:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 6:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 10:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			default:
				if(tecla < 48 && tecla != 8){
					return false;
				}if(tecla > 57){
					return false;
				}
				return true;
			break;
		}
		
		return true;
	}
	return false;
}
function validaTelefono2(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el onkeyup						  	  */
	/*====================================================================================================*/
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
	
	if(tecla != 8){
		txtVal =  document.getElementById(txt).value;
			//if(txt.indexOf(".") > -1 && (tecla==45))
				//return false;
				//alert(txt.length);
		switch(txtVal.length){
			case 2:
				 document.getElementById(txt).value = txtVal+"-";
			break;
			case 6:
				 document.getElementById(txt).value = txtVal+"-";
			break;
			case 10:
				 document.getElementById(txt).value = txtVal+"-";
			break;
		}
	}
}

/*====================================================================================================*/
/* esta funcion valida horas con formato de 24     		    en el keypress						  	  */
/*====================================================================================================*/
function validaHoras(e,txt){
	if( window.event)  
		var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
		
	/*la tecla 47 es el Diagonal [ / ]    la tecla  45 es el Guio  [ - ]     la tecla 58 son los 2 puntos [ : ] */
	
	var separador = 58;
	if((tecla==8) || (tecla==separador) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){
		txt =  document.getElementById(txt).value;
		
		switch(txt.length){
			case 0:		
				if(tecla > 47 && tecla < 51 || tecla == 8) /*para los numero 012 en el primer dijito*/
					return true;
			break;
			case 1:
				if(txt.substring(0,1) == 2){
					if(tecla > 48 && tecla < 52 || tecla == 8)
						return true;
					else
						return false;	
				}
				return true;
			break;
			case 2:
				if(tecla == separador || tecla == 8)
					return true;
				else
					return false;
			break;
			case 3:
				if(tecla > 47 && tecla < 54 || tecla == 8) /*para los numero 012345 en el primer dijito*/
					return true;
				else 
					return false;
			break;
			case 4:
				return true;
			break;
		}
		
		return false;
	}
	return false;
}

function validaHoras2(e,txt){
	if( window.event)  
		var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
	
	if(tecla != 8){
	txtVal =  document.getElementById(txt).value;
		switch(txtVal.length){
			case 2:
				 document.getElementById(txt).value = txtVal+":";
			break;
		}
	}
}

function validaHorasRegexCtrl(txt) {
	valor = document.getElementById(txt).value;
	re=/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/
	 if(re.exec(valor))    {
		  alert("Si");
		  //return true;
	 }else{
		 alert("No");
		 //return false;
	 }
}
function validaHorasRegex(valor){
	re=/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/;
	if(re.exec(valor))    {
		  //alert("Si");
		  return true;
	 }else{
		 //alert("No");
		 return false;
	 }
}

function validaCadena(e){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		tecla = (document.all) ? e.keyCode : e.which; 

	if((tecla==8) || (tecla==32) || (tecla >= 65 && tecla <= 90) || (tecla >= 97 && tecla <= 122) && (tecla != 16)){ return true;}else{return false;} 
}

function validaCadenaANDNumero(e){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		tecla = (document.all) ? e.keyCode : e.which; 

	if((tecla==8) || (tecla==32) || (tecla >= 65 && tecla <= 90) || (tecla >= 48 && tecla <= 57) || (tecla >= 97 && tecla <= 122) && (tecla != 16)){ return true;}else{return false;} 
}

function validaNumeroIP(e,num){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
	
	if(tecla==46 && num < 4){ document.getElementById('ip'+(num+1)).focus(); return false; }
	
	if((tecla==8) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){ return true;}else{return false;} 	
}

function validaNumeroIPUp(e,num){
	
	if(document.getElementById('ip'+num).value > 255)
	{
		document.getElementById('ip'+num).value = 255;
	}
	
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 

	if(num < 4 && document.getElementById('ip'+num).value.length == 3){ document.getElementById('ip'+(num+1)).focus(); return false; }

	if(tecla==8 && num > 1 && document.getElementById('ip'+num).value.length == 0){ document.getElementById('ip'+(num-1)).focus(); return false; }	
}

function validaNumeroMAC(e,num){

	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
	if(tecla==46 && num < 8){ document.getElementById('mac'+(num+1)).focus(); return false; }
	
	if((tecla==8) || (tecla >= 48 && tecla <= 57) || (tecla >= 65 && tecla <= 70) || (tecla >= 97 && tecla <= 102) && (tecla != 16)){ return true;}else{return false;} 	
}

function validaNumeroMACUp(e,num){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 

	if(num < 8 && document.getElementById('mac'+num).value.length == 4){ document.getElementById('mac'+(num+1)).focus(); return false; }

	if(tecla==8 && num > 1 && document.getElementById('mac'+num).value.length == 0){ document.getElementById('mac'+(num-1)).focus(); return false; }	
}

/*====================================================================================================*/
	/* esta funcion valida las fechas con formatos    AAAA/MM/DD    en el onkeypress					  */
	/*====================================================================================================*/
function validaFecha(e,txt){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
		
	/*la tecla 47 es el Diagonal [ / ]    la tecla  45 es el Guio  [ - ]  */
	var separador = 45;
	if((tecla==8) || (tecla==separador) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){
		txt =  document.getElementById(txt).value;
		switch(txt.length){
			case 4:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 7:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			default:
				if(tecla < 48 && tecla != 8){
					return false;
				}if(tecla > 57){
					return false;
				}
				return true;
			break;
		}
		
		return true;
	}
	return false;
}
function validaFecha2(e,txt){
	/*====================================================================================================*/
	/* esta funcion valida las fechas con formatos    AAAA/MM/DD    en el onkeyup						  */
	/*====================================================================================================*/
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
	
	if(tecla != 8){
	txtVal =  document.getElementById(txt).value;
		//if(txt.indexOf(".") > -1 && (tecla==45))
			//return false;
			//alert(txt.length);
	switch(txtVal.length){
		case 4:
			 document.getElementById(txt).value = txtVal+"-";
		break;
		case 7:
			 document.getElementById(txt).value = txtVal+"-";
		break;
	}
	}
}

/*====================================================================================================*/
/* esta funcion valida las fechas con formatos    DD/MM/AAAA    en el onkeypress					  */
/*====================================================================================================*/
function validaFecha3(e,txt){
if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
		
	/*la tecla 47 es el Diagonal [ / ]    la tecla  45 es el Guio  [ - ]  */
	var separador = 47;
	if((tecla==8) || (tecla==separador) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){
		txt =  document.getElementById(txt).value;
		switch(txt.length){
			case 2:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 5:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			default:
				if(tecla < 48 && tecla != 8){
					return false;
				}if(tecla > 57){
					return false;
				}
				return true;
			break;
		}
		
		return true;
	}
	return false;
}
function validaFecha4(e,txt){
	/*====================================================================================================*/
	/* esta funcion valida las fechas con formatos    DD/MM/AAAA    en el onkeyup						  */
	/*====================================================================================================*/
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
	
	if(tecla != 8){
	txtVal =  document.getElementById(txt).value;
		//if(txt.indexOf(".") > -1 && (tecla==45))
			//return false;
			//alert(txt.length);
	switch(txtVal.length){
		case 2:
			 document.getElementById(txt).value = txtVal+"/";
		break;
		case 5:
			 document.getElementById(txt).value = txtVal+"/";
		break;
	}
	}
}


function validaFechaRegex(txt){
	
	txt =  document.getElementById(txt);
	
	if(txt != null)
	{
		var RegExPattern = /([0-9]{4})-([0-9]{2})-([0-9]{2})$/;
		
		if ((txt.value!='') && (txt.value.match(RegExPattern))) {
			return true;
		}
	}
	return false;
}

/*=====================================================================*/
/*                              Funciones                              */
/*=====================================================================*/
function validaSession(x){
	if(x == 10000000 || x == "10000000" || x == "10000000|XYZ.,;"){
		location.reload(true);
	}
}

function txtValue(txt){
	try{
                return	document.getElementById(txt).value;
	}catch(e){ alert(e.description+" "+txt); return "";}
}
function getDivHTML(div){
	try{
                return	document.getElementById(div).innerHTML;
	}catch(e){ alert(e.description+" "+div); return "";}
}
function setValue(ctrl,valor){
	try{
		document.getElementById(ctrl).value = valor;
	}catch(e){ alert(e.description+" "+ctrl); }
}
function setDivHTML(div,valor){
	try{
		document.getElementById(div).innerHTML= valor;
	}catch(e){ alert(e.description+" "+div); }
}

function Recargar(url) {
	  window.location.href = url;
}
function SubmitForm(form) {
	  document.forms[form].submit();
}
function setActionForm(form,actionx) {
	  document.forms[form].action = actionx;
}

function Bloquear(ctrl){
	try{
    	document.getElementById(ctrl).disabled = true;
	}catch(e){ alert(e.description+" "+ctrl); return false;}
}
function Desbloquear(ctrl){
	try{
    	document.getElementById(ctrl).disabled = false;
	}catch(e){ alert(e.description+" "+ctrl); return false;}
}
function DisplayNone(div){
	try{
		document.getElementById(div).style.display = "none";
	}catch(e){ alert(e.description+" "+div);}
}
function DisplayBlock(div){
	try{
		document.getElementById(div).style.display = "block";
	}catch(e){ alert(e.description+" "+div); }
}

function VisibilityDivHidden(div){
	try{
		document.getElementById(div).style.visibility = "hidden";
	}catch(e){ alert(e.description+" "+div);}
}
function VisibilityDiv(div){
	try{
		document.getElementById(div).style.visibility = "visible";
	}catch(e){ alert(e.description+" "+div); }
}

function Check(cb) {
	try{
	  return document.getElementById(cb).checked;
	}catch(e){ alert(e.description+" "+cb); }
}
function CheckTrue(cb) {
	try{
	  return document.getElementById(cb).checked = true;
	}catch(e){ alert(e.description+" "+cb); }
}
function CheckFalse(cb) {
	try{
	  return document.getElementById(cb).checked = false;
	}catch(e){ alert(e.description+" "+cb); }
}

function Existe(ctrl){
	var d = document.getElementById(ctrl);
	if(d != null){
		return true;
	}
	return false;
}

function getTextSelect(ddl){
	try{
	var combo = document.getElementById(ddl);
	var selected = combo.options[combo.selectedIndex].text;	
	return selected;
	}catch(e){ alert(e.description+" "+ddl); }
}
/*=== PARA MOSTRAR LOS POP UPS===*/	
function MostrarPopUp(contenido){
	//$("#base").css({"visibility":"visible"});
	if(Existe('base')){
		//DisplayBlock('base');
		$("#base").fadeTo("normal",0.4);
	}
	if(Existe('base2')){
		$("#base2").fadeIn("normal");
	}
	if(Existe('base3')){
		$("#base3").fadeIn("normal");
	}
	if(Existe('base4')){
		$("#base4").fadeIn("normal");
	}
	
	try{
	//alert(contenido);
	document.getElementById('ContentPopUp').innerHTML = contenido;
	}catch(e){ alert("No existe el PopUp para mostrar datos");}
}

/*=== PARA OCULTAR LOS POP UPS===*/
function OcultarPopUps(){
	$("#base").fadeOut("normal");
	if(Existe('base2')){
		$("#base2").fadeOut("normal");
	}
	if(Existe('base3')){
		$("#base3").fadeOut("normal");
	}
	if(Existe('base4')){
		$("#base4").fadeOut("normal");
	}
}

/*==============================================================================================*/
/*									Ir de una pagina a otra										*/				
/*==============================================================================================*/
function irAForm(form,rutaIda,rutaVuelta){
	if(Existe('hRutaX') && (rutaVuelta != null && rutaVuelta != ""))
		setValue('hRutaX',rutaVuelta);
		
	setActionForm(form,rutaIda);
	SubmitForm(form);
}


//FUNCION QUE MANDA RELLENAR UN TEXT COMO SI FUESE GOOGLE
//SEL ES UNA VARIABLE QUE CONTIENE EL VALOR SELECCIONADO
var sel = -3;
var sel2 = -3;
var sel3 = -3;
function AutoCompletar(txt,url,x,lenx){
if(lenx == null)
	lenx = 2;
$(function() {
    $("#"+txt).autocomplete({
        source: url,
        minLength: lenx,
        select: function( event, ui ) {
            switch(x){
                case 1:sel =  ui.item.id;
                break;
                case 2:sel2 =  ui.item.id;
                break;
                case 3:sel3 =  ui.item.id;
                break;
                default:sel =  ui.item.id;
                break;
            }
        }
              
    });
  });
}


//Muestra un div emergente que contiene una imagen de cargando
//que indica que se esta esperandon una respuesta del servidor
function Emergente(){
	$("#emergente").css({"visibility":"visible"});
	$("#emergente").fadeTo("fast",0.4)
}

function OcultarEmergente(){
	$("#emergente").fadeOut("fast");
}



//es para validar la cantidad de registros a buscar en el paginador
//f es una variable para decidir a que funcion llamar

function validaCantidad(f,e){
	if(window.event) 
		if(e != null)
    	    var tecla = window.event.keyCode;//
		else
			var tecla = -1;
	else{
		if(e != null)
			var tecla = (document.all)?e.keyCode:e.which;
		else
			var tecla = -1;
	}
		if(document.getElementById("cpag").value != ""){
			$("#etbus").fadeTo("normal",0.8);
		//document.getElementById("etbus").style.display = "inline";
		var x = parseInt(document.getElementById("cpag").value);
		var t = parseInt(document.getElementById("totalreg").value);
	
		if(x > t)
			 document.getElementById("cpag").value = t;	 
		if(tecla==13 || tecla == -1){
			BusquedaPaginacion(f,x);
		}
	}else if(tecla == 8){
		$("#etbus").fadeOut("normal");
	}
}


//FUNCION QUE INDICA QUE FUNCION EJECUTAR EN LA PAGINACION
function BusquedaPaginacion(f,x){

	cant = x;
	document.getElementById("cpag").value = x;
	switch(f){
		case "BuscarOperaciones":BuscarOperaciones();
		break;
		case "BuscarMovimientos":BuscarMovimientos();
		break;
		case "BuscaSucursales":BuscaSucursales();
		break;
		case "BuscarProveedores":BuscarProveedores();
		break;
		case "BuscaReporteDepositoManual":BuscaReporteDepositoManual();
		break;
		case "BuscaReporteDepositoAuto":BuscaReporteDepositoAuto();
		break;
		case "BuscaDepositoManual":BuscaDepositoManual();
		break;
		case "BuscaDepositoAutomatico":BuscaDepositoAutomatico();
		break;
	}
		
}