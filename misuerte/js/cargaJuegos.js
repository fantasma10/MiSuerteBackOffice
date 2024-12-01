$(document).on('change', '#progol',function (e) {
$('#juego').val(1);
	tipo = 1


$('#xgol').replaceWith($('#xgol').clone( true ) );
var inputFile = document.getElementById("progol");
var file = inputFile.files[0];
nombre = file.name.split('_');
nombre = nombre[0];
var data = new FormData();
data.append('progol',file);
data.append('tipo',tipo);

if(nombre == 'Pgol'){

		$.ajax({
				url			: BASE_PATH+"/misuerte/ajax/cargaJuegos.php",
				type		: 'POST',
				data		: data,
				mimeType	:"	multipart/form-data",
				contentType	: false,
				cache		: false,
				processData	: false,
				dataType	: 'json',
		success		: function(response, textStatus, jqXHR){
			
			$('#juegos').remove();
			$('#btnCarga').remove();
			var obj = response;


					//console.log(obj);
				var total = 0;
				if(obj.length > 0){
				$('#contenedor').append('<table width="400" id="juegos" style="border:1px solid #616161;margin: 0 auto;margin-top:15px;">'+
									'<tr>'+
                      						'<td colspan="2" style="font-family:Arial; color:#282828; font-weight:bold; padding:5px; border-bottom:1px solid #616161; background:#dedede;text-align:center;">'+
                                               			'ESTA ES LA QUINIELA SELECCIONADA A SUBIR'+
                               						'</td>'+
                								'</tr>'+
                								'<tr>'+
                               						'<td width="50%" style="font-family:Arial; color:#282828; font-weight:bold; text-align:center; border-bottom:1px solid #616161; background:#eaeaea;border-right: 1px solid #616161"> PARTIDO </td>'+
                               						'<td width="50%" style="font-family:Arial; color:#282828; font-weight:bold; text-align:center; border-bottom:1px solid #616161; background:#eaeaea;"> NÚMERO DE SORTEO</td>'+
                								'</tr>');


				}else{

					$('#contenedor').append('<table width="400" id="juegos" style="border:1px solid #616161;margin: 0 auto;margin-top:15px;">'+
									'<tr>'+
                      						'<td colspan="2" style="font-family:Arial; color:#282828; font-weight:bold; padding:5px; border-bottom:1px solid #616161; background:#dedede;text-align:center;">'+
                                               			'NO SE ENCONTRARON ARCHIVOS'+
                               						'</td>'+
                								'</tr>');

				}
					jQuery.each(obj, function(index,value) {
					var  local = obj[index]['local_name'][0];
					var  visitor_name  = obj[index]['visitor_name'][0];
					var  draw  = obj[index]['draw_num'];
					$('#juegos').append('<tr>'+
                               '<td width="50%" style="color:#616161;background:#ffffff; border-bottom: 1px solid #616161; font-family:Arial; text-align:left;padding-left:15px;border-right:1px solid #616161"> '+local+' VS '+visitor_name+' </td>'+
                               '<td width="50%" style="color:#616161;background:#ffffff; border-bottom: 1px solid #616161; font-family:Arial; text-align:center;"> '+draw+'</td>'+
                				'</tr>');
	
					});

					if(obj.length > 0){

						$('#contenedor').append('<div class="row" id="btnCarga">'+
												'<div class="col-xs-12" style="margin-top:16px;">'+
													'<div class="form-group" >'+
            											'<a type="button" class="btn btn-success" id="cargar" style="float:none; margin:0 auto; display:block;width: 150px;">Cargar Juegos</a>'+
            										'</div>'+
            									'</div>'+
            								'</div>');

					}
		},

		error		: function(jqXHR, textStatus, errorThrown){
					console.log(jqXHR, textStatus, errorThrown);
				}
	})

}else{
		alert('el archivo no corresponde al juego seleccionado');
		$('#juegos').remove();
		$('#btnCarga').remove();
		$('#progol').replaceWith($('#progol').clone( true ) );
}

});





