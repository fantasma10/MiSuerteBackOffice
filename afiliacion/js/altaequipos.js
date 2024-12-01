

	$(document).ready(function(){
       datatablaprosp();
     
       $('#btnBusacrSucursal').click(function(){validarcte();});
        
        
        
        $("#txtCliente").autocomplete({
			source: function(request,respond){
				$.post( "./application/models/RE_Clientesequipo.php", { "strBuscar": request.term },
				function( response ) {
					respond(response);
				}, "json" );
			},
			minLength: 1,
			focus: function(event,ui){
				$("#txtCliente").val(ui.item.sRazonSocial);
				return false;
			},
			select: function(event,ui){
				$("#txtIdCliente").val(ui.item.nIdCliente);
				
					
			
				return false;
			},
			search: function(){
			
				$("#txtIdCliente").val('');
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a style=\"color:black\">"+ item.value + "</a>" )
			.appendTo( ul );
		};
        
        
	});

 var sucursal = 0;
 var clie = 0;
 var nombresucursal = '';
 var mailcliente = '';
 var tipo1 = 'Notificación Movimiento de Equipos';
 var tipo2 = 'Notificación Movimiento de Operador';
 var mensaje = '';
 var fecha = new Date().toJSON().slice(0,10) + ' '+new Date().toJSON().slice(11,19);



	
	
    function datatablaprosp(){     
        
        	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#presubcadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./application/models/equiposClientesConfigDT.php", 

		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
            //1ra columna
			{ "mRender": function ( data, type, row ) {//id
				return row[0];
			}, "aTargets": [ 0 ] },
            //segunda columna
			{ 	"mRender": function ( data, type, row ) { //RFC
				return row[1];
			}, /*"sWidth": "20px",*/ "aTargets": [ 1 ] },
            //3a columna
			{ "mRender": function ( data, type, row ) { //RAZON SOCIAL
				return row[2];
					
			}, "aTargets": [ 2 ] },
            //4a columna
			{ "mRender": function ( data, type, row ) { //SUCURSALES
				return row[3];
					
			}, "aTargets": [ 3 ] },
            
             //5a columna
			{ "mRender": function ( data, type, row ) { //FECHA ALTA
				 return row[4];
			},  "aTargets": [ 4 ] },
            //6a columna
			
			{ "mRender": function ( data, type, row ) { //DETALLE
                //var rfcstr = row[6];
				var iconoEditar = "<a href='#' onclick='cargasucursalesDT("+row[0]+")'><center><img src=\"../img/edit.png\" title='Ver Sucursales del Cliente'></center></a>";
				return iconoEditar;
               
               
			
            }, "bSortable": false, "aTargets": [ 5 ] },
          
		],
		"fnDrawCallback": function ( oSettings ) {
			/* Aplicar tooltips */
			tablaPreSubCadenas.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
			//tablaPreSubCadenas.$('tr:odd').css( "background-color", "#D4DDED" );

		},
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			$('td:eq(0)', nRow).addClass( "dataTableNombre" );
			$('td:eq(1)', nRow).addClass( "dataTableAvance" );
		},		
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por p&aacute;gina.",
			"sZeroRecords": "No se encontr&oacute; ning&uacute;n resultado.",
			"sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros.",
			"sInfoEmpty": "Mostrando 0 de 0 de 0 registros.",
			"sInfoFiltered": "(filtrados de un total de _MAX_ registros)",
			"sSearch": "Buscar",
			"sProcessing": "Procesando..."
		}
	} );
        
   }




  function datatablesucs(cliente){     
        
       	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#sucursalesdt').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./application/models/equiposSucursalesConfigDT.php", 
		//"sServerMethod": 'POST',
		 "fnServerParams": function ( aoData ) {
            aoData.push( { name: 'cliente', value: cliente } );
        },

		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
            //1ra columna
			{ "mRender": function ( data, type, row ) {//id
				return row[0];
			}, "aTargets": [ 0 ] },
            //segunda columna
			{ 	"mRender": function ( data, type, row ) { //CODIGO
				return row[1];
			}, /*"sWidth": "20px",*/ "aTargets": [ 1 ] },
            //3a columna
			{ "mRender": function ( data, type, row ) { //NOMBRE
				return row[2];
					
			}, "aTargets": [2] },
            //4a columna
			{ "mRender": function ( data, type, row ) { //ACTIVOS
				return row[3];
					
			}, "aTargets": [3] },
            
             //5a columna
			{ "mRender": function ( data, type, row ) { //INACTIVOS
				 return row[4];
			},  "aTargets": [4] },
            //6a columna
			
			{ "mRender": function ( data, type, row ) { //EQUIPOS DETALLE
                //var rfcstr = row[6];
				var iconoEditar = "<a href='#' onclick='editar("+row[0]+")'><center><img src=\"../img/edit.png\" title='Ver los Equipos de la Sucursal'></center></a>";
				return iconoEditar;
               
            }, "bSortable": false, "aTargets": [5] },
            
            { "mRender": function ( data, type, row ) { //OPERADORES DETALLE
                //var rfcstr = row[6];
				var iconoEditar = "<a href='#' onclick='operadores("+row[0]+")'><center><img src=\"../img/edit.png\" title='Ver los Operadores de la Sucursal'></center></a>";
				return iconoEditar;
               
             }, "bSortable": false, "aTargets": [6] },
          
		],
		"fnDrawCallback": function ( oSettings ) {
			/* Aplicar tooltips */
			tablaPreSubCadenas.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});


		},
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			$('td:eq(0)', nRow).addClass( "dataTableNombre" );
			$('td:eq(1)', nRow).addClass( "dataTableAvance" );
		},		
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por p&aacute;gina.",
			"sZeroRecords": "No se encontr&oacute; ning&uacute;n resultado.",
			"sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros.",
			"sInfoEmpty": "Mostrando 0 de 0 de 0 registros.",
			"sInfoFiltered": "(filtrados de un total de _MAX_ registros)",
			"sSearch": "Buscar",
			"sProcessing": "Procesando..."
		}
	} );
        
   }


