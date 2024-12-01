var opcionesLocales = [
    {
        value: "Todos",
        idCliente: -1,
        idCadena: -1,
        idSubCadena: -1,
        idCorresponsal: -1,
        nombreCadena: "Todos",
        nombreSubCadena: "Todos",
        nombreCorresponsal: "Todos",
        label: "ID : -1 Todos"
    }
];

$(function(){
  if ($("#txtCliente").length > 0) {
    $("#txtCliente").alphanum({
        allow: "áéíóúÁÉÍÓÚñÑ",
            disallow: "¿¡°´¨~-",
            allowLatin: true,
            allowOtherCharSets: false
    });

    $("#txtCliente").on('keyup', function(event){
        var id = event.target.id;
        var value = event.target.value;

        if(myTrim(value) == ""){
            $("#ddlCIdCliente").val(0);
        }
    });
  }

  if ($("#txtCliente").length > 0) {
    $("#txtCliente").autocomplete({
        source: function( request, respond ) {
            $.post( "../../inc/Ajax/_Clientes/getClientes.php", { "text": request.term },
            function( response ) {
                respond(response);
            }, "json" );
        },
        minLength: 1,
        focus: function( event, ui ) {
            $(this).val(ui.item.nombre);
            return false;
        },
        select: function( event, ui ) {
            var fijo = {};

            $("#ddlIdCliente").val(ui.item.idCliente);
            fijo = {"-2":"Seleccione una cadena"};
            getComboList("getCadenas.php", "#ddlCad", ui.item.idCadena, fijo);

            fijo = {"-2":"Seleccione una subcadena", "-1":"Todos"};
            getComboList("getSubCadenas.php", "#ddlSubCad", ui.item.idCliente, fijo);
            fijo = {"-2":"Seleccione un corresponsal", "-1":"Todos"};
            getComboList("getCorresponsales.php", "#ddlCorresponsal", ui.item.idCliente, fijo);

        }
    });
  }

    if ($("#numDias").length > 0) {
      $("#numDias").numeric({
          allowPlus: false,
          allowMinus: false,
          allowThouSep: false,
          allowLeadingSpaces: false,
          maxDigits: 2
      });
    }

    if ($("#numOpSucursal").length > 0) {
      $("#numOpSucursal").numeric({
          allowPlus: false,
          allowMinus: false,
          allowThouSep: false,
          allowLeadingSpaces: false,
          maxDigits: 3
      });
    }

    $("#fini, #ffin").prop("readonly", "readonly");

    $("#fini, #ffin, #numOperaciones, #numOpSucursal, #numDias").bind("paste", function(e){
        return false;
    });

    $("#fini").change(function(a, b, c){
        var fechaI = $('#fini').val();
        if(fechaI.length == 0){
            $("#ffin").val("");
        }
        if(fechaI.length > 10){
            var fechaI = fechaI.substring(0, 10);
            $('#fini').val(fechaI);
        }
        if(fechaI.length == 10){
            setFechas(fechaI);
        }
    });

    $("#numOperaciones").on("keypress", function(){
        return validaNumeroEntero();
    });

    $("#numOperaciones").on("change", function(){
        if($("#numOperaciones").val() == ""){
            $("#numOperaciones").val(0);
        }
    });

    if($("#fini").length > 0 && $("#ffin").length > 0){
        var checkin = $('#fini').datepicker().on('changeDate',function(ev){
            var fechaI = $('#fini').val();
            if(fechaI.length == 0){
                $("#ffin").val("");
            }
            if(fechaI.length > 10){
                var fechaI = fechaI.substring(0, 10);
                $('#fini').val(fechaI);
            }
            if(fechaI.length == 10){
                setFechas(fechaI);
            }
        }).data('datepicker');
    }

    $("#btnBuscarReactivaciones").on("click", function(){
        showExcelReactivaciones();
    });

    $(function(){
      if ($("#idCadena").length > 0) {
        $("#idCadena").alphanum({
            allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
            disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
            allowOtherCharSets: false
        });
      }

      if ($("#idSub").length > 0) {
        $("#idSub").alphanum({
            allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
            disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
            allowOtherCharSets: false
        });
      }

      if ($("#idCor").length > 0) {
        $("#idCor").alphanum({
            allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
            disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
            allowOtherCharSets: false
        });
      }

        if($("#idCadena").length > 0){
            $("#idCadena").autocomplete({
                source: function( request, respond ) {
                    //Resultados locales
                    var resultadosLocales = $.ui.autocomplete.filter(opcionesLocales, request.term);

                    $.post( "../../inc/Ajax/_Clientes/getListaCategoria.php",{ text : request.term, categoria : 1 },
                    function( response ) {
                        respond(response.concat(resultadosLocales));
                    }, "json" );
                },
                minLength: 1,
                focus: function( event, ui ) {
                    $("#idCadena").val(ui.item.nombreCadena);
                    return false;
                },
                select: function( event, ui ) {
                    $("#ddlCad").val(ui.item.idCadena);
                    return false;
                }
            })
            .data("ui-autocomplete")._renderItem = function( ul, item ) {
                return $('<li>')
                .append( "<a>" + item.label + "</a>" )
                .appendTo( ul );
            }
            $("#idCadena").on( "keypress keyup", function() {
                if ( $("#idCadena").val() == "" ) {
                    $("#ddlCad").val("-1");
                }
            });
            $("#idCadena").on( "mouseup", function() {
              var $input = $(this),
                  oldValue = $input.val();

              if (oldValue == "") return;

              // When this event is fired after clicking on the clear button
              // the value is not cleared yet. We have to wait for it.
              setTimeout(function(){
                var newValue = $input.val();

                if (newValue == ""){
                  // Gotcha
                  $("#ddlCad").val("-1");
                }
              }, 1);
            });
        }

        if($("#idSub").length){
            $("#idSub").autocomplete({
                source: function( request, respond ) {
                    //Resultados locales
                    var resultadosLocales = $.ui.autocomplete.filter(opcionesLocales, request.term);

                    $.post("../../inc/Ajax/_Clientes/getListaCategoria.php",
                        {
                            idCadena    : $("#ddlCad").val(),
                            categoria   : 2,
                            text        : request.term
                        },
                        function( response ) {
                            respond(response.concat(resultadosLocales));
                        }, "json" );
                },
                minLength: 1,
                focus: function( event, ui ) {
                    $("#idSub").val(ui.item.nombreSubCadena);
                    return false;
                },
                select: function( event, ui ) {
                    $("#ddlSub").val(ui.item.idSubCadena);
                    return false;
                }
            })
            .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $('<li>')
                .append("<a>" + item.label + "<br>"+item.nombreCadena + "</a>")
                .appendTo( ul );
            }
            $("#idSub").on( "keypress keyup", function() {
                if ( $("#idSub").val() == "" ) {
                    $("#ddlSub").val("-1");
                }
            });
            $("#idSub").on( "mouseup", function() {
              var $input = $(this),
                  oldValue = $input.val();

              if (oldValue == "") return;

              // When this event is fired after clicking on the clear button
              // the value is not cleared yet. We have to wait for it.
              setTimeout(function(){
                var newValue = $input.val();

                if (newValue == ""){
                  // Gotcha
                  $("#ddlSub").val("-1");
                }
              }, 1);
            });
        }

        if($("#idCor").length){
            $("#idCor").autocomplete({
                source: function( request, respond ) {
                    //Resultados locales
                    var resultadosLocales = $.ui.autocomplete.filter(opcionesLocales, request.term);

                    $.post("../../inc/Ajax/_Clientes/getListaCategoria.php",
                        {
                            idCadena    : $("#ddlCad").val(),
                            idSubCadena : $("#ddlSub").val(),
                            categoria   : 3,
                            text        : request.term
                        },
                        function( response ) {
                            respond(response.concat(resultadosLocales));
                        }, "json" );
                },
                minLength: 1,
                focus: function( event, ui ) {
                    $("#idCor").val(ui.item.nombreCorresponsal);
                    return false;
                },
                select: function( event, ui ) {
                    if ( ui.item.idCadena != -1 && ui.item.idSubCadena != -1 && ui.item.idCorresponsal != -1 ) {
                        $("#idCadena").val(ui.item.nombreCadena);
                        $("#idSub").val(ui.item.nombreSubCadena);
                        $("#ddlSub").val(ui.item.idSubCadena);
                        $("#ddlCad").val(ui.item.idCadena);
                        $("#ddlCorresponsal").val(ui.item.idCorresponsal);
                    } else {
                        $("#ddlCorresponsal").val(ui.item.idCorresponsal);
                    }
                    return false;
                }
            })
            .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $('<li>')
                //.append( "<a>" + "ID: " + item.idSubCadena + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
                .append("<a>" + item.label + "<br>"+item.nombreCadena + "</a>")
                .appendTo( ul );
            }
            $("#idCor").on( "keypress keyup", function() {
                if ( $("#idCor").val() == "" ) {
                    $("#ddlCorresponsal").val("-1");
                }
            });
            $("#idCor").on( "mouseup", function() {
              var $input = $(this),
                  oldValue = $input.val();

              if (oldValue == "") return;

              // When this event is fired after clicking on the clear button
              // the value is not cleared yet. We have to wait for it.
              setTimeout(function(){
                var newValue = $input.val();

                if (newValue == ""){
                  // Gotcha
                  $("#ddlCorresponsal").val("-1");
                }
              }, 1);
            });
        }
    });
});

