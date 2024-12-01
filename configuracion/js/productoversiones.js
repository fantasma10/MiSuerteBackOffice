$(document).ready(function(){

    
    formatosiniciales(); 
    
    busquedaproducto()
    $('#nuevospn').click(function(){ resetform();$('#pannel1').css('display','block');});  
    $("#txtimpespecial, #txtporcomercio, #txtporgrup, #txtporusuario, #txtporcosto, #txtporespecial").mask("0.0000");

});

var idpermisoo = 0;



function cargapermisos(){
    
    
    var textidprod = $('#idproducto').val();
    
    if(textidprod == ''){
        toasts('Debe seleccionar un producto antes de filtrar'); return;
        
        }else{
            
           $.post('./productopermisos.php',{prod:textidprod},function(mensaje){
        
        $('#tablaCortes').html(mensaje);
        
    });
     loadrutas();
    limpiaformulario();
       $('#pannel1').css('display','none');       
   }
       
}


function formatosiniciales(){ 
     
     	$('#txtimpcosto, #txtimpespecial, #txtimpusuario, #txtimpgrupo, #txtimpcomercio, #txtminimo, #txtmaximo, #txtimpcomercio, #txtimpgrup, #txtimpusuario, #txtimpespecial, #txtimpcosto').alphanum({
			disallow			    : 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA',
			allow			: '.0123456789',
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: false,
			allowLower			: false,
			allowLatin			: false,
			allowOtherCharSets	: false,
			maxLength			: 6
		});
        

}//caracteres admitidos en los campos del formulario





function toasts(mensaje){ // contraer el toast
       $().toastmessage('showToast', {
       text	: mensaje,
		sticky: false, position	: 'top-center', type: 'warning'}); 
} // contraccion de la funcion toastmsg
    



function resetform(){ 
    
  $('#txtnombre').val('');
  $('#txtabrev').val('');
  idpermisoo =0;   
   console.log(idpermisoo);   
}//limpiar los datos del formulario



