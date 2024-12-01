$(document).ready(function(){
	settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
	  "oLanguage": {
		"sZeroRecords": "No se encontraron registros",
		"sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
		"sLengthMenu": "Mostrar _MENU_ registros",
		"sSearch": "Buscar:"  ,
		"sInfoFiltered": " - filtrado de _MAX_ registros",
		"oPaginate": {
			  "sNext": "Siguiente",
			  "sPrevious": " Anterior"
		}
	},
	  "bSort": true, 
	};
	table = $("#usuarios").DataTable(settings);
	RevisionFiltro();
});

function RevisionFiltro(){
	const radiobtn = document.getElementsByName("rdbBusca");
	var status = -1;
	for(var i = 0; i < radiobtn.length; i ++){
		if(radiobtn[i].checked){
			if(radiobtn[i].id == "Activo"){
				status = 0;
			}else if(radiobtn[i].id == "Inactivo"){
				status = 1;
			}else {
				status = 2;
			}
		}
	}
	TableUsuariosStatus(status);
}

function TableUsuariosStatus(status){
	table.fnClearTable();
    table.fnDestroy();
	$.post("../../../inc/Ajax/_Admin/UsuariosDataTable.php" , {
		estatus : status
	},
	function(response){
		const infoTable = JSON.parse(response);
		console.log(infoTable)
		if(infoTable.length > 0){
			infoTable.forEach(element => {
				if(parseInt(element.estatusUsuario) == 0){
					estatusUsuario = "Activo";
				}else if(parseInt(element.estatusUsuario) == 1){
					estatusUsuario = "Inactivo";
				}else{
					estatusUsuario = "Eliminados";
				}
				if(element.apellidoMaterno == null) { element.apellidoMaterno = ""; }
				var buttonElimina = "";
				if(element.estatusUsuario != 2){
					buttonElimina = '<button id="eliminarUsuario" class="btn habilitar btn-default btn-xs" onclick="EliminarActualizarUsuario(' + element.idUsuario + ',' + '2' + ')">' + '<span class="fa fa-trash-o fa-2x"></span></button>';
				}else{
					buttonElimina = '';
				}
				const buttonEditar = '<button id="editarUsuario" class="btn habilitar btn-default btn-xs" onclick="EditarUsuario(' + element.idUsuario + ')">' + '<span class="fa fa-pencil-square-o fa-2x"></span></button>';
				if(element.nombrePerfil == null) { element.nombrePerfil = "Sin perfil" }
				$('#usuarios tbody').append('<tr><td style="text-align:center;">'+ element.idUsuario +'</td>'+
					'<td style="text-align:center;">'+ estatusUsuario +'</td>'+
					'<td style="text-align:center;">'+ element.nombrePerfil +'</td>'+
					'<td style="text-align:center;">'+ element.email +'</td>'+
					'<td style="text-align:center;">'+ element.nombre + ' ' + element.apellidoPaterno + ' ' + element.apellidoMaterno +'</td>'+
					'<td style="text-align:center;">'+ buttonEditar  +'</td>' + //Button editar
					'<td style="text-align:center;">'+ buttonElimina +'</td></tr>' //Button Eliminar
				);
			});
			table = $("#usuarios").DataTable(settings);
		}else{
			table = $("#usuarios").DataTable(settings);
			jAlert("No se encontro informacion");
		}
	});
}