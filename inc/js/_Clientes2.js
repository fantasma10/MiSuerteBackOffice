function BCadena(){
    http.open("POST","../../../inc/Ajax/CadenaNombres.php", true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
    http.onreadystatechange=function() 
    { 
            if (http.readyState==1)
            {
                    Emergente();
            }
            if (http.readyState==4)
            {
                var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
                document.getElementById("divselect").innerHTML = RespuestaServidor;
                OcultarEmergente();
            } 
    }
    http.send();
}

function BSubCadena(){
    http.open("POST","../../../inc/Ajax/SubCadenaNombres.php", true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
    http.onreadystatechange=function() 
    { 
            if (http.readyState==1)
            {
                    Emergente();
            }
            if (http.readyState==4)
            {
                var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
                document.getElementById("divselect").innerHTML = RespuestaServidor;
                OcultarEmergente();
            } 
    }
    http.send();
}

function BCorresponsal(){
    http.open("POST","../../../inc/Ajax/CorresponsalNombres.php", true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
    http.onreadystatechange=function() 
    { 
            if (http.readyState==1)
            {
                    Emergente();
            }
            if (http.readyState==4)
            {
                var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
                document.getElementById("divselect").innerHTML = RespuestaServidor;
                OcultarEmergente();
            } 
    }
    http.send();
}

function BusquedaDat(){
    if(Existe("ddlCad")){
        var cadena = document.getElementById("ddlCad").value;
        if(cadena > -1){
            MCadena(cadena);
            BuscarParametros("../../inc/Ajax/_Clientes/DatosGrlsCadena.php","cadena="+cadena,"PA1");
            CadenaNombre();
        }else{
            alert("Favor De Seleccionar Una Cadena");
        }
    }
    if(Existe("ddlSubCad")){
        var subcadena = document.getElementById("ddlSubCad").value;
        if(subcadena > -1){
            MSubCadena(subcadena);
        }else{
            alert("Favor De Seleccionar Una SubCadena");
        }
    }
    if(Existe("ddlCorresponsal")){
        var corresponsal = document.getElementById("ddlCorresponsal").value;
        if (corresponsal > -1){
            MCorresponsal(corresponsal);
        }else{
            alert("Favor De Seleccionar Un Corresponsal");
        }
    }
    
}

function BusquedaDatId(){
    if(Existe("ddlCad")){
        var cadena = document.getElementById("txtid").value;
        if(cadena > -1){
            MCadena(cadena);
            BuscarParametros("../../inc/Ajax/_Clientes/DatosGrlsCadena.php","cadena="+cadena,"PA1");
            document.getElementById("subtitulo").innerHTML = "Dat. Grls.";
        }
    }
    if(Existe("ddlSubCad")){
        var subcadena = document.getElementById("txtid").value;
        if(subcadena > -1){
            MSubCadena(subcadena);
        }
    }
    if(Existe("ddlCorresponsal")){
        var corresponsal = document.getElementById("txtid").value;
        if (corresponsal > -1){
            MCorresponsal(corresponsal);
        }
    }
    
}

function BusquedaDatNombre(){
    
    if(document.getElementById("txtnombre").value != "" && sel > -1){
            MCadena();
            BuscarParametros("../../inc/Ajax/_Clientes/DatosGrlsCadena.php","cadena="+sel,"PA1");
            document.getElementById("subtitulo").innerHTML = "Dat. Grls."; 
    }
    else if(document.getElementById("txtnombre").value != "" && sel2 > -1){
        //busqueda por nombre  
    }
    else if(document.getElementById("txtnombre").value != "" && sel3 > -1){
        //busqueda por nombre  
    }
}


function MCadena(){
    $(".tdleft").html("<ul class='ulPrealta'><li class='linull'></li><li onclick='DatGrlsCadena()'>Dat. Grls.</li><li onclick='CorrespCadena()'>Corresponsales</li><li onclick='PermisosCadena()'>Permisos</li><ul>");
    $("#contpre").html("<div id='PA1'>1</div><div id='PA2' class='ocultarDiv'>2</div><div id='PA3' class='ocultarDiv'>3</div><div id='PA4' class='ocultarDiv'>4</div><div id='PA5' class='ocultarDiv'>5</div>")
    
}

function MSubCadena(){
    $(".tdleft").html("<ul class='ulPrealta'><li class='linull'></li><li>Dat. Grls.</li><li>Corresponsales</li><li>Permisos</li><li>Historial</li><li>Dat. Contables</li><li>Dat. Fiscales</li><ul>");
    
}

function MCorresponsal(){
    $(".tdleft").html("<ul class='ulPrealta'><li class='linull'></li><li>Dat. Grls.</li><li>Sucursal</li><li>Horario</li><li>Permisos</li><li>Historial</li><li>Dat. Contables</li><li>Operaciones</li><ul>");
    
}

function DatGrlsCadena(){
    if(Existe("ddlCad") || sel > -1){
        var cadena = document.getElementById("ddlCad").value;
        if(document.getElementById("rbtcadena").checked && cadena > -1){
            BuscarParametros("../../inc/Ajax/_Clientes/DatosGrlsCadena.php","cadena="+cadena,"PA1");
        }if(document.getElementById("rbtcadena").checked && cadena > -1){
            BuscarParametros("../../inc/Ajax/_Clientes/DatosGrlsCadena.php","cadena="+sel,"PA1");
        }else if(document.getElementById("txtnombre").value != ""){
          //busqueda por nombre  
        }
    }
    
    BuscarParametros("../../inc/Ajax/_Clientes/DatosGrlsCadena.php","cadena="+cadena,"PA1");
    
}

function CorrespCadena(){
    if(Existe("ddlCad") || sel > -1){
        var cadena = document.getElementById("ddlCad").value;
        if(cadena > -1){    
            BuscarParametros("../../inc/Ajax/_Clientes/CorrespCadena.php","v=0&cadena="+cadena,"PA2");
        }else if(sel > -1){
            BuscarParametros("../../inc/Ajax/_Clientes/CorrespCadena.php","v=0&cadena="+sel,"PA2");
        }else if(document.getElementById("txtnombre").value != ""){
          //busqueda por nombre
          alert("sss")
        }
    }
}

function ListaCorresponsales(c,s){
    MostrarPopUp();
    document.getElementById("textoenc").innerHTML =  "Corresponsales De La Cadena "+document.getElementById("ddlCad").options[document.getElementById("ddlCad").selectedIndex].text;
    if(s > -1)
        BuscarParametros("../../inc/Ajax/_Clientes/CorrespCadena.php","v=1&cadena="+c+"&subcadena="+s,"contenido");
    else if(s == -1)
        BuscarParametros("../../inc/Ajax/_Clientes/CorrespCadena.php","v=1&cadena="+c,"contenido");
}

function PermisosCadena(){
    if(Existe("ddlCad")){
        var cadena = document.getElementById("ddlCad").value;
        
    }
}

//function ContablesCadena(){
//    if(Existe("ddlCad")){
//        var cadena = document.getElementById("ddlCad").value;
//        BuscarParametros("../../inc/Ajax/_Clientes/DatosContCadena.php","cadena="+cadena,"PA4");
//    }
//}

//function FiscalesCadena(){
//    if(Existe("ddlCad")){
//        var cadena = document.getElementById("ddlCad").value;
//        
//    }
//}

function SiguienteCad(){
    Siguiente();
    CambioCad();
}

function CambioCad(){
    switch(index){
        case 1:DatGrlsCadena();
            break;
        case 2:CorrespCadena();
            break;
        case 3:PermisosCadena();
            break;
        case 4:ContablesCadena();
            break;
        case 5:FiscalesCadena();
            break;
    }
}

function AnteriorCad(){
    Anterior();
    CambioCad();
}



function AparecerBtn(i){
    $("#botones").css({"display":"none"});
    $("#divcontenido").fadeIn("normal");
    switch(i){
        case 1:BCadena();AutoCompletar("txtnombre","../../inc/Ajax/_Clientes/BuscaCadenaNombre.php",1);
            break;
        case 2:BSubCadena();AutoCompletar("txtnombre","../../inc/Ajax/_Clientes/BuscaCadenaNombre.php",2);
            break;
        case 3:BCorresponsal();AutoCompletar("txtnombre","../../inc/Ajax/_Clientes/BuscaCadenaNombre.php",3);
            break;
    }
}

function AparecerBtn2(){
     $("#divcontenido").css({"display":"none"});
    $("#botones").fadeIn("normal");
}

//HACE SUBMIT A UN FORM PARA GENERAR UN ARCHIVO .CSV
function SubForm(i){
	switch(i){
		case 1: Caracter();document.getElementById("excel").submit();
		break;
	}
}
//Cambia el caracter para el archivo csv
function Caracter(){
	if(document.getElementById("chkn").checked){
		document.getElementById("caracter").value = ";";
		document.getElementById("tcaracter").value = ";";
	}else{
		document.getElementById("caracter").value = ",";
		document.getElementById("tcaracter").value = ",";
	}
}

function CadenaNombre(){
    if(Existe("ddlCad")){
        var cadena = document.getElementById("ddlCad").value;
        if(cadena > -1){
            BuscarParametros("../../inc/Ajax/_Clientes/NombreCadenaById.php","cadena="+cadena,"divRES");
        }
    }
}



















//******************** PRE CORRESPONSAL ********************//

function CambioPaginaCorr(i){
	//verificar que se hayan guardado los cambios antes de redireccionar
	//mandar un confirm
	switch(i){
		case 0:window.location = "Crear.php"
			break;
		case 1:window.location = "Crear1.php"
			break;
		case 2:window.location = "Crear2.php"
			break;
		case 3:window.location = "Crear3.php"
			break;
		case 4:window.location = "Crear4.php"
			break
		case 5:window.location = "Crear5.php"
			break;
		case 6: window.location = "Crear6.php"
			break;
		case 7:window.location = "Crear7.php"
			break;
		case 8:window.location = "Crear8.php"
		    break;
	}
}


function EditarGrlsPreCorresponsal(){
	var idcadena = txtValue("ddlCadena");
	var idsubcadena = txtValue("ddlSubCad");
	var tiposub = idsubcadena.split("|");
	var giro = txtValue("ddlGiro");
	var grupo = txtValue("ddlGrupo");
	var ref = txtValue("ddlReferencia");
	var tel1 = txtValue("txttel1");
	var tel2 = txtValue("txttel2");
	var fax = txtValue("txtfax");
	var mail = txtValue("txtmail");
	
	var NumSucu = txtValue("txtNumSucursal")
	var NomSucu = txtValue("txtNomSucursal");
	var iva = txtValue("ddlIva");
	band = true;
	if(idcadena > -1){
		var parametros = "idcadena="+idcadena;
		if(tiposub[0] > -1){
			parametros += "&idsubcadena="+tiposub[1];
			parametros += "&idtiposub="+tiposub[0];
			
			parametros += "&nomsubcadena="+getTextSelect("ddlSubCad");
			
			if(giro > -1){
				parametros+="&idgiro="+giro;
				if(grupo > -1){
					parametros+="&idgrupo="+grupo;
					if(ref > -1){
						parametros+="&idref="+ref;
						if(tel1 != ''){
						    if(validaTelefono("txttel1")){
							parametros+="&tel1="+tel1;
							
							if(mail != ''){
							    if(validarEmail("txtmail")){
								parametros+="&mail="+mail;
								if(iva > -1){
								    if(tel2 != '' && !validaTelefono("txttel2")){
										band = false;
										alert("El Telefono 2 es incorrecto");
								    }else if(fax != '' && !validaTelefono("txtfax")){
										band = false;
										alert("El Fax es incorrecto");
								    }
								    parametros+="&iva="+iva;
								}else{
									band = false;
									alert("Favor de escribir seleccionar un IVA");
								}
							    }else{
								band = false;
								alert("El correo electronico es incorrecto")
							    }
							}else{
								band = false;
								alert("Favor de escribir el correo del corresponsal");
							}
						    }else{
							band = false;
							alert("El Telefono 1 es incorrecto");
						    }
						}else{
							band = false;
							alert("Favor de escribir el telefono del corresponsal");
						}
					}else{
						band = false;
						alert("Favor de seleccionar la referencia del corresponsal");
					}
				}else{
					band = false;
					alert("Favor de seleccionar el grupo del corresponsal");
				}
			}else{
				band = false;
				alert("Favor de seleccionar el giro del corresponsal");
			}
		}else{
			band = false;
			alert("Favor de seleccionar una subcadena");
		}
		if(band){
			if(tel2 != '')
				parametros+="&tel2="+tel2;
			if(fax != '')
				parametros+="&fax="+fax;
			if(NumSucu != '')
				parametros+="&numSucursal="+NumSucu;
			if(NomSucu != '')
				parametros+="&nomSucursal="+NomSucu;
			
			MetodoAjaxReload("../../inc/Ajax/_Clientes/EditarGrlsPreCorresponsal.php",parametros);
		}	
	}else{
		alert("Favor de seleccionar una cadena")
	}
	
}

function EditarVersionCorresponsal(){
	var Ver = txtValue("idVersionXML");
	if(Ver != ""){
		MetodoAjaxReload("../../inc/Ajax/_Clientes/EditarVersionPreCorresponsal.php","ver="+Ver);
	}else{alert("Favor de seleccionar una version");}
}

function VerificarDireccionCorr( tipo ){
	var caracteresValidos = /^\d{5}$/i;
	if ( txtValue("txtcalle") != '' )
		document.getElementById("calleok").style.display = "inline-block";
	else
		document.getElementById("calleok").style.display = "none";
	if ( txtValue("txtnext") !=  '' )
		document.getElementById("nextok").style.display = "inline-block";
	else
		document.getElementById("nextok").style.display = "none";
	if ( tipo == "nacional" ) {
		if ( txtValue("ddlMunicipio") > -2 && txtValue("ddlMunicipio") != "" )
			document.getElementById("ciudadok").style.display = "inline-block";
		else
			document.getElementById("ciudadok").style.display = "none";
		if ( txtValue("ddlEstado") > -2 && txtValue("ddlEstado") != "" )
			document.getElementById("estadook").style.display = "inline-block";
		else
			document.getElementById("estadook").style.display = "none";
		if ( txtValue("ddlPais") > -1 )
			document.getElementById("paisok").style.display = "inline-block";
		else
			document.getElementById("paisok").style.display = "none";
		if ( txtValue("ddlColonia") > -1 )
			document.getElementById("colok").style.display = "inline-block";
		else
			document.getElementById("colok").style.display = "none";
	}
	if ( txtValue("txtnint") != '' )
		document.getElementById("nintok").style.display = "inline-block";	
	else
		document.getElementById("nintok").style.display = "none";
	if ( txtValue("txtcp").match(caracteresValidos) )
		document.getElementById("cpok").style.display = "inline-block";	
	else
		document.getElementById("cpok").style.display = "none";
	if ( tipo == "extranjera" ) {
		if ( txtValue("txtColonia") != '' )
			document.getElementById("colok").style.display = "inline-block";	
		else
			document.getElementById("colok").style.display = "none";
		if ( txtValue("txtEstado") != '' )
			document.getElementById("estadook").style.display = "inline-block";	
		else
			document.getElementById("estadook").style.display = "none";
		if ( txtValue("txtMunicipio") != '' )
			document.getElementById("ciudadok").style.display = "inline-block";	
		else
			document.getElementById("ciudadok").style.display = "none";
	}
	if(Existe("txtnombre"))
	    VerificarRepresentanteLeg();
}
function VerificarRepresentanteLeg(){
	if(txtValue("txtnombre") != '')
		document.getElementById("txtnombreok").style.visibility = "visible";
	else
		document.getElementById("txtnombreok").style.visibility = "hidden";
		
	if(txtValue("txtpaterno") !=  '')
		document.getElementById("txtpaternook").style.visibility = "visible";
	else
		document.getElementById("txtpaternook").style.visibility = "hidden";
		
	if(txtValue("txtmaterno") != '')
		document.getElementById("txtmaternook").style.visibility = "visible";
	else
		document.getElementById("txtmaternook").style.visibility = "hidden";
		
	if(txtValue("txtnumiden") != '')
		document.getElementById("txtnumidenok").style.visibility = "visible";
	else
		document.getElementById("txtnumidenok").style.visibility = "hidden";
		
	if(txtValue("txtrrfc") != '')
		document.getElementById("txtrrfcok").style.visibility = "visible";
	else
		document.getElementById("txtrrfcok").style.visibility = "hidden";
	
	if(txtValue("txtcurp") != '')
		document.getElementById("txtcurpok").style.visibility = "visible";
	else
		document.getElementById("txtcurpok").style.visibility = "hidden";
	
	if(txtValue("ddlTipoIden") > -1)
		document.getElementById("ddlTipoIdenok").style.visibility = "visible";
	else
		document.getElementById("ddlTipoIdenok").style.visibility = "hidden";
	
	VerificarContrato();
}
function VerificarContrato(){
	var permitirGuardarCambios = false;
	if(txtValue("txtrfc") != '') {
		document.getElementById("txtrfcok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("txtrfcok").style.visibility = "hidden";
	}
	if(txtValue("txtrazon") !=  '') {
		document.getElementById("txtrazonok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("txtrazonok").style.visibility = "hidden";
	}
	if(txtValue("txtfecha") !=  '') {
		document.getElementById("txtfechaok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("txtfechaok").style.visibility = "hidden";
	}
	if(txtValue("ddlRegimen") > -1) {
		document.getElementById("ddlRegimenok").style.visibility = "visible";
		permitirGuardarCambios = true;
	} else {
		document.getElementById("ddlRegimenok").style.visibility = "hidden";
	}
	if ( permitirGuardarCambios ) {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "visible";
		}
	} else {
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById("guardarCambios").style.visibility = "hidden";
		}
	}	
}

function EditarContratoCorresponsal( tipo ){
	var rfc = txtValue("txtrfc");
	var rsocial = txtValue("txtrazon");
	var fconst = txtValue("txtfecha");
	var regimen = txtValue("ddlRegimen");
	var parametros = "f=0";
	var band = false;
	
	var calle = txtValue("txtcalle");
	var nint = txtValue("txtnint");
	var next = txtValue("txtnext");
	var pais = txtValue("ddlPais");
	if ( tipo == "nacional" ) {
		var edo = txtValue("ddlEstado");
		var ciudad = txtValue("ddlMunicipio");
		var colonia = txtValue("ddlColonia");
	} else if ( tipo == "extranjera" ) {
		var edo = txtValue("txtEstado");
		var ciudad = txtValue("txtMunicipio");
		var colonia = txtValue("txtColonia");
	}
	var cp = txtValue("txtcp");
	var parametros = "f=0";
	
	var nombre = txtValue("txtnombre");
	var paterno = txtValue("txtpaterno");
	var materno = txtValue("txtmaterno");
	var numiden = txtValue("txtnumiden");
	var tipoiden = txtValue("ddlTipoIden");
	var rrfc = txtValue("txtrrfc");
	var curp = txtValue("txtcurp");
	var figura = (document.getElementById("chkfigura").checked) ? 0 : 1;
	var familia = (document.getElementById("chkfamilia").checked) ? 0 : 1;
	
	var dirGral = (document.getElementById("chkDirGral").checked) ? "false" : "true";
	
	if(validaRFC("txtrfc")){
	
	    parametros+="&rfc="+rfc;
	    if(rsocial != ''){
		    parametros+="&rsocial="+rsocial;
		    if(fconst != ''){
			    parametros+="&fconstitucion="+fconst;
			    if(regimen != ''){
				    parametros+="&regimen="+regimen;
				    band = true;
			    }else{
				    alert("Favor de seleccionar un regimen");
					return false;
			    }
		    }else{
			    alert("Favor de seleccionar una fecha de constitucion");
				return false;
		    }
	    }else{
		    alert("Favor de escribir una razon social");
			return false;
	    }
	    
	}else{
		alert("El RFC es incorrecto. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX para persona f\u00EDsica o ABC680524P76 para persona moral.");
		return false;
	}
	
	if(calle != '')
		parametros+="&calle="+calle;
	if(nint != '')
		parametros+="&nint="+nint;
	if(next != '')
		parametros+="&next="+next;
	if(pais != '')
		parametros+="&idpais="+pais;
	if(edo != '')
		parametros+="&idestado="+edo;
	if(ciudad != '')
		parametros+="&idciudad="+ciudad;
	if(colonia != '')
		parametros+="&idcolonia="+colonia;
	if(cp != '')
		parametros+="&cp="+cp;
	    
	if(validaRFCPersona("txtrrfc")){
	    if(validaCURP("txtcurp")){
		if(nombre != '' && paterno != '' && materno != '' && numiden != '' && tipoiden > -1 && curp != ''){
		    parametros+="&nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&numiden="+numiden+"&tipoiden="+tipoiden+"&rrfc="+rrfc+"&curp="+curp+"&figura="+figura+"&familia="+familia;
		}else{
		    band = false;
		    alert("Favor de escribir los datos del representante legal");
			return false;
		}
	    }else{
		band = false;
		alert("El CURP del representante legal es incorrecto. Favor de escribirlo en un formato v\u00E1lido. Ejemplo: PUXB571021HNELXR00");
		return false;
	    }
	    
	}else{
	    band = false;
	    alert("El RFC del representante legal es incorrecto. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX para persona f\u00EDsica o ABC680524P76 para persona moral.");
		return false;
	}

	if ( pais < 0 ) {
		band = false;
		alert("Falta seleccionar Pais");
		return false;
	}
	
	if ( pais == '' ) {
		band = false;
		alert("Falta seleccionar Pais");
		return false;
	}
	
	if ( calle == '' ) {
		band = false;
		alert("Falta escribir Calle");
		return false;
	}
	
	if ( next == '' ) {
		band = false;
		alert("Falta escribir Numero Exterior");
		return false;
	}
	
	if ( cp == '' ) {
		band = false;
		alert("Falta escribir Codigo Postal");
		return false;
	}	
	
	if ( pais == 164 ) {
		if ( colonia < 0 ) {
			band = false;
			alert("Falta seleccionar Colonia");
			return false;
		}		
		if ( edo < 0 ) {
			band = false;
			alert("Falta seleccionar Estado");
			return false;
		}
		if ( ciudad < 0 ) {
			band = false;
			alert("Falta seleccionar Ciudad");
			return false;
		}
	}	
	
	if ( pais != 164 && pais > 0 ) {
		if ( colonia == '' ) {
			band = false;
			alert("Falta escribir Colonia");
			return false;
		}
		if ( edo == '' ) {
			band = false;
			alert("Falta escribir Estado");
			return false;
		}		
		if ( ciudad == '' ) {
			band = false;
			alert("Falta escribir Ciudad");
			return false;
		}
	}

	if(band){
	    parametros+="&dirGral="+dirGral;
		parametros += "&tipodireccion=" + tipo;
	    MetodoAjax2("../../inc/Ajax/_Clientes/EditarContratoPreCorresponsal.php",parametros);
	    
	    //window.setTimeout("Recargar()",100);
	}
	
}



function CheckDirGral( tipoAlta, tipoDir )
{
	var isChecked = document.getElementById("chkDirGral").checked;
	if ( isChecked ) {
		var urlAjax = "";
		if ( tipoAlta == "PreSubCadena" ) {
			urlAjax = "../../inc/Ajax/_Clientes/PreCargarDireccionPreSubCadena.php";
		} else if ( tipoAlta == "PreCorresponsal" ) {
			urlAjax = "../../inc/Ajax/_Clientes/PreCargarDireccionPreCorresponsal.php";
		}
		$.post( urlAjax ).done(
			function( data ) {
				var direccion = jQuery.parseJSON( data );
				if ( direccion.codigoDeRespuesta == 0 ) {
					$("#txtcalle").val(direccion.calle);
					$("#txtnext").val(direccion.numeroExterior);
					$("#txtnint").val(direccion.numeroInterior);
					$("#ddlPais").val(direccion.pais);
					if ( direccion.pais == 164 ) {
						tipoDireccion = "nacional";
						tipoDir = "nacional";
						$("#txtColonia").css("display", "none");
						$("#txtEstado").css("display", "none");
						$("#txtMunicipio").css("display", "none");
					} else {
						tipoDireccion = "extranjera";
						tipoDir = "extranjera";
					}
					cambiarEstado( direccion.pais, 'selectestados', direccion.estado, true, tipoAlta, tipoDir );
					cambiarCiudad( direccion.pais, direccion.estado, 'divCd', direccion.ciudad, true, tipoAlta, tipoDir );
					cambiarColonia( direccion.pais, direccion.estado, direccion.ciudad, 'divCol', direccion.colonia, true, tipoAlta, tipoDir );
					$("#txtcp").val(direccion.codigoPostal);
					Bloquear("txtcalle");
					Bloquear("txtnext");
					Bloquear("txtnint");
					Bloquear("txtcp");
					Bloquear("ddlPais");
					Bloquear("ddlColonia");
					Bloquear("ddlMunicipio");
					Bloquear("ddlEstado");					
					if ( tipoAlta == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipoAlta == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					}
				} else {
					alert(direccion.mensajeDeRespuesta);
					Desbloquear("txtcalle");
					Desbloquear("txtnext");
					Desbloquear("txtnint");
					Desbloquear("ddlColonia");
					Desbloquear("txtcp");
					Desbloquear("ddlPais");
					setValue("txtcalle","");
					setValue("txtnext","");
					setValue("txtnint","");
					setValue("txtcp","");
					setValue("ddlColonia",-1);
					setValue("ddlMunicipio",-2);
					setValue("ddlEstado",-2);
					setValue("ddlPais",-2);
					if ( tipoDir == "nacional" ) {
						vaciarCiudades("divCd");
						vaciarColonias("divCol");
					} else if ( tipoDir == "extranjera" ) {
						setValue("txtColonia", "");
						setValue("txtEstado", "");
						setValue("txtMunicipio", "");
					}
					Bloquear("ddlMunicipio");
					if ( tipoAlta == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipoAlta == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					}
				}
			}
		);
		
	} else {
		var txtColoniaDisplay = $("#txtColonia").css("display");
		var txtEstadoDisplay = $("#txtEstado").css("display");
		var txtMunicipioDisplay = $("#txtMunicipio").css("display");
		Desbloquear("txtcalle");
		Desbloquear("txtnext");
		Desbloquear("txtnint");
		Desbloquear("ddlColonia");
		Desbloquear("txtcp");
		Desbloquear("ddlPais");
		Desbloquear("txtColonia");
		Desbloquear("txtEstado");
		Desbloquear("txtMunicipio");
		if ( tipoAlta == "PreSubCadena" ) {
			VerificarDireccionSub(tipoDir);
		} else if ( tipoAlta == "PreCorresponsal" ) {
			VerificarDireccionCorr(tipoDir);
		}
	}
}

/**
* Permite cargar un Drop Down List con todos
* los estados basandose en la seleccion de
* algun pais. Tambien permite seleccionar
* un estado en particular por default.
* Parametro		paisID				ID del pais al que pertenecen
*									los estados que se quieren cargar.
* Parametro		listaID				ID del DIV HTML que contiene la lista
*									de estados que se quiere cargar.
* Parametro		estadoSeleccionado	Estado que se quiere seleccionar por
*									default. Si no hay ninguno entonces
*									poner un valor de -2 o aquel que corresponda
*									a la opcion generica por default.
* Parametro		disabled			Booleano que indica si la nueva lista debe
*									estar deshabilitada.
* Valor de retorno:	Un elemento SELECT HTML con los Estados. En caso de no
* encontrarlos se regresa un elemento SELECT HTML con un mensaje de Error.
* Autor:	Ing. Roberto Cortina
* Fecha de creacion:		7 de febrero de 2014
* Fecha de modificacion:	7 de febrero de 2014
**/
function cambiarEstado( paisID, listaID, estadoSeleccionado, disabled, tipo, tipoDir ) {
	$.post( '../../inc/Ajax/_Clientes/CambioEstado.php', { "idpais": paisID } ).done(
		function( listaEstados ) {
			if ( paisID == 164 ) {
				if ( listaEstados != null || listaEstados != '' ) {
					$("#ddlEstado").replaceWith( listaEstados );
					$("#ddlEstado").val(estadoSeleccionado);
					if ( disabled ) {
						$("#ddlEstado").prop("disabled", true);
					} else {
						$("#ddlEstado").prop("disabled", false);		
					}
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);	
					}
				}
			} else {
				if ( listaEstados != null || listaEstados == '' ) {
					$("#ddlEstado").replaceWith( listaEstados );
					$("#ddlEstado").val(estadoSeleccionado);
					$("#ddlEstado").css("display", "none");
					$("#txtEstado").css("display", "block");
					setValue("txtEstado", $("#ddlEstado option:selected").text());
					Bloquear("txtEstado");
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);	
					}					
				}
			}
		}
	);
}

