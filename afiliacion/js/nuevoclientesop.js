

	$(document).ready(function(){
       datatablaprosp();
        inicial();
        $('.nombre').on('keypress', function(){ return validarn(event); });
        
		$('#cmbPais').on('change', function(){paisFormato();});
        $('#cmbRegimen').on('change', function(){regimenFormato();});
        $('#txtRFC').on('blur', function(){ RFCFormato();});
	

		$('#txtTelefono').mask('(00) 00-00-00-00');
        $('#btnRegistraCliente').on('click', function(e){ registrar();});
        $('#btnNuevoCte').on('click', function(){ inicial();});
        $('#btnGuardaCliente').on('click', function(){ validaractualizacte(); });
        $('#btnArchivarCte').on('click', function(){ $("#pop1").css('display','block')});
       $('#btncan').on('click', function(){ $("#pop1").css('display','none')});
        $('#btnarc').on('click', function(){ archivarcte(); });
         $('#nuevospn').on('click', function(){ inicial(); $('#pannel1').css('display', 'block'); });
        $('#btnReenviaCorreo').on('click', function(){ 
            
            var inc = $('#idincr').val();
            var mail = $('#txtmail').val();
            var nombre = $('#txtnomcom').val();
            var codigoval = $('#txtcodval').val();
            
            enviarcorreo(inc, mail, nombre, codigoval);
        });
        
        //enviarcorreo(mail);
	});

 
    function datatablaprosp(){     
        
        	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#presubcadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./application/models/ClientesNuevosSoporteDataTable.php",
		/*"bJQueryUI": true,*/
		/*"sDom": '<"H"<"elementos"lr><"search-box"f>>t<"F"ip>',*/
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
            //1ra columna
			{ "mRender": function ( data, type, row ) {
				return row[1];
			}, "aTargets": [ 0 ] },
            //segunda columna
			{ 	"mRender": function ( data, type, row ) {
				return row[2];
			}, /*"sWidth": "20px",*/ "aTargets": [ 1 ] },
            //3a columna
			{ "mRender": function ( data, type, row ) {
			
				
					return row[0];
				
			}, "aTargets": [ 2 ] },
            
             //4a columna
			{ "mRender": function ( data, type, row ) {
			return row[3];
			},  "aTargets": [ 3 ] },
            //5a columna
			
			{ "mRender": function ( data, type, row ) {
                var rfcstr = row[4];
				var iconoEditar = "<a href='#' onclick=''><center><img src=\"../img/edit.png\" title='Editar'></center></a>";
				return iconoEditar;
                
                //src=\"../img/edit.png\"
			
            }, "bSortable": false, "aTargets": [ 4 ] },
              //5a columna
			
			{ "mRender": function ( data, type, row ) {
                var rfcstr = row[4];
				var iconoEditar = "<a href='#' onclick=''><center><img src=\"../img/edit.png\" title='Editar'></center></a>";
				return iconoEditar;
                
                //src=\"../img/edit.png\"
			
            }, "bSortable": false, "aTargets": [ 5] },
              //5a columna
			
			{ "mRender": function ( data, type, row ) {
                var rfcstr = row[4];
				var iconoEditar = "<a href='#' onclick=''><center><img src=\"../img/edit.png\" title='Editar'></center></a>";
				return iconoEditar;
                
                //src=\"../img/edit.png\"
			
            }, "bSortable": false, "aTargets": [ 6 ] },
          
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
    function inicial(){
           $('.nombre').css('text-transform', 'uppercase');
        $('#txtEmail').prop('disabled', false);
        $('.nombre').attr('maxlength',50);
	    $('#txtRFC').prop('disabled', false);
        $('#cmbRegimen').prop('disabled', true)
        $('#btnRegistraCliente').css('display', 'block');
       
       $('.editar').css('display', 'none');
                                $('#idincr').val('');
		                      $('#cmbPais').val(164);
		                      $('#cmbRegimen').val(-1);
		                      $('#txtRFC').val('');
		                      $('#txtEmail').val('');
		                      $('#txtNombre').val('');
		                      $('#txtPaterno').val('');
		                      $('#txtMaterno').val('');
                                $('#txtTelefono').val('');
		                      $('#cmbPais').prop('disabled', false);
                            
       
   }
  
//-------------------------------------------------------------------------------------




	function registrar(){
        var sRFC		= $('#txtRFC').val();

		if(validaciones() == false){
        
         $().toastmessage('showToast', {
				                text		: "no se pudo regustrar el prospecto Verifique la información",
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         }); 
        }
        else{ ValidRFC( sRFC );}
       

		
	} // registrar

    function editar(idincr, verif, pais, regimen, idEstatus){
         
         if(verif == 0){
       
                            $('#pannel1').css('display', 'block');
         
                            $.post( "./application/models/ProspLlenadoEditar.php",
                                    { idincr: idincr },
	                                   function ( respuesta ) {
                     
		                                      if ( respuesta.incr == idincr ) {//idincr
                                                    $('#idincr').val(respuesta.incr);
		                                            $('#cmbPais').val(respuesta.pais);
		                                              $('#cmbRegimen').val(respuesta.reg);
		                                              $('#txtRFC').val(respuesta.rfc);
		                                              $('#txtEmail').val(respuesta.mail);
		                                              $('#txtNombre').val(respuesta.nom);
		                                              $('#txtPaterno').val(respuesta.pat);
		                                              $('#txtMaterno').val(respuesta.mat);
                                                  //hiddens
                                                  $('#txtmail').val(respuesta.mail);
                                                  $('#txtnomcom').val(respuesta.ncom);
                                                  $('#txtcodval').val(respuesta.cval);
                                                  
                                                  ////////
		                                              $('#txtTelefono').val(respuesta.tel);
                                                    $('#txtRFC').prop('disabled', true);
                                                    $('#cmbPais').prop('disabled', true);
                                                    $('#btnRegistraCliente').css('display', 'none');
                                                    $('.editar').css('display', 'block');  
                          
                                                if(respuesta.cod == 1){$('#txtEmail').prop('disabled', true);}else{$('#txtEmail').prop('disabled', false);}
                                        } else {
                              
                                                $().toastmessage('showToast', {
                                                            text		: "no se regreso ningun dato",
				                                            sticky		: false,
				                                            position	: 'top-center',
				                                            type		: 'warning'
                                                        }); 
                                                inicial();
                                          }
                                }, "json");
         }else{
             
         
             var form = $('<form action="ProspectoGenerales.php" method="post" >'+
                          '<input type="hidden" name="idincr" value="'+idincr+'"/>'+
                          '<input type="hidden" name="pais" value="'+pais+'"/>'+
                          '<input type="hidden" name="regimen" value="'+regimen+'"/>'+
                          '<input type="hidden" name="estatus" value="'+idEstatus+'"/>'+
                           '</form>');
             $('body').append(form);
             $(form).submit();
             
             //aqui poner el redireccionamiento...
             //alert('Aqui es donde se redirecciona a la pagina de llenado de los demas datos.');
         }
    }


    function validaractualizacte(){
 	if(validaciones() == false){
        
         $().toastmessage('showToast', {
				                text		: "no se pudo regustrar el prospecto Verifique la información",
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         }); 
        }
        else{actualizacte();}
    
}

    function actualizacte(){
        var sRFC		= $('#txtRFC').val();
        var idincr      = $('#idincr').val();
 		var sEmail		= $('#txtEmail').val();
		var sNombre		= $('#txtNombre').val();
		var sPaterno	= $('#txtPaterno').val();
		var sMaterno	= $('#txtMaterno').val();
		var sTelefono	= $('#txtTelefono').val();
    
      $.post( "./application/models/prospectoNuevoEditar.php",
	               { incr: idincr, telefono: sTelefono,nombre: sNombre, paterno: sPaterno, materno: sMaterno, mail: sEmail },
	               function ( respuesta ) {
                     
		              if ( respuesta.rfc == sRFC ) {//idincr
                                   
                                inicial();
                                RefreshTable('#presubcadenas', "../inc/Ajax/_Clientes/ClientesRegistroDataTable.php");                 $().toastmessage('showToast', {
				                text		: "El Registro Ha Sido Actualizado",
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         });   
                          $('#pannel1').css('display', 'none');
                          } else {
                              
                         $().toastmessage('showToast', {
				                text		: "no se pudo actualizar el registro",
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         }); 
                          inicial();
                         
                        }
                    }, "json");
    
    

}

    function archivarcte(){
        var idincr      = $('#idincr').val();
    
 		$.post( "./application/models/prospectoNuevoArchivar.php",
	               { incr: idincr},
	               function ( respuesta ) {
                     
		              if ( respuesta.rows == 0 ) {//idincr
                                  $().toastmessage('showToast', {
				                text		: "El Registro Ha sido Eliminado",
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         });    
                           $('#pannel1').css('display', 'none');      
                          inicial();
                                RefreshTable('#presubcadenas', "../inc/Ajax/_Clientes/ClientesRegistroDataTable.php");               $("#pop1").css('display','none');         
                          } else {
                              
                         $().toastmessage('showToast', {
				                text		: "no se pudo eliminar el registro",
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         }); 
                          inicial();
                         
                        }
                    }, "json");
    
 
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

