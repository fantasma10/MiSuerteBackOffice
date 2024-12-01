function NewAviso(){
	var titulo = txtValue("txtTitulo");
	if( titulo != ""){
		var resumen = txtValue("txtResumen");
		if(resumen != ""){
			var fechaVen = txtValue("txtFechaVen");
			if(fechaVen != ""){
				var grupo			= txtValue('ddlGrupo');
				var cad				= txtValue('ddlCad');
				var subcad			= txtValue('ddlSubCad');
				var corr			= txtValue('ddlCorresponsal');
				
				var prioridad		= txtValue('ddlPrio');
				
				var aviso			= tinyMCE.get('avisoCuerpo').getContent()
				
				var parametros =  "titulo="+titulo+"&resumen="+resumen+"&fecha="+fechaVen+"&idgrupo="+grupo+"&idcad="+cad+"&idsubcad="+subcad+"&idcorr="+corr+"&prioridad="+prioridad+"&aviso="+aviso;
				//alert(parametros);
				MetodoAjax2("../../inc/Ajax/_Soporte/NewAviso.php",parametros);
			}else{alert("Favor de escribir una Fecha");}	
		}else{alert("Favor de escribir un Resumen");}
	}else{alert("Favor de escribir un Titulo");}
}