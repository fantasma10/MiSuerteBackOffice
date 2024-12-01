var subFamiliaRequest = serviciosRequest = null;
var productoServicio = null;
var updateProducto = null;
var closeLoader = false;

$(document).ready(function() {
    $("#select_familia").on("change", function (){
        closeLoader = false;
        $("#loaderEmisor").removeClass("hidden");
        $('.rowservicios').remove();
        BuscarSubFamilias(this.value);
    })
});

function closeSpinner() {
    if(closeLoader){
        $("#loaderEmisor").addClass("hidden");
        closeLoader = false;
    }
    else closeLoader = true;
}

function initViewAltaProducto(){

    $(".alphanum45").alphanum({
        allow				: 'áéíóúÁÉÍÓÚñÑ',
        allowNumeric		: true,
        allowOtherCharSets	: false,
        maxLength			: 45
    });

    $("#importe_minimo_producto, #importe_maximo_producto").numeric({
        maxDigits           : 18,
        maxDecimalPlaces    : 4,
        allowPlus           : false,
        allowMinus          : false,
        allowThouSep        : false,
        allowDecSep         : true,
        allowLeadingSpaces  : false
    });

    var dataTableObj;
    var Layout = {
        inicializatxt: function(){
            /*$("#sku").alphanum({
                allowNumeric        : true,
                allowOtherCharSets  : false,
                maxLength           : 25
            });
            $("#sku").attr('style', 'text-transform: uppercase;');*/

            /*$("#importe_minimo_producto, #importe_maximo_producto,#importe_comision_producto,#importe_comision_corresponsal,#importe_comision_cliente").numeric({
                allowPlus           : false,
                allowMinus          : false,
                allowThouSep        : false,
                allowDecSep         : true,
                allowLeadingSpaces  : false
            });
            $("#porcentaje_comision_producto, #porcentaje_comision_corresponsal, #porcentaje_comision_cliente").numeric({
                allowPlus           : false,
                allowMinus          : false,
                allowThouSep        : false,
                allowDecSep         : true,
                allowLeadingSpaces  : false
            });
             $("#porcentaje_comision_producto, #porcentaje_comision_corresponsal, #porcentaje_comision_cliente").attr("maxlength", "5");*/
        },

        buscaFamilia: function() {
            $("#select_familia").empty();
            if(jSonFamilia == undefined || jSonFamilia == null) {
                $.post("../ajax/altaProveedores.php", {tipo: 1},
                    function (response) {
                        //async: false;
                        var obj = jQuery.parseJSON(response);
                        $('#select_familia').append('<option value="0">Seleccione</option>');
                        if (obj !== null) {
                            jQuery.each(obj, function (index, value) {
                                var nombre_familia = obj[index]['descFamilia'];
                                $('#select_familia').append('<option value="' + obj[index]['idFamilia'] + '">' + nombre_familia + '</option>');
                            });
                        }
                    }
                ).fail(function (resp) {
                    alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
                })
            } else {
                $('#select_familia').append('<option value="0">Seleccione</option>');
                jSonFamilia.forEach(function(index, value){
                    var nombre_familia = index['descFamilia'];
                    $('#select_familia').append('<option value="' + index['idFamilia'] + '">' + nombre_familia + '</option>');
                });
            }
        },
        detectaCambio : function(){
            $('#fecha1').datepicker()
                .on('changeDate', function(e) {
                    var contador=0;
                    $.each(e, function (key, value) {
                        contador++;
                        if(contador==2){
                            var hora =value+"";
                            var partes = hora.split(" ");
                            var anio;
                            var mes;
                            var dia;
                            if(partes[1]=="Jan"){
                                mes ="01";
                            }
                            if(partes[1]=="Feb"){
                                mes ="02";
                            }
                            if(partes[1]=="Mar"){
                                mes ="03";
                            }
                            if(partes[1]=="Apr"){
                                mes ="04";
                            }
                            if(partes[1]=="May"){
                                mes ="05";
                            }
                            if(partes[1]=="Jun"){
                                mes ="06";
                            }
                            if(partes[1]=="Jul"){
                                mes ="07";
                            }
                            if(partes[1]=="Aug"){
                                mes ="08";
                            }
                            if(partes[1]=="Sep"){
                                mes ="09";
                            }
                            if(partes[1]=="Oct"){
                                mes ="10";
                            }
                            if(partes[1]=="Nov"){
                                mes ="11";
                            }
                            if(partes[1]=="Dec"){
                                mes ="12";
                            }
                            anio = parseInt(partes[3])+parseInt(20);
                            var finale = anio+"-"+mes+"-"+partes[2];
                            $("#fecha2").val(finale);
                        }
                    });
                });

        },
        cargaEmisores: function() {
            $("#select_emisor").empty();
            if(jSonEmisor == undefined || jSonEmisor == null) {
                $.post("../ajax/altaProveedores.php", {tipo: 4},
                    function (response) {
                        //async: false;
                        var obj = jQuery.parseJSON(response);
                        $('#select_emisor').append('<option value="0">Seleccione</option>');
                        if (obj !== null) {
                            jQuery.each(obj, function (index, value) {
                                var nombre_emisor = obj[index]['descEmisor'];
                                $('#select_emisor').append('<option value="' + obj[index]['idEmisor'] + '">' + nombre_emisor + '</option>');
                            });
                        }
                    }
                ).fail(function (resp) {
                    alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
                })
            } else {
                $('#select_emisor').append('<option value="0">Seleccione</option>');
                jSonEmisor.forEach(function(index, value){
                    var nombre_emisor = index['descEmisor'];
                    $('#select_emisor').append('<option value="' + index['idEmisor'] + '">' + nombre_emisor + '</option>');
                });
            }
        },

        cargaFlujoImporte: function() {
            $("#select_flujo_importe").empty();
            if(jSonFlujoImporte == undefined || jSonFlujoImporte == null) {
                $.post("../ajax/altaProveedores.php", {tipo: 5},
                    function (response) {
                        //async: false;
                        var obj = jQuery.parseJSON(response);
                        $('#select_flujo_importe').append('<option value="-1">Seleccione</option>');
                        if (obj !== null) {
                            jQuery.each(obj, function (index, value) {
                                var nombre_flujo = obj[index]['descFlujo'];
                                $('#select_flujo_importe').append('<option value="' + obj[index]['idFlujo'] + '">' + nombre_flujo + '</option>');
                            });
                        }
                    }
                ).fail(function (resp) {
                    alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
                })
            } else {
                $('#select_flujo_importe').append('<option value="-1">Seleccione</option>');
                jSonFlujoImporte.forEach(function(index, value){
                    var nombre_flujo = index['descFlujo'];
                    $('#select_flujo_importe').append('<option value="' + index['idFlujo'] + '">' + nombre_flujo + '</option>');
                });
            }
        },

        cargaEstatus: function(){
            $("#estatus").empty();
            $.post("../ajax/consultaProducto.php", { tipo: 3 },
                function(response) {
                    //async: false;
                    var obj = jQuery.parseJSON(response);
                    $('#estatus').append('<option value="-1">Seleccione</option>');
                    if (obj !== null) {
                        jQuery.each(obj, function(index, value) {
                            var descEstatus = obj[index]['descEstatus'];
                            $('#estatus').append('<option value="' + obj[index]['idEstatus'] + '">' + descEstatus + '</option>');
                        });
                    }
                }
            ).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
        },

        initBotones: function(){
            $('#guardarProducto').on("click", function(){   // guarda la info del produto
                var lack = "";
                var error = "";

                if (updateProducto != null){
                    updateProducto.abort();
                    updateProducto = null;
                }

                $("#loaderEmisor").removeClass("hidden");

                if ($('#fecha2').val() < $('#fecha1').val()){
                    $("#loaderEmisor").addClass("hidden");
                    jAlert('La Fecha Salida debe ser mayor que la Fecha Entrada');
                    return;
                }else{
                    var familia = $("#select_familia option:selected").val();
                    var subfamilia = $("#select_subfamilia option:selected").val();
                    var emisor = $("#select_emisor option:selected").val();
                    var descripcion = $("#producto_descripcion").val();
                    var abreviatura = $("#producto_abreviatura").val();
                    var fechaentradavigor = $("#fecha1").val();
                    var fechasalidavigor = $("#fecha2").val();
                    var flujoimporte = $("#select_flujo_importe option:selected").val();

                    var importeminimoproducto = $("#importe_minimo_producto").val();
                    var importemaximoproducto = $("#importe_maximo_producto").val();
                    var porcentajecomisionproducto = $("#porcentaje_comision_producto").val();
                    var importecomisionproducto = $("#importe_comision_producto").val();
                    var porcentajecomisioncorresponsal = $("#porcentaje_comision_corresponsal").val();
                    var importecomisioncorresponsal = $("#importe_comision_corresponsal").val();
                    var porcentajecomisioncliente = $("#porcentaje_comision_cliente").val();
                    var importecomisioncliente = $("#importe_comision_cliente").val();

                    var CheckBox = new Array();
                    $.each($('.check_servicios:checkbox:checked'), function (key, value) {
                        CheckBox.push($(value).attr("id"));
                    });
                    longitudServicios = CheckBox.length;

                    if(familia == undefined || familia == 0 || familia == '' ){lack +='Familia\n'; }
                    if(subfamilia == undefined || subfamilia == 0 || subfamilia == '' ){lack +='Subfamilia\n'; }
                    if(emisor == undefined || emisor == 0 || emisor == '' ){lack +='Emisor\n'; }
                    if(descripcion == undefined || descripcion == 0 || descripcion == '' ){lack +='Descripcion\n'; }
                    if(abreviatura == undefined || abreviatura == 0 || abreviatura == '' ){lack +='Abreviatura\n'; }
                    if(fechaentradavigor == undefined || fechaentradavigor == 0 || fechaentradavigor == '' ){lack +='Fecha Entrada Vigor\n'; }
                    if(fechasalidavigor == undefined || fechasalidavigor == 0 || fechasalidavigor == '' ){lack +='Fecha Salida Vigor\n'; }
                    if(flujoimporte == undefined || flujoimporte == -1 || flujoimporte == '' ){lack +='Flujo Importe\n'; }

                    if(importeminimoproducto == undefined || importeminimoproducto == '' ){lack +='Importe Minimo Producto\n'; }
                    if(importemaximoproducto == undefined || importemaximoproducto == '' ){lack +='Importe Maximo Producto\n'; }
                    if(porcentajecomisionproducto == undefined  || porcentajecomisionproducto == '' ){lack +='Porcentaje Comision Producto\n'; }
                    if(importecomisionproducto == undefined ||  importecomisionproducto == '' ){lack +='Importe Comision Producto\n'; }
                    if(porcentajecomisioncorresponsal == undefined  || porcentajecomisioncorresponsal == '' ){lack +='Porcentaje Comision Corresponsal\n'; }
                    if(importecomisioncorresponsal == undefined || importecomisioncorresponsal == '' ){lack +='Importe Comision Corresponsal\n'; }
                    if(porcentajecomisioncliente == undefined || porcentajecomisioncliente == '' ){lack +='Porcentaje Comision Cliente\n'; }
                    if(importecomisioncliente == undefined || importecomisioncliente == '' ){lack +='Importe Comision Cliente\n'; }


                    if(longitudServicios == undefined || longitudServicios == 0 || longitudServicios == '' ){lack +='Servicios\n'; }

                    if(lack != "" || error != ""){
                        var black = (lack != "") ? "Los siguientes datos son Obligatorios : " : "";
                        $("#loaderEmisor").addClass("hidden");
                        jAlert(black + '\n' + lack+'\n' );
                    }else{
                        updateProducto = $.ajax({
                            data:{
                                tipo : 7,
                                familia : familia,
                                subfamilia : subfamilia,
                                emisor : emisor,
                                descripcion : descripcion,
                                abreviatura : abreviatura,
                                fechaentradavigor : fechaentradavigor,
                                fechasalidavigor : fechasalidavigor,
                                flujoimporte : flujoimporte,
                                importeminimoproducto : importeminimoproducto,
                                importemaximoproducto : importemaximoproducto,
                                porcentajecomisionproducto : porcentajecomisionproducto,
                                importecomisionproducto : importecomisionproducto,
                                porcentajecomisioncorresponsal : porcentajecomisioncorresponsal,
                                importecomisioncorresponsal : importecomisioncorresponsal,
                                porcentajecomisioncliente : porcentajecomisioncliente,
                                importecomisioncliente : importecomisioncliente,
                                longitudServicios : CheckBox
                            },
                            type: 'POST',
                            cache: false,
                            url: '../ajax/altaProveedores.php',
                            success: function(response){
                                var obj = jQuery.parseJSON(response);
                                var errorcode="";
                                var errormsg="";
                                var idProducto = "";
                                errorcode = obj['showMessage'];
                                errormsg =  obj['msg'];
                                idProducto = obj["idproducto"];
                                $("#loaderEmisor").addClass("hidden");
                                jAlert(errormsg);
                                if(errorcode === 0) setTimeout("location.reload()", 2000);
                            }
                        });
                    }
                }
            });

            $("#guardarProductoEditar").on("click",function(){  //actuliza la info del producto
                var lack = "";
                var error = "";

                if (updateProducto != null){
                    updateProducto.abort();
                    updateProducto = null;
                }

                $("#loaderEmisor").removeClass("hidden");

                if ($('#fecha2').val() < $('#fecha1').val()){
                    $("#loaderEmisor").addClass("hidden");
                    jAlert('La Fecha Salida debe ser mayor que la Fecha Entrada');
                    return;
                }else{
                    var idProducto = $("#idProducto").val();
                    var familia = $("#select_familia option:selected").val();
                    var subfamilia = $("#select_subfamilia option:selected").val();
                    var emisor = $("#select_emisor option:selected").val();
                    var descripcion = $("#producto_descripcion").val();
                    var abreviatura = $("#producto_abreviatura").val();
                    var fechaentradavigor = $("#fecha1").val();
                    var fechasalidavigor = $("#fecha2").val();
                    var flujoimporte = $("#select_flujo_importe option:selected").val();
                    var estatus = $("#estatus").val();
                    var CheckBox = new Array();
                    $.each($('.check_servicios:checkbox:checked'), function (key, value) {
                        CheckBox.push($(value).attr("id"));
                    });

                    var importeminimoproducto = $("#importe_minimo_producto").val();
                    var importemaximoproducto = $("#importe_maximo_producto").val();
                    var porcentajecomisionproducto = $("#porcentaje_comision_producto").val();
                    var importecomisionproducto = $("#importe_comision_producto").val();
                    var porcentajecomisioncorresponsal = $("#porcentaje_comision_corresponsal").val();
                    var importecomisioncorresponsal = $("#importe_comision_corresponsal").val();
                    var porcentajecomisioncliente = $("#porcentaje_comision_cliente").val();
                    var importecomisioncliente = $("#importe_comision_cliente").val();

                    longitudServicios = CheckBox.length;
                    if(familia == undefined || familia == 0 || familia == '' ){lack +='Familia\n'; }
                    if(subfamilia == undefined || subfamilia == 0 || subfamilia == -1|| subfamilia == '' ){lack +='Subfamilia\n'; }
                    if(emisor == undefined || emisor == 0 || emisor == '' ){lack +='Emisor\n'; }
                    if(descripcion == undefined || descripcion == 0 || descripcion == '' ){lack +='Descripcion\n'; }
                    if(abreviatura == undefined || abreviatura == 0 || abreviatura == '' ){lack +='Abreviatura\n'; }
                    // if(sku == undefined || sku == 0 || sku == '' ){lack +='SKU\n'; }
                    if(fechaentradavigor == undefined || fechaentradavigor == 0 || fechaentradavigor == '' ){lack +='Fecha Entrada Vigor\n'; }
                    if(fechasalidavigor == undefined || fechasalidavigor == 0 || fechasalidavigor == '' ){lack +='Fecha Salida Vigor\n'; }
                    if(flujoimporte == undefined || flujoimporte == -1 || flujoimporte == '' ){lack +='Flujo Importe\n'; }
                    //if(estatus == undefined || estatus == '' ){lack +='Estatus\n'; }
                    if(longitudServicios == undefined || longitudServicios == 0 || longitudServicios == '' ){lack +='Servicios\n'; }

                    if(lack != "" || error != ""){
                        var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
                        $("#loaderEmisor").addClass("hidden");
                        jAlert(black + '\n' + lack+'\n' );
                    } else{
                        updateProducto = $.ajax({
                            data:{
                                tipo : 4,
                                idProducto: idProducto,
                                familia : familia,
                                subfamilia : subfamilia,
                                emisor : emisor,
                                descripcion : descripcion,
                                abreviatura : abreviatura,
                                fechaentradavigor : fechaentradavigor,
                                fechasalidavigor : fechasalidavigor,
                                flujoimporte : flujoimporte,
                                importeminimoproducto : importeminimoproducto,
                                importemaximoproducto : importemaximoproducto,
                                porcentajecomisionproducto : porcentajecomisionproducto,
                                importecomisionproducto : importecomisionproducto,
                                porcentajecomisioncorresponsal : porcentajecomisioncorresponsal,
                                importecomisioncorresponsal : importecomisioncorresponsal,
                                porcentajecomisioncliente : porcentajecomisioncliente,
                                importecomisioncliente : importecomisioncliente,
                                estatus: estatus,
                                lista_servicios : CheckBox
                            },
                            type: 'POST',
                            cache: false,
                            url: '../ajax/consultaProducto.php',
                            success: function(response){
                                var obj = jQuery.parseJSON(response);
                                var errorcode="";
                                var errormsg="";
                                jQuery.each(obj,function(index,value){
                                    errorcode = obj[index]['ErrorCode'];
                                    errormsg =  obj[index]['ErrorMsg'];
                                });
                                $("#loaderEmisor").addClass("hidden");
                                cancelarEdicion();
                                jAlert(errormsg);
                                /*
                                setTimeout(function(){
                                    var formProveedor = '<form action="altaProducto.php"  method="POST" id="formProducto"><input type="text" id="txtidProducto"  name="txtidProducto" value="'+idProducto+'"/></form>'
                                    $('body').append(formProveedor);
                                    $( "#formProducto" ).submit();
                                }, 3000);
                                //*/
                            }
                        });
                    }
                }
            });
        }

    }//Layout

    Layout.inicializatxt();
    Layout.buscaFamilia();
    Layout.cargaEmisores();
    Layout.cargaFlujoImporte();
    //Layout.cargaEstatus();
    Layout.initBotones();
    Layout.detectaCambio();
} // initViewAltaProducto

