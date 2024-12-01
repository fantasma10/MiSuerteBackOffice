$(document).ready(function(){

    datatablaprosp();
    $('#nuevospn').click(function(){ resetform();});  
    
   // cargarfamilias(); 
    //busquedaemisor();
    formatosiniciales();   
    $('#btneditarprod').css('display','none');
    cargarproductos();
    cargarproveedor();
    cargarconector();
    
});

///////////////////////////////////////zona de variables declaradas/////////////////////


var idrutassss = 0;



////////////////////////////////////////////////////////////////////////////////////////

    function datatablaprosp(){     
        
        	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#presubcadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./ajax/rutas/rutasDT.php",
		/*"bJQueryUI": true,*/
		/*"sDom": '<"H"<"elementos"lr><"search-box"f>>t<"F"ip>',*/
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
            //1ra columna
			{ "mRender": function ( data, type, row ) {// familia
				return row[0];
			}, "aTargets": [ 0 ] },
            //segunda columna
			{ 	"mRender": function ( data, type, row ) {//subfamilia
				return row[1];
			}, /*"sWidth": "20px",*/ "aTargets": [ 1 ] },
            //3a columna
			{ "mRender": function ( data, type, row ) { //descripcion
								
					return row[2];
				
			
			}, "aTargets": [ 2 ] },
            
             //4a columna
			{ "mRender": function ( data, type, row ) { //inicio vigencia
                
				return row[3];
                
			},  "aTargets": [ 3] },
            //5a columna
			
			{ "mRender": function ( data, type, row ) {//fin vigencia
                return row[4];
			
            }, "aTargets": [ 4 ] },
            
            //6a columna
			
			{ "mRender": function ( data, type, row ) {//fin vigencia
                return row[5];
			
            }, "aTargets": [ 5 ] },
            //7a columna
			
			{ "mRender": function ( data, type, row ) {//fin vigencia
               
				var iconoEditar = "<a href='#' onclick='editaruta("+row[0]+")'><center><img src=\"../img/edit.png\" title='Editar'></center></a>";
				return iconoEditar;
                
                //src=\"../img/edit.png\"
			
            }, "bSortable": false, "aTargets": [6] },
          
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



function editaruta(idruta){
    
    
    $.post('./ajax/rutas/cargaruta.php',{idruta:idruta},function(res){
        
   $('#cmbProducto').val(res.idprod);
   $('#cmbProveedor').val(res.idprov);
   $('#cmbconector').val(res.idcon);
   $('#txtestatus').val(res.idestatus);
        
   
        
  // $('#idemisor').val(res.idemisor);
   $('#txtdescr').val(res.descruta);
   $('#txtsku').val(res.sku);
        
   $('#txtIniVigencia').val(res.fevruta);
   $('#txtFinVigencia').val(res.fsvruta);
        
   $('#txtMin').val(res.minruta);
   $('#txtMax').val(res.maxruta);
        
   $('#txtPorcostoruta').val(res.porcostoruta);
   $('#txtimpcostoruta').val(res.impcostoruta);
        
   $('#txtporcomprod').val(res.porcomprod);
   $('#txtImpComProd').val(res.impcomprod);
        
   $('#txtPorComCte').val(res.porcomcte);
   $('#txtImpComCte').val(res.impcomcte);
        
   $('#txtPorComUsr').val(res.porcomusu);
   $('#txtImpComUsr').val(res.impcomusu);
        
       
       idrutassss                 = res.idurta;     
        
    },"JSON");
  
    
    formatoedicion();
    
    
}


function cargarproductos(){ // carga catalodo de productos
    
    $.post('./ajax/rutas/productoCatalogo.php',null,function(mensaje){
        
        $('#cmbProducto').html(mensaje);
        
    });
    
}

function cargarproveedor(){ // carga catalodo de proveedores
    
    $.post('./ajax/rutas/proveedorCatalogo.php',null,function(mensaje){
        
        $('#cmbProveedor').html(mensaje);
        
    });
    
}

function cargarconector(){ // carga catalodo de conectores
    
    $.post('./ajax/rutas/conectorCatalogo.php',null,function(mensaje){
        
        $('#cmbconector').html(mensaje);
        
    });
    
}


function formatosiniciales(){
    
     $('#txtIniVigencia, #txtFinVigencia').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(){
          $(this).datepicker('hide'); $(this).blur();
        }); 
    
    
     	$('#txtMax, #txtMin, #txtPorcostoruta, #txtimpcostoruta, #txtporcomprod, #txtImpComProd, #txtporcomprod, #txtPorComCte, #txtImpComCte, #txtPorComUsr, #txtImpComUsr').alphanum({
			disallow			: 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ',
			allow				: '.',
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: false,
			allowLower			: false,
			allowLatin			: false,
			allowOtherCharSets	: false,
			maxLength			: 10
		});
    
    
    	$('#txtdescr','#txtsku').alphanum({
			allow			: 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA',
			disallow		: '',
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: true,
			allowLower			: true,
			allowLatin			: false,
			allowOtherCharSets	: false,
            maxLength			: 30
			
		});
    
     
    
}



