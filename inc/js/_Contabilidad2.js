/**************************************************FUNCIONES DE _CONTABILIDAD*/

function BuscarPagoProveedores(){
	var factual = new Date();
	var fecha1 = txtValue("fecha1");
	var fecha2 = txtValue("fecha2");
	var parametros = "";
	var banderaz = false;
	var proveedor = document.getElementById("ddlProveedor").value;
	var familia = document.getElementById("ddlFamilia").value;
	parametros+="proveedor="+proveedor+"&familia="+familia;
	if(fecha1 != '' && fecha2 != ''){
		parametros+="&fecha1="+fecha1+"&fecha2="+fecha2;
		//Peticion ajax
		http.open("POST","../../../inc/Ajax/_Contabilidad/BuscaPagoProveedor.php", true);
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
				document.getElementById('divRES').innerHTML = RespuestaServidor;//alert("ddd");
				OcultarEmergente();
				if(RespuestaServidor != "<label class='subtitulo_contenido'>Lo sentimos pero no se encontraron resultados</label><input type='hidden' name='busq' id='busq' value='1' />"){
					BuscaTotalProveedores();
					banderaz = true;
				}
			} 
		}
		http.send(parametros);
		
		
		//BuscarParametros("../../../inc/Ajax/_Contabilidad/BuscaPagoProveedor.php",parametros);
		//BuscaTotalProveedores
		if(banderaz){
		var nproveedor = document.getElementById("ddlProveedor").options[document.getElementById("ddlProveedor").selectedIndex].text;
		var fproveedor = document.getElementById("ddlFamilia").options[document.getElementById("ddlFamilia").selectedIndex].text;
		document.getElementById("idProv").innerHTML = "<label><span style='font-weight:bold;'>IdProveedor: </span><span style='font-weight:bold;color:#3399ff'>"+proveedor+"</span></label>";
		document.getElementById("nombreProv").innerHTML = "<label><span style='font-weight:bold;'>Nombre Proveedor: </span><span style='font-weight:bold;color:#3399ff'>"+nproveedor+"</span></label>";
		document.getElementById("familiaProv").innerHTML = "<label><span style='font-weight:bold;'>Familia Proveedor: </span><span style='font-weight:bold;color:#3399ff'>"+fproveedor+"</span></label>";
		}
	}
	else
		alert("Favor De Escribir Un Rango De Fechas");
}

//Calcula el total a pagar a los proveedores
function BuscaTotalProveedores(){
	var parametros = "";
	var proveedor = document.getElementById("ddlProveedor").value;
	var familia = document.getElementById("ddlFamilia").value;
	var fecha1 = txtValue("fecha1");
	var fecha2 = txtValue("fecha2");
	var tipo = 1;
	if(Existe("ddlTipo")){
		tipo = document.getElementById("ddlTipo").value;
	}
		var ieps = 0;
		if(familia == 1){
			if(document.getElementById("chkieps").checked)
			ieps = 1;
		}
		parametros+="proveedor="+proveedor+"&familia="+familia+"&tipo="+tipo+"&ieps="+ieps;
		if(fecha1 != '' && fecha2 != ''){
			parametros+="&fecha1="+fecha1+"&fecha2="+fecha2;
			//PETICION AJAX
			http.open("POST","../../../inc/Ajax/_Contabilidad/CalcularTotalProveedor.php", true);
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
					document.getElementById('lblimporte').innerHTML = RespuestaServidor;//alert("ddd");
					OcultarEmergente();
					Ordenar();
				} 
			}
			http.send(parametros);
			
		}
		else
			alert("Favor De Escribir Un Rango De Fechas");
	
}