/**
* Permite cargar un Drop Down List con todas
* las ciudades basandose en la seleccion de
* algun pais. Tambien permite seleccionar
* una ciudad en particular por default.
* Parametro		paisID				ID del pais al que pertenecen
*									las ciudades que se quieren cargar.
* Parametro		listaID				ID del DIV HTML que contiene la lista
*									de ciudades que se quiere cargar.
* Parametro		estadoSeleccionado	Ciudad que se quiere seleccionar por
*									default. Si no hay ninguno entonces
*									poner un valor de -2 o aquel que corresponda
*									a la opcion generica por default.
* Parametro		disabled			Booleano que indica si la nueva lista debe
*									estar deshabilitada.
* Valor de retorno:	Un elemento SELECT HTML con las Ciudades. En caso de no
* encontrarlos se regresa un elemento SELECT HTML con un mensaje de Error.
* Autor:	Ing. Roberto Cortina
* Fecha de creacion:		7 de febrero de 2014
* Fecha de modificacion:	7 de febrero de 2014
**/
function cambiarCiudad( paisID, estadoID, listaID, ciudadSeleccionada, disabled, tipo, tipoDir ) {
	$.post( '../../inc/Ajax/_Clientes/BuscaSelectCd.php', { "idpais": paisID, "idedo": estadoID } ).done(
		function( listaCiudades ) {
			if ( paisID == 164 ) {
				if ( listaCiudades != null || listaCiudades != '' ) {
					$("#ddlMunicipio").replaceWith( listaCiudades );
					//$("#"+listaID).append( '<input type="text" style="display:none;" name="txtMunicipio" id="txtMunicipio" value="" />' );
					$("#ddlMunicipio").val(ciudadSeleccionada);
					if ( disabled ) {
						$("#ddlMunicipio").prop("disabled", true);
					} else {
						$("#ddlMunicipio").prop("disabled", false);		
					}
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					} else if ( tipo == "PreCadena" ) {
						VerificarDireccionCad(tipoDir);	
					}
				}
			} else {
				if ( listaCiudades != null || listaCiudades != '' ) {
					$("#ddlMunicipio").replaceWith( listaCiudades );
					$("#ddlMunicipio").val(ciudadSeleccionada);
					$("#ddlMunicipio").css("display", "none");
					$("#txtMunicipio").css("display", "block");
					setValue("txtMunicipio", $("#ddlMunicipio option:selected").text());
					Bloquear("txtMunicipio");
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					} else if ( tipo == "PreCadena" ) {
						VerificarDireccionCad(tipoDir);	
					}					
				}
			}
		}
	);
}

