$(document).ready(function(){

    datatablaprosp();
    $('#nuevospn').click(function(){ resetform();});  
    
    cargarfamilias(); 
    busquedaemisor();
    formatosiniciales();   
    $('#btneditarprod').css('display','none');
    
     $("#txtPorComProd, #txtPorComCte, #txtPorComUsr").mask("0.0000");
    
  /*  $("#txtIniVigencia").change(function(){
        
      var dt = new Date($("#txtIniVigencia").val());
             dt.setFullYear(dt.getFullYear() + 20);
         var monthss   = dt.getMonth();
         var dayss     = dt.getDate();
         var outputss  = dt.getFullYear() + '-' +(monthss<10 ? '0' : '') + monthss + '-' +(dayss<10 ? '0' : '') + dayss;
         $("#txtFinVigencia").val(outputs);
  
    });*/
      
});


    function datatablaprosp(){     
        
        	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#presubcadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./ajax/productos/productosDT.php",
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
                return row[5];
			
            }, "aTargets": [ 4 ] },
            
            //6a columna
			
			{ "mRender": function ( data, type, row ) {//fin vigencia
                return row[6];
			
            }, "aTargets": [ 5 ] },
            //7a columna
			
			{ "mRender": function ( data, type, row ) {//fin vigencia
               
				var iconoEditar = "<a href='#' onclick='editarproductopre("+row[0]+")'><center><img src=\"../img/edit.png\" title='Editar'></center></a>";
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

var idsubfamiliaseleccionada = -1;
var arraydeservicios = '';
var idprodss = 0;

function editarproductopre(idprod){
    editarproducto(idprod);
    setTimeout(function(){seleccioarsubfamilia()},2000);
      setTimeout(function(){seleccionarservicios()},2000);
    
$('#divestatus').css('display','block');
$('#divestatus1').css('display','block');    
    
}

function editarproducto(idprod){
    
    
    $.post('./ajax/productos/cargarproducto.php',{idprod:idprod},function(res){
        
   $('#cmbFamilias').val(res.idfam);
        cargarsubfamlias(res.idfam);
        //cargarservicios(res.idfam);
   
        
   $('#idemisor').val(res.idemisor);
   $('#txtEmisor').val(res.nombemisor);
   $('#txtdescr').val(res.desc);
   $('#txtabrev').val(res.abrev);
   $('#txtIniVigencia').val(res.inivigencia);
   $('#txtFinVigencia').val(res.finvigencia);
   $('#cmbflujo').val(res.idflujo);
   $('#txtMax').val(res.max);
   $('#txtMin').val(res.min);
   $('#txtPorComProd').val(res.pcp * 100);
   $('#txtImpComProd').val(res.icp);
   $('#txtPorComCte').val(res.pcc * 100);
   $('#txtImpComCte').val(res.icc);
   $('#txtPorComUsr').val(res.pcu * 100);
   $('#txtImpComUsr').val(res.icu);
   $('#txtestatus').val(res.idEstaProd);
    $('#txtsku').val(res.skuProducto);
       idsubfamiliaseleccionada = res.idsubfam;        
       arraydeservicios         = res.arrserv;       
       idprodss                 = res.idprod;     
        
    },"JSON");
  
    
    formatoedicion();
    
    
}


function cargarfamilias(){ // carga catalodo de familia
    
    $.post('./ajax/productos/familiasCatalogo.php',null,function(mensaje){
        
        $('#cmbFamilias').html(mensaje);
        
    });
    
}

function cargarsubfamlias(idfamilia){// carga catalogo de subfamilias por id de familia
    
    if(idfamilia == -1){
         $('#cmbsubfamilia').html('<option value="-1">--</option>');
        
    }else{
  $.post('./ajax/productos/subfamiliasCatalogo.php',{idfamilia:idfamilia},function(mensaje){
      
      $('#cmbsubfamilia').html(mensaje);
      
  }); 
        
         
    }
    cargarservicios(idfamilia);
    trantype.length = 0;
}



function cargarservicios(idfamilia){ // carga el catalogo de  servicion checkbox por id de familia
    
   $.post('./ajax/productos/serviciosFamilias.php',{idfamilia:idfamilia},function(mensaje){
       
       $('#servporfam').html(mensaje);
       
   });  
    
}


function busquedaemisor(){
    
         $("#txtEmisor").autocomplete({
			source: function(request,respond){
				$.post( "./ajax/productos/emisoresCatalogoBuscar.php", { "strBuscar": request.term },
				function( response ) {
					respond(response);
				}, "json" );
			},
			minLength: 1,
			focus: function(event,ui){
				$("#txtEmisor").val(ui.item.sRazonSocial);
				return false;
			},
			select: function(event,ui){
				$("#idemisor").val(ui.item.nIdCliente);
				
					
			
				return false;
			},
			search: function(){
			
				$("#idemisor").val('');
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a style=\"color:black\">"+ item.value + "</a>" )
			.appendTo( ul );
		};
    
}
    

function formatosiniciales(){
    
     $('#txtIniVigencia, #txtFinVigencia').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(){
          $(this).datepicker('hide'); 
         $(this).blur();
         
       
         
        }); 
    
    
     	$('#txtMax, #txtMin, #txtPorComProd, #txtImpComProd, #txtPorComCte, #txtImpComCte, #txtPorComUsr, #txtImpComUsr').alphanum({
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
    
    
    	$('#txtdescr','#txtdescr').alphanum({
			allow			: 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA',
			disallow		: '',
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: true,
			allowLower			: true,
			allowLatin			: false,
			allowOtherCharSets	: false,
			
		});
    
}

var trantype = new Array();

function serviciosasarray(e,idtrantype){
    if(e.checked==true){ trantype.push(idtrantype);  }else{
       
         for(var i = 0; i< trantype.length; i++){
            
             if(trantype[i] == idtrantype) {trantype.splice(i,1);}
         
         }
    }
  
    //alert(trantype);

    
}

function validarform(tipo){
    //alert(idprodss);
    
    var  familia = $('#cmbFamilias').val();
     var  subfamila = $('#cmbsubfamilia').val();
     var  emisor = $('#idemisor').val();
     var  descript = $('#txtdescr').val();
     var  abrev = $('#txtabrev').val();
    
     var  inivigencia = $('#txtIniVigencia').val();
     var  finvigencia = $('#txtFinVigencia').val();
     var  diflujo = $('#cmbflujo').val();
     var  max = $('#txtMax').val();
     var  min = $('#txtMin').val();
     var  porcomprod = $('#txtPorComProd').val();
     var  impcomprod = $('#txtImpComProd').val();
     var  porcomcte = $('#txtPorComCte').val();
     var  impporcte = $('#txtImpComCte').val();
     var  porcomusr = $('#txtPorComUsr').val();
     var  impcomusr = $('#txtImpComUsr').val();
   
    
    if(familia == -1){toasts('Debe seleccionar una Familia'); return;}
    if(subfamila == -1){toasts('Debe seleccionar una Subfamila'); return;}
    if(emisor == ''){toasts('Debe seleccionar un Emisor'); return;}
    if(descript == '' || descript.length < 3){toasts('Capture la descripci&oacute;n del producto de al menos 3 caracteres'); return;}
    if(abrev == '' || abrev.length < 3){toasts('Capture la abreviaci&oacute;n del producto de al menos 3 caracteres'); return;}
    
    //validar las fechas de vigencia.. falta ponerle valor predeterminado a la fecha  de vigencia que es de hoy a 20 años
    if(inivigencia == ''){toasts('Seleccione una fecha inicial de la vigencia'); return;}
    if(finvigencia == ''){toasts('Seleccione una fecha  final de la vigencia'); return;}
    if(finvigencia < inivigencia ){toasts('La fecha final de la vigencia debe ser mayor que la fecha inicial de la vigencia'); return;}
    
    
    
    
    if(diflujo == -1){toasts('Debe seleccionar un flujo'); return;}
    
    
    if(max == ''){toasts('Ingrese el importe m&iacute;nimo de la transacci&oacute;n'); return;}
    if(min == ''){toasts('Ingrese el importe m&aacute;ximo de la transacci&oacute;n'); return;}
    if(min > max){toasts('Il importe m&iacute;nimo debe ser menor o igual el importe m&aacute;ximo de la transacci&oacute;n'); return;}
    
    
    
    if(porcomprod == ''){toasts('Ingrese el porcentaje de la  comisi&oacute;n por producto dividido entre 100'); return;}
    if(impcomprod == ''){toasts('Ingrese el importe de la comisi&oacute;n por producto'); return;}
    
    if(porcomcte == ''){toasts('Ingrese el porcentaje de la  comisi&oacute;n para clientes dividido entre 100'); return;}
    if(porcomcte > porcomprod){toasts('El porcentaje de comisi&oacute;n para clientes no debe ser mayor que el porcentaje de la  comisi&oacute;n por producto  '); return;}
    
        
    if(impporcte == ''){toasts('Ingrese el importe de la comisi&oacute;n para clientes'); return;}
    if(impporcte > impcomprod){toasts('El importe de la comisi&oacute;n para clientes no debe ser mayor al importe de la comisi&oacute;n por producto'); return;}
    
    
    if(porcomusr == ''){toasts('Ingrese el porcentaje cobrable al usuario dividido entre 100'); return;}
    if(impcomusr == ''){toasts('Ingrese el importe de  comisi&oacute;n cobrable al usuario'); return;}
    

    if(trantype.length == 0){toasts('Debe seleccionar al menos un servicio'); return;}
    
    if(tipo == 1){
        
        var r = confirm('¿Desea Registar el Producto?');
        if(r == true){ guardarproducto();}
        
    }else{
        var act = confirm('¿Desea Actualizar  el Producto?');
        if(act == true){ editarproductoss();}
        
    }
    
   
    
    
}

function toasts(mensaje){
       $().toastmessage('showToast', {
       text	: mensaje,
		sticky: false, position	: 'top-center', type: 'warning'}); 
}
    
    
function guardarproducto(){
    
   // alert('ha accedido a guardar el producto');
    
    var  familia = $('#cmbFamilias').val();
     var  subfamila = $('#cmbsubfamilia').val();
     var  emisor = $('#idemisor').val();
     var  descript = $('#txtdescr').val();
     var  abrev = $('#txtabrev').val();
     var  inivigencia = $('#txtIniVigencia').val();
     var  finvigencia = $('#txtFinVigencia').val();
     var  idflujo = $('#cmbflujo').val();
     var  max = $('#txtMax').val();
     var  min = $('#txtMin').val();
     var  porcomprod = $('#txtPorComProd').val() / 100;
     var  impcomprod = $('#txtImpComProd').val();
     var  porcomcte = $('#txtPorComCte').val() / 100;
     var  impporcte = $('#txtImpComCte').val();
     var  porcomusr = $('#txtPorComUsr').val() / 100;
     var  impcomusr = $('#txtImpComUsr').val();
    
    var servicios = trantype.join(",");
   
    
    $.post('./ajax/productos/productosGuardar.php',{familia:familia,subfamila:subfamila,emisor:emisor,descript:descript,abrev:abrev,inivigencia:inivigencia,finvigencia:finvigencia,idflujo:idflujo,max:max,min:min,porcomprod:porcomprod,impcomprod:impcomprod,porcomcte:porcomcte,impporcte:impporcte,porcomusr:porcomusr,impcomusr:impcomusr,servicios:servicios,usr:usr},function(res){
        
        if(res.code == 0){
            toasts(res.msg);
            resetform();
            
            $('#pannel1').css('display','none');
            // no se resetea el datatable so mucho productos.
        }else{toasts(res.msg);}
        
    },"JSON");
    
}    
    


function resetform(){
    
var d       = new Date();
var month   = d.getMonth()+1;
var day     = d.getDate();
var output  = d.getFullYear() + '-' +(month<10 ? '0' : '') + month + '-' +(day<10 ? '0' : '') + day;
    
  
var ds = new Date();
ds.setFullYear(ds.getFullYear() + 20);
var months   = ds.getMonth();
var days     = ds.getDate();
var outputs  = ds.getFullYear() + '-' +(month<10 ? '0' : '') + month + '-' +(day<10 ? '0' : '') + day;
    
    
    
   $('#cmbFamilias').val(-1);
   $('#cmbsubfamilia').val(-1);
   $('#idemisor').val(-1);
   $('#txtEmisor').val('');
   $('#txtdescr').val('');
   $('#txtabrev').val('');
   $('#txtIniVigencia').val(output);
   $('#txtFinVigencia').val(outputs);
   $('#cmbflujo').val(-1);
   $('#txtMax').val('');
   $('#txtMin').val('');
   $('#txtPorComProd').val('');
   $('#txtImpComProd').val('');
   $('#txtPorComCte').val('');
   $('#txtImpComCte').val('');
   $('#txtPorComUsr').val('');
   $('#txtImpComUsr').val('');
     
     trantype.length = 0;
    cargarservicios(0);
    
    formatonuevoprod();
    
}

function eliminarproducto(idprod){
    
     var r= confirm('¿Desea eliminar el Producto?');
    
    if(r == true){
    $.post('./ajax/productos/productosEliminar.php',{idprod:idprod,usr:usr},function(res){
        
        if(res.code == 0){ toasts(res.msg);
                          
                         RefreshTable('#presubcadenas', './ajax/productos/productosDT.php');
               
                         }else{toasts(res.msg);}
    
    },"JSON");

    }
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


function seleccioarsubfamilia(){
    
    $('#cmbsubfamilia').val(idsubfamiliaseleccionada);
     console.log(idsubfamiliaseleccionada);
}
function seleccionarservicios(){
     trantype.length = 0;
    arraydeservicios = arraydeservicios.split(',');
    
    
    for(var i = 0; i < arraydeservicios.length;i++){
        
        trantype.push(arraydeservicios[i]);
     
        $('input[type=checkbox][name=ckservicio][value='+arraydeservicios[i]+']').prop('checked', true);
    }

}

function editarproductoss(){
    
    var  emisor    = $('#idemisor').val();
     var  descript    = $('#txtdescr').val();
     var  abrev       = $('#txtabrev').val();
     var  inivigencia = $('#txtIniVigencia').val();
     var  finvigencia = $('#txtFinVigencia').val();
    // averiguar se aqui se peude cambiar el status de cuelta a activo.. si no pues ya se armo.
     var  max         = $('#txtMax').val();
     var  min         = $('#txtMin').val();
     var  porcomprod  = $('#txtPorComProd').val() / 100;
     var  impcomprod  = $('#txtImpComProd').val() ;
     var  porcomcte   = $('#txtPorComCte').val() / 100;
     var  impporcte   = $('#txtImpComCte').val();
     var  porcomusr   = $('#txtPorComUsr').val() / 100;
     var  impcomusr   = $('#txtImpComUsr').val();
     var  sku         = $('#txtsku').val();
    
    var servicios     = trantype.join(",");
    
    
     $.post('./ajax/productos/productosEditar.php',{idprodss:idprodss,descript:descript,abrev:abrev,inivigencia:inivigencia,finvigencia:finvigencia,max:max,min:min,porcomprod:porcomprod,impcomprod:impcomprod,porcomcte:porcomcte,impporcte:impporcte,porcomusr:porcomusr,impcomusr:impcomusr,servicios:servicios,usr:usr,sku:sku,emisor:emisor},function(res){
        
        if(res.code == 0){
            toasts(res.msg);
            resetform();
            
            $('#pannel1').css('display','none');
            // no se resetea el datatable so mucho productos.
        }else{toasts(res.msg);}
        
    },"JSON");
    
  
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
    $('#divestatus').css('display','none');
    $('#divestatus1').css('display','none');  
}

function updatestatus(idstatus){
    
    
    $.post('./ajax/productos/productosEstatusActualizar.php',{idprodss:idprodss,idstatus:idstatus,usr:usr},function(res){
        
        toasts(res.msg);
        
    },"JSON");
    
    
}

