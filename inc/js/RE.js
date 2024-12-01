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
	$("#emergente").fadeOut("fast");
	RellenarConf();

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

	$("#cerrar").on("click",function(){
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
        $(".cerrarDM").on("click",function(){
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
        $(".cerrarDA").on("click",function(){
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


$(".ulPrealta li").on("click",function(){
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

function validaEsNumeroEntero(data) {
	integer = parseInt(data);
	if ( data == integer ) {
		if ( integer > 0 ) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
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
	else{
		return false;
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
	//alert("tecla validaTelefono1: " + tecla);
	/*la tecla 47 es el Diagonal [ / ]    la tecla  45 es el Guio  [ - ]  */
	var separador = 45;
	//alert("e.ctrlKey: " + e.ctrlKey);
	if((tecla==8) || (tecla==separador) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){
		//alert("TEST");
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
	//alert("tecla validaTelefono2: " + tecla);
	//alert("e.CtrlKey: " + e.ctrlKey);
	//alert("e.ctrlKey: " + e.ctrlKey);
	//console.log("tecla: " + tecla);
	//console.log("e.ctrlKey: " + e.ctrlKey);
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

function validaUUID1(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el keypress						  	  */
	/*====================================================================================================*/
	if( window.event)
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which;
	//alert("tecla validaTelefono1: " + tecla);
	/*la tecla 47 es el Diagonal [ / ]    la tecla  45 es el Guio  [ - ]  */
	var separador = 45;
	//console.log("tecla: " + tecla);
	//alert("e.ctrlKey: " + e.ctrlKey);
	var teclaOK = false;
	if ( tecla >= 48 && tecla <= 57 ) {
		teclaOK = true;
	} else if ( tecla >= 65 && tecla <= 90 ) {
		teclaOK = true;
	} else if ( tecla >= 97 && tecla <= 122 ) {
		teclaOK = true;
	}
	if((tecla==8) || (tecla==separador) || teclaOK && (tecla != 16)){
		//alert("TEST");
		txt =  document.getElementById(txt).value;
		switch(txt.length){
			case 8:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 13:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 18:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 23:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			/*case 35:
				if(tecla != separador && tecla != 8)
					return false;
			break;*/
			default:
				/*if(tecla < 48 && tecla != 8){
					return false;
				}if(tecla > 57){
					return false;
				}*/
				return true;
			break;
		}

		return true;
	}
	return false;
}
function validaUUID2(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el onkeyup						  	  */
	/*====================================================================================================*/
	if( window.event)
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which;
	//alert("tecla validaTelefono2: " + tecla);
	//alert("e.CtrlKey: " + e.ctrlKey);
	//alert("e.ctrlKey: " + e.ctrlKey);
	//console.log("tecla: " + tecla);
	//console.log("e.ctrlKey: " + e.ctrlKey);
	if(tecla != 8){
		txtVal =  document.getElementById(txt).value;
			//if(txt.indexOf(".") > -1 && (tecla==45))
				//return false;
				//alert(txt.length);
		switch(txtVal.length){
			case 8:
				 document.getElementById(txt).value = txtVal+"-";
			break;
			case 13:
				 document.getElementById(txt).value = txtVal+"-";
			break;
			case 18:
				 document.getElementById(txt).value = txtVal+"-";
			break;
			case 23:
				 document.getElementById(txt).value = txtVal+"-";
			break;
			/*case 35:
				 document.getElementById(txt).value = txtVal+"-";
			break;*/
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
					if(tecla >= 48 && tecla <= 51 || tecla == 8)
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
	var valor = document.getElementById(txt).value;
	var re = /^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/;
	if ( re.exec(valor) ) {
		alert("Si");
	} else {
		alert("No");
	}
}
function validaHorasRegex(valor){
	var re = /^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/;
	if ( re.exec(valor) ) {
		return true;
	} else {
		return false;
	}
}

function validaCadenaConAcentos(e){
	if( window.event)
        var tecla = window.event.keyCode;//
	else
		tecla = (document.all) ? e.keyCode : e.which;

	if((tecla==8) || (tecla==32) || (tecla >= 65 && tecla <= 90) || (tecla >= 97 && tecla <= 122) && (tecla != 16) || (tecla >= 193 && tecla <= 250)){ return true;}else{return false;}
}

function validaCadena(e){
	if( window.event)
        var tecla = window.event.keyCode;//
	else
		tecla = (document.all) ? e.keyCode : e.which;

	if((tecla==8) || (tecla==32) || (tecla >= 65 && tecla <= 90) || (tecla >= 97 && tecla <= 122) && (tecla != 16)){ return true;}else{return false;}
}

function validaCadenaNumero(valor){
	re=/^[\w\s-.]*$/;
	if(re.exec(valor))    {
		  //alert("Si");
		  return true;
	 }else{
		 //alert("No");
		 return false;
	 }
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

function validaRFC(txt){
	var RFC =  document.getElementById(txt);
	if ( RFC != null ) {
		RFC = document.getElementById(txt).value;
		RFC = RFC.toUpperCase();
		var RegExPattern = /([A-Z]{4}|[A-Z]{3})[0-9]{6}[A-Z0-9]{3}$/;
		if ( RFC != '' ) {
			if ( RFC.match(RegExPattern) ) {
				return true;
			}
		}
	}
	return false;
}

function validaRFCPersona(txt){
	var RFC =  document.getElementById(txt);
	if ( RFC != null ) {
		RFC = document.getElementById(txt).value;
		RFC = RFC.toUpperCase();
		var RegExPattern = /[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$/;
		if ( RFC != '' ) {
			if ( RFC.match(RegExPattern) ) {
				return true;
			}
		}
	}
	return false;
}

function validaCURP(txt){
    var CURP =  document.getElementById(txt);
	if ( CURP != null ) {
		CURP = document.getElementById(txt).value;
		CURP = CURP.toUpperCase();
		var RegExPattern = /[A-Z]{4}[0-9]{6}(H|M)[A-Z]{5}[0-9]{2}$/;
		if ( CURP != '' ) {
			if ( CURP.match(RegExPattern) ) {
				return true;
			}
		}
	}
	return false;
}

function filtrarArchivos(file){
                var archivo = document.getElementById(file).value;
                var ext = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
                if(ext == ".jpg" || ext == ".pdf")
                   return true;
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
	try{
	  document.forms[form].submit();
	}catch(e){ alert(e.description+" "+form); return false;}
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
function DisplayInlineBlock(div){
	try {
		document.getElementById(div).style.display = "inline-block";
	} catch(e) {
		alert(e.description+" "+div);
	}
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
function AsignarImpFac(importe,factura){
	try{
	document.getElementById('importe2').value = importe;
	document.getElementById('idfactura').value = factura;
	}catch(e){alert("No existe importe2 o Factura");}
}
function getTextSelect(ddl){
	try{
	var combo = document.getElementById(ddl);
	var selected = combo.options[combo.selectedIndex].text;
	return selected;
	}catch(e){ alert(e.description+" "+ddl); }
}

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

/*==============================================================================================*/
/*									Ir de una pagina a otra										*/
/*==============================================================================================*/
function irAForm(form,rutaIda,rutaVuelta){
	if(Existe('hRutaX') && (rutaVuelta != null && rutaVuelta != ""))
		setValue('hRutaX',rutaVuelta);

	setActionForm(form,rutaIda);
	SubmitForm(form);
}



function RellenarConf(){

	var ddl = document.getElementById('ddlEntidad');
	if(ddl != null){

		var desc = document.getElementById('txtServDesc');
		if(desc != null){
			/* para rellenar la Descripcion del Servidor con la descripcion de la Entidad*/
			var d = ddl.options[ddl.selectedIndex].text;
				desc.value = d;

			/* para rellenar el Puerto con 0 a la izquierda del valor de la Entidad*/
			n = ddl.value.toString();
			while(n.length < 3) n = "0" + n;
			document.getElementById('txtPort').value = "21"+n;

			var logname = document.getElementById('txtServLogName');
			if(logname != null){
				window.setTimeout("GetCountServerPrio('"+n+"','"+d+"');",150);
			}

			/* para obtener la prioridad*/
			//window.setTimeout("GetProridadServ();", 200);
		}
	}
}

function exportarSeguimientoACorresponsales(){


	document.getElementById("emergente").style.display = "block";
	window.location="../../_Operaciones/Seguimiento/SeguimientoCorresponsales.php";


$.ajax({
    url: '../../_Operaciones/Seguimiento/SeguimientoCorresponsales.php',
    success: function(data) {

    },
    //error: function() {alert("error occurred.")},
    complete: function() { document.getElementById("emergente").style.display = "none"; }
});


}


function GetCountServerPrio(n,d){
	var ntty		= document.getElementById('ddlEntidad').value;
	var loc			= document.getElementById('ddlLocation').value;

	var parametros ="idNtty="+ntty+"&idLoc="+loc;

	http.open("POST","../../inc/Ajax/_Configuracion/PrioriConfServCount.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");
			validaSession(RESserv[0]);
			if(RESserv[0] == 0){
//				alert(RESserv[1]);
				var logname = document.getElementById('txtServLogName');
				logname.value = n+"_"+d+"_"+ RESserv[1];
				document.getElementById('txtPrioridad').value = RESserv[2];
			}
			else
			{
				alert("Error: "+RESserv[0]+" "+RESserv[1]);
			}

		}
	}
	http.send(parametros);

}
/*
function GetProridadServ(){
	try{
	var ntty		= document.getElementById('ddlEntidad').value;
	var loc			= document.getElementById('ddlLocation').value;

	var parametros ="idNtty="+ntty+"&idLoc="+loc;

	http.open("POST","../../inc/Ajax/_Configuracion/PrioridadConfServ.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;
			var RESserv = RespuestaServidor.split("|");

			if(RESserv[0] == 0){
//				alert(RESserv[1]);
				document.getElementById('txtPrioridad').value = RESserv[1];
			}
			else
			{
				alert("Error: "+RESserv[0]+" "+RESserv[1]);
			}

		}
	}
	http.send(parametros);
	}catch(e){alert(e.description);}
}

function GetCountServer(n,d){
	var ntty		= document.getElementById('ddlEntidad').value;
	var loc			= document.getElementById('ddlLocation').value;

	var parametros ="idNtty="+ntty+"&idLoc="+loc;

	http.open("POST","../../inc/Ajax/_Configuracion/CountConfServ.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;
			var RESserv = RespuestaServidor.split("|");//alert(RespuestaServidor);

			if(RESserv[0] == 0){
//				alert(RESserv[1]);
				var logname = document.getElementById('txtServLogName');
				logname.value = n+"_"+d+"_"+ RESserv[1];
			}
			else
			{
				alert("Error: "+RESserv[0]+" "+RESserv[1]);
			}

		}
	}
	http.send(parametros);

}
*/



/*=====================================================================*/
/*                            Busquedas                                */
/*=====================================================================*/
function Busca(url){
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			validaSession(RespuestaServidor);
			try{
			document.getElementById('divRES').innerHTML = RespuestaServidor;
				OcultarEmergente();
				Ordenar();
			}catch(e){alert(e.description);}
		}
	}
	http.send();
}
var cant = 20;
function Buscar(url,i){

	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);

			document.getElementById('divRES').innerHTML = RespuestaServidor;
			OcultarEmergente();
			Ordenar();
		}
	}
	http.send("actual="+i+"&cant="+cant);
}

function Ordenar(){
//	$("#tablaiso").tablesorter();
	if(document.getElementById("ordertabla") != null)
	{
		if(document.getElementById("ordertabla").rows.length > 1)
			$("#ordertabla").tablesorter({sortList:[[0,1],[2,1]], widgets: ['zebra']});
	}
}

function Ordenar2(){
//	$("#tablaiso").tablesorter();
	if(document.getElementById("ordertabla3") != null)
	{
		if(document.getElementById("ordertabla3").rows.length > 1)
			$("#ordertabla3").tablesorter({sortList:[[0,0],[2,1]], widgets: ['zebra']});
	}
}

function Ordenar3(){
//	$("#tablaiso").tablesorter();
	if(document.getElementById("ordertabla4") != null)
	{
		if(document.getElementById("ordertabla4").rows.length > 1)
			$("#ordertabla4").tablesorter({sortList:[[0,0],[2,1]], widgets: ['zebra']});
	}
}

/*=====================================================================*/
/*                    Busquedas  con parametros                        */
/*=====================================================================*/
/*function BuscarParamentros(url,parametros){
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);

			document.getElementById('divRES').innerHTML = RespuestaServidor;

		}
	}
	http.send(parametros);
}*/

//function BuscarParametros(url,parametros,i){
//
//	http.open("POST",url, true);
//	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//
//	http.onreadystatechange=function()
//	{
//		if (http.readyState==1)
//		{
//			//div para  [cargando....]
//			Emergente();
//		}
//		if (http.readyState==4)
//		{
//			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
//			document.getElementById('divRES').innerHTML = RespuestaServidor;//alert("ddd");
//			OcultarEmergente();
//			Ordenar();
//		}
//	}
//	http.send(parametros+"&actual="+i+"&cant="+cant);
//}

function BuscarParametros(url,parametros,div,i){

	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;
			validaSession(RespuestaServidor);
			if(div == null || div == ''){
				document.getElementById('divRES').innerHTML = RespuestaServidor;
				if ( $("#T2").length ) {
					$("#T2").remove();
				}
				if ( $("#cpag").length ) {
					$("#cpag").numeric({
						allowPlus: false,
						allowMinus: false,
						allowThouSep: false,
						allowLeadingSpaces: false,
						maxDigits: 3
					});
				}
				$('body').trigger('contenidocargado');
			}else{
				//document.getElementById(div).innerHTML = RespuestaServidor;
				setDivHTML(div,RespuestaServidor);
			}
			OcultarEmergente();
			Mostrar();
			Ordenar();
			Ordenar2();
			Ordenar3();
		}
	}
	http.send(parametros+"&actual="+i+"&cant="+cant);
}
function BuscarParametros2(url,parametros,div){

	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			validaSession(RespuestaServidor);
                        if(div == null || div == '')
                                document.getElementById(div).innerHTML = RespuestaServidor;//alert("ddd");
                        else{
                                //document.getElementById(div).innerHTML = RespuestaServidor;
								setDivHTML(div,RespuestaServidor);
                        }
			OcultarEmergente();
			Ordenar();
		}
	}
	http.send(parametros);
}

function BuscarParametros3(url,parametros,div,i,registrosPorPagina){

	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			validaSession(RespuestaServidor);
			if(div == null || div == ''){
				document.getElementById('divRES').innerHTML = RespuestaServidor;
				if ( $("#cpag").length ) {
					$("#cpag").numeric({
						allowPlus: false,
						allowMinus: false,
						allowThouSep: false,
						allowLeadingSpaces: false,
						maxDigits: 3
					});
				}
			}else{
				//document.getElementById(div).innerHTML = RespuestaServidor;
				setDivHTML(div,RespuestaServidor);
			}
			OcultarEmergente();
			Ordenar();
			Ordenar2();
			Ordenar3();
		}
	}
	http.send(parametros+"&actual="+i+"&cant="+registrosPorPagina);
}
/*=====================================================================*/
/*                              MetodAjax                              */
/*=====================================================================*/

function MetodoAjax(url,parametros){
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;
			var RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
				Recargar("Listado.php");
			}
			else
			{
				alert("Error: "+RESserv[0]+" "+RESserv[1]);
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];
			}
		}
	}
	http.send(parametros+"&pemiso="+true);
}


var contad = 0;
function MetodoAjax2(url,parametros){

	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;
			RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
                contad = 0;
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];

				alert(RESserv[1]);
                contad = 1;
			}
		}
	}
	http.send(parametros+"&pemiso="+true);
}