function CreaReembolsoManual(){
	document.getElementById("divRES").innerHTML = "";
	var parametros = "";
	var cadena =  document.getElementById("ddlCad").value;
	var subcadena =  document.getElementById("ddlSubCad").value;
	var corresponsal =  document.getElementById("ddlCorresponsal").value;
	var importe = document.getElementById("txtimporte").value;
	var descripcion = document.getElementById("txtdescripcion").value;
	var fecha = txtValue("txtfecha");
	if(cadena > -1 && subcadena > -1 && corresponsal > -1 && importe != '' && descripcion != '' && fecha != ''){
		parametros+= "cadena="+cadena+"&subcadena="+subcadena+"&corresponsal="+corresponsal+"&importe="+importe+"&descripcion="+descripcion+"&fecha="+fecha;
		BuscarParametros("../../../inc/Ajax/_Contabilidad/ReembolsoManual.php",parametros)
	}else{
		alert("Todos los Campos Son Obligatorios");
	}
	
}
//Funcion sin utilidad
//Inserta un pago de proveedor
function InsertPagoProveedor(){
	var parametros = "";
	var proveedor = document.getElementById("ddlProveedor").value;
	var familia = document.getElementById("ddlFamilia").value;
	var fecha1 = txtValue("fecha1");
	var fecha2 = txtValue("fecha2");
	//var tipoliquidacion =  document.getElementById("ddlTipo").value;
	var cuenta = document.getElementById("ddlNumCuenta").value;
	parametros+="proveedor="+proveedor+"&familia="+familia+"&numcuenta="+cuenta;
	if(fecha1 != '' && fecha2 != ''){
		parametros+="&fecha1="+fecha1+"&fecha2="+fecha2;
		MetodoAjax("../../../inc/Ajax/_Contabilidad/AgregarCorteProveedor.php",parametros)
	}else{
		alert("Favor de ingresar la informacion");
	}
	
}
//Busca los pago pendientes a proveedores
function BuscarCorteProveedor(){
	var parametros = "";
	var proveedor = document.getElementById("ddlProveedor").value;
	var fecha1 = txtValue("fecha1");
	var fecha2 = txtValue("fecha2");
	//var cuenta = document.getElementById("ddlNumCuenta").value;
	//parametros+="proveedor="+proveedor+"&numcuenta="+cuenta;
	parametros+="proveedor="+proveedor+"&fecha1="+fecha1+"&fecha2="+fecha2;
	BuscarParametros("../../../inc/Ajax/_Contabilidad/BuscarCorteProveedor.php",parametros);
}

//Obtiene el numero de cuenta y el forelo de el corresponsal
function BuscarDatosReembolsos(){
	document.getElementById('lblnocuenta').innerHTML = "";
	document.getElementById("cantforelo").innerHTML = "";
	var cadena =  document.getElementById("ddlCad").value;
	var subcadena =  document.getElementById("ddlSubCad").value;
	var corresponsal =  document.getElementById("ddlCorresponsal").value;
	var parametros = "";
	
	if(cadena > -1 || subcadena > -1 && corresponsal > -1){
		if(corresponsal == -1){
			categoria = 2;
		}
		if(subcadena == -1){
			categoria = 1;
		}
		parametros+= "cadena="+cadena+"&subcadena="+subcadena+"&corresponsal="+corresponsal+"&categoria="+categoria;
	}
	if(parametros != ""){
		document.getElementById('lblnocuenta').innerHTML = "";//alert("ddd");
		document.getElementById("cantforelo").innerHTML = "";
		//PETICION AJAX
		http.open("POST","../../../inc/Ajax/_Contabilidad/BuscaDatosReembolsos.php", true);
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
				var R = RespuestaServidor.split("|");
				validaSession(R[0]);
				if(R[0] == 1){
					document.getElementById('lblnocuenta').innerHTML = R[1];
					document.getElementById("cantforelo").innerHTML = R[2];
				}
				OcultarEmergente();
			} 
		}
		http.send(parametros);
	}
}

