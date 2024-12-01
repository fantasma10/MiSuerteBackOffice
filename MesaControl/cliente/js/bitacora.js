var urlConsulta = "../../../MesaControl/cliente/ajax/consultaBitacora.php";

var settings = {
    iDisplayLength: 10, // configuracion del lenguaje del plugin de la tabla
    oLanguage: {
      sZeroRecords: "No se encontraron registros",
      sInfo: "Mostrando _TOTAL_ registros (_START_ de _END_)",
      sLengthMenu: "Mostrar _MENU_ registros",
      sSearch: "Buscar:",
      sInfoFiltered: " - filtrado de _MAX_ registros",
      oPaginate: {
        sNext: "Siguiente",
        sPrevious: " Anterior",
      },
    },
  };

  var settingsBitacoraCliente = {
    iDisplayLength: 10, // configuracion del lenguaje del plugin de la tabla
    oLanguage: {
      sZeroRecords: "No se encontraron registros",
      sInfo: "Mostrando _TOTAL_ registros (_START_ de _END_)",
      sLengthMenu: "Mostrar _MENU_ registros",
      sSearch: "Buscar:",
      sInfoFiltered: " - filtrado de _MAX_ registros",
      oPaginate: {
        sNext: "Siguiente",
        sPrevious: " Anterior",
      },
    },
    bSort: false,
  };

  var nombreValorTabla = []
  var usuarios = []

  var $loading = $("#circularG").hide();
  $(document)
    .ajaxStart(function () {
      $loading.show();
    })
    .ajaxStop(function () {
      $loading.hide();
    });

  $(document).ready(function () {
    loadBitacora()

    $('#txtregistro').keypress(function (event) {
      if (event.which < 48 || event.which > 57) {
        event.preventDefault();
      }
    });

  })

  function formatDate(date) {
    var months = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
    var dateParts = date.split(" ")[0].split("-");
    var formattedDate = dateParts[2] + " " + months[parseInt(dateParts[1]) - 1] + " " + dateParts[0] + " " + date.split(" ")[1];
    return formattedDate;
  }

  function cargarCatalogos() {
    if (getCatalogos != null) {
      getCatalogos.abort();
      getCatalogos = null;
    }

    var getCatalogos = $.ajax({
      url: urlConsulta,
      type: "POST",
      data: {
        tipo: 1,
      },
      success: function (response) {
        var obj = jQuery.parseJSON(response);
        nombreValorTabla = obj
        jQuery.each(obj, function (index, value) {

          $('#opcionCatalogo').append(
            $('<option/>', {
              'value': value.tabla,
              'text': value.catalogo
            }))
        });
      },
      error: function (error) {
        alert("Ha ocurrido un error, intente de nuevo m\u00E1s tarde");
      }
    });
  }

  function cargarUsuarios() {
    if (getCatalogos != null) {
      getCatalogos.abort();
      getCatalogos = null;
    }

    var getCatalogos = $.ajax({
      url: urlConsulta,
      type: "POST",
      data: {
        tipo: 5,
      },
      success: function (response) {
        var obj = jQuery.parseJSON(response);
        usuarios = obj
        jQuery.each(obj, function (index, value) {

          $('#opcionUsuarios').append(
            $('<option/>', {
              'value': value.id,
              'text': value.nombreCompleto
            }))
        });
      },
      error: function (error) {
        alert("Ha ocurrido un error, intente de nuevo m\u00E1s tarde");
      }
    });
  }

  function obtenerTablaPorCatalogo(valor) {
    var tabla = '';

    $.each(nombreValorTabla, function (i, obj) {
      if (obj.catalogo === valor) {
        tabla = obj.tabla;
        return false;
      }
    });

    return tabla;
  }

  function obtenerNombreUsuarios(id) {
    var nombreCompleto = '-';

    $.each(usuarios, function (i, obj) {
      if (obj.id === parseInt(id)) {
        nombreCompleto = obj.nombreCompleto;
        return false;
      }
    });

    return nombreCompleto;
  }

  function cargarBitacora() {
    if (getBitacora != null) {
      getBitacora.abort();
      getBitacora = null;
    }

    document.getElementById("bitacoraPanel").style.display = "block";
    document.getElementById("bitacoraClientePanel").style.display = "none";

    var getBitacora = $.ajax({
      url: urlConsulta,
      type: "POST",
      data: {
        tipo: 2,
      },
      success: function (response) {
        $("#bitacoraTable").DataTable().fnDestroy();
        $("#bitacoraTable tbody").empty();
        var obj = jQuery.parseJSON(response);
        jQuery.each(obj, function (index, value) {

          var addColorChip = value.tipoAccion === "Actualizó" ? "success" : "info";
          var nombreUsuario = obtenerNombreUsuarios(value.usuario);

          var boton_bitacora = $('<button/>', {
            'class': 'verInformacionClienteButton btn habilitar btn-default btn-xs',
            'data-title': 'Ver Último Cambio',
            'title': 'Ver Último Cambio',
            'click': function () {
              verBitacoraCliente(value);
            }
          }).append($('<span/>', { 'class': 'fa fa-search' }));

          var fila = $('<tr/>').append(
            $('<td/>', { 'style': 'text-align:center;', 'text': value.id }),
            $('<td/>', { 'style': 'text-align:center;', 'text': value.catalogo }),
            $('<td/>', { 'style': 'text-align:center;', 'text': formatDate(value.fechMovimiento) }),
            $('<td/>', { 'style': 'text-align:center;' }).append($('<strong/>', { 'text': nombreUsuario })),
            $('<td/>', { 'style': 'text-align:center;', 'class': addColorChip, 'text': value.tipoAccion }),
            $('<td/>', { 'style': 'text-align:center;', 'class': 'ellipsis', 'text': value.ultimosCambios }),
            $('<td/>', { 'style': 'text-align:center;' }).append(boton_bitacora)
          );

          $("#bitacoraTable tbody").append(fila);
        });
        $("[rel=tooltip]").tooltip();
        $("#bitacoraTable").DataTable(settings);
      },
      error: function (error) {
        alert("Ha ocurrido un error, intente de nuevo m\u00E1s tarde");
      }
    });
  }

  function buscarBitacora() {
    if (getBitacora != null) {
      getBitacora.abort();
      getBitacora = null;
    }
    var fechaInicial = $("#txtFechaIni").val();

    var hoy = new Date();
    hoy.setFullYear(hoy.getFullYear() - 2);
    var fechaObj = new Date(fechaInicial);

    if (fechaObj < hoy) {
      alert('No es posible obtener datos más antiguos');
      return
    }

    $("#bitacoraTable").DataTable().fnDestroy();
    $("#bitacoraTable tbody").empty();
    $loading.show();
    document.getElementById("bitacoraPanel").style.display = "block";
    document.getElementById("bitacoraClientePanel").style.display = "none";

    var fechaFinal = $("#txtFechaFin").val();
    var tipoAccion = $("#tipoAccion").val();
    var txtregistro = $("#txtregistro").val();
    var opcionUsuarios = $("#opcionUsuarios").val();
    var opcionCatalogo = $("#opcionCatalogo").val();

    $("#botonBuscar").prop("disabled", true);
    $("#botonBuscar").text("Buscando...");

    var getBitacora = $.ajax({
      url: urlConsulta,
      type: "POST",
      data: {
        tipo: 3,
        fechaInicial,
        fechaFinal,
        tipoAccion,
        txtregistro,
        opcionUsuarios,
        opcionCatalogo
      },
      success: function (response) {

        var obj = jQuery.parseJSON(response);
        $loading.hide();
        $("#botonBuscar").prop("disabled", false);
        $("#botonBuscar").text("Buscar");
        jQuery.each(obj, function (index, value) {

          var addColorChip = value.tipoAccion === "Actualizó" ? "success" : "info";
          var nombreUsuario = obtenerNombreUsuarios(value.usuario);

          var boton_bitacora = $('<button/>', {
            'class': 'verInformacionClienteButton btn habilitar btn-default btn-xs',
            'data-title': 'Ver Último Cambio',
            'title': 'Ver Último Cambio',
            'click': function () {
              verBitacoraCliente(value);
            }
          }).append($('<span/>', { 'class': 'fa fa-search' }));

          var fila = $('<tr/>').append(
            $('<td/>', { 'style': 'text-align:center;', 'text': value.id }),
            $('<td/>', { 'style': 'text-align:center;', 'text': value.catalogo }),
            $('<td/>', { 'style': 'text-align:center;', 'text': formatDate(value.fechMovimiento) }),
            $('<td/>', { 'style': 'text-align:center;' }).append($('<strong/>', { 'text': nombreUsuario })),
            $('<td/>', { 'style': 'text-align:center;', 'class': addColorChip, 'text': value.tipoAccion }),
            $('<td/>', { 'style': 'text-align:center;', 'class': 'ellipsis', 'text': value.ultimosCambios }),
            $('<td/>', { 'style': 'text-align:center;' }).append(boton_bitacora)
          );

          $("#bitacoraTable tbody").append(fila);
        });
        $("[rel=tooltip]").tooltip();
        $("#bitacoraTable").DataTable(settings);
      },
      error: function (error) {
        alert("Ha ocurrido un error, intente de nuevo m\u00E1s tarde");
        $("#botonBuscar").prop("disabled", false);
        $("#botonBuscar").text("Buscar");
        $loading.hide();
      }
    });
  }

  function verBitacoraCliente(value) {
    $('#labelCatalogo, #labelFechaMovimiento, #labelUsuario, #labelAccion').empty();

    var obj = JSON.parse(value.ultimosCambios);
    $("#bitacoraClienteTable").DataTable().fnDestroy();
    $("#bitacoraClienteTable tbody").empty();

    if (obj.length !== 0) {
      document.getElementById("bitacoraPanel").style.display = "none";
      document.getElementById("bitacoraClientePanel").style.display = "block";
    } else {
      alert('Ha ocurrido un error, intente de nuevo más tarde');
      return;
    }

    var nombreUsuario = obtenerNombreUsuarios(value.usuario);
    $('#labelCatalogo').text(value.catalogo);
    $('#labelFechaMovimiento').text(formatDate(value.fechMovimiento));
    $('#labelUsuario').text(value.usuario ? nombreUsuario : '');
    $('#labelAccion').text(value.tipoAccion ? value.tipoAccion : '');

    var data = JSON.parse(value.ultimosCambios);
    var index = 1
    var table = $('#bitacoraClienteTable');

    if (Object.keys(data.old).length <= 0) {
      $.each(data['new'], function (key, value) {
        var row = $('<tr>').append(
          $('<td>').text(index),
          $('<td>').text(key),
          $('<td class="ellipsis">').text('-'),
          $('<td class="ellipsis">').text(value),
        );
        if (row.text().trim().length > 0) {
          table.append(row);
          index++;
        }
      });
    } else {
      $.each(data['old'], function (key, value) {
        var row = $('<tr>').append(
          $('<td>').text(index),
          $('<td>').text(key),
          $('<td class="ellipsis">').text(value),
          $('<td class="ellipsis">').text(data['new'][key])
        );

        if (value !== data['new'][key]) {
          row.addClass('danger');
          if (row.hasClass('even')) {
            row.removeClass('even');
          }
          table.find('tbody').prepend(row);
          index++;
        } else {
          if (row.hasClass('danger')) {
            row.removeClass('danger');
          }
          table.find('tbody').append(row);
          index++;
        }
      });
    }

    $("#bitacoraClienteTable").DataTable(settingsBitacoraCliente);
    $("#bitacoraClienteTable").css("width", "100%");
  }

  function volverBitacora() {
    document.getElementById("bitacoraPanel").style.display = "block";
    document.getElementById("bitacoraClientePanel").style.display = "none";
  }

  function loadBitacora() {
    cargarCatalogos()
    cargarUsuarios()
    cargarBitacora()
  }