function showExcelReactivaciones(){
    var fini = $("#fini").val();
    var ffin = $("#ffin").val();
    var nOps = $("#numOperaciones").val();

    if(validarFecha(fini) === false || fini == "" || fini == undefined){
        alert("Seleccione una fecha Válida");
        return false;
    }

    Emergente();
    $.fileDownload("../../../inc/Ajax/_Reportes/ReactivacionesXLS.php?fini="+fini+"&ffin="+ffin+"&nOps="+nOps, {
        successCallback: function(url) {
            OcultarEmergente();
        },
        failCallback: function(responseHtml, url){
            OcultarEmergente();
            alert("Ha ocurrido un error");
        }
    });
    return false;
}

function validarFecha(str){
    return /^(19|20)[0-9]{2}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/.test(str);
}

function setFechas(fechaI){
    var arrf = fechaI.split("-");
    var fecha = new Date(arrf[0], arrf[1]-1, arrf[2],"00","00","00");

    fecha.setDate(fecha.getDate() + 6);

    var anio= fecha.getFullYear();
    var mes = fecha.getMonth()+1;
    var dia = fecha.getDate();

    if(mes < 10){
        mes = "0" + mes;
    }
    if(dia < 10){
        dia = "0" + dia;
    }

    $("#ffin").val(anio + "-" + mes + "-" + dia);
}

function BuscarRemesasPendientes(){
    var nombreBen = document.getElementById("txtNombre").value;
    var apellidoBen = document.getElementById("txtApellido").value;
    var nombreRem = document.getElementById("txtNombreRemitente").value;

    if((nombreBen != "" || apellidoBen != "") || nombreRem != ""){
        var parametros = "";

        if(nombreBen != ""){
            parametros += "vNombreBeneficiario="+nombreBen;
        }
        if(apellidoBen != ""){
            parametros += "&vApellidoBeneficiario="+apellidoBen;
        }

        if(nombreRem != ""){
            parametros += "&vRemitente="+nombreRem;
        }

        if(parametros != ""){
            BuscarParametros("../../inc/Ajax/_Operaciones/BuscarRemesasPendientes.php",parametros);
        }
    }
    else{
        alert("Capture Nombre y Apellidos del Beneficiario y/o Nombre Completo del Remitente");
    }

}


function BuscarComisiones(){
    cliente = document.getElementById("ddlIdCliente").value;
    cadena = document.getElementById("ddlCad").value;
    subcadena = document.getElementById("ddlSubCad").value;
    corresponsal = document.getElementById("ddlCorresponsal").value;
    if(cadena >= -2){
        var fecIni = document.getElementById("fecIni").value;
        if(fecIni != ""){
            var fecFin = document.getElementById("fecFin").value;
            if(fecFin != ""){
                if(validaFechaRegex("fecIni")){
                    if(validaFechaRegex("fecFin")){
                        if(fecFin >= fecIni){
                            if(fecIni <= fecFin){
                                var tipo = document.getElementById("ddlTipo").value;
                                var chk = document.getElementById("chk_separados");

                                if(chk.checked == true){
                                    var estados_separados = true;
                                }
                                else{
                                    var estados_separados = false;
                                }
                                var entidad = document.getElementById("ddlEntidad").value;

                                var parametros = "idcliente="+cliente+"&idcadena="+cadena+"&idsubcadena="+subcadena+"&idcorresponsal="+corresponsal+"&fecha1="+fecIni+"&fecha2="+fecFin+"&tipo="+tipo+"&separados="+estados_separados;
                                if(entidad > -1)
                                    parametros+="&identidad="+entidad;
                                Emergente();
                                BuscarParametros("../../inc/Ajax/_Reportes/BuscaComision.php",parametros);
                                Mostrar();
                            }else{
                                alert("La fecha inicial debe ser menor a la fecha final")
                            }
                        }else{
                            alert("La fecha inicial debe ser menor a la fecha final")
                        }
                    }else{
                        alert("EL formato de la fecha final es incorrecto")
                    }
                }else{
                    alert("El formato de la fecha inicial es incorrecto");
                }
            }else{alert("Favor de seleccionar una Fecha Final")};
        }else{alert("Favor de seleccionar una fecha inicial");}
    }else{alert("Favor de seleccionar una cadena")}
}
/*

******* FUNCIONES DE LOS REPORTES DE OPERACIONES ******

*/