//function BuscarReembolsos2(){
//	//PETICION AJAX
//	http.open("POST","../../../inc/Ajax/_Contabilidad/BuscaReembolsos.php", true);
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
//			var R = RespuestaServidor.split("|");
//			if(R[0] == 1){
//				document.getElementById('lblnocuenta').innerHTML = R[1];//alert("ddd");
//				document.getElementById("cantforelo").innerHTML = R[2];
//				document.getElementById("divRES").innerHTML =  R[3];
//			}else if(R[0] == 2){
//				
//			}
//			OcultarEmergente();
//		} 
//	}
//	http.send();
//}

//Funcion Sin utilidad
//function AutorizacionReembolso(i){
//	MetodoAjax2("../../../inc/Ajax/_Contabilidad/ReembolsoAutorizacion.php","corte="+i);
//	window.setTimeout('BuscarReembolsos()',200);
//}


//LA COMENTE PARA QUE NO ME ESTORBARA EN LA PARTE DE DEPOSITOS DE CONTABILIDAD
//$(function() {
//	$( "#txtfecha" ).datepicker({
//		showOn: "button",
//		dateFormat: "dd-mm-yy",
//		buttonImage: "../../../../img/cal.gif",
//		buttonImageOnly: true
//	});
//});


//$(function() {
//	$( "#txtfecha1" ).datepicker({
//		showOn: "button",
//		buttonImage: "../../../../img/cal.gif",
//		buttonImageOnly: true
//	});
//});
//$(function() {
//	$( "#txtfecha2" ).datepicker({
//		showOn: "button",
//		buttonImage: "../../../../img/cal.gif",
//		buttonImageOnly: true
//	});
//});




//***************** DEPOSITOS *****************************//

function BuscaDepositoManual(i){
	var numcuenta = txtValue("NumCta");
	var importe = txtValue("Importe");
	var fecha = txtValue("fecha");
	var autorizacion = txtValue("Autorizacion");
	var estatus = -1;
	var parametros = "";
	parametros+="tipo=0";
	parametros+= (numcuenta != '') ? "&numcuenta=" + numcuenta : '';
	parametros+= (importe != '') ? "&importe=" + importe : '';
	parametros+= (fecha != '') ? "&fecha=" + fecha : '';
	parametros+= (autorizacion != '') ? "&autorizacion=" + autorizacion : '';
	
	if(document.getElementById("rbtaplicado").checked)
		parametros+= "&estatus=0";
	if(document.getElementById("rbtpendiente").checked)
		parametros+= "&estatus=1";
	if(document.getElementById("rbtcancelado").checked)
		parametros+= "&estatus=5";
	if(document.getElementById("rbttodos").checked)
		parametros+= "&estatus=-1";
	//var parametros ="numcuenta="+tipo+"&fechai="+fechai+"&fechaf="+fechaf;
	//var parametros ="numcuenta=70020108914&importe=-1&folio=-1&status=-1&importe=-1&tipo=-1";
		//alert(parametros);	
	BuscarParametros("../../inc/Ajax/_Contabilidad/BuscaDepositos2.php",parametros,'',i);
}

