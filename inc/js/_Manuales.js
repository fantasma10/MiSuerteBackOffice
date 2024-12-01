function NewManual(){
	var nom =   txtValue("txtNomDoc");
	if(nom != ""){
		var desc = txtValue("txtNomCorto");
		if(desc!= ""){
			var url = txtValue("txtURL");
			if(url != "" && url.length > 4){
				$extencion = url.substring(url.length-3,url.length);
				
				if($extencion == 'pdf'){
					var tipo = 0;
					
					if(Check('Corresponsal'))
						tipo = 1;
					var parametros ="nom="+nom+"&desc="+desc+"&url="+url+"&tipo="+tipo;
				
					MetodoAjax("../../inc/Ajax/_Manuales/NewManual.php",parametros);
				}else{alert("El archivo debe ser .pdf, favor de verificar su URL");}
			}else{alert("Favor de Escribir una URL correctamente");}
		}else{alert("Favor de Escribir una Descripcion");}
	}else{alert("Favor de Escribir un Nombre");}

}

function UpdateManual(){
var nom =   txtValue("txtNomDoc");
	if(nom != ""){
		var desc = txtValue("txtNomCorto");
		if(desc!= ""){
			var url = txtValue("txtURL");
			if(url != ""){
				var tipo = 0;
				if(Check('Corresponsal'))
					tipo = 1;
					
					var parametros ="nom="+nom+"&desc="+desc+"&url="+url+"&tipo="+tipo;
				
				//alert(parametros);
				MetodoAjax("../../inc/Ajax/_Manuales/UpdateManual.php",parametros);
							
			}else{alert("Favor de Escribir una URL");}
		}else{alert("Favor de Escribir una Descripcion");}
	}else{alert("Favor de Escribir un Nombre");}
		
}

function DescargarArchivoManuales(url,i){
		MetodoAjax2("../../inc/Ajax/descargarArchivo.php","url="+url,i);
}

function DeleteManual(id,val){
	if(id != "")
	{
		var parametros ="id="+id+"&val="+val;			
			MetodoAjax("../../inc/Ajax/_Manuales/DeleteManual.php",parametros);		
	
	}else{ alert("Favor de escribir un Id para el Acceso");}
}