function BuscarCorresponsalesOp(){
    ClearRes();
    var parametros = "";
    var cadena = document.getElementById("ddlCad").value;
    var id = txtValue("txtId");

    if(cadena > -3){
        parametros+= "idcadena="+cadena;
        var subcadena = document.getElementById("ddlSubCad").value;
        if(subcadena > -3){
            parametros+= "&idsubcadena="+subcadena;
            var corresponsal = document.getElementById("ddlCorresponsal").value;
            if(corresponsal > -3){
                document.getElementById("txtId").value = "";
                parametros+= "&idcorresponsal="+corresponsal;
            }else{
                parametros = "";
            }
        }else{
            parametros = "";
        }
    }else if(id != ''){
        document.getElementById("ddlCad").value = -3;
        document.getElementById("ddlSubCad").value = -3;
        document.getElementById("ddlCorresponsal").value = -3;
        parametros+= "idcorresponsal="+id;
    }
    else{
        alert("Favor de seleccionar o escribir un corresponsal")
    }
    if(parametros != ''){
        //Aqui realizar la peticion ajax
        BuscarParametros("../../inc/Ajax/_Operaciones/consultarCorresponsalesOp.php",parametros);
    }

}
var idcorresponsal = -3;
function PreBo(i){
    idcorresponsal = i;
    BuscarOperaciones();
}
function SubForm(i){
    switch(i){
        case 1: Caracter();document.getElementById("excel").submit();
        break;
        case 2: Caracter();document.getElementById("todoexcel").submit();
        break;
        case 3: document.getElementById("pdf").submit();
        break;
        case 4: document.getElementById("todopdf").submit();
        break;
        case 5:
            //document.getElementById("pdf").idcliente.value = txtValue("ddlIdCliente");
            document.getElementById("pdf").idcadena.value = txtValue("ddlCad");
            document.getElementById("pdf").idsubcadena.value = txtValue("ddlSubCad");
            document.getElementById("pdf").idcorresponsal.value = txtValue("ddlCorresponsal");
            document.getElementById("pdf").fechac.value = txtValue("fecIni");
            document.getElementById("pdf").fecha2.value = txtValue("fecFin");
            document.getElementById("pdf").submit();
        break;
        case 6:
            var chk = document.getElementById("chk_separados");
            if(chk.checked == true){var estados_separados = true;}
            else{var estados_separados = false;}

            document.getElementById("pdf").idcliente.value = txtValue("ddlIdCliente");
            document.getElementById("pdf").idcadena.value = txtValue("ddlCad");
            document.getElementById("pdf").idsubcadena.value = txtValue("ddlSubCad");
            document.getElementById("pdf").idcorresponsal.value = txtValue("ddlCorresponsal");
            document.getElementById("pdf").identidad.value = txtValue("ddlEntidad");
            document.getElementById("pdf").fecha1.value = txtValue("fecIni");
            document.getElementById("pdf").fecha2.value = txtValue("fecFin");
            document.getElementById("pdf").hseparados.value = estados_separados;
            document.getElementById("pdf").htipo.value = txtValue("ddlTipo");
            document.getElementById("pdf").submit();
        break;
        case 7:
            //document.getElementById("excel").idcliente.value = txtValue("ddlIdCliente");
            document.getElementById("excel").idcadena.value = txtValue("ddlCad");
            document.getElementById("excel").idsubcadena.value = txtValue("ddlSubCad");
            document.getElementById("excel").idcorresponsal.value = txtValue("ddlCorresponsal");
            document.getElementById("excel").fechac.value = txtValue("fecIni");
            document.getElementById("excel").fecha2.value = txtValue("fecFin");
            document.getElementById("excel").submit();
        break;
        case 8:
            var chk = document.getElementById("chk_separados");
            if(chk.checked == true){var estados_separados = true;}
            else{var estados_separados = false;}

            document.getElementById("excel").idcliente.value = txtValue("ddlIdCliente");
            document.getElementById("excel").idcadena.value = txtValue("ddlCad");
            document.getElementById("excel").idsubcadena.value = txtValue("ddlSubCad");
            document.getElementById("excel").idcorresponsal.value = txtValue("ddlCorresponsal");
            document.getElementById("excel").identidad.value = txtValue("ddlEntidad");
            document.getElementById("excel").fecha1.value = txtValue("fecIni");
            document.getElementById("excel").fecha2.value = txtValue("fecFin");
            document.getElementById("excel").hseparados.value = estados_separados;
            document.getElementById("excel").htipo.value = txtValue("ddlTipo");
            document.getElementById("excel").submit();
        break;
    }
}
//Cambia el caracter para el archivo csv
function Caracter(){
    if(document.getElementById("chkn").checked){
        document.getElementById("caracter").value = ";";
        document.getElementById("tcaracter").value = ";";
    }else{
        document.getElementById("caracter").value = ",";
        document.getElementById("tcaracter").value = ",";
    }
}
$.fn.getType = function(){ return this[0].tagName == "INPUT" ? this[0].type.toLowerCase() : this[0].tagName.toLowerCase(); }

function showEXCELSucursales(){
    var cant    = $("#cpag").val();
    var estado  = $("#ddlEntidad").val();
    var version = $("#ddlVersion").val();
    var actual  = $("#actual").val();
    var total   = $("#totalreg").val();
    var lblEstado = $("#ddlEntidad option:selected").text();
    var lblVersion = $("#ddlVersion option:selected").text();
    var numDias         = document.getElementById("numDias").value;
    var checkboxMinimo  = document.getElementById("checkboxMinimo");
    var checkboxMaximo  = document.getElementById("checkboxMaximo");
    var numOperaciones  = document.getElementById("numOpSucursal").value;
    var form = $("#excel");
    var tipoBusqueda = "";

    if (checkboxMinimo.checked)
        tipoBusqueda = 'min';
    if (checkboxMaximo.checked)
        tipoBusqueda = 'max';

    form[0].estado.value                = estado;
    form[0].version.value               = version;
    form[0].actual.value                = actual;
    form[0].lblEstado.value             = lblEstado;
    form[0].lblVersion.value            = lblVersion;
    form[0].numDiasExcel.value          = numDias;
    form[0].numOpSucursalExcel.value    = numOperaciones;
    form[0].tipoBusquedaExcel.value     = tipoBusqueda;

    if($("#todosexcel").is(':checked')) {
        form[0].todos.value = true;
        form[0].cant.value  = total;
        var resultadoDetalle = confirm("S\u00F3lo es posible generar un archivo Excel con los primeros 100 resultados como m\u00E1ximo al utilizar esta opci\u00F3n. \u00BFDesea continuar?");
    } else {
        form[0].todos.value = false;
        form[0].cant.value  = cant;
        var resultadoDetalle = confirm("S\u00F3lo es posible generar un archivo Excel con 100 resultados por p\u00E1gina como m\u00E1ximo al utilizar esta opci\u00F3n. \u00BFDesea continuar?");
    }

    if ( resultadoDetalle ) {
        $("#excel").submit();
    }
}

function showEXCELOperaciones(){

    var inputTodo = $("#todosexcel").clone();
    var allInputs = $("#tbusqueda :input");
    allInputs.push($("#actual"));
    allInputs.push($("#cpag"));
    var nInputs = allInputs.length;

    var labels = new Array();
    var values = new Array();

    for(var i = 0; i < nInputs; i++){
        var inputActual = allInputs[i];

        var id = $(inputActual).attr("id");
        var valor = $(inputActual).val();

        var newInput = "<input type=\"hidden\" name = '"+id+"' value = '"+valor+"'>";

        $("#excel").append(newInput);

        if(id != "actual" && id != "cpag" && id != "" && id != undefined){
            var tipo = $(inputActual).getType();
            if((valor > -1 && tipo == 'select') ||(valor != "" && tipo == 'text')){
                if(tipo == 'select'){
                    valor = $("#"+id+" option:selected").text();
                }
                var lbl = $("label[for='"+id+"']");
                labels.push(lbl[0].innerHTML);
                values.push(valor);
            }
        }
    }//for

    $("#excel").append("<input type=\"hidden\" name=\"labels\" value='"+labels.join(",")+"'>");
    $("#excel").append("<input type=\"hidden\" name=\"values\" value='"+values.join(",")+"'>");
    var totalRegistros = $("#totalreg").val();
    $("#excel").append("<input type=\"hidden\" name=\"totalreg\" value='"+totalRegistros+"'>");

    var form = $("#excel");
    if($("#todosexcel").is(':checked')){
        var total = $("#totalreg").val();
        form[0].cpag.value  = total;
        var resultadoDetalle = confirm("S\u00F3lo es posible generar un archivo Excel con los primeros 100 resultados como m\u00E1ximo al utilizar esta opci\u00F3n. \u00BFDesea continuar?");
    } else {
        var resultadoDetalle = confirm("S\u00F3lo es posible generar un archivo Excel con 100 resultados por p\u00E1gina como m\u00E1ximo al utilizar esta opci\u00F3n. \u00BFDesea continuar?");
    }

    if ( resultadoDetalle ) {
        $("#excel").submit();
    }
}