function validarform(tipo){
    //alert(idprodss);
    
   var producto     =   $('#cmbProducto').val();
   var proveedor    =   $('#cmbProveedor').val();
   var conector     =   $('#cmbconector').val();
   var estatus      =   $('#txtestatus').val();
   var descripcion  =   $('#txtdescr').val();
   var sku          =   $('#txtsku').val();
   var inivigencia  =   $('#txtIniVigencia').val();
   var finvigencia  =   $('#txtFinVigencia').val();
   var minimo       =   $('#txtMin').val();
   var maximo       =   $('#txtMax').val();
   var porcostoruta =   $('#txtPorcostoruta').val();
   var impcostoruta =   $('#txtimpcostoruta').val();
   var porcomprod   =   $('#txtporcomprod').val();
   var impcomprod   =   $('#txtImpComProd').val();
   var porcomcte    =   $('#txtPorComCte').val();
   var impcpmcte    =   $('#txtImpComCte').val();
   var porcomusr    =   $('#txtPorComUsr').val();
   var impcomusr    =   $('#txtImpComUsr').val();
   
    
    
    
    if(producto == -1){toasts('Debe seleccionar una Producto'); return;}
    if(proveedor == -1){toasts('Debe seleccionar una Proveedor'); return;}
    if(conector == -1){toasts('Debe seleccionar un Conector'); return;}
    
    if(descripcion == '' || descripcion.length < 3){toasts('Capture la descripci&oacute;n de la ruta de al menos 3 caracteres'); return;}
    if(sku == '' || sku.length < 1){toasts('Capture el SKU del proveedor de al menos 1 caracteres'); return;}
    
    //validar las fechas de vigencia.. falta ponerle valor predeterminado a la fecha  de vigencia que es de hoy a 20 años
    if(inivigencia == ''){toasts('Seleccione una fecha inicial de la vigencia'); return;}
    if(finvigencia == ''){toasts('Seleccione una fecha  final de la vigencia'); return;}
    if(finvigencia < inivigencia ){toasts('La fecha final de la vigencia debe ser mayor que la fecha inicial de la vigencia'); return;}
    
        
    
    if(maximo == ''){toasts('Ingrese el importe m&iacute;nimo de la transacci&oacute;n'); return;}
    if(minimo == ''){toasts('Ingrese el importe m&aacute;ximo de la transacci&oacute;n'); return;}
    if(minimo > maximo){toasts('El importe m&iacute;nimo debe ser menor o igual el importe m&aacute;ximo de la transacci&oacute;n'); return;}
    
    
    
    if(porcostoruta == ''){toasts('Ingrese el porcentaje de la  comisi&oacute;n por producto dividido entre 100'); return;}
    if(impcostoruta == ''){toasts('Ingrese el importe de la comisi&oacute;n por producto'); return;}
    
    if(porcomprod == ''){toasts('Ingrese el porcentaje de la  comisi&oacute;n del producto dividido entre 100'); return;}
    if(impcomprod == ''){toasts('Ingrese el Importe de la  comisi&oacute;n del producto'); return;}
    
        
    if(porcomcte == ''){toasts('Ingrese el Porcentaje de la comisi&oacute;n para clientes'); return;}
    if(impcpmcte == ''){toasts('Ingrese el Importe de la  comisi&oacute;n para clientes'); return;}
    
    
    if(porcomusr == ''){toasts('Ingrese el porcentaje cobrable al usuario dividido entre 100'); return;}
    if(impcomusr == ''){toasts('Ingrese el importe de  comisi&oacute;n cobrable al usuario'); return;}
    


    
  if(tipo == 1){
        
        var r = confirm('¿Desea Registar La ruta?');
        if(r == true){ guardarruta();}
        
    }else{
        var act = confirm('¿Desea Actualizar  la Ruta?');
        if(act == true){ editarutas();}
        
    }
    
   
    
    
}

function toasts(mensaje){
       $().toastmessage('showToast', {
       text	: mensaje,
		sticky: false, position	: 'top-center', type: 'warning'}); 
}
    
    
function guardarruta(){
    
   // alert('ha accedido a guardar el producto');
    
     var producto     =   $('#cmbProducto').val();
   var proveedor    =   $('#cmbProveedor').val();
   var conector     =   $('#cmbconector').val();
   var estatus      =   $('#txtestatus').val();
   var descripcion  =   $('#txtdescr').val();
   var sku          =   $('#txtsku').val();
   var inivigencia  =   $('#txtIniVigencia').val();
   var finvigencia  =   $('#txtFinVigencia').val();
   var minimo       =   $('#txtMin').val();
   var maximo       =   $('#txtMax').val();
   var porcostoruta =   $('#txtPorcostoruta').val();
   var impcostoruta =   $('#txtimpcostoruta').val();
   var porcomprod   =   $('#txtporcomprod').val();
   var impcomprod   =   $('#txtImpComProd').val();
   var porcomcte    =   $('#txtPorComCte').val();
   var impcpmcte    =   $('#txtImpComCte').val();
   var porcomusr    =   $('#txtPorComUsr').val();
   var impcomusr    =   $('#txtImpComUsr').val();
    

    
    
    $.post('./ajax/rutas/rutaGuardar.php',{producto:producto,proveedor:proveedor,conector:conector,estatus:estatus,descripcion:descripcion,sku:sku,inivigencia:inivigencia,finvigencia:finvigencia,minimo:minimo,maximo:maximo,porcostoruta:porcostoruta,impcostoruta:impcostoruta,porcomprod:porcomprod,impcomprod:impcomprod,porcomcte:porcomcte,impcpmcte:impcpmcte,porcomusr:porcomusr,impcomusr:impcomusr,usr:usr},function(res){
        
        if(res.code == 0){
            toasts(res.msg);
            resetform();
            
            $('#pannel1').css('display','none');
            // no se resetea el datatable so mucho productos.
        }else{toasts(res.msg);}
        
    },"JSON");
    
}    
    