function BuscarSubFamilias(value){ //buscador de subfamilias
    $('#select_subfamilia').empty();
    var idFamilia = value;

    buscarServicios(idFamilia);
    if (subFamiliaRequest != null){
        subFamiliaRequest.abort();
        subFamiliaRequest = null;
    }

    subFamiliaRequest = $.ajax({
        data:{
            tipo : 2,
            idFamilia: idFamilia
        },
        type: 'POST',
        cache: false,
        async: false,
        url: '../ajax/altaProveedores.php',
        success: function(response){
            var obj = jQuery.parseJSON(response);
            $('#select_subfamilia').append('<option value="0">Seleccione</option>');
            jQuery.each(obj,function(index,value){
                var nombre_subfamilia = obj[index]['descSubFamilia'];
                $('#select_subfamilia').append('<option value="'+obj[index]['idSubFamilia']+'">'+nombre_subfamilia+'</option>');
            });
            closeSpinner();
            //buscarServicios(idFamilia);
        }
    });
}

function getServiciosProductos(producto,lista){
    productoServicio.forEach(a => {
        $("#checkbox_"+a.servicio).attr('checked',true);
        $("#checkbox_"+a.servicio).data('productoServicio',a.idProductoServicio);
        $("#checkbox_"+a.servicio).data('saved',1);
    });
    /*
    $.ajax({
        data:{
            tipo : 5,
            producto : producto
        },
        type: 'POST',
        url: '../ajax/consultaProducto.php',
        success: function(response){
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj,function(index,value){
                var idPadre = obj[index]['idTranType'];
                $.each( lista, function( key, value ) {
                    if(idPadre==value){
                        $('#checkbox_'+idPadre).attr('checked', true);
                    }
                });

            });
        }
    });
    //*/
}