/**
* Permite cargar un Drop Down List con todas
* las ciudades basandose en la seleccion de
* algun pais. Tambien permite seleccionar
* una ciudad en particular por default.
* Parametro		paisID				ID del pais al que pertenecen
*									las ciudades que se quieren cargar.
* Parametro		listaID				ID del DIV HTML que contiene la lista
*									de ciudades que se quiere cargar.
* Parametro		estadoSeleccionado	Ciudad que se quiere seleccionar por
*									default. Si no hay ninguno entonces
*									poner un valor de -2 o aquel que corresponda
*									a la opcion generica por default.
* Parametro		disabled			Booleano que indica si la nueva lista debe
*									estar deshabilitada.
* Valor de retorno:	Un elemento SELECT HTML con las Ciudades. En caso de no
* encontrarlos se regresa un elemento SELECT HTML con un mensaje de Error.
* Autor:	Ing. Roberto Cortina
* Fecha de creacion:		7 de febrero de 2014
* Fecha de modificacion:	7 de febrero de 2014
**/
function cambiarColonia( paisID, estadoID, ciudadID, listaID, coloniaSeleccionada, disabled, tipo, tipoDir ) {
	$.post( '../../inc/Ajax/BuscaSelectColonias.php', { "idpais": paisID, "idedo": estadoID, "idcd": ciudadID } ).done(
		function( listaColonias ) {
			if ( paisID == 164 ) {
				if ( listaColonias != null || listaColonias != '' ) {
					$("#ddlColonia").replaceWith( listaColonias );
					$("#ddlColonia").val(coloniaSeleccionada);
					if ( disabled ) {
						$("#ddlColonia").prop("disabled", true);
					} else {
						$("#ddlColonia").prop("disabled", false);		
					}
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					}
				}
			} else {
				if ( listaColonias != null || listaColonias != '' ) {
					$("#ddlColonia").replaceWith( listaColonias );
					$("#ddlColonia").val(coloniaSeleccionada);
					$("#ddlColonia").css("display", "none");
					$("#txtColonia").css("display", "block");
					setValue("txtColonia", $("#ddlColonia option:selected").text());
					Bloquear("txtColonia");
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					}
				}
			}
		}
	);
}