function cargasucursalesDT(cliente){
    
    $('#panel1').css('display','none');
     $('#pannelbusq').css('display','none');
    $('#panel2').css('display','block'); //pannelbusq
    infocliente(cliente);
   datatablesucs(cliente);

    
}


    function RefreshTable(tableId, urlData){
  $.getJSON(urlData, null, function( json )
  {
    table = $(tableId).dataTable();
    oSettings = table.fnSettings();

    table.fnClearTable(this);

    for (var i=0; i<json.aaData.length; i++)
    {
      table.oApi._fnAddData(oSettings, json.aaData[i]);
    }

    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
    table.fnDraw();
  });
    
}








//-------------------------------------------------------------------------------------





   function editar(suc){
	   sucursal = suc;
	   		cargaequipos(suc);
         $('#disclamer').modal('show');
    
    }
 function operadores(suc){
	   sucursal = suc;
	   		cargaoperadores(suc);
         $('#operadoresmodal').modal('show');
    
    }



 



    function enviarcorreo(inc, mail, nombre, codigoval){
    
    
        $.post( "./correos/enviar.php",
	               {inc:inc, mail: mail,nombre:nombre,codigoval:codigoval},
	               function ( respuesta ) {
                     
		              if ( respuesta.bExito == true ) {
                                  $().toastmessage('showToast', {
				                text		: respuesta.sMensaje,
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         });    
                           $('#pannel1').css('display', 'none');      
                          inicial();
                                         
                          } else {
                              
                         $().toastmessage('showToast', {
				                text		:  respuesta.sMensaje,
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         }); 
                          inicial();
                         
                        }
                    }, "json");
    
}

function  cargaequipos(suc){
    
    infoclineteysucursal(suc);
	
$.post('./application/models/equiposListado.php',{suc:suc},function(mensaje){
	
	
$('#equiposdiv').html(mensaje);	
	});
	
	}