function MetodoAjax4(url,parametros){

	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;
			RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
                contad = 0;
                irAEditar();
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];

				alert(RESserv[1]);
                contad = 1;
			}
		}
	}
	http.send(parametros+"&pemiso="+true);
}
// Esta funcion se utiliza cuando se crea una nueva factura, en el codigo original utilizaba la funcion MetodoAjax4
function MetodoAjax5(url,parametros){

	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	http.onreadystatechange=function() {
            if (http.readyState==1) {
                Emergente();
            }
            if (http.readyState==4) {
                OcultarEmergente();
                var RespuestaServidor = http.responseText;//alert("respuesta "+RespuestaServidor);
                var RESserv = RespuestaServidor.split("|");
                validaSession(RESserv[0]);
                if(RESserv[0] == 0) {
                        alert(RESserv[1]);
                        if($("#idFactura").val() > 0){
                        	BuscarFacturaRecibo();
                        }
                        else{
                        	if($("#txtIdTipoProveedor").val() == 1){
                        		cargarStoreProveedoresExternos();
                    		}

                        	$('#formAlta').get(0).reset();
	                        validaTipoDcto();
                        }
                }
                else {
                    if(document.getElementById('daniel') != null)
                        document.getElementById('daniel').innerHTML = RESserv[1];
                    alert("Error: "+RESserv[0]+"  "+RESserv[1]);
                }
            }
	}
	http.send(parametros+"&pemiso="+true);
}