function BuscaDetallesDeposito(){
	if(Existe("ordertabla")){
		var bref = "";
		var est = "";
		document.getElementById("hvalores").value = "";
		document.getElementById("hvaloresestatus").value = "";
		$("#ordertabla tbody").children("tr").each(function(index){
			$(this).children("td").each(function(index2){
				//alert(index2)
			    if(index2 == 8){
				if($(this).children(".chkd").is(':checked')) {
					//alert("si")
				    x = $(this).children(".hidmov").val()
				    
				    est = $(this).children(".hestatus").val()
				    if(x !== undefined){
					document.getElementById("hvalores").value+= x+","
					document.getElementById("hvaloresestatus").value+= est+","
				    }
				}else{
					//alert("no")
				}
			    }
			})
			});
		//alert(document.getElementById("hvalores").value)
		if(document.getElementById("hvalores").value != ''){
			$("#pieautorizar").css({"visibility":"hidden"});
			$("#piecancelar").css({"visibility":"hidden"});
			$("#base4").css({"width":"500px"})
			document.getElementById("NomCorPopUp").innerHTML = "Detalle Depositos";
			MetodoAjaxDiv("../../inc/Ajax/_Contabilidad/DetallesDepositos2.php","hvalores="+document.getElementById("hvalores").value+"&hvaloresestatus="+document.getElementById("hvaloresestatus").value);
			window.setTimeout("OcultarEmergente()",400);			
		}else
			alert("Favor de seleccionar almenos un deposito")
	}else{
		alert("Favor de realizar una busqueda para ver los detalles de los depositos")
	}
	
}
function VerOtrosDepositos(cta){
	
	setValue("NomCorPopUp","Ultimos Depositos");
	VisibilityDivHidden('pieautorizar');
	var parametros = "cuenta="+cta;
	$("#base4").css({"max-width":"700px"})
	$("#base4").css({"width":"700px"})
	http.open("POST","../../../inc/Ajax/_Contabilidad/VerOtrosDepositos.php", true);
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
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			MostrarPopUp(RespuestaServidor);	
		} 
	}
	http.send(parametros);
}

function BuscaDepositoCancelar(){
	if(Existe("ordertabla")){
		document.getElementById("hvalores").value = "";
		$("#ordertabla tbody").children("tr").each(function(index){
			$(this).children("td").each(function(index2){
			    if(index2 == 8){
				if($(this).children(".chkd").is(':checked')) {
				    x = $(this).children(".hidmov").val()
				    estatus = $(this).children(".hestatus").val();
				    if(x !== undefined && estatus != "Cancelado" && estatus != "Aplicado"){
					document.getElementById("hvalores").value+= x+","
				    }else{
					$(this).children(".chkd").removeAttr("checked");
				    }
				}
			    }
			})
			});
		//alert(document.getElementById("hvalores").value)
		if(document.getElementById("hvalores").value != ''){
			$("#pieautorizar").css({"visibility":"hidden"});
			$("#base4").css({"width":"680px"})
			document.getElementById("NomCorPopUp").innerHTML = "Cancelar Depositos";
			$("#piecancelar").css({"visibility":"visible"});
			MetodoAjaxDiv("../../inc/Ajax/_Contabilidad/CancelarDepositos2.php","hvalores="+document.getElementById("hvalores").value+"&consulta=0");
			window.setTimeout("OcultarEmergente()",200);
		}else
			alert("Favor de seleccionar almenos un deposito que se pueda cancelar")
	}else{
		alert("Favor de realizar una busqueda para cancelar los depositos")
	}
	
}