function  cargaoperadores(suc){
    
    infoclineteysucursal(suc);
	
$.post('./application/models/operadoresListado.php',{suc:suc},function(mensaje){
	
	
$('#operadoresdiv').html(mensaje);	
	});
	
	}
	
	
	function nuevoequipo(){
		$.post('./application/models/equiposNuevo.php',{suc:sucursal},function(res){
			if(res.cod == -1){
				$().toastmessage('showToast', {
                                 text		: "Se ha llegado al limite de equipos permitidos por sucursal",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
				}else{
					$().toastmessage('showToast', {
                                 text		: "Equipo Creado Exitosamente",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
					cargaequipos(sucursal);
					
					}
			
			},"JSON");
		
		}


function validarcte(){
    
    
     var clientebuscar = $('#txtIdCliente').val();
    
    if(clientebuscar == ''){
        
        $().toastmessage('showToast', {
                                 text		: "Primero debe seleccionar un Cliente",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
        return;
    }
           cargasucursalesDT(clientebuscar);
    
}



function eliminarequipo(equipo){
        var elimconf= confirm('¿Desea Eliminar el Equipo?');
    
    if(elimconf == true){
    $.post('./application/models/equipoeliminar.php',{equipo:equipo},function(res){
           
           if(res.code == 1){
         $().toastmessage('showToast', {
                                 text		: "Equipo Eliminado Exitosamentee",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
        
        cargaequipos(sucursal);
       
        
    }else{
        
         $().toastmessage('showToast', {
                                 text		: "No se Pudo Eliminar el Equipo, Contacte a Soporte",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
        
        
    }
           
           },"JSON");
    }
    
}

function suspenderequipo(equipo){
    
        var susconf= confirm('¿Desea Suspender el Equipo?');
    
    if(susconf == true){
        $.post('./application/models/equiposuspender.php',{equipo:equipo},function(res){
           
           if(res.code == 1){
         $().toastmessage('showToast', {
                                 text		: "Equipo Suspendido Exitosamente",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
        
        cargaequipos(sucursal);
        
    }else{
        
         $().toastmessage('showToast', {
                                 text		: "No se Pudo Suspender el Equipo, Contacte a Soporte",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
    }
           
           },"JSON");
    }
}


function archivarequipo(equipo){
    
    var arconf= confirm('¿Desea Archivar el Equipo?');
    
    if(arconf == true){
        $.post('./application/models/equipoarchivar.php',{equipo:equipo},function(res){
           
           if(res.code == 1){
         $().toastmessage('showToast', {
                                 text		: "Equipo Archivado Exitosamente",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
        
        cargaequipos(sucursal);
        
    }else{
        
         $().toastmessage('showToast', {
                                 text		: "No se Pudo Archivar el Equipo, Contacte a Soporte",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
    }
           
           },"JSON");
    }
}


function infocliente(cliente){
    
    clie = cliente;
    
    $.post('./application/models/equiposclienteinfo.php',{cliente:cliente},function(res){
        $("#txtcliente").val(res.code);
    },"JSON");
    
}



function infoclineteysucursal(suc){
    
      $.post('./application/models/equiposclienteinfo.php',{cliente:clie},function(res){
        $("#txtclienteequipo").val(res.code);
           $("#txtclienteequipo2").val(res.code);
          $("#txtclientecorreo").val(res.mail);
          mailcliente = res.mail;
    },"JSON");
    
      $.post('./application/models/equipossucursalinfo.php',{sucursal:suc},function(res){
        $("#txtsucursalequipo").val(res.code);
           $("#txtsucursalequipo2").val(res.code);
          nombresucursal = res.nombre;
          
    },"JSON");
    
    
    
}




	function nuevooperador(){
		$.post('./application/models/operadoresNuevo.php',{suc:sucursal},function(res){
			if(res.cod == -1){
				$().toastmessage('showToast', {
                                 text		: "Se Ha completado el M&aacute;ximo de Operadores por Sucural.",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
				}else{
					$().toastmessage('showToast', {
                                 text		: "Operador Creado Exitosamente",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
                    
                      
                      mensaje = 'El Operador '+res.opnom+' se ha creado exitosamente';
                    
					cargaoperadores(sucursal);
                    
					enviarnotificacion(mailcliente, mensaje, fecha,nombreusuario,tipo2,nombresucursal);
                    
					}
			
			},"JSON");
		
		}


function reiniciarpassword(idop,status){
    
   var confrp = confirm('¿Desea reiniciar el Password del Operador?');
    
 if(confrp == true){
    $.post('./application/models/operadoresReinicarPass.php',{op:idop},function(res){
        
        if(res.cod == 1){
            $().toastmessage('showToast', {
                                 text		: "No se pudo reiniciar el password, contacte a Soporte",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
        }else{
            $().toastmessage('showToast', {
                                 text		: "Passwor reseteado exitosamente",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
            mensaje = 'El Paswoord del  Operador id:'+idop+'  se ha Reiniciado  exitosamente. Nueva Contraseña "12345"';
            cargaoperadores(sucursal);
            enviarnotificacion(mailcliente, mensaje, fecha,nombreusuario,tipo2,nombresucursal);
        }
        
        
    },"JSON");
  }
   
}




function reestablecersesion(idop,estatus){
    
   var confrp = confirm('¿Desea reestablecer la sesión?');
    
 if(confrp == true){
    $.post('./application/models/operadoresReestablecerSesion.php',{op:idop,estatus:estatus},function(res){
        
        if(res.cod == 1){
            $().toastmessage('showToast', {
                                 text		: "No se pudo reestablecer la sesion, contacte a Soporte",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
        }else{
            $().toastmessage('showToast', {
                                 text		: "sesion reestablecida exitosamente",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
            mensaje = 'La sesion del  Operador id:'+idop+'  se ha Reestablecido exitosamente';
            cargaoperadores(sucursal);
            enviarnotificacion(mailcliente, mensaje, fecha,nombreusuario,tipo2,nombresucursal);
        }
        
        
    },"JSON");
  }
   
}

function eliminaroperador(idop){
    
    var confrp = confirm('¿Desea eliminar el operador?');
    
 if(confrp == true){
    $.post('./application/models/operadoreseliminar.php',{op:idop},function(res){
        
        if(res.cod == 1){
            $().toastmessage('showToast', {
                                 text		: "No se pudo Eliminar al operador, contacte a Soporte",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
        }else{
            $().toastmessage('showToast', {
                                 text		: "Operador Eliminado exitosamente",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
            
            mensaje = 'El Operador id:'+idop+'  se ha Eliminado exitosamente';
            cargaoperadores(sucursal);
            enviarnotificacion(mailcliente, mensaje, fecha,nombreusuario,tipo2,nombresucursal);
        }
        
        
    },"JSON");
  } 
    
    
}


function desbloquaroperador(idop){
    
   var confrp = confirm('¿Desea Desbloquear la sesi&oacute;n del operador?');
    
 if(confrp == true){
    $.post('./application/models/operadorescerrarsesion.php',{op:idop},function(res){
        
        if(res.cod == 1){
            $().toastmessage('showToast', {
                                 text		: "No se pudo Desbloquear al operador, contacte a Soporte",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
        }else{
            $().toastmessage('showToast', {
                                 text		: "Operador Desbloqueado exitosamente",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
         
            
             mensaje = 'La sesion del  Operador id:'+idop+'  se ha Desbloqueado exitosamente';
            cargaoperadores(sucursal);
            enviarnotificacion(mailcliente, mensaje, fecha,nombreusuario,tipo2,nombresucursal);
        }
        
        
    },"JSON");
  } 
       
    
}


function enviarnotificacion(mail, msg, fecha,usr,tipo,sucursal){
    
    var correo = mail;
    var mensaje = msg;
    var fecha = fecha;
    var usuario = usr;
    var tipo = tipo;
    var sucursal = sucursal;
    
       $.post('./correos/notificacioncorresponsal.php',{correo:correo,mensaje:mensaje,fecha:fecha,usuario:usuario,tipo:tipo,sucursal:sucursal},function(res){
        
        if(res.nCodigo == 0){
            $().toastmessage('showToast', {
                                 text		: res.sMensaje,
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
        }else{
            $().toastmessage('showToast', {
                                 text		: res.sMensaje,
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
            cargaoperadores(sucursal);
        }
        
        
    },"JSON");
    
}