var contad = 0;
function MetodoAjaxAutorizar(url,parametros){

	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;
			RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
                contad = 0;
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];

				alert(RESserv[1]);
                contad = 1;
			}
		}
	}
	http.send(parametros+"&pemiso="+true);
}

function MetodoAjax3(url,parametros,ir){
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;//alert("respuesta "+RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
				window.location = ir;
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];

				alert("Error: "+RESserv[0]+"  "+RESserv[1]);
			}
		}
	}
	http.send(parametros+"&pemiso="+true);
}

function MetodoAjaxReload(url,parametros){
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
				location.reload();
			}
			else
			{
				//document.getElementById('daniel').innerHTML = RESserv[1];
				alert("Error: "+RESserv[0]+"  "+RESserv[1]);
			}
		}
	}
	http.send(parametros);
}

function MetodoAjaxJSON(url, parametros) {
	var datos = parametros.split("|");
	var dGenerales = datos[0];
	var perm = datos[1];
	var request = $.ajax({
						url: url,
						type: "POST",
						data: { datosGenerales : dGenerales, permisos : perm, permiso : true },
						dataType: "JSON"
					});
	Emergente();
	request.done( function( msg ) {
		OcultarEmergente();
		var RespuestaServidor = http.responseText;
		console.log(RespuestaServidor);
		RESserv = RespuestaServidor.split("|");
		validaSession(RESserv[0]);
		if( RESserv[0] == 0 ) {
			location.reload();
		} else {
			alert("Error: "+RESserv[0]+"  "+RESserv[1]);
		}
	});
	request.fail( function( jqXHR, textStatus ) {
		OcultarEmergente();
	});
}

function MetodoAjaxJSON2(url, parametros) {
	var request = $.ajax({
						url: url,
						type: "POST",
						data: { datos : parametros, permiso : true },
						dataType: "JSON"
					});
	Emergente();
	request.done( function( msg ) {
		OcultarEmergente();
		var RespuestaServidor = http.responseText;
		RESserv = RespuestaServidor.split("|");
		validaSession(RESserv[0]);
		if( RESserv[0] == 0 ) {
			location.reload();
		} else {
			alert("Error: "+RESserv[0]+"  "+RESserv[1]);
		}
	});
	request.fail( function( jqXHR, textStatus ) {
		OcultarEmergente();
	});
}

/*=====================================================================*/
/*                         TestConexion                                */
/*=====================================================================*/

function TestConec(){

	var user							= txtValue('txtUser');
	if(user != "")
	{
		var pass						= txtValue('txtPass');
		if(pass != "")
		{
			var sch						= txtValue('txtSchema');
			if(sch != "")
			{
				var	ip1				= txtValue('ip1');
				var	ip2				= txtValue('ip2');
				var	ip3				= txtValue('ip3');
				var	ip4				= txtValue('ip4');
				if(ip1 != "" && ip2 != "" && ip3 != "" && ip4 != "")
				{
					var port = txtValue('txtPuerto');
					if( port != ""){
							http.open("POST", "../../inc/Ajax/_Configuracion/TestConection.php", true);
							http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

							http.onreadystatechange=function()
							{
								if (http.readyState==1)
								{
									//div para  [cargando....]
								}
								if (http.readyState==4)
								{
									var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
									var RESserv = RespuestaServidor.split("|");

									validaSession(RESserv[0]);

									if(RESserv[0] == 0){
										alert(RESserv[1]);
									}
									else
									{
										alert("Error: "+RESserv[0]+" "+RESserv[1]);
									}
								}
							}
						http.send("user="+user+"&pass="+pass+"&schema="+sch+"&host="+ip1+"."+ip2+"."+ip3+"."+ip4+"&port="+port);
					}else{alert("Favor de escribir un puerto");}
				}else{alert("Favor de escribir correctamente el Host para la Base de Datos");}
			}else{alert("Favor de escribir una nombre para la Base de Datos");}
		}else{alert("Favor de escribir una contrase�a para ingresar a la Base de Datos");}
	}else{alert("Favor de escribir un usuario para entrar a la Base de Datos");}
}




/*=====================================================================*/
/*                             Nuevo Usuario                           */
/*=====================================================================*/
function NewUsu(){
var nombre = txtValue("txtNombre");
if(nombre != ""){
	var paterno = txtValue("txtApellidoP");
	if(paterno != ""){
		var materno = txtValue("txtApellidoM");
		if(materno != ""){
			var tipoperfil = txtValue("ddlTipo");
			if(tipoperfil != ""){
				var parametros = "nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&idperfil="+tipoperfil;

				http.open("POST","../../inc/Ajax/_Sesion/NewUsuarios.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
				alert(RESserv[1]);
				Recargar("../Datos/Consulta.php");
			}
			else
			{
				alert("Error: "+RESserv[0]+" "+RESserv[1]);
			}
		}
	}
	http.send(parametros);

			}else{alert("Favor de seleccionar un tipo de perfil");}
		}else{alert("Favor de escribir un apellido materno");}
	}else{alert("Favor de escribir un apellido paterno");}
}else{alert("Favor de escribir un nombre");}

}

