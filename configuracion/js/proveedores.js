$(document).ready(function(){

    datatablaprosp();
    $('#nuevospn').click(function(){ resetform();});  
    

    formatosiniciales();   
    $('#btneditarprod').css('display','none');
    $('#txtCLABE').on('blur', function(e){ var sCLABE = $("#txtCLABE").val(); datosbancarios(sCLABE);});

});


function datatablaprosp(){     
        
        	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#presubcadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./ajax/proveedores/proveedoresDT.php",
		/*"bJQueryUI": true,*/
		/*"sDom": '<"H"<"elementos"lr><"search-box"f>>t<"F"ip>',*/
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
            //1ra columna
			{ "mRender": function ( data, type, row ) {// familia
				return row[1];
			}, "aTargets": [ 0 ] },
            //segunda columna
			{ 	"mRender": function ( data, type, row ) {//subfamilia
				return row[2];
			}, /*"sWidth": "20px",*/ "aTargets": [ 1 ] },
            //3a columna
			{ "mRender": function ( data, type, row ) { //descripcion
								
					return row[3];
				
			
			}, "aTargets": [ 2 ] },
            
             //4a columna
			{ "mRender": function ( data, type, row ) { //inicio vigencia
                
				return row[4];
                
			},  "aTargets": [ 3] },
       
            //5a columna
			
			{ "mRender": function ( data, type, row ) {//fin vigencia
               
				var iconoEditar = "<a href='#' onclick='editarproducto("+row[0]+")'><center><img src=\"../img/edit.png\" title='Editar'></center></a>";
				return iconoEditar;
                
                //src=\"../img/edit.png\"
			
            }, "bSortable": false, "aTargets": [4] },
          
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

var idprov = 0;

function editarproducto(idprovr){
    
    
    $.post('./ajax/proveedores/cargarproveedor.php',{idprov:idprovr},function(res){
        

        
   $('#txtnombre').val(res.nombre);
   $('#txtrc').val(res.racsoc);
   $('#txtrfc').val(res.rfc);
   $('#txttel').val(res.tel);    
   $('#cmbtipo').val(res.tipo);
   $('#cmbstatus').val(res.status);
   $('#txtnc').val(res.cta);
        
   idprov   = res.idprov;   
        console.log(idprov);
    },"JSON");
  
    
    formatoedicion();
    
    
}


function formatosiniciales(){
    
     
     	$('#txtnombre, #txtrc, #txtBeneficiario').alphanum({
			allow			    : 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA',
			disallow			: '',
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: true,
			allowLower			: false,
			allowLatin			: false,
			allowOtherCharSets	: false,
			maxLength			: 50
		});
    
    
    	$('#txtrfc').alphanum({
			allow			    : 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA',
			disallow			: '',
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: true,
			allowLower			: false,
			allowLatin			: false,
			allowOtherCharSets	: false,
			maxLength			: 13
		});
    

}


function validarform(tipos){
    //alert(idprodss);
    
     var  nombre  = $('#txtnombre').val();
     var  rs      = $('#txtrc').val();
     var  rfc     = $('#txtrfc').val();
     var  tel     = $('#txttel').val();
     var  tipo    = $('#cmbtipo').val();
    
    
     var  clabe    = $('#txtCLABE').val();
     var  banco    = $('#cmbBanco').val();
     var  cuenta   = $('#txtCuenta').val();
     var  benef    = $('#txtBeneficiario').val();
   
    //(23) 45-78-10-10
   
    if(nombre == '' || nombre.length < 3){toasts('Capture el nombre del proveedor de al menos 3 caracteres'); return;}
    if(rs == '' || rs.length < 3){toasts('Capture la raz&oacute;n social  de al menos 3 caracteres'); return;}
     if(rfc == '' || rfc.length < 12 ){toasts('Debe Capturar el RFC del Proveedor'); return;}
    
     if(rfc.length == 13){
         
          if(verif_rfcf(rfc) == false){
              
           toasts('El formato del RFC es Incorrecto');
            return;
          }
              
          
         
     }else if(rfc.length == 12){
         
         if(verif_rfcm(rfc) == false){
              
           toasts('El formato del RFC es Incorrecto');
            return;
         }
         
     }
    
    
   
    
   if(tel == '' || tel.length != 10){toasts('Debe Capturar el tel&eacute;fono'); return;}

     if(tipo == -1){toasts('Debe seleccionar un tipo de proveedor'); return;}
    
    
	 /*if(clabe == undefined || clabe == ''){
		toasts('Captura CLABE Interbancaria (Datos Bancarios)');
		return ;
	}
	else if(clabe.length != 18){
		toasts('La CLABE debe ser de 18 d\u00EDgitos');
		return ;
	}*/
	/*else if(!validarDigitoVerificador(params5.sCLABE)){
		toasts('El Formato de la CLABE es Inv\u00E1lido');
		return false;
	}*/

	/*if(banco == undefined || banco == '' || banco <= 0){
		toasts('Captura nuevamente la CLABE para seleccionar el Banco');
		return ;
	}

	if(cuenta == undefined || cuenta == ''){
		toasts('Captura nuevamente la CLABE para obtener el N\u00FAmero de Cuenta');
		return;	
	}
    
    
	else if(cuenta.length != 11){
		toasts('Captura nuevamente la CLABE para obtener el N\u00FAmero de Cuenta');
		return;	
	}

	
	if(benef == undefined || benef == ''){
		toasts('Captura Nombre de Beneficiario');
		return;
	}
	else if(benef.length < 3){
		toasts('La Longitud M\u00EDnima para el Nombre de Beneficiario es de 3 caracteres');
		return;
	}
	else if(benef.length > 50){
		toasts('La Longitud M\u00E1xima para el Nombre de Beneficiario es de 50 caracteres');
		return;
	}*/
   
 console.log(tipos);
    if(tipos == 1){
        
        var r = confirm('¿Desea Registar el Proveedor?');
        if(r == true){validarRFC(); }
        
    }else{
        var act = confirm('¿Desea Actualizar  el Proveedor?');
        if(act == true){ editarproveedor();}
        
    }
    

}

function toasts(mensaje){
       $().toastmessage('showToast', {
       text	: mensaje,
		sticky: false, position	: 'top-center', type: 'warning'}); 
}
    
    
function guardarproveedor(){
    
   // alert('ha accedido a guardar el producto');
    
     var  nombre    = $('#txtnombre').val();
     var  rs        = $('#txtrc').val();
     var  rfc       = $('#txtrfc').val();
     var  tel       = $('#txttel').val();
     var  tipo      = $('#cmbtipo').val();
    
      
    
     var  clabe    = $('#txtCLABE').val();
     var  banco    = $('#cmbBanco').val();
     var  cuenta   = $('#txtCuenta').val();
     var  benef    = $('#txtBeneficiario').val();
    
    var  desc    = $('#txtDescripcion').val();

   
   
    
    $.post('./ajax/proveedores/proveedoresGuardar.php',{nombre:nombre,rs:rs,rfc:rfc,tel:tel,tipo:tipo,usr:usr,clabe:clabe,banco:banco,cuenta:cuenta,benef:benef,desc:desc},function(res){
        
        if(res.code == 0){
            toasts(res.msg);
            resetform();
            
            $('#pannel1').css('display','none');
            // aqui si debemos resetear el datatable.
        }else{toasts(res.msg);}
        
    },"JSON");
    
}    
    

function resetform(){
    
  $('#txtnombre').val('');
  $('#txtrc').val('');
  $('#txtrfc').val('');
  $('#txttel').val('');
  $('#cmbtipo').val(-1);
     
  formatonuevoprod();
    
}


function editarproveedor(){
    
    var  nombre    = $('#txtnombre').val();
     var  rs        = $('#txtrc').val();
     var  rfc       = $('#txtrfc').val();
     var  tel       = $('#txttel').val();
     var  tipo      = $('#cmbtipo').val();
    
    console.log(idprov);
     $.post('./ajax/proveedores/proveedorEditar.php',{idprov:idprov,nombre:nombre,rs:rs,rfc:rfc,tel:tel,tipo:tipo,usr:usr},function(res){
        
        if(res.code == 0){
            toasts(res.msg);
            resetform();
            
            $('#pannel1').css('display','none');
            // aqui si podemos   poner el  refresh table
            RefreshTable('#presubcadenas', './ajax/proveedores/proveedoresDT.php');
        }else{toasts(res.msg);}
        
    },"JSON");
    
  
}

function formatoedicion(){
    
        $('#pannel1').css('display','block');  
        $('#btneditarprod').css('display','inline-block'); 
        $('#btnGuardaProd').css('display','none'); 
        $('.inps').css('display','inline-block');
     
        $('#txtrfc').prop('disabled',true);
    
}

function formatonuevoprod(){
    
        $('#pannel1').css('display','block');  
        $('#btneditarprod').css('display','none'); 
        $('#btnGuardaProd').css('display','inline-block'); 
        $('.inps').css('display','none');
 
        $('#txtrfc').prop('disabled',false);
    
}

function updatestatus(idstatus){
    
    
    $.post('./ajax/productos/productosEstatusActualizar.php',{idprodss:idprodss,idstatus:idstatus,usr:usr},function(res){
        
        toasts(res.msg);
        
    },"JSON");
    
    
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

function validarRFC(){
    
   var  rfc     = $('#txtrfc').val();
    
    
    $.post('./ajax/prveedores/validarrfc.php',{rfc,rfc},function(res){
        
        if(res.code == 0 ){
            guardarproveedor();
        }else{
            
          toasts(res.msg);  
            
        }
    },"JSON");
    
}


function datosbancarios(sCLABE){
    
    var cuenta	= sCLABE.substring(6,17)
    if(sCLABE.length == 18){
    
      $.post( "../afiliacion/application/models/RE_Banco.php",
             { clabe: sCLABE },
	           function ( respuesta ) {
                     
		           if ( respuesta.records == 1) {//idincr
                       //alert("debe de funcionar");
                      $("select[id='cmbBanco'] option").remove();
                       $('#cmbBanco').append("<option value= '"+respuesta.idbanco+"' selected>"+respuesta.nombrebanco+"</option>");
		              $("#txtCuenta").val(cuenta);                              
                 } else {
                      $("select[id='cmbBanco'] option").remove();
                       $('#cmbBanco').append("<option value= '-1' selected>--</option>");  
                     $("#txtCuenta").val(""); 
                     $().toastmessage('showToast', {
                        text		: "la CLABE no es correcta",
				        sticky		: false,
				        position	: 'top-center',
				        type		: 'warning'
                    }); 
                 }
            }, "json");
    }else{
        
        $().toastmessage('showToast', {
            text		: "Capture una CLABE de 18 dígitos",
			sticky		: false,
			position	: 'top-center',
			type		: 'warning'
           }); 
        
         $("select[id='cmbBanco'] option").remove();
         $('#cmbBanco').append("<option value= '-1' selected>--</option>");
		 $("#txtCuenta").val('');                              
        
    }
}