function cambiarPantalla() {
	var pais = txtValue('ddlPais');
	var coloniaDisplay = document.getElementById('ddlColonia').style.display;
	var estadoDisplay = document.getElementById('ddlEstado').style.display;
	var ciudadDisplay = document.getElementById('ddlMunicipio').style.display;
	if ( document.getElementById('colok') ) {
		var coloniaOKDisplay = document.getElementById('colok').style.display;
	}
	if ( document.getElementById('estadook') ) {
		var estadoOKDisplay = document.getElementById('estadook').style.display;
	}
	if ( document.getElementById('ciudadok') ) {
		var ciudadOKDisplay = document.getElementById('ciudadok').style.display;
	}
	if ( document.getElementById('cpok') ) {
		var codigoPostalOKDisplay = document.getElementById('cpok').style.display;
	}
	if ( pais != 164 && pais != -2 ) {
		if ( coloniaDisplay != 'none' ) {
			document.getElementById('ddlColonia').style.display = 'none';
		}
		if ( estadoDisplay != 'none' ) {
			document.getElementById('ddlEstado').style.display = 'none';
		}
		if ( ciudadDisplay != 'none' ) {
			document.getElementById('ddlMunicipio').style.display = 'none';
		}
		document.getElementById('txtColonia').style.display = 'block';
		document.getElementById('txtEstado').style.display = 'block';
		document.getElementById('txtMunicipio').style.display = 'block';
		tipoDireccion = "extranjera";
	} else if ( pais != -2 ) {
		if ( coloniaDisplay == 'none' ) {
			document.getElementById('ddlColonia').style.display = 'block';
		}
		if ( estadoDisplay == 'none' ) {
			document.getElementById('ddlEstado').style.display = 'block';
		}
		if ( ciudadDisplay == 'none' ) {
			document.getElementById('ddlMunicipio').style.display = 'block';
		}
		document.getElementById('txtColonia').style.display = 'none';
		document.getElementById('txtEstado').style.display = 'none';
		document.getElementById('txtMunicipio').style.display = 'none';
		tipoDireccion = "nacional";
	}
}