function UpdateUsu(id){
	/*var id = txtValue("txtId");
	var nombre = txtValue("txtNombre");
if(nombre != ""){
	var paterno = txtValue("txtApellidoP");
	if(paterno != ""){
		var materno = txtValue("txtApellidoM");
		if(materno != ""){
			var tipoperfil = txtValue("ddlTipo");
			if(tipoperfil != ""){*/
				//var parametros = "id="+id+"&nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&idperfil="+tipoperfil;
				var materno = txtValue("txtApellidoM");
				var parametros = "id="+id+"&materno="+materno;

				http.open("POST","../../inc/Ajax/_Sesion/UpdateUsuarios.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
				alert(RESserv[1]);
				Recargar("../Datos/Consulta.php");
			}
			else
			{
				alert("Error: "+RESserv[0]+" "+RESserv[1]);
			}
		}
	}
	http.send(parametros+"&pemiso="+true);
			/*
			}else{alert("Favor de seleccionar un tipo de perfil");}
		}else{alert("Favor de escribir un apellido materno");}
	}else{alert("Favor de escribir un apellido paterno");}
}else{alert("Favor de escribir un nombre");}*/

}


/* ==========================================================================================================*/
/*									Buscar Combos Cadena													 */
/* ==========================================================================================================*/
function buscarCadena(j){
	var grupo = document.getElementById("ddlGrupo").value;

	if(grupo == -2){
		document.getElementById("ddlCad").value = -2;
		document.getElementById("ddlSubCad").value = -2;
		document.getElementById("ddlCorresponsal").value = -2;
		document.getElementById("ddlCad").disabled = true;
		document.getElementById("ddlSubCad").disabled = true;
		document.getElementById("ddlCorresponsal").disabled = true;

	}else{
		ClearRes();
		//busqueda de select subcadena
			document.getElementById("divcad").innerHTML = "<select id='ddlCad' class='textfield' disabled='disabled'><option value='-2' selected='selected'>Todos</option></select>";
			document.getElementById("divsubcad").innerHTML = "<select id='ddlSubCad' class='textfield' disabled='disabled'><option value='-2' selected='selected'>Todos</option></select>";
			document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='textfield' disabled='disabled'><option value='-3'>Seleccione un corresponsal</option><option value='-2' selected='selected'>Todos</option></select>";

			var parametros = "";
			switch(j){
				case 1:
				break;
			}


			http.open("POST","../../inc/Ajax/BuscaCad.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			http.onreadystatechange=function()
			{
				if (http.readyState==1)
				{
					//div para  [cargando....]
					Emergente();
				}
				if (http.readyState==4)
				{
					var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
					validaSession(RespuestaServidor);
					document.getElementById("divcad").innerHTML = RespuestaServidor;
					OcultarEmergente();
				}
			}
			http.send("idgrupo="+grupo);
	}
}
function buscarCadena2(j){
	var grupo = document.getElementById("ddlGrupo").value;

	if(grupo == -2){
		document.getElementById("ddlCad").value = -2;
		document.getElementById("ddlSubCad").value = -2;
		document.getElementById("ddlCorresponsal").value = -2;
		document.getElementById("ddlCad").disabled = true;
		document.getElementById("ddlSubCad").disabled = true;
		document.getElementById("ddlCorresponsal").disabled = true;

	}else{
		ClearRes();
		//busqueda de select subcadena
			document.getElementById("divcad").innerHTML = "<select id='ddlCad' class='textfield' disabled='disabled'><option value='-2' selected='selected'>Todos</option></select>";
			document.getElementById("divsubcad").innerHTML = "<select id='ddlSubCad' class='textfield' disabled='disabled'><option value='-2' selected='selected'>Todos</option></select>";
			document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='textfield' disabled='disabled'><option value='-3'>Seleccione un corresponsal</option><option value='-2' selected='selected'>Todos</option></select>";

			var parametros = "";
			switch(j){
				case 1:
				break;
			}


			http.open("POST","../../../inc/Ajax/BuscaCad2.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			http.onreadystatechange=function()
			{
				if (http.readyState==1)
				{
					//div para  [cargando....]
					Emergente();
				}
				if (http.readyState==4)
				{
					var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
					validaSession(RespuestaServidor);
					document.getElementById("divcad").innerHTML = RespuestaServidor;
					OcultarEmergente();
				}
			}
			http.send("idgrupo="+grupo);
	}
}


function buscarSubCadena(j){
	var cadena = document.getElementById("ddlCad").value;
	if(cadena == -2){//Busqueda de todos los accesos
		document.getElementById("ddlSubCad").value = -2;
		document.getElementById("ddlCorresponsal").value = -2;
		document.getElementById("ddlSubCad").disabled = true;
		document.getElementById("ddlCorresponsal").disabled = true;
		document.getElementById("divsubcad").innerHTML = "<select id='ddlSubCad' class='form-control m-bot15' disabled='disabled'><option value='-3'>Seleccione una subcadena</option><option value='-2' selected='selected'>Todos</option></select>";
		document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='form-control m-bot15' disabled='disabled'><option value='-3'>Seleccione un corresponsal</option><option value='-2' selected='selected'>Todos</option></select>";
		//Aqui mandar llamar a la busqueda de accesos!!
		if(j == 4)
			BuscaOperaIncompletas();

	}else{
		ClearRes();
		if(cadena == -3){
			document.getElementById("divsubcad").innerHTML = "<select id='ddlSubCad' class='form-control m-bot15' disabled='disabled'><option value='-3'>Seleccione una subcadena</option><option value='-2' selected='selected'>Todos</option></select>";
			document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='form-control m-bot15' disabled='disabled'><option value='-3'>Seleccione un corresponsal</option><option value='-2' selected='selected'>Todos</option></select>";
			$("#ddlSubCad").val(-3);
			$("#ddlCorresponsal").val(-3);
			return false;
		}
		//busqueda de select subcadena
		document.getElementById("divsubcad").innerHTML = "<select id='ddlSubCad' class='form-control m-bot15' disabled='disabled'><option value='-3'>Seleccione una subcadena</option><option value='-2' selected='selected'>Todos</option></select>";
		document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='form-control m-bot15' disabled='disabled'><option value='-3'>Seleccione un corresponsal</option><option value='-2' selected='selected'>Todos</option></select>";

		var parametros = "";
		switch(j){
			case 1: parametros = "&j=1&funcion2= BuscaCorresponsal()";
			break;
			case 2: parametros = "&j=2&funcion2= BuscaCorresponsal()";
			break;
			case 3: parametros = "&j=3&funcion2= BuscaCorresponsal()";
			break;
			case 4: parametros = "&j=4&funcion2= BuscaOperaIncompletas()";
			break;
			case 5: parametros = "&j=4";
			break;
		}

		var i = document.getElementById("ddlCad").selectedIndex;

		http.open("POST","../../inc/Ajax/BuscaSubCad.php", true);
		http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		http.onreadystatechange=function(){
			if (http.readyState==1){
				//div para  [cargando....]
				Emergente();
			}
			if (http.readyState==4){
				var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
				document.getElementById("divsubcad").innerHTML = RespuestaServidor;
				OcultarEmergente();
				if(cadena == 0){
					window.setTimeout("buscarCorresponsal("+j+")",10);
				}
				switch(j){
					case 4: BuscaOperaIncompletas();
					break;
				}
			}
		}
		http.send("idcad="+cadena+parametros);
	}
}
/*    esta funcion es para los archivos que tengan 3 archivos anidados*/
function buscarSubCadena2(j){
	var cadena = document.getElementById("ddlCad").value;
	if(cadena == -2){//Busqueda de todos los accesos
		document.getElementById("ddlSubCad").value = -2;
		document.getElementById("ddlCorresponsal").value = -2;
		document.getElementById("ddlSubCad").disabled = true;
		document.getElementById("ddlCorresponsal").disabled = true;
		//Aqui mandar llamar a la busqueda de accesos!!
		if(j == 4)
			BuscaOperaIncompletas();

	}else{
		//ClearRes();
		//busqueda de select subcadena
			document.getElementById("divsubcad").innerHTML = "<select id='ddlSubCad' class='form-control m-bot15' disabled='disabled'><option value='-2' selected='selected'>Todos</option></select>";
			document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='form-control m-bot15' disabled='disabled'><option value='-2' selected='selected'>Todos</option></select>";

			var parametros = "";
			switch(j){
				case 1:parametros = "&j=1&funcion2= buscarCorresponsal2()";
				break;
                case 3:parametros = "&j=3";
                break;
			}

			var i = document.getElementById("ddlCad").selectedIndex;


			http.open("POST","../../../inc/Ajax/BuscaSubCad2.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			http.onreadystatechange=function()
			{
				if (http.readyState==1)
				{
					//div para  [cargando....]
					Emergente();
				}
				if (http.readyState==4)
				{
					var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
					validaSession(RespuestaServidor);
					document.getElementById("divsubcad").innerHTML = RespuestaServidor;
					OcultarEmergente();
					if(cadena == 0){
						window.setTimeout("buscarCorresponsal2("+j+")",10);
					}
					switch(j){
						case 4:BuscaOperaIncompletas();
						break;
					}
				}
			}

			http.send("idcad="+cadena+parametros);
	}
}



function buscarSubCadena3(j){
	var cadena = document.getElementById("ddlCad").value;
	if(cadena == -2){//Busqueda de todos los accesos
		document.getElementById("ddlSubCad").value = -2;
		document.getElementById("ddlCorresponsal").value = -2;
		document.getElementById("ddlSubCad").disabled = true;
		document.getElementById("ddlCorresponsal").disabled = true;
		//Aqui mandar llamar a la busqueda de accesos!!
		if(j == 4)
			BuscaOperaIncompletas()

	}else{
		ClearRes();
		//busqueda de select subcadena
			document.getElementById("divsubcad").innerHTML = "<select id='ddlSubCad' class='textfield' disabled='disabled'>";
			document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='textfield' disabled='disabled'></select>";

			var parametros = "";
			switch(j){
				case 1:parametros = "&j=1&funcion2= BuscaCorresponsal()";
				break;
                case 3:parametros = "&j=3";
                break;
			}

			var i = document.getElementById("ddlCad").selectedIndex;


			http.open("POST","../../../inc/Ajax/BuscaSubCad3.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			http.onreadystatechange=function()
			{
				if (http.readyState==1)
				{
					//div para  [cargando....]
					Emergente();
				}
				if (http.readyState==4)
				{
					var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
					validaSession(RespuestaServidor);
					document.getElementById("divsubcad").innerHTML = RespuestaServidor;
					OcultarEmergente();
					if(cadena == 0){
						window.setTimeout("buscarCorresponsal("+j+")",10);
					}
					switch(j){
						case 4:BuscaOperaIncompletas();
						break;
					}
				}
			}
			http.send("idcad="+cadena+parametros);
	}
}



function buscarSelectSubCadena(j){
	var cadena = document.getElementById("ddlCad").value;
	if(cadena == -2){//Busqueda de todos los accesos
		document.getElementById("ddlSubCad").value = -2;
		document.getElementById("ddlCorresponsal").value = -2;
		document.getElementById("ddlSubCad").disabled = true;
		document.getElementById("ddlCorresponsal").disabled = true;
		//Aqui mandar llamar a la busqueda de accesos!!
		if(j == 1)
		BuscarAccesos()

	}else{
		//busqueda de select subcadena
		if(document.getElementById("divcodigo") != null)
			document.getElementById("divcodigo").innerHTML = "<p class='anuncio'>No se Encontro codigo,<a onclick='CrearCodigoSinTenerlo()' style='cursor:pointer'> <span class='anuncio-import'>Crear uno aqui</span></a></p>";

		var parametros = "";
		switch(j){
			case 1:parametros = "&j=1&funcion2= BuscaCorresponsal()";
			break;
			case 2:parametros = "&j=2&funcion2= BuscaCorresponsal()";
			break;
			case 3:parametros = "&j=3&funcion2= BuscaCorresponsal()";
			break;
			case 4:parametros = "&j=4&funcion2= BuscaOperaIncompletas()";
			break;
		}

		var i = document.getElementById("ddlCad").selectedIndex;

		http.open("POST","../../inc/Ajax/BuscaSelectSubCad.php", true);
		http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		http.onreadystatechange=function()
		{
			if (http.readyState==1)
			{
				//div para  [cargando....]
				Emergente();
			}
			if (http.readyState==4)
			{
				var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
				document.getElementById("divsubcad").innerHTML = RespuestaServidor;
				OcultarEmergente();

				if(cadena == 0){
					window.setTimeout("buscarSelectCorresponsal("+j+")",10);
				}
				if(j == 2 && cadena != 0)
				{
					window.setTimeout("calcularNivelAcc()",200);
					window.setTimeout("buscarCodigo()",300);
				}
			}
		}
		http.send("idcad="+cadena+parametros);
	}
}

function ClearScreen(){
	Emergente();
	ClearRes();
	OcultarEmergente();
}

function buscarCorresponsal(j){
	var subcadena = document.getElementById("ddlSubCad").value;
	if(subcadena == -2){//Busqueda de todos los accesos
		document.getElementById("ddlCorresponsal").value = -2;
		document.getElementById("ddlCorresponsal").disabled = true;
		//Aqui mandar llamar a la busqueda de accesos!!
		if(j == 1)
		BuscarAccesos()

	}
	else{
	ClearRes();
	var parametros = "";
	switch(j){
		case 1:parametros = "&j=1&funcion2= BuscaCorresponsal()";
		break;
		case 2:parametros = "&j=2&funcion2= BuscaCorresponsal()";
		break;
		case 3:parametros = "&j=3&funcion2= BuscaCorresponsal()";
		break;
		case 4:parametros = "&j=4&funcion2= BuscaOperaIncompletas()";
		break;
	}
	/*document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='textfield'><option value='-3'>Seleccione un corresponsal</option><option value='-1'>General</option>";*/
	if(document.getElementById("divcodigo") != null)
		document.getElementById("divcodigo").innerHTML = "<p class='anuncio'>No se Encontro codigo,<a onclick='CrearCodigoSinTenerlo()' style='cursor:pointer'> <span class='anuncio-import'>Crear uno aqui</span></a></p>";

    var i = document.getElementById("ddlSubCad").selectedIndex;
	http.open("POST","../../inc/Ajax/BuscaCorresponsal.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			validaSession(RespuestaServidor);
			document.getElementById("divcorresponsal").innerHTML = RespuestaServidor;
			OcultarEmergente();
		}
	}
	http.send("idcad="+document.getElementById("ddlCad").value+"&idsubcad="+document.getElementById("ddlSubCad").value+"&al=1"+parametros);
	}
}
/*                  esta funcion es para los que tienen 3 archivos anidados*/
function buscarCorresponsal2(j){
	var subcadena = document.getElementById("ddlSubCad").value;

	if(subcadena == -2){//Busqueda de todos los accesos
		document.getElementById("ddlCorresponsal").value = -2;
		document.getElementById("ddlCorresponsal").disabled = true;
		//Aqui mandar llamar a la busqueda de accesos!!
		if(j == 1)
		BuscarAccesos();

	}else{
	var parametros = "";
	switch(j){
		case 1:parametros = "&j=1&funcion2= BuscaCorresponsal()";
		break;
                case 3:parametros = "&j=3&funcion2= BuscarDatosReembolsos()";
                break;

	}
	document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='textfield'><option value='-3'>Seleccione un corresponsal</option><option value='-1'>General</option>";
	if(document.getElementById("divcodigo") != null)
		document.getElementById("divcodigo").innerHTML = "<p class='anuncio'>No se Encontro codigo,<a onclick='CrearCodigoSinTenerlo()' style='cursor:pointer'> <span class='anuncio-import'>Crear uno aqui</span></a></p>";

    var i = document.getElementById("ddlSubCad").selectedIndex;
	http.open("POST","../../../inc/Ajax/BuscaCorresponsal2.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			validaSession(RespuestaServidor);
			document.getElementById("divcorresponsal").innerHTML = RespuestaServidor;
			OcultarEmergente();
		}
	}
	http.send("idcad="+document.getElementById("ddlCad").value+"&idsubcad="+document.getElementById("ddlSubCad").value+"&al=1"+parametros);
	}
}



function buscarCorresponsal3(j){
	var subcadena = document.getElementById("ddlSubCad").value;

	if(subcadena == -2){//Busqueda de todos los accesos
		document.getElementById("ddlCorresponsal").value = -2;
		document.getElementById("ddlCorresponsal").disabled = true;
		//Aqui mandar llamar a la busqueda de accesos!!
		if(j == 1)
		BuscarAccesos()

	}else{
	var parametros = "";
	switch(j){
		case 1:parametros = "&j=1&funcion2= BuscaCorresponsal()";
		break;
                case 3:parametros = "&j=3&funcion2= BuscarDatosReembolsos()";
                break;

	}
	document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='textfield'><option value='-3'>Seleccione un corresponsal</option>";


    var i = document.getElementById("ddlSubCad").selectedIndex;
	http.open("POST","../../../inc/Ajax/BuscaCorresponsal21.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			validaSession(RespuestaServidor);
			document.getElementById("divcorresponsal").innerHTML = RespuestaServidor;
			OcultarEmergente();
		}
	}
	http.send("idcad="+document.getElementById("ddlCad").value+"&idsubcad="+document.getElementById("ddlSubCad").value+"&al=1"+parametros);
	}
}



function BuscaSelectSubFamilia(){
	var parametros = "";
	var familia = document.getElementById("ddlFam").value;
	if(familia > -3){
		parametros+="idfamilia="+familia;
		http.open("POST","../../inc/Ajax/BuscaSelectSubFam.php", true);
		http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		http.onreadystatechange=function()
		{
			if (http.readyState==1)
			{
				//div para  [cargando....]
				Emergente();
			}
			if (http.readyState==4)
			{
				var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
				document.getElementById("divSubFamilia").innerHTML = RespuestaServidor;
				OcultarEmergente();
			}
		}
		http.send(parametros);
	}
	else{
		$("#divSubFamilia").html("<select id='ddlSubFam' class='form-control m-bot15' disabled='disabled'><option value='-3'>Seleccione una SubFamilia</option></select>");
	}
}
/*este tiene el ajuste de la ruta por el ../../../     */
function BuscaSelectSubFam(){
	var parametros = "";
	var familia = document.getElementById("ddlFam").value;
	if(familia > -3){
		parametros+="idfamilia="+familia;
		http.open("POST","../../../inc/Ajax/BuscaSelectSubFam.php", true);
		http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		http.onreadystatechange=function()
		{
			if (http.readyState==1)
			{
				//div para  [cargando....]
				Emergente();
			}
			if (http.readyState==4)
			{
				var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
				document.getElementById("divSubFamilia").innerHTML = RespuestaServidor;
				OcultarEmergente();
			}
		}
		http.send(parametros);
	}
}

/*este tiene el ajuste de la ruta por el ../../../     */
function BuscaSelectProducto(){
	var parametros = "";
	var prov = document.getElementById("ddlProveedor").value;
	if(prov > -3){
		parametros ="idproveedor="+prov;
		http.open("POST","../../../inc/Ajax/BuscaSelectProducto.php", true);
		http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		http.onreadystatechange=function()
		{
			if (http.readyState==1)
			{
				//div para  [cargando....]
				Emergente();
			}
			if (http.readyState==4)
			{
				var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
				document.getElementById("divProductos").innerHTML = RespuestaServidor;
				OcultarEmergente();
			}
		}
		http.send(parametros);
	}
}


function buscarSelectCorresponsal(j){
	var parametros = "";
	switch(j){
		case 1:parametros = "&j=1&funcion2= BuscaCorresponsal()";
		break;
		case 2:parametros = "&j=2&funcion2= BuscaCorresponsal()";
		break;
		case 3:parametros = "&j=3&funcion2= BuscaCorresponsal()";
		break;
		case 4:parametros = "&j=4&funcion2= BuscaOperaIncompletas()";
		break;
	}

	//document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='textfield'><option value='-2'>Seleccione un corresponsal</option><option value='-1'>General JS</option>";

	if(document.getElementById("divcodigo") != null)
		document.getElementById("divcodigo").innerHTML = "<p class='anuncio'>No se Encontro codigo,<a onclick='CrearCodigoSinTenerlo()' style='cursor:pointer'> <span class='anuncio-import'>Crear uno aqui</span></a></p>";

    //var i = document.getElementById("ddlSubCad").selectedIndex;
	var idcad 		= document.getElementById("ddlCad").value;
	var idsubcad 	= document.getElementById("ddlSubCad").value;
	//alert("cad "+idcad+" sub "+idsubcad);
	http.open("POST","../../inc/Ajax/BuscaSelectCorresponsal.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			validaSession(RespuestaServidor);
			document.getElementById("divcorresponsal").innerHTML = RespuestaServidor;
			OcultarEmergente();
			if(j == 2)
			{
				window.setTimeout("calcularNivelAcc()",50);
				window.setTimeout("buscarCodigo()",150);
			}
		}
	}
	http.send("idcad="+idcad+"&idsubcad="+idsubcad+"&al=1"+parametros);

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
		document.getElementById("etbus").style.display = "inline";
		var x = parseInt(document.getElementById("cpag").value);
		var t = parseInt(document.getElementById("totalreg").value);
		if(x > t)
			document.getElementById("cpag").value = t;
		if(tecla==13 || tecla == -1){
			var regPagina = document.getElementById("cpag").value;
			if ( regPagina <= 100 ) {
				BusquedaPaginacion(f,x);
			} else {
				alert("S\u00F3lo es posible consultar 100 resultados por p\u00E1gina como m\u00E1ximo.");
			}
		}
	}else if(tecla == 8){
		$("#etbus").fadeOut("normal");
	}
}