function CancelarDepositos(){
	if(Existe("ordertabla")){
		var estatus = -1;
		document.getElementById("hvalores").value = "";
		$("#ordertabla tbody").children("tr").each(function(index){
			$(this).children("td").each(function(index2){
			    if(index2 == 8){
				if($(this).children(".chkd").is(':checked')) {
				    x = $(this).children(".hidmov").val()
				    estatus = $(this).children(".hestatus").val();
				    if(x !== undefined && estatus != "Cancelado"){
					document.getElementById("hvalores").value+= x+","
				    }
				}
			    }
			})
			});
		//alert(document.getElementById("hvalores").value)
		if(document.getElementById("hvalores").value != ''){
			//$("#pieautorizar").css({"visibility":"hidden"});
			//$("#base4").css({"width":"680px"})
			//document.getElementById("NomCorPopUp").innerHTML = "Cancelar Depositos";
			//$("#piecancelar").css({"visibility":"visible"});
			
			http.open("POST","../../inc/Ajax/_Contabilidad/CancelarDepositos2.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				
			http.onreadystatechange=function() 
			{ 
				if (http.readyState==1)
				{
					//div para  [cargando....]
					OcultarPopUps();
					Emergente();
				}
				if (http.readyState==4)
				{
					OcultarEmergente();
					var RespuestaServidor = http.responseText;//alert("respuesta "+RespuestaServidor);
					validaSession(RespuestaServidor);
					$("#piecancelar").css({"visibility":"hidden"});
					$("#pieautorizar").css({"visibility":"hidden"});
					MostrarPopUp(RespuestaServidor);
					window.setTimeout("OcultarEmergente()",200);
				} 
			}
			http.send("pemiso="+true+"&hvalores="+document.getElementById("hvalores").value+"&consulta=1");
			
			
			//MetodoAjaxDiv("../../inc/Ajax/_Contabilidad/CancelarDepositos.php","hvalores="+document.getElementById("hvalores").value+"&consulta=1");
			//window.setTimeout("OcultarEmergente()",200);
		}else
			alert("Favor de seleccionar almenos un deposito que se pueda cancelar")
	}else{
		alert("Favor de realizar una busqueda para cancelar los depositos")
	}
}

function BuscaDepositoAutorizar(){
	if(Existe("ordertabla")){
		var c = '';
		var importedep = 0;
		var et = "";
		var dautorizar = "";
		var indice = Existe("hindice") ? txtValue("hindice") : 0;
		document.getElementById("hvalores").value = "";
		document.getElementById("hvalorescuentas").value = "";
		document.getElementById("hvaloresimportes").value = "";
		$("#ordertabla tbody").children("tr").each(function(index){
			$(this).children("td").each(function(index2){
			    if(index2 == 8){
				if($(this).children(".chkd").is(':checked')) {
				    x = $(this).children(".hidmov").val()
				    c = $(this).children(".hcuenta").val()
				    et = $(this).children(".hestatus").val()
				    dautorizar = $(this).children(".hautorizar").val()
				    importedep = $(this).children(".himporte").val()
				    if(x !== undefined && et == 'Pendiente' && dautorizar != 'No'){
					document.getElementById("hvalores").value+= x+","
					document.getElementById("hvalorescuentas").value+= c+","
					document.getElementById("hvaloresimportes").value+= importedep+","
				    }else{
					$(this).children(".chkd").removeAttr("checked");
				    }
				}
				
			    }
			})
			
			});
		
		document.getElementById("hvalores").value = document.getElementById("hvalores").value.substring(0, document.getElementById("hvalores").value.length-1);
				document.getElementById("hvalorescuentas").value = document.getElementById("hvalorescuentas").value.substring(0, document.getElementById("hvalorescuentas").value.length-1);
				document.getElementById("hvaloresimportes").value = document.getElementById("hvaloresimportes").value.substring(0, document.getElementById("hvaloresimportes").value.length-1);
		
		//alert(document.getElementById("hvalorescuentas").value)
		if(document.getElementById("hvalores").value != ''){
			$("#piecancelar").css({"visibility":"hidden"});
			$("#base4").css({"width":"680px"})
			document.getElementById("NomCorPopUp").innerHTML = "Autorizar Depósitos";
			$("#pieautorizar").css({"visibility":"visible"});
			$("#pieautorizar").fadeIn("normal");
			//$("#ContentPopUp").css({"height":"500px"});
			var parametros = "hvalores="+document.getElementById("hvalores").value+"&consulta=0"+"&hvalorescuentas="+document.getElementById("hvalorescuentas").value+"&hindice="+indice+"&hvaloresimportes="+document.getElementById("hvaloresimportes").value;
			
			http.open("POST","../../inc/Ajax/_Contabilidad/AutorizarDepositos.php", true);
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
					
					MostrarPopUp(RespuestaServidor);
					$("#base").fadeIn("normal");
					$("#base4").fadeIn("normal");
					if(Existe("hfolio") && Existe("hnumcuenta") && Existe("himporte")){
						setDivHTML("sfolio",txtValue("hfolio"));
						setDivHTML("scuenta",txtValue("hnumcuenta"));
						setDivHTML("simporte",txtValue("himporte"));
					}
				} 
			}
			http.send(parametros+"&pemiso="+true);
			
			
			
		}
		else
			alert("Favor de seleccionar almenos un deposito pendiente para autorizar")
	}else{
		alert("Favor de realizar una busqueda para autorizar los depositos")
	}
	
}