function resetform(){
    
   $('#cmbProducto').val(-1);
   $('#cmbProveedor').val(-1);
   $('#cmbconector').val(-1);
   $('#txtestatus').val(0);
        
   
        
  // $('#idemisor').val(res.idemisor);
   $('#txtdescr').val('');
   $('#txtsku').val('');
        
   $('#txtIniVigencia').val('');
   $('#txtFinVigencia').val('');
        
   $('#txtMin').val('');
   $('#txtMax').val('');
        
   $('#txtPorcostoruta').val('');
   $('#txtimpcostoruta').val('');
        
   $('#txtporcomprod').val('');
   $('#txtImpComProd').val('');
        
   $('#txtPorComCte').val('');
   $('#txtImpComCte').val('');
        
   $('#txtPorComUsr').val('');
   $('#txtImpComUsr').val('');
        
       
       idrutassss                 = 0;  
     
     
    //cargarservicios(0);
    
    formatonuevoprod();
    
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



function editarutas(){
    
    
     var producto     =   $('#cmbProducto').val();
   var proveedor    =   $('#cmbProveedor').val();
   var conector     =   $('#cmbconector').val();
  
   var descripcion  =   $('#txtdescr').val();
   var sku          =   $('#txtsku').val();
   var inivigencia  =   $('#txtIniVigencia').val();
   var finvigencia  =   $('#txtFinVigencia').val();
   var minimo       =   $('#txtMin').val();
   var maximo       =   $('#txtMax').val();
   var porcostoruta =   $('#txtPorcostoruta').val();
   var impcostoruta =   $('#txtimpcostoruta').val();
   var porcomprod   =   $('#txtporcomprod').val();
   var impcomprod   =   $('#txtImpComProd').val();
   var porcomcte    =   $('#txtPorComCte').val();
   var impcpmcte    =   $('#txtImpComCte').val();
   var porcomusr    =   $('#txtPorComUsr').val();
   var impcomusr    =   $('#txtImpComUsr').val();
    

    
    $.post('./ajax/rutas/rutaEditar.php',{ruta:idrutassss,producto:producto,proveedor:proveedor,conector:conector,descripcion:descripcion,sku:sku,inivigencia:inivigencia,finvigencia:finvigencia,minimo:minimo,maximo:maximo,porcostoruta:porcostoruta,impcostoruta:impcostoruta,porcomprod:porcomprod,impcomprod:impcomprod,porcomcte:porcomcte,impcpmcte:impcpmcte,porcomusr:porcomusr,impcomusr:impcomusr,usr:usr},function(res){
        
        if(res.code == 0){
            toasts(res.msg);
            resetform();
            
            $('#pannel1').css('display','none');
            // no se resetea el datatable so mucho productos.
        }else{toasts(res.msg);}
        
    },"JSON")
    
  
}

function formatoedicion(){
    
        $('#pannel1').css('display','block');  
        $('#btneditarprod').css('display','inline-block'); 
        $('#btnGuardaProd').css('display','none'); 
        $('.inps').css('display','inline-block');
        $('#cmbFamilias').prop('disabled',true);
        $('#cmbsubfamilia').prop('disabled',true);
        $('#cmbflujo').prop('disabled',true);
        $('#txtEmisor').prop('disabled',true);
    
}

function formatonuevoprod(){
    
        $('#pannel1').css('display','block');  
        $('#btneditarprod').css('display','none'); 
        $('#btnGuardaProd').css('display','inline-block'); 
        $('.inps').css('display','none');
        $('#cmbFamilias').prop('disabled',false);
        $('#cmbsubfamilia').prop('disabled',false);
        $('#cmbflujo').prop('disabled',false);
        $('#txtEmisor').prop('disabled',false);
    
}

function updatestatus(idstatus){
    if(idrutassss > 0){
        
        var confrutaupdate = confirm('Se actualizara el estatus de la ruta');
        
        if(confrutaupdate == true){
            
            $.post('./ajax/rutas/rutaEstatusActualizar.php',{idrutas:idrutassss,idstatus:idstatus,usr:usr},function(res){
        
                toasts(res.msg);
        
            },"JSON"); 
        }
        
             
    }
    
  
    
    
}