function buscarServicios(familia){
    var contador=0;
    var respuesta="";
    var idProducto = $("#idProducto").val();
    $('.rowservicios').remove();
    var servicios  = new Array();
    if (serviciosRequest != null){
        serviciosRequest.abort();
        serviciosRequest = null;
    }

    serviciosRequest = $.ajax({
        data:{
            tipo : 6,
            idFamilia: familia
        },
        type: 'POST',
        url: '../ajax/altaProveedores.php',
        success: function(response){
            var obj = jQuery.parseJSON(response);
            jQuery.each(obj,function(index,value){
                contador++;
                var id_servicio = obj[index]['idTranType'];
                servicios.push(id_servicio);
                var nombre_servicio = obj[index]['descTranType'];
                if(contador==1){
                    respuesta +="<tr class='rowservicios'><td id='td_"+id_servicio+"'><input class='check_servicios'  type='checkbox' id='checkbox_"+id_servicio+"'> "+nombre_servicio+"</td>";
                }
                if(contador==2){
                    respuesta +="<td id='td_"+id_servicio+"'><input class='check_servicios'   type='checkbox' id='checkbox_"+id_servicio+"' > "+nombre_servicio+"</td>";
                }
                if(contador==3){
                    respuesta +="<td id='td_"+id_servicio+"'><input class='check_servicios'   type='checkbox' id='checkbox_"+id_servicio+"' > "+nombre_servicio+"</td></tr>";
                    contador=0;
                }
            });
            $("#tableServicios").append(respuesta);
            if(idProducto!=='') getServiciosProductos(idProducto,servicios);
            closeSpinner();
        }
    });
}

