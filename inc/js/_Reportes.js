function AutoCorresponsal(){
if(Existe("txtCorresponsal"))
	AutoCompletar("txtCorresponsal","../../inc/Ajax/AutoCorresponsalNom.php",1);
}



/*function getCorte(){
	var cad =  document.getElementById("ddlCad").value;
	if(cad != ""){
		var subcad = document.getElementById("ddlSubCad").value;
		if(subcad != ""){
			var corr = document.getElementById("ddlCorresponsal").value;
			if(corr != ""){
				var fecIni = document.getElementById("fecIni").value;
				if(fecIni != ""){
					var fecFin = document.getElementById("fecFin").value;
					if(fecFin != ""){
						var parametros ="idCadena="+cad+"&idSubCadena="+subcad+"&idCorresponsal="+corr+"&fini="+fecIni+"&ffin="+fecFin;
						BuscarParametros("../../inc/Ajax/_Reportes/BuscaCorte.php",parametros);
					
					}else{alert("Favor de seleccionar una Fecha Final");}					
				}else{alert("Favor de seleccionar una Fecha Inicial");}
			}else{alert("Favor de seleccionar un Corresponsal");}		
		}else{alert("Favor de seleccionar una Subcadena");}
	}else{alert("Favor de seleccionar una Cadena");}
}*/

function getReporte(i){
	var fechai =  txtValue("txtFechaIni");
	if(fechai != ""){
		if(validaFechaRegex("txtFechaIni")){
			var fechaf = txtValue("txtFechaFin");
			if(fechaf != ""){
				if(validaFechaRegex("txtFechaFin")){
					if(fechai != fechaf){
						if(fechai < fechaf){
							var tipo = txtValue("tipoPago");
							var parametros ="tipopago="+tipo+"&fechai="+fechai+"&fechaf="+fechaf;
							
							BuscarParametros("../../inc/Ajax/_Reportes/BuscaPagos.php",parametros,'',i);
						}else{
							alert("La fecha inicial debe ser menor a la fecha final")
						}
					}else{
						alert("Favor de seleccionar fechas distintas")
					}
				}else{
					alert("El formato de la fecha final es incorrecto")
				}	
			}else{
				alert("Favor de escribir una fecha Final");
			}
		}else{
			alert("El formato de la fecha inicial es incorrecto")
		}
	}else{
		alert("Favor de escribir una fecha Inicial");
	}
}

function BuscaReporteDepositoManual(i){
	var numcuenta 		= txtValue("NumCta");
	var fecha 			= txtValue("fecha");
	var autorizacion 	= txtValue("Autorizacion");
	var estatus 		= -1;
	var parametros 		= "";
	
	parametros+="tipo=0";

	parametros+= (sel != -3) ? "&numcuenta=" + sel: '';
	parametros+= (numcuenta != '' && sel == -3) ? "&numcuenta=" + numcuenta : '';
	
	parametros+= (fecha != '') ? "&fecha=" + fecha : '';
	parametros+= (autorizacion != '') ? "&autorizacion=" + autorizacion : '';

	if(Check('Aplicado'))
		parametros+= "&estatus=0";
	if(Check('Pendiente'))
		parametros+= "&estatus=1";
	if(Check('Cancelado'))
		parametros+= "&estatus=2";

	//alert(parametros);			
	BuscarParametros("../../inc/Ajax/_Reportes/BuscaDepositos.php",parametros,'',i);
	
	sel = -3;
	setValue("txtCorresponsal","")
}
function BuscaReporteDepositoAuto(i){
	var numcuenta 		= txtValue("NumCta");
	var fecha 			= txtValue("fecha");
	var autorizacion 	= txtValue("Autorizacion");
	var estatus 		= -1;
	var parametros 		= "";
	
	parametros+="tipo=1";

	parametros+= (sel != -3) ? "&numcuenta=" + sel: '';
	parametros+= (numcuenta != '' && sel == -3) ? "&numcuenta=" + numcuenta : '';
	
	parametros+= (fecha != '') ? "&fecha=" + fecha : '';
	parametros+= (autorizacion != '') ? "&autorizacion=" + autorizacion : '';

	if(Check('Aplicado'))
		parametros+= "&estatus=0";
	if(Check('Pendiente'))
		parametros+= "&estatus=1";
	if(Check('Cancelado'))
		parametros+= "&estatus=2";

	//alert(parametros);			
	BuscarParametros("../../inc/Ajax/_Reportes/BuscaDepositos.php",parametros,'',i);
	
	sel = -3;
	setValue("txtCorresponsal","")
}

function BuscaDetalleDeposito(id){
	MetodoAjaxDiv("../../inc/Ajax/_Reportes/DetalleDeposito.php","folio="+id);
}