function showPDFOperaciones(){

    var inputTodo = $("#todos").clone();
    var allInputs = $("#tbusqueda :input");
    allInputs.push($("#actual"));
    allInputs.push($("#cpag"));
    var nInputs = allInputs.length;
    var labels = new Array();
    var values = new Array();

    for(var i = 0; i < nInputs; i++){
        var inputActual = allInputs[i];

        var id = $(inputActual).attr("id");
        var valor = $(inputActual).val();

        var newInput = "<input type=\"hidden\" name = '"+id+"' value = '"+valor+"'>";
        $("#pdf").append(newInput);

        if(id != "actual" && id != "cpag" && id != "" && id != undefined){
            var tipo = $(inputActual).getType();
            if((valor > -1 && tipo == 'select') ||(valor != "" && tipo == 'text')){
                if(tipo == 'select'){
                    valor = $("#"+id+" option:selected").text();
                }
                var lbl = $("label[for='"+id+"']");
                labels.push(lbl[0].innerHTML);
                values.push(valor);
            }
        }
    }//for

    $("#pdf").append("<input type=\"hidden\" name=\"labels\" value='"+labels.join(",")+"'>");
    $("#pdf").append("<input type=\"hidden\" name=\"values\" value='"+values.join(",")+"'>");
    var totalRegistros = $("#totalreg").val();
    $("#pdf").append("<input type=\"hidden\" name=\"totalreg\" value='"+totalRegistros+"'>");

    var form = $("#pdf");
    if($("#todos").is(':checked')){
        var total = $("#totalreg").val();
        form[0].cpag.value  = total;
        var exportar = confirm("S\u00F3lo es posible generar un archivo Excel con los primeros 100 resultados como m\u00E1ximo al utilizar esta opci\u00F3n. \u00BFDesea continuar?");
    } else {
        var exportar = confirm("S\u00F3lo es posible generar un archivo Excel con 100 resultados por p\u00E1gina como m\u00E1ximo al utilizar esta opci\u00F3n. \u00BFDesea continuar?");
    }

    if ( exportar ) {
        $("#pdf").submit();
    }
}

function BuscarOperaciones(i){
    var parametros = "";
    var familia = document.getElementById("ddlFam").value;
    var subfamilia = document.getElementById("ddlSubFam").value;
    var proveedor = document.getElementById("ddlProveedor").value;
    var emisor = document.getElementById("ddlEmisor").value;
    var cadena = document.getElementById("ddlCad").value;
    if(cadena < -2){
        cadena = "";
        subcadena = "";
        corresponsal = "";
        idcorresponsal = txtValue("txtId");
        if(idcorresponsal != ''){
            parametros="idcorresponsal="+idcorresponsal;
        }
    }else{
        var subcadena = document.getElementById("ddlSubCad").value;
        if(subcadena < -2){
            subcadena = "";
            corresponsal = "";
        }else{
            var corresponsal = document.getElementById("ddlCorresponsal").value;
            if(corresponsal < -2){
                corresponsal = "";
            }
            else{
                parametros+="idcadena="+cadena+"&idsubcadena="+subcadena+"&idcorresponsal="+corresponsal;
            }
        }
    }
    if(parametros != ''){
        if(familia < 1)
            familia = "";
        if(subfamilia < 1)
            subfamilia = "";
        if(proveedor < 1)
            proveedor = "";
        if(emisor < 1)
            emisor = "";
        var fecha1 = txtValue("fecha1");
        var fecha2 = txtValue("fecha2");
        if(fecha1 != '' && fecha2 != ''){
            if(validaFechaRegex("fecha1")){
                if(validaFechaRegex("fecha2")){
                    //if(fecha1 != fecha2){
                        if(fecha1 <= fecha2){
                            parametros+= "&familia="+familia+"&subfamilia="+subfamilia+"&proveedor="+proveedor+"&emisor="+emisor+"&fecha1="+fecha1+"&fecha2="+fecha2;
                            //Aqui realizar la peticion ajax
                            BuscarParametros("../../inc/Ajax/_Reportes/ConsultarOperaciones.php",parametros,'',i);
                            document.getElementById("ddlFam").disabled = false;
                            document.getElementById("ddlSubFam").disabled = false;
                            document.getElementById("ddlProveedor").disabled = false;
                            document.getElementById("ddlEmisor").disabled = false;

    //}
                            Mostrar();
                        }else{
                            alert("La fecha inicial debe ser menor o igual que la fecha final")
                        }
                    /*}else{
                        alert("Favor de seleccionar fechas distintas")
                    }*/
                }else{
                    alert("El formato de la fecha final es incorrecto")
                }
            }
            else{
                alert("El formato de la fecha inicial es incorrecto")
            }
        }else{
            alert("Favor de escribir o seleccionar un rango de fechas");
        }
    }else{
        alert("Favor de seleccionar Cadena, SubCadena y Corresponsal o escribir un Id de corresponsal");
    }
}


function ExportarExcel(){


}

//funcion para limpiar los select de cadena subcadena y corresponsal
function LimpiarCSC(){
    document.getElementById("ddlCad").value = -3;
    document.getElementById("ddlSubCad").value = -3;
    document.getElementById("ddlCorresponsal").value = -3;
}


/*

****** FUNCIONES DE LOS REPORTES DE CONTABILIDAD *******

*/

function getCorte(){
    var cad =  document.getElementById("ddlCad").value;
    if(cad != ""){
        var subcad = document.getElementById("ddlSubCad").value;
        if(subcad != ""){
            var corr = document.getElementById("ddlCorresponsal").value;
            if(corr != ""){
                var fecIni = document.getElementById("fecIni").value;
                if(fecIni != ""){
                    if(validaFechaRegex("fecIni")){
                        var fecFin = document.getElementById("fecFin").value;
                        if(fecFin != ""){
                            if(validaFechaRegex("fecFin")){
                                /*if(fecIni != fecFin){*/
                                    /*if(fecIni < fecFin){*/
                                        var parametros ="idcadena="+cad+"&idsubcadena="+subcad+"&idcorresponsal="+corr+"&fechac="+fecIni+"&fecha2="+fecFin;
                                        BuscarParametros("../../inc/Ajax/_Reportes/BuscaCorte.php",parametros);
                                        Mostrar();
                                        document.getElementById("impresion").idcadena.value = cad;
                                        document.getElementById("impresion").idsubcadena.value = subcad;
                                        document.getElementById("impresion").idcorresponsal.value = corr;
                                        document.getElementById("impresion").fechac.value = fecIni;
                                        document.getElementById("impresion").fecha2.value = fecFin;
                                    /*}else{
                                        alert("La fecha inicial debe ser menor a la fecha final");
                                    }*/
                                /*}else{
                                    alert("Favor de seleccionar fechas distintas");
                                }*/
                            }else{
                                alert("El formato de la fecha final es incorrecto");
                            }
                        }else{alert("Favor de seleccionar una Fecha Final");}
                    }else{
                        alert("El formato de la fecha de inicio es incorrecto");
                    }
                }else{alert("Favor de seleccionar una Fecha Inicial");}
            }else{alert("Favor de seleccionar un Corresponsal");}
        }else{alert("Favor de seleccionar una Subcadena");}
    }else{alert("Favor de seleccionar una Cadena");}
}