//FUNCION QUE INDICA QUE FUNCION EJECUTAR EN LA PAGINACION
function BusquedaPaginacion(f,x){

	cant = x;
	document.getElementById("cpag").value = x;
	eval(f);
	switch(f){
		case "showReporte":showReporte();
		break;
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
                case "BuscaCorresponsalDir":BuscaCorresponsalDir();
		break;
                case "BuscarPreCadenas":BuscarPreCadenas();
                break;
                case "BuscarPreSubCadenas":BuscarPreSubCadenas();
                break;
                case "BuscaPreSubCadena":BuscaPreSubCadena();
                break;
                case "BuscarPreCorresponsal":BuscarPreCorresponsal();
                break;
                case "BuscaRemesas":BuscaRemesas();
                break;
                case "getReporte":getReporte();
                break;
        default:
        	eval(f+"()");
        break;
	}

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

//$(".anclapaginacion2").live("click",function(e){e.preventDefault;})

function buscarCodigo(){
	if(document.getElementById("divcodigo") != null){
	http.open("POST","../../inc/Ajax/_Corresponsal/BuscaCodigo.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			validaSession(RespuestaServidor);
			document.getElementById("divcodigo").innerHTML = RespuestaServidor;

		}
	}
	http.send("idcadena="+document.getElementById("ddlCad").value+"&idsubcadena="+document.getElementById("ddlSubCad").value+"&idcorresponsal="+document.getElementById("ddlCorresponsal").value);
//http.send("idcadena="+document.getElementById("ddlCad").value+"&idsubcadena="+document.getElementById("ddlSubCad").value+"&idcorresponsal="+document.getElementById("ddlCorresponsal").value);
	}
}