function vaciarEstados( listaID ) {
	var listaEstados = "<select name=\"ddlEstado\" id=\"ddlEstado\" onchange=\"VerificarDireccionSub();\">";
	listaEstados += "<option value=\"-2\">Seleccione un Edo</option>";
	listaEstados += "</select>";
	$("#ddlEstado").replaceWith(listaEstados);
}

function vaciarCiudades( listaID ) {
	var listaCiudades = "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\" title=\"Favor de selecionar un Edo. antes\">";
	listaCiudades += "<option value='-2'>Seleccione una Ciudad</option>";
	listaCiudades += "</select>";
	$("#ddlMunicipio").replaceWith(listaCiudades);	
}

function vaciarColonias( listaID ) {
	var listaColonias = "<select name=\"ddlColonia\" id=\"ddlColonia\"";
	listaColonias += "onchange=\"VerificarDireccionSub(tipoDireccion);\"";
	listaColonias += "style=\"display:block;\">";
	listaColonias += "<option value='-1'>Seleccione una Colonia</option>";
	listaColonias += "</select>";
	$("#ddlColonia").replaceWith(listaColonias);
}

function CheckDirGral2()
{
	Bloquear("txtcalle");
	Bloquear("txtnext");
	Bloquear("txtnint");
	Bloquear("txtcp");
	Bloquear("ddlColonia");
	Bloquear("ddlMunicipio");
	Bloquear("ddlEstado");
	Bloquear("ddlPais");
}