$(document).on('change', '#xgol',function (e) {

$('#juego').val(2);
tipo = 2;

$('#progol').replaceWith($('#progol').clone( true ) );
var inputFile = document.getElementById("xgol");
var file = inputFile.files[0];
nombre = file.name.split('_');
nombre = nombre[0];
var data = new FormData();
data.append('xgol',file);
data.append('tipo',tipo);

if(nombre == 'Xgol'){

		$.ajax({
				url			: BASE_PATH+"/misuerte/ajax/cargaJuegos.php",
				type		: 'POST',
				data		: data,
				mimeType	:"	multipart/form-data",
				contentType	: false,
				cache		: false,
				processData	: false,
				dataType	: 'json',
		success		: function(response, textStatus, jqXHR){	
			
			$('#juegos').remove();
			$('#btnCarga').remove();
			var obj = response;
					//console.log(obj);
				var total = 0;
				if(obj.length > 0){
				$('#contenedor').append('<table width="400" id="juegos" style="border:1px solid #616161;margin: 0 auto;margin-top:15px;">'+
									'<tr>'+
                      						'<td colspan="2" style="font-family:Arial; color:#282828; font-weight:bold; padding:5px; border-bottom:1px solid #616161; background:#dedede;text-align:center;">'+
                                               			'ESTA ES LA QUINIELA SELECCIONADA A SUBIR'+
                               						'</td>'+
                								'</tr>'+
                								'<tr>'+
                               						'<td width="50%" style="font-family:Arial; color:#282828; font-weight:bold; text-align:center; border-bottom:1px solid #616161; background:#eaeaea;border-right: 1px solid #616161"> PARTIDO </td>'+
                               						'<td width="50%" style="font-family:Arial; color:#282828; font-weight:bold; text-align:center; border-bottom:1px solid #616161; background:#eaeaea;"> NÚMERO DE SORTEO</td>'+
                								'</tr>');


				}else{

					$('#contenedor').append('<table width="400" id="juegos" style="border:1px solid #616161;margin: 0 auto;margin-top:15px;">'+
									'<tr>'+
                      						'<td colspan="2" style="font-family:Arial; color:#282828; font-weight:bold; padding:5px; border-bottom:1px solid #616161; background:#dedede;text-align:center;">'+
                                               			'NO SE ENCONTRARON ARCHIVOS'+
                               						'</td>'+
                								'</tr>');

				}
					jQuery.each(obj, function(index,value) {
					var  local = obj[index]['local_name'][0];
					var  visitor_name  = obj[index]['visitor_name'][0];
					var  draw  = obj[index]['draw_num'];
					$('#juegos').append('<tr>'+
                               '<td width="50%" style="color:#616161;background:#ffffff; border-bottom: 1px solid #616161; font-family:Arial; text-align:left;padding-left:15px;border-right:1px solid #616161"> '+local+' VS '+visitor_name+' </td>'+
                               '<td width="50%" style="color:#616161;background:#ffffff; border-bottom: 1px solid #616161; font-family:Arial; text-align:center;"> '+draw+'</td>'+
                				'</tr>');
	
					});

					if(obj.length > 0){

						$('#contenedor').append('<div class="row" id="btnCarga">'+
												'<div class="col-xs-12" style="margin-top:16px;">'+
													'<div class="form-group" >'+
            											'<a type="button" class="btn btn-success" id="cargar" style="float:none; margin:0 auto; display:block;width: 150px;">Cargar Juegos</a>'+
            										'</div>'+
            									'</div>'+
            								'</div>');

					}
		},

		error		: function(jqXHR, textStatus, errorThrown){
					console.log(jqXHR, textStatus, errorThrown);
				}
	})

	}else{

		alert('El archivo no corresponde al juego seleccionado');
		$('#juegos').remove();
		$('#btnCarga').remove();
		$('#xgol').replaceWith($('#xgol').clone( true ) );

	}


});





$(document).on('click', '#cargar',function (e) {
juego = $('#juego').val();

if(juego == 1){
	fileNombre = "progol";
}else{
	fileNombre = "xgol";
}

tipo = 3

var inputFile = document.getElementById(fileNombre);
var file = inputFile.files[0];
var data = new FormData();
data.append(fileNombre,file);
data.append('tipo',tipo);
data.append('juego',juego);

		$.ajax({
				url			: BASE_PATH+"/misuerte/ajax/cargaJuegos.php",
				type		: 'POST',
				data		: data,
				mimeType	:"	multipart/form-data",
				contentType	: false,
				cache		: false,
				processData	: false,
				dataType	: 'json',
		success		: function(response, textStatus, jqXHR){	
			
			$('#juegos').remove();
			$('#btnCarga').remove();
			$('#progol').replaceWith($('#progol').clone( true ) );
			$('#xgol').replaceWith($('#xgol').clone( true ) );
			var obj = response;
					//console.log(obj);
				var total = 0;
				if(obj['showMessage'] == 0){
				$('#contenedor').append('<table width="400" id="juegos" style="border:1px solid #616161;margin: 0 auto;margin-top:15px;">'+
									'<tr>'+
                      						'<td colspan="2" style="font-family:Arial; color:#282828; font-weight:bold; padding:5px; border-bottom:1px solid #616161; background:#dedede;text-align:center;">'+
                                               			'RESULTADO DE LA CARGA'+
                               						'</td>'+
                								'</tr>');


				}else{

					$('#contenedor').append('<table width="400" id="juegos" style="border:1px solid #616161;margin: 0 auto;margin-top:15px;">'+
									'<tr>'+
                      						'<td colspan="2" style="font-family:Arial; color:#282828; font-weight:bold; padding:5px; border-bottom:1px solid #616161; background:#dedede;text-align:center;">'+
                                               			'OCURRIO UN ERROR'+
                               						'</td>'+
                								'</tr>');

				}
					var  actualizaciones = obj['actualizados'];
					var  inserciones  = obj['insertados'];
					var  totalRegistros  = obj['total'];
					$('#juegos').append('<tr>'+
                               '<td colspan="2" style="font-family:Arial; color:#282828; font-weight:bold; padding:5px; border-bottom:1px solid #616161; background:#ffffff;text-align:left;">'+
                                               	'REGISTROS ACTUALIZADOS :'+ actualizaciones+
                               						'</td>'+
                               	'</tr>'+
                               	'<tr>					'+
                               	'<td colspan="2" style="font-family:Arial; color:#282828; font-weight:bold; padding:5px; border-bottom:1px solid #616161; background:#ffffff;text-align:left;">'+
                                               	'REGISTROS INSERTADOS :'+inserciones +
                               						'</td>'+
                               	'</tr>'+
                               	'<tr>'+
                               	'<td colspan="2" style="font-family:Arial; color:#282828; font-weight:bold; padding:5px; border-bottom:1px solid #616161; background:#ffffff;text-align:left;">'+
                                               	'TOTAL DE REGISTROS :'+totalRegistros+
                               						'</td>'+
                				'</tr>');

		},
		error		: function(jqXHR, textStatus, errorThrown){
					console.log(jqXHR, textStatus, errorThrown);
				}
	})

});