function AutorizarDeposito(){
	var autorizacion = txtValue("txtautorizacion");
	var indice = Existe("hindice") ? txtValue("hindice") : 0;
	//document.getElementById("hvalores").value = "";
	//var x = "";
	//$("#ordertabla tbody").children("tr").each(function(index){
	//		$(this).children("td").each(function(index2){
	//		    if(index2 == 8){
	//			if($(this).children(".chkd").is(':checked')) {
	//			    x = $(this).children(".hidmov").val()
	//			    if(x !== undefined && et == 'Pendiente' && dautorizar != 'No'){
	//				document.getElementById("hvalores").value+= x+","
	//			    }else{
	//				$(this).children(".chkd").removeAttr("checked");
	//			    }
	//			}
	//			
	//		 }
	//	})	
	//});
	
	
	var parametros = "hvalores="+document.getElementById("hvalores").value+"&consulta=1"+"&hindice="+indice+"&autorizacion="+autorizacion;
	
	alert(parametros);
	http.open("POST","../../inc/Ajax/_Contabilidad/AutorizarDepositos.php", true);
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
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");
			validaSession(RESserv[0]);
			
			if(RESserv[0] == 0){
				OcultarPopUps();
				BuscaDepositoAutorizar();
				//alert("ww"+RESserv[0]);
			}else if(RESserv[0] == 9){
				$("#pieautorizar").fadeOut();
				document.getElementById("NomCorPopUp").innerHTML = "Depositos Autorizados";
				//document.getElementById("ContentPopUp").innerHTML = RESserv[1];
				MostrarPopUp(RESserv[1]);
				
			}else if(RESserv[0] == 100){
				//alert("aqui se va a mandar llamar el otro pop up con los autorizados");
				alert(RESserv[1]);
			}else{
				alert(RESserv[1]);
			}
			//MostrarPopUp(RespuestaServidor);
		} 
	}
	http.send(parametros);
	//MetodoAjaxDiv2("../../inc/Ajax/_Contabilidad/AutorizarDepositos.php","hvalores="+document.getElementById("hvalores").value+"&consulta=1"+"&hindice="+indice+"&autorizacion="+autorizacion);
}

function FinalizarAutorizacion(){
	http.open("POST","../../inc/Ajax/_Contabilidad/AutorizarDepositos.php", true);
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
			var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");
			validaSession(RESserv[0]);
			if(RESserv[0] == 0){
				OcultarPopUps();
				BuscaDepositoAutorizar();
				//alert("ww"+RESserv[0]);
			}else if(RESserv[0] == 9){
				$("#pieautorizar").fadeOut();
				document.getElementById("ContentPopUp").innerHTML = RESserv[1];
				
			}else if(RESserv[0] == 100){
				//alert("aqui se va a mandar llamar el otro pop up con los autorizados");
				alert(RESserv[1]);
			}
			//MostrarPopUp(RespuestaServidor);
		} 
	}
	http.send("finalizar=1");
}

var seleccionados = false;
function SelTodos(){
    if(seleccionados == false)
        $(".chkd").attr("checked","checked")
    else
        $(".chkd").removeAttr("checked");
    seleccionados = !seleccionados
}





/* ======================================   Depositos Automaticos   ==============================================*/