function imprimirCorte() {
    window.open('', 'ImpresionCorte', 'width=680,height=650,menubar=no,scrollbars=yes,toolbar=no,location=no,directories=no,resizable=no,top=50,left=50');
    document.getElementById("impresion").submit();
}

function getRepProveedores(){

    BuscarParametros("../../Ajax/_Reportes/BuscaReporteOperadores.php");

}



function BuscarProveedores(i){
    var parametros = "";
    var proveedor = document.getElementById("ddlProveedor").value;
    var familia = document.getElementById("ddlFamilia").value;
    if(proveedor < -1)
        proveedor = '';
    if(familia < -1)
        familia = '';
    var fecIni = document.getElementById("fecha1").value;
    if(fecIni != ""){
        if(validaFechaRegex("fecha1")){
            var fecFin = document.getElementById("fecha2").value;
            if(fecFin != ""){
                if(validaFechaRegex("fecha2")){
                    if(fecFin >= fecIni){
                        Emergente();
                        parametros = "proveedor="+proveedor+"&familia="+familia+"&fecha1="+fecIni+"&fecha2="+fecFin;
                        BuscarParametros("../../inc/Ajax/_Reportes/BuscaReporteProveedores.php",parametros,'',i);
                        Mostrar();
                    }else{
                        alert("La Fecha Inicial debe ser menor o igual a la Fecha Final");
                    }
                }else{
                    alert("El formato de la fecha final es incorrecto");
                }
            }else{
                alert("Favor de seleccionar una Fecha Final");
            }
        }else{
            alert("El formato de la fecha inicial es incorrecto");
        }
    }else{alert("Favor de seleccionar una Fecha Inicial");}
}

function BuscarMovimientos(i){
    var parametros = "";
    var nocuenta = txtValue("txtNoCuenta");
    var idcadena = txtValue("ddlCad");
    var idsubcadena = txtValue("ddlSub");
    var idcorresponsal = txtValue("ddlCorresponsal");

    parametros += "nocuenta="+nocuenta;
    parametros += "&idcadena="+idcadena;
    parametros += "&idsubcadena="+idsubcadena;
    parametros += "&idcorresponsal="+idcorresponsal;

    var idTipoM = txtValue("ddlTipoMov");

    var fecIni = document.getElementById("fecha1").value;
    var fecFin = document.getElementById("fecha2").value;

    if(parametros != ""){
        if(fecIni != ""){
            if(validaFechaRegex("fecha1")){
                if(fecFin != ""){
                    if(validaFechaRegex("fecha2")){
                        if(fecIni <= fecFin){
                            if(fecIni <= fecFin){
                                parametros+="&fecha1="+fecIni+"&fecha2="+fecFin+"&tipoM="+idTipoM;
                                Emergente();
                                BuscarParametros("../../inc/Ajax/_Reportes/BuscarMovimientos.php",parametros,'',i);
                                Mostrar();
                            }else{
                                alert("La fecha inicial debe ser menor a la fecha final");
                            }

                        }else{
                            alert("Favor de seleccionar fechas distintas");
                        }
                    }else{
                        alert("El formato de la fecha final es incorrecta");
                    }
                }else{
                    alert("Favor de seleccionar una Fecha Final");
                }
            }else{
                alert("El formato de la fecha inicial es incorrecto");
            }
        }else{
            alert("Favor de seleccionar una Fecha Inicial");
        }
    }else{
        alert("Favor de escribir un numero de cuenta o id de corresponsal");
    }
}

function showPDFSucursales(){
    var cant            = $("#cpag").val();
    var estado          = $("#ddlEntidad").val();
    var version         = $("#ddlVersion").val();
    var actual          = $("#actual").val();
    var total           = $("#totalreg").val();
    var lblEstado       = $("#ddlEntidad option:selected").text();
    var lblVersion      = $("#ddlVersion option:selected").text();
    var numDias         = document.getElementById("numDias").value;
    var checkboxMinimo  = document.getElementById("checkboxMinimo");
    var checkboxMaximo  = document.getElementById("checkboxMaximo");
    var numOperaciones  = document.getElementById("numOpSucursal").value;
    var form = $("#pdf");
    var totalRegistros  = $("#totalreg").val();
    var tipoBusqueda    = "";

    if (checkboxMinimo.checked)
        tipoBusqueda = 'min';
    if (checkboxMaximo.checked)
        tipoBusqueda = 'max';

    form[0].estado.value                = estado;
    form[0].version.value               = version;
    form[0].actual.value                = actual;
    form[0].lblEstado.value             = lblEstado;
    form[0].lblVersion.value            = lblVersion;
    form[0].numDiasPDF.value            = numDias;
    form[0].numOpSucursalPDF.value      = numOperaciones;
    form[0].tipoBusquedaPDF.value       = tipoBusqueda;

    if ($("#todos").is(':checked')) {
        form[0].buscatodo.value = total;
        form[0].cant.value      = cant;
        var resultadoDetalle = confirm("S\u00F3lo es posible generar un archivo Excel con los primeros 100 resultados como m\u00E1ximo al utilizar esta opci\u00F3n. \u00BFDesea continuar?");
    } else {
        form[0].buscatodo.value = 0;
        form[0].cant.value      = cant;
        var resultadoDetalle = confirm("S\u00F3lo es posible generar un archivo Excel con 100 resultados por p\u00E1gina como m\u00E1ximo al utilizar esta opci\u00F3n. \u00BFDesea continuar?");
    }
    if ( resultadoDetalle ) {
        $("#pdf").submit();
    }
}