function busquedaproducto(){
    
         $("#txtProducto").autocomplete({
			source: function(request,respond){
				$.post( "./ajax/permisos/productosAC.php", { "strBuscar": request.term },
				function( response ) {
					respond(response);
				}, "json" );
			},
			minLength: 1,
			focus: function(event,ui){
				$("#txtProducto").val(ui.item.sRazonSocial);
				return false;
			},
			select: function(event,ui){
				$("#idproducto").val(ui.item.nIdCliente);
				
					
			
				return false;
			},
			search: function(){
			
				$("#idproducto").val('');
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a style=\"color:black\">"+ item.value + "</a>" )
			.appendTo( ul );
		};
    
}
function borraidprod(){
    
    var textnomoprod = $('#txtProducto').val();
    
    
    if(textnomoprod == '' || textnomoprod.length < 4){
        
        $('#idproducto').val('');
        limpiaformulario();
          idpermisoo =0; 
        console.log(idpermisoo); 
        $('#pannel1').css('display','none'); 
    }
}

function loadformulario(){
    
  var textidprod = $('#idproducto').val();
    
    if(textidprod == ''){
        toasts('Debe seleccionar un producto para agregar a los permisos'); return;
        
        }else{
           $('#pannel1').css('display','block'); 
            limpiaformulario();
            loadrutas();
       
        }
    
} 

function loadrutas(){
    
    var idproductos = $("#idproducto").val();
    
    $.post('./ajax/permisos/rutasporprod.php',{prod:idproductos},function(mensaje){
       
        $('#cmbruta').html(mensaje);
        
        
    });
}




function validarform(){
 
var  version        = $('#cmbversion').val();
var  maximo         = $('#txtmaximo').val();
var  impcomercio    = $('#txtimpcomercio').val();
var  impgrupo       = $('#txtimpgrupo').val();
var  impusuario     = $('#txtimpusuario').val();
var  impespecial    = $('#txtimpespecial').val();
var  impcosto       = $('#txtimpcosto').val();

var  ruta           = $('#cmbruta').val();
var  minimo         = $('#txtminimo').val();
var  porcomercio    = $('#txtporcomercio').val();
var  porgrupo       = $('#txtporgrup').val();
var  porusuario     = $('#txtporusuario').val();
var  porespecial    = $('#txtporespecial').val();
var  porcosto       = $('#txtporcosto').val();

  //campos para validacion
    
    
var  impcpmercioval   = $('#impcomercio').val();
var  impusuarioval    = $('#impusuario').val();
var  impcostoval      = $('#impcosto').val();
var  porcomercioval   = $('#pocomercio').val();
var  porusuarioval    = $('#porusuario').val();
var  porcostoval      = $('#porcosto').val();
    
    
    //validaciones
    
    if(version == -1){toasts('Debe seleccionar una versión'); return;}
    if(ruta == -1){toasts('Debe seleccionar una Ruta'); return;}
    if(maximo == ''){toasts('Debe Caputurar el importe máximo'); return;}
    if(minimo == ''){toasts('Debe Caputurar el importe mínimo'); return;}
    
    if(minimo > maximo){toasts('El importe Máximo deve ser igual o mayor al importe Mínimo'); return;}
    
    
    if(impcomercio == "." || impcomercio  == ''){toasts('Debe Capturar un importe al comercio dejarlo en 0'); return;}
    if(impgrupo == "."|| impgrupo  == ''){toasts('Debe Capturar un importe al grupo dejarlo en 0'); return;}
    if(impusuario == "."|| impusuario  == ''){toasts('Debe Capturar un importe al usuario dejarlo en 0'); return;}
    if(impespecial == "."|| impespecial  == ''){toasts('Debe Capturar un importe al especial dejarlo en 0'); return;}
    if(impcosto == "."|| impcosto  == ''){toasts('Debe Capturar un importe del costo dejarlo en 0'); return;}
    
    if(porcomercio == "."|| porcomercio  == ''){toasts('Debe Capturar un porcentaje al comercio dejarlo en 0'); return;}
    if(porgrupo == "."|| porgrupo  == ''){toasts('Debe Capturar un porcentaje al grupo dejarlo en 0'); return;}
    if(porusuario == "."|| porusuario  == ''){toasts('Debe Capturar un porcentaje al usuario dejarlo en 0'); return;}
    if(porespecial == "."|| porespecial  == ''){toasts('Debe Capturar un porcentaje especial dejarlo en 0'); return;}
    if(porcosto == "."|| porcosto == ''){toasts('Debe Capturar un porcentaje al costo dejarlo en 0'); return;}
    
    
    
    if(impcomercio > impcpmercioval){toasts('El immporte del Comercio capturado no debe ser mayor al importe de comercio establecido en la ruta'); return;}
    if(impusuario  > impusuarioval){toasts('El immporte cobrado al usuario capturado no debe ser mayor al importe cobrado al usuario establecido en la ruta'); return;}
    if(impcosto    > impcostoval){toasts('El immporte del Costo capturado no debe ser mayor al importe del Costo establecido en la Ruta'); return;}
    if(porcomercio > porcomercioval){toasts('El porcentaje capturado al comercio no debe ser mayor al porcentaje al comercio establecido en la Ruta'); return;}
    if(porusuario  > porusuarioval){toasts('El porcentaje cobrado al usuario capturado no debe ser mayor al porcentaje cobrado al usuario establecido en la Ruta'); return;}
    if(porcosto    > porcostoval){toasts('El porcentaje capturado del costo no debe ser mayor al porcentaje de costo establecido en la Ruta'); return;}
    
    guardarPermiso();
}


function guardarPermiso(){
    
    var cnf= confirm ('¿Desea guardar la información?');
  
    
var  producto       = $('#idproducto').val();
var  version        = $('#cmbversion').val();
var  maximo         = $('#txtmaximo').val();
var  impcomercio    = $('#txtimpcomercio').val();
var  impgrupo       = $('#txtimpgrupo').val();
var  impusuario     = $('#txtimpusuario').val();
var  impespecial    = $('#txtimpespecial').val();
var  impcosto       = $('#txtimpcosto').val();

var  ruta           = $('#cmbruta').val();
var  minimo         = $('#txtminimo').val();
var  porcomercio    = $('#txtporcomercio').val();
var  porgrupo       = $('#txtporgrup').val();
var  porusuario     = $('#txtporusuario').val();
var  porespecial    = $('#txtporespecial').val();
var  porcosto       = $('#txtporcosto').val(); 
var estatus         = $('#txtestatus').val(); 
    
    if(cnf == true){
        
        
       $.post('./ajax/permisos/guardarpermisos.php',{idpermisoo:idpermisoo,version:version,ruta:ruta,producto:producto,maximo:maximo,minimo:minimo,impcomercio:impcomercio,impgrupo:impgrupo,impusuario:impusuario,impespecial:impespecial,impcosto:impcosto,porcomercio:porcomercio,porgrupo:porgrupo,porusuario:porusuario,porespecial:porespecial,porcosto:porcosto,usr:usr,estatus:estatus},function(res){
        
        if(res.code == 0){
           toasts(res.msg);
            cargapermisos();
            limpiaformulario()
            $('#pannel1').css('display','none');
                        
        }else{
            
            toasts(res.msg); 
        }
    },"JSON"); 
        
    }
    
  
}

function limpiaformulario(){
    
    $('#rutasdiv').css('display','none');
    
$('#cmbversion').val(-1);
$('#txtmaximo').val('0.0000');
$('#txtimpcomercio').val('0.0000');
$('#txtimpgrupo').val('0.0000');
$('#txtimpusuario').val('0.0000');
$('#txtimpespecial').val('0.0000');
$('#txtimpcosto').val('0.0000');

$('#cmbruta').val(-1);
$('#txtminimo').val('0.0000');
$('#txtporcomercio').val('0.0000');
$('#txtporgrup').val('0.0000');
$('#txtporusuario').val('0.0000');
$('#txtporespecial').val('0.0000');
$('#txtporcosto').val('0.0000'); 
    
    
    $('#impcomercio').val('0.0000');
    $('#impgrupo').val('0.0000');
    $('#impusuario').val('0.0000');
    $('#impespecial').val('0.0000');
    $('#impcosto').val('0.0000');


    $('#pocomercio').val('0.0000');
    $('#porgrupo').val('0.0000');
    $('#porusuario').val('0.0000');
    $('#porespecial').val('0.0000');
    $('#porcosto').val('0.0000');  
    $('#divstatus').val('0');
     idpermisoo =0; 
        console.log(idpermisoo);
    
    $('#divstatus').css('display','none');
}

function cargaruta(){
    
  var rutaa =  $('#cmbruta').val(); 
    
    if (rutaa != -1){ 
      $('#rutasdiv').css('display','block');   
    $.post('./ajax/rutas/cargaruta.php',{idruta:rutaa},function(res){
        
      
            // ponemos los datos en los campos editables
            
                
                $('#txtmaximo').val(res.maxruta);
                $('#txtimpcomercio').val(res.impcomcte);
                $('#txtimpgrupo').val('0.0000');
                $('#txtimpusuario').val(res.impcomusu);
                $('#txtimpespecial').val('0.0000');
                $('#txtimpcosto').val(res.impcostoruta);

                
                $('#txtminimo').val(res.minruta);
                $('#txtporcomercio').val(res.porcomcte);
                $('#txtporgrup').val('0.0000');
                $('#txtporusuario').val(res.porcomusu);
                $('#txtporespecial').val('0.0000');
                $('#txtporcosto').val(res.porcostoruta); 
            
            //ponemos los datos en los campos no editables para comparacion visible
            
               
                $('#impcomercio').val(res.impcomcte);
                $('#impusuario').val(res.impcomusu);
                $('#impcosto').val(res.impcostoruta);


                $('#pocomercio').val(res.porcomcte);
                $('#porusuario').val(res.porcomusu);
                $('#porcosto').val(res.porcostoruta);
     
    
    },"JSON")
    
    }else{ $('#rutasdiv').css('display','none');}
}

function cargaruta2(idrutas){
    

    console.log(idrutas);
  
      $('#rutasdiv').css('display','block');   
    $.post('./ajax/rutas/cargaruta.php',{idruta:idrutas},function(res){
        
      
            //ponemos los datos en los campos no editables para comparacion visible
            
               
                $('#impcomercio').val(res.impcomcte);
                $('#impusuario').val(res.impcomusu);
                $('#impcosto').val(res.impcostoruta);


                $('#pocomercio').val(res.porcomcte);
                $('#porusuario').val(res.porcomusu);
                $('#porcosto').val(res.porcostoruta);
     
    
    },"JSON");
    
  
}

function editapermiso(idpermiso){
    
    $.post('./ajax/permisos/cargapermiso.php',{idpermiso:idpermiso},function(res){
        
         $('#txtmaximo').val(res.maxruta);
                idpermisoo = res.idpermiso;
                $('#cmbversion').val(res.idversion);
                $('#cmbruta').val(res.idruta);
        
                $('#txtimpcomercio').val(res.impcomercio);
                $('#txtimpgrupo').val(res.impgrupo);
                $('#txtimpusuario').val(res.impusuario);
                $('#txtimpespecial').val(res.impespecial);
                $('#txtimpcosto').val(res.impcosto);

        
                $('#txtmaximo').val(res.maximo);
                $('#txtminimo').val(res.minimo);
                $('#txtporcomercio').val(res.porcomercio);
                $('#txtporgrup').val(res.porgrupo);
                $('#txtporusuario').val(res.porusuario);
                $('#txtporespecial').val(res.porespecial);
                $('#txtporcosto').val(res.porcosto); 
                 $('#txtestatus').val(res.idestatus); 
        
        
        console.log(res.idruta);
         cargaruta2(res.idruta);
       
        
    },"JSON");
    
   $('#pannel1').css('display','block');
    $('#divstatus').css('display','block'); 
    
}



function NumCheck(e, field) {
  key = e.keyCode ? e.keyCode : e.which
  // backspace
  if (key == 8) return true
  // 0-9
  if (key > 47 && key < 58) {
    if (field.value == "") return true
    regexp = /.[0-9]{4}$/
    return !(regexp.test(field.value))
  }
  // .
  if (key == 46) {
    if (field.value == "") return false
    regexp = /^[0-9]+$/
    return regexp.test(field.value)
  }
  // other key
  return false
 
}
 