function ClearRes(){
	try{
		document.getElementById('divRES').innerHTML = "";
		$(".excel").fadeOut();
		$(".pdf").fadeOut();
		$(".verDetalle").fadeOut();
		if ( $("#impresionCorte").length ) {
			$("#impresionCorte").fadeOut();
		}
		$('body').trigger('clearres');
	}catch(e){
		alert("No existe divRES");
	}
}

//===============================================================================
//======================== Calendario =======================================================
function calendario(cas,cal){ //alert(cas+"-"+cal);
	new Calendar({
			  inputField: cas,
			  dateFormat: "%Y-%m-%d",
			  trigger: cal,
			  bottomBar: false,
			  onSelect: function(){
					  var date = Calendar.intToDate(this.selection.get());

					  this.hide();
			  }
	  });
	new Calendar({
			  inputField: cas,
			  dateFormat: "%Y-%m-%d",
			  trigger: cal,
			  bottomBar: false,
			  onSelect: function(){
					  var date = Calendar.intToDate(this.selection.get());

					  this.hide();
			  }
	  });
}
//===============================================================================


//===============================================================================
//======================== Esto es para la asignacion de Facturas =======================================================
function AsignarFactura(url,parametros){

	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);

			validaSession(RespuestaServidor);

			MostrarPopUp(RespuestaServidor);

			OcultarEmergente();
		}
	}
	http.send(parametros);
}