function VerificarGrlsCorr(){
	if(txtValue("ddlCadena") > -1)
		document.getElementById("cadok").style.visibility = "visible";
	else
		document.getElementById("cadok").style.visibility = "hidden";
		
	var idsubcadena = txtValue("ddlSubCad");
	var tiposub = idsubcadena.split("|");
	if(tiposub[1] !== undefined && tiposub[1] > -1)
		document.getElementById("subcadok").style.visibility = "visible";
	else
		document.getElementById("subcadok").style.visibility = "hidden";
	if(txtValue("ddlGiro") > -1)
		document.getElementById("girook").style.visibility = "visible";
	else
		document.getElementById("girook").style.visibility = "hidden";
	if(txtValue("ddlGrupo") > -1)
		document.getElementById("grupook").style.visibility = "visible";
	else
		document.getElementById("grupook").style.visibility = "hidden";
	if(txtValue("ddlReferencia") > -1)
		document.getElementById("refok").style.visibility = "visible";
	else
		document.getElementById("refok").style.visibility = "hidden";
	if(txtValue("txttel1") != '' && validaTelefono("txttel1"))
		document.getElementById("tel1ok").style.visibility = "visible";
	else{
		document.getElementById("tel1ok").style.visibility = "hidden";
	}
	if (txtValue("txttel2") != '' && validaTelefono("txttel2")) {
		document.getElementById("tel2ok").style.visibility = "visible";
	}else{
		document.getElementById("tel2ok").style.visibility = "hidden";
	}
	if (txtValue("txtfax") != '' && validaTelefono("txtfax")) {
		document.getElementById("faxok").style.visibility = "visible";
	}else{
		document.getElementById("faxok").style.visibility = "hidden";
	}
	if(txtValue("txtmail") != '' && validarEmail("txtmail"))
		document.getElementById("mailok").style.visibility = "visible";
	else{
		document.getElementById("mailok").style.visibility = "hidden";
	}
	if (txtValue("txtfax") != '' && validaTelefono("txtfax")) {
		document.getElementById("faxok").style.visibility = "visible";
	}else{
		document.getElementById("faxok").style.visibility = "hidden";
	}
	if (txtValue("txtNumSucursal") != '') {
		document.getElementById("numsucursalok").style.visibility = "visible";
	}else{
		document.getElementById("numsucursalok").style.visibility = "hidden";
	}
	if (txtValue("txtNomSucursal") != '') {
		document.getElementById("nomsucursalok").style.visibility = "visible";
	}else{
		document.getElementById("nomsucursalok").style.visibility = "hidden";
	}	
	if(txtValue("ddlIva") > -1)
		document.getElementById("ivaok").style.visibility = "visible";
	else
		document.getElementById("ivaok").style.visibility = "hidden";
}