function  cargaProducto(){ //para  desahabilitar los input y select
    $("#btnback").css('display','block');
    if(idProducto != 0){
        $("#cajaIdProducto").css('display','block');
        $("#divEstatus").css('display','block');
        $("#idProducto").val(idProducto);
        $('input').attr('disabled', true);
        $('select').attr('disabled', true);
        $("#guardarProducto").css('display','none');
        cargaDatosProducto(idProducto);
        $("#tableServicios").addClass('disabledbutton');
    }
}

function cargaDatosProducto(idProducto){ //funciona para desplegar la infomacion del producto
    $("#loaderEmisor").removeClass("hidden");
    closeLoader = false;
    $.ajax({
        data:{
            idProducto : idProducto,
            tipo:2
        },
        type: 'POST',
        cache: false,
        url: '../ajax/consultaProducto.php',
        success: function(response){
            var obj = jQuery.parseJSON(response);

            if(obj.iTotalRecords == 0){
                alert("No se encontro información");
                var inputs = document.getElementsByTagName("input");
                for(var i=0;i<inputs.length;i++){
                    inputs[i].value = "";
                }
                $("#loaderEmisor").addClass("hidden");
            }else{
                $("#select_familia").addClass('disabledbutton');
                $("#select_subfamilia").addClass('disabledbutton');
                $("#select_emisor").addClass('disabledbutton');
                //setTimeout(function(){
                $("#select_familia").val(obj.aaData[0].idFamilia);
                BuscarSubFamilias(obj.aaData[0].idFamilia);
                $("#select_subfamilia").val(obj.aaData[0].idSubFamilia);
                $("#select_emisor").val(obj.aaData[0].idEmisor);

                $("#producto_descripcion").val(obj.aaData[0].descProducto);
                $("#producto_abreviatura").val(obj.aaData[0].abrevProducto);
                $("#sku").val(obj.aaData[0].skuProducto);
                $("#fecha1").val(obj.aaData[0].idFevProducto);
                $("#fecha2").val(obj.aaData[0].idFsvProducto);
                $("#select_flujo_importe").val(obj.aaData[0].idFlujoImporte);
                $("#importe_minimo_producto").val(obj.aaData[0].impMinProducto);
                $("#importe_maximo_producto").val(obj.aaData[0].impMaxProducto);
                var porcentaje_com_producto = obj.aaData[0].perComProducto*100;
                porcentaje_com_producto = porcentaje_com_producto.toFixed(4);

                var porcentaje_com_corresponsal = obj.aaData[0].perComCorresponsal*100;
                porcentaje_com_corresponsal = porcentaje_com_corresponsal.toFixed(4);

                var porcentaje_com_cliente = obj.aaData[0].perComCliente*100;
                porcentaje_com_cliente = porcentaje_com_cliente.toFixed(4);

                //datos con mascara
                var porcentaje_com_producto_mascara = obj.aaData[0].perComProducto;
                porcentaje_com_producto_mascara = porcentaje_com_producto_mascara;

                var porcentaje_com_corresponsal_mascara = obj.aaData[0].perComCorresponsal;
                porcentaje_com_corresponsal_mascara = porcentaje_com_corresponsal_mascara;

                var porcentaje_com_cliente_mascara = obj.aaData[0].perComCliente;
                porcentaje_com_cliente_mascara = porcentaje_com_cliente_mascara;

                $("#estatus").val(obj.aaData[0].idEstatusProducto);
                $("#porcentaje_comision_producto").val(porcentaje_com_producto);
                $("#porcentaje_comision_producto_mascara").val(porcentaje_com_producto_mascara);
                $("#importe_comision_producto").val(obj.aaData[0].impComProducto);
                $("#porcentaje_comision_corresponsal").val(porcentaje_com_corresponsal);
                $("#porcentaje_comision_corresponsal_mascara").val(porcentaje_com_corresponsal_mascara);
                $("#importe_comision_corresponsal").val(obj.aaData[0].impComCorresponsal);
                $("#porcentaje_comision_cliente").val(porcentaje_com_cliente);
                $("#porcentaje_comision_cliente_mascara").val(porcentaje_com_cliente_mascara);
                $("#importe_comision_cliente").val(obj.aaData[0].impComCliente);
                $("#estatus").val(obj.aaData[0].idEstatusProducto);

                productoServicio = obj.aaData[0].productoservicio;

                if(ID_PERFIL==1){
                    $('#btnEditar').css('display','block');
                }else{
                    $('#btnEditar').css('display','none');
                }
                //}, 2000);
            }

        }
    });
}

function habilitaredicion(){ //para el boton de editar 
    $('input').attr('disabled', false);
    $('select').attr('disabled', false);
    $('#idProducto').attr('disabled', true);
    $('#btnCancelarEditar').css('display','block');
    $('#btnEditar').css('display','none');
    $("#guardarProductoEditar").css('display','block');
    // $(".check_servicios").attr('disabled',false);
    $("#tableServicios").removeClass("disabledbutton");
}

function cancelarEdicion(){ //para el boton de cancelar edicion
    $('input').attr('disabled', true);
    $('select').attr('disabled', true);
    $('#btnCancelarEditar').css('display','none');
    if($('#btnEditar').css('display') == 'none') $('#btnEditar').css('display','block');
    $("#guardarProductoEditar").css('display','none');
    $(".check_servicios").attr('disabled',true);
    $("#tableServicios").addClass("disabledbutton");
}

function irAtras(){
    cancelarEdicion();
    window.location.href = "../Afiliacion/consultaProducto.php";
}

function convertirAPorcentaje(id){
    var valor = $("#"+id).val();
    var resultado = parseFloat(valor/100);
    resultado = resultado.toFixed(4);
    $("#"+id).val(resultado);
    $("#"+id+"_mascara").val(resultado);
}