function AsignarFacturaAceptada(tipo){
	id 			= txtValue('id');
	idfactura	= txtValue('idfactura');
	imp1 		= txtValue('importe1');
	imp2 		= txtValue('importe2');
	parametros 	= "id="+id+"&idfactura="+idfactura+"&tipo="+tipo+"&imp="+imp1+"&imp2="+imp2;
	MetodoAjax("../../../inc/Ajax/_Contabilidad/AsignacionAceptada.php",parametros)
}
function AsignarFacturaAceptada2(tipo){
	id 			= txtValue('id');
	idfactura	= txtValue('idfactura');
	if(Check('chkAcepto')){
		desc	= txtValue('txtDesc');
		if(desc != ""){
			importe1	= txtValue('importe1');
			if(importe1 != '' || importe1 > 0){
				importe2 = txtValue('importe2');
				if(importe2 != '' || importe2 > 0){

					parametros 	= "id="+id+"&idfactura="+idfactura+"&tipo="+tipo+"&desc="+desc+"&imp="+importe1+"&imp2="+importe2;
					//alert(parametros);
					MetodoAjax("../../../inc/Ajax/_Contabilidad/AsignacionAceptada.php",parametros)

				}else{alert("No Existe el Importe de la Factura, favor de verificar");}
			}else{alert("No Existe el Importe de Corte, favor de verificar");}
		}else{alert("Favor escribir un motivo de anomalia");}
	}else{alert("Favor de leer la informacion");}
}

function ConsultaFactura(id,numcta,importe,tipo,i){

	if(numcta != '' || numcta > 0){
	   parametros = "&id="+id+"&numcta="+numcta+"&importe="+importe+"&tipo="+tipo;
	   //alert(parametros);
	   BuscarParametros("../../../inc/Ajax/_Contabilidad/ConsultaFactura.php","status=3"+parametros,'',i);

	}else{alert("Falta el numero de cuenta revisar por favor");}
}

function btnAsignarFactura(tipo){
	imp1 = document.getElementById('importe1').value;
	imp2 = document.getElementById('importe2').value;
	if(imp2 != '' || imp2 != 0){

	parametros = "importe1="+imp1+"&importe2="+imp2+"&tipo="+tipo;
	AsignarFactura("../../../inc/Ajax/_Contabilidad/Asignacion.php",parametros)

	}else{alert("Favor de selcionar una Factura");}
}

function GetFecha(x){
    var f = x.split("-");
    return f[2]+"-"+f[1]+"-"+f[0];
}


//FUNCION QUE MANDA RELLENAR UN TEXT COMO SI FUESE GOOGLE
//SEL ES UNA VARIABLE QUE CONTIENE EL VALOR SELECCIONADO
var sel = -3;
var sel2 = -3;
var sel3 = -3;
var sel4 = -3;
var sel5 = -3;
function AutoCompletar(txt,url,x,lenx){
if(lenx == null)
	lenx = 2;
$(function() {
    $("#"+txt).autocomplete({
        source: url,
        minLength: lenx,
        select: function( event, ui ) {
			switch(x){
                case 1:
				sel = ui.item.id;
                break;
				case "1":
				sel = ui.item.id;
                break;
                case 2:
				sel2 = ui.item.id;
                if ( document.getElementById('guardarCambios') ) {
					document.getElementById('guardarCambios').style.visibility = "visible";
				}
				break;
                case 3:
				sel3 = ui.item.id;
                if ( document.getElementById('guardarCambios') ) {
					document.getElementById('guardarCambios').style.visibility = "visible";
				}
                break;
                case 4:
				sel4 = ui.item.id;
                break;
				case 5:
				sel5 = ui.item.id;
				break;
                default:
				sel = ui.item.id;
                break;
            }
        }

    });
  });
}

/*=======  para el cambio de imagen ========*/

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}




/*======== Para las fechas ======*/
$(function() {
	if(Existe("txtFecha"))
		var checkin1 = $('#txtFecha').datepicker().on('changeDate', function(ev) {  checkin1.hide();}).data('datepicker');
	if(Existe("txtfecha"))
		var checkin2 = $('#txtfecha').datepicker().on('changeDate', function(ev) {  checkin2.hide();}).data('datepicker');

	if(Existe("txtFechaIni"))
		var checkin3 = $('#txtFechaIni').datepicker().on('changeDate', function(ev) {  checkin3.hide();}).data('datepicker');

	if(Existe("txtFechaFin"))
		var checkin4 = $('#txtFechaFin').datepicker().on('changeDate', function(ev) {  checkin4.hide();}).data('datepicker');

	if(Existe("fecha1"))
		var checkin5 = $('#fecha1').datepicker().on('changeDate', function(ev) {  checkin5.hide();}).data('datepicker');

	if(Existe("fecha2"))
		var checkin6 = $('#fecha2').datepicker().on('changeDate', function(ev) {  checkin6.hide();}).data('datepicker');

	if(Existe("fecIni"))
		var checkin7 = $('#fecIni').datepicker().on('changeDate', function(ev) {  checkin7.hide();}).data('datepicker');

	if(Existe("fecFin"))
		var checkin8 = $('#fecFin').datepicker().on('changeDate', function(ev) {  checkin8.hide();}).data('datepicker');

	if(Existe("fecha"))
		var checkin9 = $('#fecha').datepicker().on('changeDate', function(ev) {  checkin9.hide();}).data('datepicker');

	if(Existe("txtFechaVen"))
		var checkin10 = $('#txtFechaVen').datepicker().on('changeDate', function(ev) {  checkin10.hide();}).data('datepicker');

	if(Existe("feini"))
		var checkin11 = $('#feini').datepicker().on('changeDate', function(ev) {  checkin11.hide();}).data('datepicker');
	if(Existe("fefin"))
		var checkin12 = $('#fefin').datepicker().on('changeDate', function(ev) {  checkin12.hide();}).data('datepicker');

	if(Existe("fechaInicio")){
		//var checkin = $('#txtFechaVen').datepicker().on('changeDate',function(ev){  checkin.hide();}).data('datepicker');
		var checkin = $('#fechaInicio').datepicker().on('changeDate',function(ev){
			checkin.hide();
			var fecha = $('#fechaInicio').val();

			var d = new Date();
			var curr_date = d.getDate();
			if(curr_date < 10){
				curr_date = "0"+curr_date;
			}
			var curr_month = d.getMonth() + 1; //Months are zero based

			if(curr_month < 10){
				curr_month = "0"+curr_month;
			}
			var curr_year = d.getFullYear();

			var hoy = curr_year + "-" + curr_month + "-" + curr_date;

			if(fecha < hoy){
				alert("La fecha debe ser Mayor o Igual al d�a de Hoy");
				$("#fechaInicio").val(hoy);
			}
		}).data('datepicker');
	}
});