function BuscaDepositoAutomatico(i){
	var numcuenta = txtValue("NumCta");
	var ref = txtValue("Referencia");
	var fecha = txtValue("fecha");
	var autorizacion = txtValue("Autorizacion");
	var importe = txtValue("Importe");
	var estatus = -1;
	var parametros = "";
	parametros+="tipo=1";
	parametros+= (numcuenta != '') ? "&numcuenta=" + numcuenta : '';
	parametros+= (ref != '') ? "&ref=" + ref : '';
	parametros+= (fecha != '') ? "&fecha=" + fecha : '';
	parametros+= (autorizacion != '') ? "&autorizacion=" + autorizacion : '';
	parametros+= (importe != '') ? "&importe=" + importe : '';
	
	if(document.getElementById("rbtaplicado").checked)
		parametros+= "&estatus=0";
	if(document.getElementById("rbtpendiente").checked)
		parametros+= "&estatus=1";
	if(document.getElementById("rbtcancelado").checked)
		parametros+= "&estatus=2";
	if(document.getElementById("rbttodos").checked)
		parametros+= "&estatus=-1";
	//var parametros ="numcuenta="+tipo+"&fechai="+fechai+"&fechaf="+fechaf;
	//var parametros ="numcuenta=70020108914&importe=-1&folio=-1&status=-1&importe=-1&tipo=-1";
		//alert(parametros);
	BuscarParametros("../../inc/Ajax/_Contabilidad/BuscaDepositos.php",parametros,'',i);
}

function BuscaDetallesDepositoAut(){
	if(Existe("ordertabla")){
		var bref = "";
		var est = "";
		var parametros = "";
		document.getElementById("hvalores").value = "";
		document.getElementById("hvaloresbref").value = "";
		document.getElementById("hvaloresestatus").value = "";
		$("#ordertabla tbody").children("tr").each(function(index){
			$(this).children("td").each(function(index2){
			    if(index2 == 9){
				if($(this).children(".chkd").is(':checked')) {
				    x = $(this).children(".hidmov").val()
				    bref = $(this).children(".hbref").val()
				    est = $(this).children(".hestatus").val()
				    if(x !== undefined){
					document.getElementById("hvalores").value+= x+","
					document.getElementById("hvaloresbref").value+= bref+","
					document.getElementById("hvaloresestatus").value+= est+","
				    }
				}
			    }
			})
			});
		//alert(document.getElementById("hvaloresestatus").value)
		if(document.getElementById("hvalores").value != ''){
			$("#pieautorizar").css({"visibility":"hidden"});
			$("#piecancelar").css({"visibility":"hidden"});
			$("#base4").css({"width":"500px"})
			document.getElementById("NomCorPopUp").innerHTML = "Detalle Depositos";
			parametros = "hvalores="+document.getElementById("hvalores").value+"&hvaloresbref="+document.getElementById("hvaloresbref").value+"&hvaloresestatus="+document.getElementById("hvaloresestatus").value;
			MetodoAjaxDiv("../../inc/Ajax/_Contabilidad/DetallesDepositos.php",parametros);
			window.setTimeout("OcultarEmergente()",400);			
		}
		else
			alert("Favor de seleccionar almenos un deposito")
	}else{
		alert("Favor de realizar una busqueda para ver los detalles de los depositos")
	}
	
}

function BuscaDepositoCancelarAut(){
	if(Existe("ordertabla")){
		document.getElementById("hvalores").value = "";
		$("#ordertabla tbody").children("tr").each(function(index){
			$(this).children("td").each(function(index2){
			    if(index2 == 9){
				if($(this).children(".chkd").is(':checked')) {
				    x = $(this).children(".hidmov").val()
				    estatus = $(this).children(".hestatus").val();
				    if(x !== undefined && estatus != "Cancelado" && estatus != "Aplicado"){
					document.getElementById("hvalores").value+= x+","
				    }else{
					$(this).children(".chkd").removeAttr("checked");
				    }
				}
			    }
			})
			});
		//alert(document.getElementById("hvalores").value)
		if(document.getElementById("hvalores").value != ''){
			$("#pieautorizar").css({"visibility":"hidden"});
			$("#base4").css({"width":"680px"})
			document.getElementById("NomCorPopUp").innerHTML = "Cancelar Depositos";
			$("#piecancelar").css({"visibility":"visible"});
			MetodoAjaxDiv("../../inc/Ajax/_Contabilidad/CancelarDepositos.php","hvalores="+document.getElementById("hvalores").value+"&consulta=0");
			window.setTimeout("OcultarEmergente()",200);
		}
		else
			alert("Favor de seleccionar almenos un deposito que se pueda cancelar")
	}else{
		alert("Favor de realizar una busqueda para cancelar los depositos")
	}
	
}


