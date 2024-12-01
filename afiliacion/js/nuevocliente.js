

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
		"sAjaxSource": "./application/models/ClientesRegistroDataTable.php",
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
				return row[3];
			}, /*"sWidth": "20px",*/ "aTargets": [ 1 ] },
            //3a columna
			{ "mRender": function ( data, type, row ) {				
				var iconoRevisado = "";
				
					if ( row[2] == 0 ) {
						iconoRevisado = "<center><img title=\"No Verificado\" src=\"../../img/ico_revision1.png\"/></center>";
					} else {
						iconoRevisado = "<center><img title=\"Correo Verificado\" src=\"../../img/ico_revision2.png\"/></center>";
					}
				
				return iconoRevisado;
			}, "bSortable": false, "aTargets": [ 2 ] },
            
             //4a columna
			{ "mRender": function ( data, type, row ) {
				var iconoRevisado = "";
				
					if ( row[7] == 2 ) {
						iconoRevisado = "<center><img title=\"No Verificado\" src=\"../../img/ico_revision2.png\"/></center>";
					} else {
						iconoRevisado = "<center><img title=\"Correo Verificado\" src=\"../../img/ico_revision1.png\"/></center>";
					}
				
				return iconoRevisado;
			}, "bSortable": false, "aTargets": [ 3 ] },
            //5a columna
			
			{ "mRender": function ( data, type, row ) {
                var rfcstr = row[3];
				var iconoEditar = "<a href='#' onclick='editar("+row[0]+","+row[2]+","+row[5]+","+row[6]+","+row[7]+")'><center><img src=\"../img/edit.png\" title='Editar'></center></a>";
				return iconoEditar;
                
                //src=\"../img/edit.png\"
			
            }, "bSortable": false, "aTargets": [ 4 ] },
          
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
    function validarn(e) { // 1  mandar esta funcion a las funciones comunes
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
	 if (tecla==9) return true; // 3
	 if (tecla==11) return true; // 3
    patron = /[A-Za-zñÑ'áéíóúÁÉÍÓÚüÜ\s\t]/; // 4
 
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
} 

    function paisFormato(){ //funcion para  el comportamiento del  combo pais
     $('#cmbRegimen').val(-1);  
     $('#txtRFC').val('');
     $('#txtRFC').prop('disabled', false);
     $('#txtRFC').css('text-transform', 'uppercase');
     
     if($('#cmbPais').val() == 164){
                $('#div-rfc label').html('RFC');
                $('#cmbRegimen').prop('disabled', true);
                $('#txtRFC').prop('disabled', false);
                $('#txtRFC').unmask();
                $('#txtRFC').attr('maxlength',13); //toUpperCase(); 
             
     }
     if($('#cmbPais').val() == 68){
                $('#div-rfc label').html('TIN');
                $('#cmbRegimen').prop('disabled', false);
                $('#txtRFC').prop('disabled', true);
                //$('#txtRFC').mask('000-00-0000');
       }
     if($('#cmbPais').val() == -1){
                $('#div-rfc label').html('RFC');
                $('#cmbRegimen').prop('disabled', true);
                $('#txtRFC').prop('disabled', true);
                $('#txtRFC').unmask();
                $('#txtRFC').attr('maxlength',13);
         }
   } 
    function regimenFormato(){ //funcion para  el comportamiento del  combo Regimen
   
     
     if($('#cmbRegimen').val() == 1){
                $('#txtRFC').prop('disabled', false);
                $('#txtRFC').mask('000-00-0000');
     } 
     if($('#cmbRegimen').val() == 2){
                $('#txtRFC').prop('disabled', false);
                $('#txtRFC').mask('00-0000000');
       }
     if($('#cmbRegimen').val() == -1){
                $('#txtRFC').val('');
                $('#txtRFC').prop('disabled', true);
                $('#txtRFC').unmask();
                $('#txtRFC').attr('maxlength',13);
                
         }
   }

    function RFCFormato(){ //funcion para  el comportamiento del  texto RFC
      
    if($('#cmbPais').val() == 164 & $('#txtRFC').val().length == 13){ //verifica si el formato del rfc de la persona  fisica es correcto
         var rfcf = $('#txtRFC').val();
        
        if(verif_rfcf(rfcf) == false){
            $().toastmessage('showToast', {
				text		: 'Debes Capturar un RFC de persona física válido',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
            $('#cmbRegimen').val(-1); 
            return false;
        }else{
            
           $('#cmbRegimen').val(1);  
            return true;
        }
               
      }
    if($('#cmbPais').val() == 164 & $('#txtRFC').val().length == 12){ //verifica el formato del rfcde la persona moral es correcto
            
            var rfcm = $('#txtRFC').val();
            if(verif_rfcm(rfcm) == false){
                    $().toastmessage('showToast', {
				            text		: 'Debes Capturar un RFC de persona moral  válido',
				            sticky		: false,
				            position	: 'top-center',
				            type		: 'warning'
			         });
                    $('#cmbRegimen').val(-1); 
                return false;
            }else{
            
                    $('#cmbRegimen').val(2);  
                return true
            }
               
      }
     if($('#cmbPais').val() == 164 & $('#txtRFC').val().length < 12){
          $().toastmessage('showToast', {
				text		: 'Debes Capturar un RFC  válido',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
                $('#cmbRegimen').val(-1);
         return false
      }
     if($('#cmbPais').val() == 68 & $('#cmbRegimen').val() == 1){
         
         if ($('#txtRFC').val().length < 11){
          $().toastmessage('showToast', {
				text		: 'Debes Capturar un TIN válido',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
            return false;   
         }
         
      }
         if($('#cmbPais').val() == 68 & $('#cmbRegimen').val() == 2){
         
         if ($('#txtRFC').val().length < 10){
          $().toastmessage('showToast', {
				text		: 'Debes Capturar un TIN válido',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
            return false;   
         }
         
      }
   }


    function verif_rfcf(rfcs) { //verifica RFC persona fisica

                var for_rfc= /^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))/;
                if(for_rfc.test(rfcs))
                    { return true; }
                    else 
                    { return false; }
                }
    function verif_rfcm(rfcs) {  //verifica RFC persona Moral

                var for_rfc= /^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))/;
                if(for_rfc.test(rfcs))
                    { return true; }
                    else 
                    { return false; }
                }

    function ValidateInputEmail(element, e){
	       if(e.which == 13 || e.which == 8){
		      e.preventDefault();
                return;
            }
	
	           var yourInput = $(element).val();
	           re = /[^0-9a-zA-Z@_./\s]/g;
	           var isSplChar = re.test(yourInput);
	       if(isSplChar)
	           {
		      var no_spl_char = yourInput.replace(/[^0-9a-zA-Z@_./-\s]/g,'');
		
		          $(element).val(no_spl_char);
	           }
        }
//-------------------------------------------------------------------------------------

    function ValidRFC( RFC, callback ) {
	               $.post( "./application/models/ProspRfcValidar.php", { RFC: RFC },function (respuesta) {
                if ( respuesta.cod == 0 ) {
                 
                          callbacks(respuesta.cod, respuesta.msg);
                       } else {
                        callbacks(respuesta.cod, respuesta.msg);
                         }
                    }, "json");
      
}

    function callbacks( codigo, mensaje){
   if(codigo == 0){
       insertProsp();
       }else{
         $().toastmessage('showToast', {
				                text		: mensaje,
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         })  
           return;
          alert("se supone que este mensaje ya no se debe de mostrar");
            }
    }

	  
 
    function insertProsp( ){
      var nIdPais		= $('#cmbPais').val();
		var nIdRegimen	= $('#cmbRegimen').val();
		var sRFC		= $('#txtRFC').val();
		var sEmail		= $('#txtEmail').val();
		var sNombre		= $('#txtNombre').val();
		var sPaterno	= $('#txtPaterno').val();
		var sMaterno	= $('#txtMaterno').val();
		var sTelefono	= $('#txtTelefono').val();
    
    $.post( "./application/models/prospectoNuevo.php",
	               { pais: nIdPais, regimen: nIdRegimen, rfc: sRFC, mail: sEmail, nombre: sNombre, paterno: sPaterno, materno: sMaterno, telefono: sTelefono, usr:usr },
	               function ( respuesta ) {
                       
                       
		              if ( respuesta.incr == 0 ) {
                           
			              /* $().toastmessage('showToast', {
				                text		: "Prospecto creado satisfactoriamente, en espera de  Confirmacion",
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         }) ;  */
                   alert("Aqui es donde se envia  a la  pagina del listado");
                              
		              } else {
                          $('#pannel1').css('display', 'none');
                         $().toastmessage('showToast', {
				                text		: "Prospecto creado satisfactoriamente, en espera de  Confirmacion",
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         }); 
                      enviarcorreo(respuesta.inc, respuesta.mail, respuesta.nombre, respuesta.codigoval);
                          inicial();
                          RefreshTable('#presubcadenas', "./application/models/ClientesRegistroDataTable.php");
                         // window.location.href = "ListadoProspectos.php";
                        }
                    }, "json");
      
   
 



}
//------------------------------------------------------------------------------------------------	
    function validaciones(){
     	
    var nIdPais		= $('#cmbPais').val();
		var nIdRegimen	= $('#cmbRegimen').val();
		var sRFC		= $('#txtRFC').val();
		var sEmail		= $('#txtEmail').val();
		var sNombre		= $('#txtNombre').val();
		var sPaterno	= $('#txtPaterno').val();
		var sMaterno	= $('#txtMaterno').val();
		var sTelefono	= $('#txtTelefono').val();

		if(nIdPais == undefined || nIdPais <= 0){
			$().toastmessage('showToast', {
				text		: 'Debes Seleccionar un Pa\u00EDs',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
			return false;
		}

		if(nIdRegimen == undefined || nIdRegimen <= 0){
			$().toastmessage('showToast', {
				text		: 'Debes Seleccionar un R\u00E9gimen',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
			return false;
		}

		if(sRFC == undefined || sRFC == ''){
			$().toastmessage('showToast', {
				text		: 'Debes Capturar un RFC',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
			return false;
		}
        
    
        
        
		 if( $('#txtRFC').val().length > 0){
         
             //RFCFormato();
         if(RFCFormato() == false){return;}     
      }

		if(sEmail == undefined || sEmail == ''){
            
			$().toastmessage('showToast', {
				text		: 'Debes Capturar un Correo',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
			return false;
		}
		else{
			
			if(sEmail.length > 150){
				$().toastmessage('showToast', {
					text		: 'La Longitud M\u00E1xima del Correo son 150 caracteres',
					sticky		: false,
					position	: 'top-center',
					type		: 'warning'
				});
				return false;
			}

			if(!isValidEmail(sEmail)){
				$().toastmessage('showToast', {
					text		: 'El Formato del Correo es Inv\u00E1lido',
					sticky		: false,
					position	: 'top-center',
					type		: 'warning'
				});
				return false;
			}
		}
        
        if(sTelefono == undefined || myTrim(sTelefono) == ''){
			$().toastmessage('showToast', {
				text		: 'Debes Capturar un Tel\u00E9fono para el Contacto',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
			return false;
		}
        
           if(sTelefono.length < 16){
			$().toastmessage('showToast', {
				text		: 'Debes Capturar un Tel\u00E9fono válido para el Contacto',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
			return false;
		}

		if(sNombre == undefined || myTrim(sNombre) == ''){
			$().toastmessage('showToast', {
				text		: 'Debes Capturar un Nombre del Contacto',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
			return false;
		}
		else{
			sNombre = myTrim(sNombre);

			if(sNombre.length < 3){
				$().toastmessage('showToast', {
					text		: 'La Longitud M\u00EDnima del Nombre del Contacto es de 3 caracteres',
					sticky		: false,
					position	: 'top-center',
					type		: 'warning'
				});
				return false;
			}

			if(sNombre.length > 50){
				$().toastmessage('showToast', {
					text		: 'La Longitud del Nombre del Contacto es de 50 caracteres',
					sticky		: false,
					position	: 'top-center',
					type		: 'warning'
				});
				return false;
			}
		}

		if(sPaterno == undefined || myTrim(sPaterno) == ''){
			$().toastmessage('showToast', {
				text		: 'Debes Capturar un Apellido Paterno del Contacto',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
			return false;
		}
		else{
			sPaterno = myTrim(sPaterno);

			if(sPaterno.length < 3){
				$().toastmessage('showToast', {
					text		: 'La Longitud M\u00EDnima del Apellido Paterno del Contacto es de 3 caracteres',
					sticky		: false,
					position	: 'top-center',
					type		: 'warning'
				});
				return false;
			}
			if(sPaterno.length > 50){
				$().toastmessage('showToast', {
					text		: 'La Longitud M\u00E1xima del Apellido Paterno del Contacto es de 50 caracteres',
					sticky		: false,
					position	: 'top-center',
					type		: 'warning'
				});
				return false;
			}
		}

		if(sMaterno != undefined && myTrim(sMaterno) != ''){
			
			sMaterno = myTrim(sMaterno);

			if(sMaterno.length < 3){
				$().toastmessage('showToast', {
					text		: 'La Longitud M\u00EDnima del Apellido Materno del Contacto es de 3 caracteres',
					sticky		: false,
					position	: 'top-center',
					type		: 'warning'
				});
				return false;
			}
			if(sMaterno.length > 50){
				$().toastmessage('showToast', {
					text		: 'La Longitud M\u00E1xima del Apellido Materno del Contacto es de 50 caracteres',
					sticky		: false,
					position	: 'top-center',
					type		: 'warning'
				});
				return false;
			}
		}
     
 }


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
                              RefreshTable('#presubcadenas', "./application/models/ClientesRegistroDataTable.php");                $().toastmessage('showToast', {
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
                                RefreshTable('#presubcadenas', "./application/models/ClientesRegistroDataTable.php");               $("#pop1").css('display','none');         
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