function MetodoAjaxDiv2(url,parametros){
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;//alert("respuesta "+RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");
			validaSession(RESserv[0]);
			if(RESserv[0] == 0){
                                MostrarPopUp(RESserv[1])
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];

				MostrarPopUp(RESserv[1]);
			}
		}
	}
	http.send(parametros+"&pemiso="+true);
}

function MetodoAjaxDiv(url,parametros){
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;//alert("respuesta "+RespuestaServidor);

			validaSession(RespuestaServidor);

			MostrarPopUp(RespuestaServidor);
			OcultarEmergente();
		}
	}
	http.send(parametros+"&pemiso="+true);
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

/*====================================  ESTE METODO ES PARA ACTUALIZAR UN DIV CON LA INFO =============================*/
function MetodoAjaxUpdateDiv(url,parametros,div,valor){
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;
			var RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
				alert(RESserv[1]);
				setDivHTML(div,valor);

				if(div == "lblTel" && Existe('divTel')){
					OcultarTelEditar()
				}
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];

				alert("Error: "+RESserv[0]+"  "+RESserv[1]);
			}
		}
	}
	http.send(parametros+"&pemiso="+true);
}

function MetodoAjaxContactos(url,parametros,tipoz,valorz){
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function()
	{
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;//alert("respuesta "+RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
				var parametros2 = "tipoCliente="+tipoz+"&idValor="+valorz;
				//BuscarParametros2("../../inc/Ajax/_Clientes/BuscaContactosClientes.php",parametros2,'divRES');
				Persiana(true);

				//alert(RESserv[1]);
				irAEditar();
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];

				alert(RESserv[1]);
			}
		}
	}
	http.send(parametros+"&pemiso="+true);
}






/*Metodos para la busqueda de direciones desde LISTADO.php que contienen seleccionar con valor de -2 */
function buscarSelectEdo(j,funcion){
	var pais = txtValue("ddlPais");
	if(pais == -2){
		if(j == true){
		document.getElementById("ddlEstado").value = -2;
		document.getElementById("ddlMunicipio").value = -2;
		document.getElementById("ddlEstado").disabled = true;
		document.getElementById("ddlMunicipio").disabled = true;
			if(Existe("ddlColonia")){
				document.getElementById("ddlColonia").value = -2;
				document.getElementById("ddlColonia").disabled = true;
			}
		}

	}else{
		if(j){
			document.getElementById("ddlMunicipio").value = -2;
			document.getElementById("ddlMunicipio").disabled = true;
			if(Existe("ddlColonia")){
				document.getElementById("ddlColonia").value = -2;
				document.getElementById("ddlColonia").disabled = true;
			}
		}
			var parametros = "";
			switch(j){
				case 1:
				break;
			}


			http.open("POST","../../inc/Ajax/BuscaSelectEdo.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			http.onreadystatechange=function()
			{
				if (http.readyState==1)
				{
					//div para  [cargando....]
					Emergente();
				}
				if (http.readyState==4)
				{
					var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
					validaSession(RespuestaServidor);
					setDivHTML("divEdo",RespuestaServidor);
					OcultarEmergente();
				}
			}
			http.send("idpais="+pais+"&j="+j+"&funcion1="+funcion);
	}
}

function buscaSelectCiudad(j,funcion){
	var edo = txtValue("ddlEstado");
	var pais = txtValue("ddlPais");
	if(edo == -2){
		if(j){
		document.getElementById("ddlMunicipio").value = -2;
		document.getElementById("ddlMunicipio").disabled = true;
			if(Existe("ddlColonia")){
				document.getElementById("ddlColonia").value = -2;
				document.getElementById("ddlColonia").disabled = true;
			}
		}
	}else{
		if(j){
			if(Existe("ddlColonia")){
                document.getElementById("txtcp").value = "";
				document.getElementById("ddlColonia").value = -2;
				document.getElementById("ddlColonia").disabled = true;
			}
		}
			var parametros = "";
			switch(j){
				case 1:
				break;
			}


			http.open("POST","../../inc/Ajax/BuscaSelectCd.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			http.onreadystatechange=function()
			{
				if (http.readyState==1)
				{
					//div para  [cargando....]
					Emergente();
				}
				if (http.readyState==4)
				{
					var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
					validaSession(RespuestaServidor);
					setDivHTML("divCd",RespuestaServidor);
					OcultarEmergente();
				}
			}
			http.send("idedo="+edo+"&idpais="+pais+"&j="+j+"&funcion1="+funcion);
	}
}

function buscaSelectColonia( j, funcion ) {
	if(Existe("ddlMunicipio")){
		var cd = txtValue("ddlMunicipio");
		var edo = txtValue("ddlEstado");
		var pais = txtValue("ddlPais");

		var col = txtValue("ddlMunicipio");
		if(cd == -2){
			document.getElementById("ddlMunicipio").value = -2;
			//document.getElementById("ddlMunicipio").disabled = true;
		}else{
                document.getElementById("txtcp").value = "";
				document.getElementById("ddlMunicipio").disabled = false;
				var parametros = "idedo="+edo+"&idpais="+pais+"&idcd="+cd+"&j="+j;
				switch(j){
					case 1:
					break;
				}

				http.open("POST","../../inc/Ajax/BuscaSelectColonias.php", true);
				http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

				http.onreadystatechange=function()
				{
					if (http.readyState==1)
					{
						//div para  [cargando....]
						Emergente();
					}
					if (http.readyState==4)
					{
						var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
						validaSession(RespuestaServidor);
						setDivHTML("divCol", RespuestaServidor);
						OcultarEmergente();
					}
				}
				http.send(parametros);
		}
	}
}

function buscaSelectSubyPreSub(funcion){
	var cad = txtValue("ddlCadena");

	if(cad > -1){
		http.open("POST","../../inc/Ajax/BuscaSelectSubyPreSub.php", true);
		http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		http.onreadystatechange=function()
		{
			if (http.readyState==1)
			{
				//div para  [cargando....]
				Emergente();
			}
			if (http.readyState==4)
			{
				var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
				setDivHTML("divSubyPreSub",RespuestaServidor);
				OcultarEmergente();
			}
		}
		http.send("idcad="+cad+"&funcion1="+funcion);

	}else{alert("favor de seleccionar una cadena");}
}