function BuscaSucursales(i){
    var parametros = "";
    var estado = document.getElementById("ddlEntidad").value;
    var version = document.getElementById("ddlVersion").value;
    var numDias = document.getElementById("numDias").value;
    var checkboxMinimo = document.getElementById("checkboxMinimo");
    var checkboxMaximo = document.getElementById("checkboxMaximo");
    var numOperaciones = document.getElementById("numOpSucursal").value;
    var tipoBusqueda = "";
    var mensajeError = "";
    var mostrarMensajeError = false;

    if (estado < -2)
        estado = '';
    if (version < -2)
        version = '';
    if (checkboxMinimo.checked)
        tipoBusqueda = 'min';
    if (checkboxMaximo.checked)
        tipoBusqueda = 'max';

    if ( checkboxMinimo.checked && checkboxMaximo.checked ) {
        mensajeError = "No es posible realizar la consulta. Por favor seleccione s\u00F3lo una opci\u00F3n ya sea M\u00E1ximo o M\u00EDnimo.";
        alert(mensajeError);
        return false;
    }

    if ( numDias == "" && numOperaciones == "" && ( checkboxMinimo.checked || checkboxMaximo.checked ) ) {
        mensajeError = "No es posible realizar la b\u00FAsqueda. Es necesario llenar los siguientes campos: ";
        mensajeError += "\n\t- N\u00FAmero de Operaciones";
        mensajeError += "\n\t- L\u00EDmite de d\u00EDas";
        alert(mensajeError);
        return false;
    }

    if ( numDias == "" && numOperaciones == "" && estado < -2 && version < -2 ) {
        mensajeError = "No es posible realizar la b\u00FAsqueda. Es necesario llenar los siguientes campos: ";
        mensajeError += "\n\t- N\u00FAmero de Operaciones";
        mensajeError += "\n\t- L\u00EDmite de d\u00EDas";
        if ( !checkboxMinimo.checked && !checkboxMaximo.checked ) {
            mensajeError += "\n\t- Seleccionar M\u00EDnimo o M\u00E1ximo de Operaciones";
        }
        alert(mensajeError);
        return false;
    }

    if ( numDias != "" ) {
        mensajeError = "No es posible realizar la b\u00FAsqueda. Es necesario llenar los siguientes campos: ";
        if ( numDias <= 0 ) {
            mensajeError += "\n\t- L\u00EDmite de d\u00EDas debe tener un valor mayor que cero";
            mostrarMensajeError = true;
        }
        if ( numOperaciones == "" ) {
            mensajeError += "\n\t- N\u00FAmero de Operaciones";
            mostrarMensajeError = true;
        }
        if ( !checkboxMinimo.checked && !checkboxMaximo.checked ) {
            mensajeError += "\n\t- Seleccionar M\u00EDnimo o M\u00E1ximo de Operaciones";
            mostrarMensajeError = true;
        }
        if ( mostrarMensajeError ) {
            alert(mensajeError);
            return false;
        }
    }

    if ( numOperaciones != "" ) {
        mensajeError = "No es posible realizar la b\u00FAsqueda. Es necesario llenar los siguientes campos: ";
        if ( numDias == "" ) {
            mensajeError += "\n\t- L\u00EDmite de d\u00EDas";
            mostrarMensajeError = true;
        }
        if ( !checkboxMinimo.checked && !checkboxMaximo.checked ) {
            mensajeError += "\n\t- Seleccionar M\u00EDnimo o M\u00E1ximo de Operaciones";
            mostrarMensajeError = true;
        }
        if ( mostrarMensajeError ) {
            alert(mensajeError);
            return false;
        }
    }

    parametros += "estado=" + estado + "&version=" + version + "&numDias=" + numDias + "&numOperaciones=" + numOperaciones + "&tipoBusqueda=" + tipoBusqueda;
    Emergente();
    var url = "../../inc/Ajax/_Reportes/BuscaSucursales.php";
    var div = "";
    http.open("POST",url, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function() {
        if (http.readyState==1) {
            Emergente();
        }
        if (http.readyState==4) {
            var response = http.responseText;
            response = response.split("%%");
            var codigo = response[0];
            var RespuestaServidor = response[1];
            //var RespuestaServidor = http.responseText;
            validaSession(RespuestaServidor);
            if (div == null || div == '') {
                document.getElementById('divRES').innerHTML = RespuestaServidor;
                if ( $("#T2").length ) {
                    $("#T2").remove();
                }
                if ( $("#cpag").length ) {
                    $("#cpag").numeric({
                        allowPlus: false,
                        allowMinus: false,
                        allowThouSep: false,
                        allowLeadingSpaces: false,
                        maxDigits: 3
                    });
                }
            }else{
                setDivHTML(div,RespuestaServidor);
            }
            if ( codigo == 0 ) {
                Mostrar();
                $("#divRES").css("text-align", "");
            } else {
                $("#checkv").fadeOut("normal");
                $(".excel").fadeOut("normal");
                $(".pdf").fadeOut("normal");
                $(".verDetalle").fadeOut("normal");
                $("#divRES").css("text-align", "center");
            }
            OcultarEmergente();
            OrdenarTabla();
            //Mostrar();
        }
    }
    http.send(parametros + "&actual=" + i + "&cant=" + cant);
}

function Mostrar(){
    $("#checkv").fadeIn("normal");
    $(".excel").fadeIn("normal");
    $(".pdf").fadeIn("normal");
    $(".verDetalle").fadeIn("normal");
    if ( $("#impresionCorte").length ) {
        $("#impresionCorte").fadeIn("normal");
    }
    if ( $("#divRES").length ) {
        $("#divRES").css("display", "inline-block");
    }
}

function MostrarFiltros(){
    $("#divsubfamilia").fadeIn("normal");
    $("#divProveedores").fadeIn("normal");
    $("#divEmisor").fadeIn("normal");
}

/* función utilizada en el reporte de proveedores para pasar parámetros para generar el excel */
function ExportarProvsExcel(i){
    var parametros = "";
    var proveedor = document.getElementById("ddlProveedor").value;
    var familia = document.getElementById("ddlFamilia").value;
    if(proveedor < -1)
        proveedor = '';
    if(familia < -1)
        familia = '';
    var fecIni = document.getElementById("fecha1").value;
    if(fecIni != ""){
        if(validaFechaRegex("fecha1")){
            var fecFin = document.getElementById("fecha2").value;
            if(fecFin != ""){
                if(validaFechaRegex("fecha2")){
                    if(fecFin >= fecIni){
                        if ( document.getElementById("cpag") ) {
                            var pag = document.getElementById("cpag").value;
                        } else {
                            var pag = "NULL";
                        }
                        if ( document.getElementById("actual") ) {
                            var actual = document.getElementById("actual").value;
                        } else {
                            var actual = "NULL";
                        }
                        parametros = "proveedor="+proveedor+"&familia="+familia+"&fecha1="+fecIni+"&fecha2="+fecFin+"&opPag="+pag+"&actual="+actual;
                        if(i == 2){
                            if ( document.getElementById("totalreg") ) {
                                var totalRegistros = document.getElementById("totalreg").value;
                                parametros += "&totalReg=" + totalRegistros;
                            }
                            if ( document.getElementById("verDetalle") ) {
                                var verDetalle = document.getElementById("verDetalle").value;
                                parametros += "&verDetalle="+verDetalle;
                            }
                            parametros += "&todos=true";
                            var resultadoDetalle = confirm("S\u00F3lo es posible generar un archivo Excel con los primeros 100 resultados como m\u00E1ximo al utilizar esta opci\u00F3n. \u00BFDesea continuar?");
                            if ( resultadoDetalle ) {
                                document.getElementById("params_excel_todos").value = parametros;
                                document.getElementById("todoexcel").submit(1);
                            }
                        }

                        if(i == 1){
                            if ( document.getElementById("verDetalle") ) {
                                var verDetalle = document.getElementById("verDetalle").value;
                                parametros += "&verDetalle="+verDetalle;
                            }
                            var resultadoDetalle = confirm("S\u00F3lo es posible generar un archivo Excel con 100 resultados por p\u00E1gina como m\u00E1ximo al utilizar esta opci\u00F3n. \u00BFDesea continuar?");
                            if ( resultadoDetalle ) {
                                document.getElementById("params_excel").value = parametros;
                                document.getElementById("excel").submit(1);
                            }
                        }

                    }else{
                        alert("La Fecha Final no debe ser Mayor a la Inicial");
                    }
                }else{
                    alert("El formato de la fecha final es incorrecto");
                }
            }else{
                alert("Favor de seleccionar una Fecha Final");
            }
        }else{
            alert("El formato de la fecha inicial es incorrecto")
        }
    }else{alert("Favor de seleccionar una Fecha Inicial");}

}
/* función utilizada en el reporte de movimientos para pasar parámetros para generar el excel */
function ExportarMovimientosExcel(i){
    var parametros = "";
    var nocuenta = txtValue("txtNoCuenta");
    //var idcorresponsal = txtValue("txtidCorresponsal");
    var idcadena = txtValue("ddlCad");
    var idsubcadena = txtValue("ddlSub");
    var idcorresponsal = txtValue("ddlCorresponsal");

    parametros += "nocuenta="+nocuenta;
    parametros += "&idcadena="+idcadena;
    parametros += "&idsubcadena="+idsubcadena;
    parametros += "&idcorresponsal="+idcorresponsal;

    var idTipoM = txtValue("ddlTipoMov");
    var fecIni = document.getElementById("fecha1").value;
    var fecFin = document.getElementById("fecha2").value;
    if(parametros != ""){
        if(fecIni != ""){
            if(validaFechaRegex("fecha1")){
                if(fecFin != ""){
                    if(validaFechaRegex("fecha2")){
                        //if(fecIni <= fecFin){
                            if(fecIni <= fecFin){
                                if ( document.getElementById("cpag") ) {
                                    var pag = document.getElementById("cpag").value;
                                } else {
                                    var pag = 0;
                                }
                                if ( document.getElementById("actual") ) {
                                    var actual = document.getElementById("actual").value;
                                } else {
                                    var actual = 0;
                                }

                                parametros+="&fecha1="+fecIni+"&fecha2="+fecFin+"&tipoM="+idTipoM+"&opPag="+pag+"&actual="+actual;

                                if(i == 2){
                                    parametros += "&todos=true";
                                    if ( document.getElementById("totalreg") ) {
                                        var totalRegistros = document.getElementById("totalreg").value;
                                        parametros += "&totalReg=" + totalRegistros;
                                    }
                                    document.getElementById("params_excel_todos").value = parametros;
                                    document.getElementById("todoexcel").submit(1);
                                }

                                if(i == 1){
                                    document.getElementById("params_excel").value = parametros;
                                    document.getElementById("excel").submit(1);
                                }
                            }else{
                                alert("La fecha inicial debe ser menor a la fecha final")
                            }

                        /*}else{
                            alert("La Fecha Final no debe ser Mayor a la Fecha Inicial")
                        }*/
                    }else{
                        alert("El formato de la fecha final es incorrecta")
                    }
                }else{
                    alert("Favor de seleccionar una Fecha Final");
                }
            }else{
                alert("El formato de la fecha inicial es incorrecto")
            }


        }else{
            alert("Favor de seleccionar una Fecha Inicial");
        }
    }else{
        alert("Favor de escribir un numero de cuenta o id de corresponsal");
    }
}





/*
    Funciones para el Reporte General
*/
$(function(){

    //$("#ddlEmisor, #feini, #fefin").prop("disabled", true);
    $("#feini, #fefin").prop("disabled", true);

    if ( $("#ck_operaciones").length ) {
        $("#ddlEmisor").prop("disabled", true);
    }

    $("#Filtros").delegate("#ddlCad, #ddlSubCad, #ddlCorresponsal", "change",
        function(){
            validarTipoOp();
    });

    $("#tipoOp, #ck_version, #ck_direccion, #ck_horario, #ck_operaciones").change(function(){
        validarTipoOp();
    });

    $("#ck_operaciones").change(function(){
        if($("#ck_operaciones").is(":checked")){
            $("#ddlEmisor, #ddlProveedor, #feini, #fefin").prop("disabled", false);
            $(".imgCal").show();
        }
        else{
            $("#ddlEmisor, #ddlProveedor, #feini, #fefin").prop("disabled", true);
            $("#ddlEmisor, #ddlProveedor, #feini, #fefin").val("");
            $(".imgCal").hide();
        }
    });

    $("#feini, #fefin").bind("paste", function(){
        return false;
    });

    $("#ck_operaciones").on("click", function(){
        if($("#ck_operaciones").is(":checked")){
            $("#tipoOp").prop("disabled", false)
        }
        else{
            $("#tipoOp").prop("disabled", true)
        }
    });

    $("#coolbutton2").on("click", function(){
        ($("#cpag").length)? $("#cpag").val(20) : "";
        showReporte();
    });

    $("#divRES").delegate("#linkDescargaExcelActual", "click", function(){
        showReporteExcel(1);
    });
    $("#divRES").delegate("#linkDescargaExcelTodo", "click", function(){
        showReporteExcel(2);
    });
});

function validarTipoOp(){
    var op = $("#tipoOp").val();
    var idCor = $("#ddlCorresponsal").val();
    var idCad = $("#ddlCad").val();
    var idSub = $("#ddlSubCad").val();

    if($("#ck_operaciones").is(":checked")){
        if(op == 0 && idCor < -1){
            $("#ck_version").attr("checked", false);
            $("#ck_direccion").attr("checked", false);
            $("#ck_horario").attr("checked", false);
        }
    }
}

function showReporteExcel(tipo){

    var feini = $("#feini").val();
    var fefin = $("#fefin").val();

    if($("#ck_operaciones").is(":checked")){
        if((feini == "" || feini==undefined) && (fefin == "" || fefin == undefined)){
            alert("Seleccione Fecha Inicial y Fecha Final");
            return false;
        }
    }

    var allInputs = $("#Filtros :input");

    var parametros = getParams(allInputs);

    var actual = ($("#actual").length)? $("#actual").val() : 0;
    var limit = ($("#cpag").length)? $("#cpag").val() : 20;

    parametros["actual"] = (actual != undefined)?parseInt(actual) : 1;
    parametros["cpag"] = (limit != undefined)?limit : 20;
    parametros["downloadExcel"] = 1;

    /*if($("#todoexcelgeneral").is(":checked")){
        parametros["cpag"] = $("#totalreg").val();
    }*/

    if(tipo == 2){
        parametros["actual"] = 0;
        parametros["cpag"] = $("#totalreg").val();
    }

    var arrP = new Array();
    $.each(parametros, function(index, value) {
        arrP.push(index + "=" + value);
    });

    Emergente();
    $.fileDownload("../../../inc/Ajax/_Reportes/ReporteGeneral.php?"+arrP.join("&"), {
        successCallback: function(url) {
            OcultarEmergente();
        },
        failCallback: function(responseHtml, url){
            OcultarEmergente();
            alert("Ha ocurrido un error");
        }
    });
    return false;
}

function showReporte(actual){

    var feini = $("#feini").val();
    var fefin = $("#fefin").val();

    if($("#ck_operaciones").is(":checked")){
        if((feini == "" || feini==undefined) || (fefin == "" || fefin == undefined)){
            alert("Seleccione Fecha Inicial y Fecha Final");
            return false;
        }
    }

    var allInputs = $("#Filtros :input");

    var parametros = getParams(allInputs);

    //var actual = ($("#actual").length)? $("#actual").val() : 0;
    var limit = ($("#cpag").length)? $("#cpag").val() : 20;

    parametros["actual"] = (actual != undefined)?parseInt(actual) : 1;
    parametros["cpag"] = (limit != undefined)?limit : 20;

    Emergente();
    $.post("../../../inc/Ajax/_Reportes/ReporteGeneral.php", parametros,
        function(data){
            OcultarEmergente();
            $("#divRES").html(data);
            if ( $("#cpag").length ) {
                $("#cpag").numeric({
                    allowPlus: false,
                    allowMinus: false,
                    allowThouSep: false,
                    allowLeadingSpaces: false,
                    maxDigits: 3
                });
            }
            Mostrar();
            Ordenar();
            //$("#ordertabla").tablesorter({widgets: ['zebra']});
        }
    );
}//function showReporte

function getParams(allInputs){
    var nInputs = allInputs.length;

    var parametros = {}

    for(var i = 0; i < nInputs; i++){
        var inputActual = allInputs[i];

        var id = $(inputActual).attr("id");

        if(id != undefined){
            if($(inputActual).attr('type') == "checkbox"){
                if($(inputActual).is(":checked")){
                    var valor = 1;}
                else{
                    var valor = 0;}
            }
            else{
                var valor = $(inputActual).val();
            }
            id = id.replace("ddl","id");
            parametros[id] = valor;
        }//if
    }//for

    return parametros;
}//getParams

function validarFecha(str){
    return /^(19|20)[0-9]{2}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/.test(str);
}

function calendario(cas, cal){
    new Calendar({
        inputField: cas,
        dateFormat: "%Y-%m-%d",
        trigger: cal,
        bottomBar: false,
        onSelect: function(){
            var date = Calendar.intToDate(this.selection.get());

            this.hide();
        }
    });
    new Calendar({
        inputField: cas,
        dateFormat: "%Y-%m-%d",
        trigger: cas,
        bottomBar: false,
        onSelect: function(){
            var date = Calendar.intToDate(this.selection.get());

            this.hide();
        }
    });
}

function buscarSubCadenas(j){
    var cadena = document.getElementById("ddlCad").value;

    if(cadena == -2){//Busqueda de todos los accesos
        document.getElementById("ddlSubCad").value = -2;
        document.getElementById("ddlCorresponsal").value = -2;
        document.getElementById("ddlSubCad").disabled = true;
        document.getElementById("ddlCorresponsal").disabled = true;
        //Aqui mandar llamar a la busqueda de accesos!!
        if(j == 4)
            BuscaOperaIncompetas()

    }else{
        ClearRes();
        //busqueda de select subcadena
            document.getElementById("divsubcad").innerHTML = "<select id='ddlSubCad' class='form-control m-bot15' disabled='disabled'><option value='-3'>Seleccione una subcadena</option><option value='-2'>Todos</option></select>";
            document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='form-control m-bot15' disabled='disabled'><option value='-2' selected='selected'></option><option value='-1'>Todos</option></select>";

            var parametros = "&j=1&funcion2= BuscaCorresponsal()";

            var i = document.getElementById("ddlCad").selectedIndex;

            http.open("POST","../../inc/Ajax/buscaSubCadenas.php", true);
            http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            http.onreadystatechange=function()
            {
                if (http.readyState==1)
                {
                    Emergente();
                }
                if (http.readyState==4)
                {
                    var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
                    validaSession(RespuestaServidor);
                    document.getElementById("divsubcad").innerHTML = RespuestaServidor;
                    OcultarEmergente();
                    if(cadena == 0){
                        window.setTimeout("buscarCorresponsal("+j+")",10);
                    }
                }
            }
            http.send("idcad="+cadena+parametros);
    }
}

function buscarCorresponsales(j){
    var subcadena = document.getElementById("ddlSubCad").value;
    if(subcadena == -2){//Busqueda de todos los accesos
        document.getElementById("ddlCorresponsal").value = -2;
        document.getElementById("ddlCorresponsal").disabled = true;
        //Aqui mandar llamar a la busqueda de accesos!!
        if(j == 1)
        BuscarAccesos()

    }
    else{
        ClearRes();
        var parametros = "";
        switch(j){
            case 1:parametros = "&j=1&funcion2= BuscaCorresponsal()";
            break;
            case 2:parametros = "&j=2&funcion2= BuscaCorresponsal()";
            break;
            case 3:parametros = "&j=3&funcion2= BuscaCorresponsal()";
            break;
            case 4:parametros = "&j=4&funcion2= BuscaOperaIncompetas()";
            break;
        }
        document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='form-control m-bot15'><option value='-3'>Seleccione un corresponsal</option><option value='-1'>General</option>";
        if(document.getElementById("divcodigo") != null)
            document.getElementById("divcodigo").innerHTML = "<p class='anuncio'>No se Encontro codigo,<a onclick='CrearCodigoSinTenerlo()' style='cursor:pointer'> <span class='anuncio-import'>Crear uno aqui</span></a></p>";

        var i = document.getElementById("ddlSubCad").selectedIndex;
        http.open("POST","../../inc/Ajax/buscarCorresponsales.php", true);
        http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        http.onreadystatechange=function()
        {
            if (http.readyState==1)
            {
                //div para  [cargando....]
                Emergente();
            }
            if (http.readyState==4)
            {
                var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
                validaSession(RespuestaServidor);
                document.getElementById("divcorresponsal").innerHTML = RespuestaServidor;
                OcultarEmergente();
            }
        }
        http.send("idcad="+document.getElementById("ddlCad").value+"&idsubcad="+document.getElementById("ddlSubCad").value+"&al=1"+parametros);
    }
}

function verDetalleProveedor(i) {
    var parametros = "";
    var proveedor = document.getElementById("ddlProveedor").value;
    var familia = document.getElementById("ddlFamilia").value;
    if(proveedor < -1)
        proveedor = '';
    if(familia < -1)
        familia = '';
    var fecIni = document.getElementById("fecha1").value;
    if(fecIni != ""){
        if(validaFechaRegex("fecha1")){
            var fecFin = document.getElementById("fecha2").value;
            if(fecFin != ""){
                if(validaFechaRegex("fecha2")){
                    if(fecFin >= fecIni){
                        Emergente();
                        parametros = "proveedor="+proveedor+"&familia="+familia+"&fecha1="+fecIni+"&fecha2="+fecFin+"&verDetalle=true";
                        if ( document.getElementById("totalreg") ) {
                            var totalRegistros = document.getElementById("totalreg").value;
                            parametros += "&totalReg=" + totalRegistros;
                        }
                        var registrosPorPagina = 25;
                        if ( document.getElementById("cpag") ) {
                            registrosPorPagina = document.getElementById("cpag").value;
                        }
                        BuscarParametros3("../../inc/Ajax/_Reportes/BuscaReporteProveedores.php",parametros,'',i,registrosPorPagina);
                        Mostrar();
                    }else{
                        alert("La Fecha Inicial debe ser menor o igual a la Fecha Final");
                    }
                }else{
                    alert("El formato de la fecha final es incorrecto");
                }
            }else{
                alert("Favor de seleccionar una Fecha Final");
            }
        }else{
            alert("El formato de la fecha inicial es incorrecto");
        }
    }else{alert("Favor de seleccionar una Fecha Inicial");}
}

function OrdenarTabla(){
    if(document.getElementById("ordertabla") != null){
        if(document.getElementById("ordertabla").rows.length > 1)
            $("#ordertabla").tablesorter({sortList:[[0,0]], widgets: ['zebra']});
    }
}

function getComboList(pagina, elemento, id, fijo)
{
    $.post("../../inc/Ajax/_Reportes/" + pagina , {cadena: id}, function(result){
        setComboList(elemento, result, fijo)
    }, "json");
}

function setComboList(elemento, registros, fijo)
{
    var $select = $(elemento);
    $select.find('option').remove();

    $.each(fijo, function(key, value)
    {
        $select.append('<option value=' + key + '>' + value + '</option>');
    });

    $.each(registros.datos, function(key, data)
    {
        var tmp = "";
        if(data.valor == registros.predeterminado)
        {
           tmp = " selected ";
        }

            $select.append('<option value=' + data.valor + tmp +'>' + data.texto + '</option>');

    });
}