function CancelarDepositosAut(){
	if(Existe("ordertabla")){
		var estatus = -1;
		document.getElementById("hvalores").value = "";
		$("#ordertabla tbody").children("tr").each(function(index){
			$(this).children("td").each(function(index2){
			    if(index2 == 9){
				if($(this).children(".chkd").is(':checked')) {
				    x = $(this).children(".hidmov").val()
				    estatus = $(this).children(".hestatus").val();
				    if(x !== undefined && estatus != "Cancelado"){
					document.getElementById("hvalores").value+= x+","
				    }
				}
			    }
			})
			});
		//alert(document.getElementById("hvalores").value)
		if(document.getElementById("hvalores").value != ''){
			//$("#pieautorizar").css({"visibility":"hidden"});
			//$("#base4").css({"width":"680px"})
			//document.getElementById("NomCorPopUp").innerHTML = "Cancelar Depositos";
			//$("#piecancelar").css({"visibility":"visible"});
			
			http.open("POST","../../inc/Ajax/_Contabilidad/CancelarDepositos.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				
			http.onreadystatechange=function() 
			{ 
				if (http.readyState==1)
				{
					//div para  [cargando....]
					OcultarPopUps();
					Emergente();
				}
				if (http.readyState==4)
				{
					OcultarEmergente();
					var RespuestaServidor = http.responseText;//alert("respuesta "+RespuestaServidor);
					validaSession(RespuestaServidor);
					$("#piecancelar").css({"visibility":"hidden"});
					$("#pieautorizar").css({"visibility":"hidden"});
					MostrarPopUp(RespuestaServidor);
					window.setTimeout("OcultarEmergente()",200);
				} 
			}
			http.send("pemiso="+true+"&hvalores="+document.getElementById("hvalores").value+"&consulta=1");
			
			
			//MetodoAjaxDiv("../../inc/Ajax/_Contabilidad/CancelarDepositos.php","hvalores="+document.getElementById("hvalores").value+"&consulta=1");
			//window.setTimeout("OcultarEmergente()",200);
		}
		else
			alert("Favor de seleccionar almenos un deposito")
	}else{
		alert("Favor de realizar una busqueda para cancelar los depositos")
	}
}

function SubForm(i){
	switch(i){
		case 1: Caracter();document.getElementById("excel").submit();
		break;
		case 2: Caracter();document.getElementById("todoexcel").submit();
		break;
		case 3: document.getElementById("pdf").submit();
		break;
		case 4: document.getElementById("todopdf").submit();
		break;
		case 5:
			document.getElementById("idcadena").value = txtValue("ddlCad");
			document.getElementById("idsubcadena").value = txtValue("ddlSubCad");
			document.getElementById("idcorresponsal").value = txtValue("ddlCorresponsal");
			document.getElementById("fechac").value = txtValue("fecIni");
			document.getElementById("fecha2").value = txtValue("fecFin");
			document.getElementById("pdf").submit();
		break;
		case 6:
			document.getElementById("idcadena").value = txtValue("ddlCad");
			document.getElementById("idsubcadena").value = txtValue("ddlSubCad");
			document.getElementById("idcorresponsal").value = txtValue("ddlCorresponsal");
			document.getElementById("identidad").value = txtValue("ddlEntidad");
			document.getElementById("fecha1").value = txtValue("fecIni");
			document.getElementById("fecha2").value = txtValue("fecFin");
			document.getElementById("pdf").submit();
		break;
	}
}