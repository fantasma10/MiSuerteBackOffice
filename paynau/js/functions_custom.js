/*
*Crea una tabla 
*@nombreDiv -> Nombre del Div donde se crear la tabla
*@idTabla -> nombre del id que se asignará la tabla
*@claseTabla -> nombre de la clase de la tabla
*@idBody -> nombre del body 
*@campos -> encabezados que tendra la tabla
*/
function crearTablaDinamica(nombreDiv,idTabla,claseTabla,idBody, campos){
  	let th = "";
  	tabla = '<table id="'+idTabla+'" class="'+claseTabla+'">'
                    + '<thead>'
                    + '<tr>';
    for (var i = 0; i < campos.length; i++) {
    	
    	th += '<th>'+campos[i].toString()+'</th>';
    }	
    cuerpoTabla = th+ '</tr>'
                    + '</thead> '
                    + '<tbody id ="'+idBody+'"></tbody>'
                    + '</table>';
    tabla += cuerpoTabla;
    $('#'+nombreDiv).html(tabla);
}

/*
*url-> direccion del archivo PHP que se ejecuta
*parametros-> json con los campos que se envian como parametros
*fn-> función que se ejecuta si la respuesta es exitosa
*/

function ejecutaAjax(url,parametros,fn) {
     $.ajax({
          url: BASE_PATH + url,
          type: 'POST',
          dataType: 'json',
          data: parametros
     })
          .done(function (resp) {
               datos = resp;
               if (!datos.bExito) {
                  jAlert(datos.sMensaje);  
               }else{
                    fn(datos);
               }
           }).fail(function(){
           		jAlert('Error al obtener los datos, vuelva a intentar mas tarde');
           }).always(function(){
           		hideSpinner();
           })
}

/*Aplica el DataTable a un tabla especificado por medio de su id
@table -> id de la tabla a la que se aplica el plugin
*/
function IniciarDataTable(table){
	$('#'+table).dataTable({"destroy": true,
                           "oLanguage": {
                                "sLengthMenu": "Mostrar _MENU_",
                                "sZeroRecords": "No se encontraron datos",
                                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                                "sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",
                                "sInfoFiltered": "(filtrado de _MAX_ total de Registros)",
                                "sProcessing": "Cargando...",
                                "sSearch": "Buscar:",
                                "oPaginate": {
                                    "sPrevious": "Anterior ", // This is the link to the previous page
                                    "sNext": " Siguiente"
                                }
                            },
                            "order": []
                          });
}

/*
*Campos -> corresponde a un array de los id´s que se validaran
*Ejemplo:
*    campos =  ['nombre_tarjeta', 'apellidos_tarjeta', 'numero_tarjeta', 'vencimiento_tarjeta', 'ccv_tarjeta', 'codigoPostal_tarjeta'], 
*               
*/
function validarCampoVacio(campos){
     let controlador = campos.length;
     let i = 0;
     while(controlador>0){

          if($('#'+campos[i]).val() == undefined || myTrim($('#'+campos[i]).val()) == ''){
               controlador = 0;
               let campo = $('#'+campos[i]);
               let nombre = campo[0].attributes['data-name'].value;
               jAlert('El campo '+nombre+' es requerido para continuar');
               $('#'+campo[0]).focus();
               return false;
          }
          controlador--;
          i++;
     }
     return true;
}