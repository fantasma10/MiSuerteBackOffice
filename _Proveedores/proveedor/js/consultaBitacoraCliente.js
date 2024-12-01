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


var urlBitacora = "../../../MesaControl/cliente/ajax/consultaBitacora.php"
var usuarios = []

$(document).ready(function () {
  cargarUsuarios()
})

function formatDate(date) {
  var months = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
  var dateParts = date.split(" ")[0].split("-");
  var formattedDate = dateParts[2] + " " + months[parseInt(dateParts[1]) - 1] + " " + dateParts[0] + " " + date.split(" ")[1];
  return formattedDate;
}

function cargarUsuarios() {
  if (getCatalogos != null) {
    getCatalogos.abort();
    getCatalogos = null;
  }

  var getCatalogos = $.ajax({
    url: urlBitacora,
    type: "POST",
    data: {
      tipo: 5,
    },
    success: function (response) {
      var obj = jQuery.parseJSON(response);
      usuarios = obj
    },
    error: function (error) {
      alert("Ha ocurrido un error, intente de nuevo m\u00E1s tarde");
    }
  });
}

function obtenerNombreUsuarios(id) {
  let nombreCompleto = '';
  for (var i = 0; i < usuarios.length; i++) {
    if (usuarios[i].id === id) {
      nombreCompleto = usuarios[i].nombreCompleto;
      break;
    }
  }

  return nombreCompleto;
}

function verBitacoraCliente(idRegistro, nombre) {
  var tipoCliente = 'Proveedor'
  if (getBitacora != null) {
    getBitacora.abort();
    getBitacora = null;
  }

  $('#labelAccion').text('')
  cargarUsuarios()

  var getBitacora = $.ajax({
    url: urlBitacora,
    type: "POST",
    data: {
      tipo: 6,
      idRegistro,
      tipoCliente
    },
    success: function (response) {
      $("#bitacoraClienteTable").DataTable().fnDestroy();
      $("#bitacoraClienteTable tbody").empty();

      var obj = JSON.parse(response);

      if (obj.length !== 0) {
        $(".panelrgb").css("max-width", "100%");
        $(".panel").css("max-width", "100%");

        document.getElementById("consultaClientePanel").style.display = "none";
        document.getElementById("bitacoraClientePanel").style.display = "block";
      } else {
        alert('No hay datos en la bitácora.');
        return;
      }

      $('#labelID').text(idRegistro + ' ' + nombre);

      $.each(obj, function (key, objValue) {
        var data = JSON.parse(objValue.ultimosCambios);
        var index = 1;
        var table = $('#bitacoraClienteTable');

        if (Object.keys(data.old).length <= 0) {
          $.each(data['new'], function (key, value) {
            var row = $('<tr>').append(
              $('<td>').text(objValue.catalogo),
              $('<td>').text(obtenerNombreUsuarios(parseInt(objValue.usuario))).css('font-weight', 'bold'),
              $('<td>').text(key),
              $('<td class="ellipsis">').text(''),
              $('<td class="ellipsis" style="max-width: 300px !important; white-space: normal !important;">').text(value ? insertarSaltoLinea(value, 40) : ''),
              $('<td>').text(objValue.fechMovimiento)
            );
            if (row.text().trim().length > 0) {
              table.append(row);
              index++;
            }
          });
        } else {
          $.each(data['old'], function (key, value) {
            var row = $('<tr>').append(
              $('<td>').text(objValue.catalogo),
              $('<td>').text(obtenerNombreUsuarios(parseInt(objValue.usuario))).css('font-weight', 'bold'),
              $('<td>').text(key),
              $('<td class="ellipsis">').text(value ? value : ''),
              $('<td class="ellipsis" style="max-width: 300px !important; white-space: normal !important;">').text(data['new'][key] ? insertarSaltoLinea(data['new'][key], 40) : ''),
              $('<td>').text(objValue.fechMovimiento)
            );

            if (value !== data['new'][key]) {
              row.find('tr').removeClass('even');
              row.find('td').addClass('danger');
              table.find('tbody').prepend(row);
              index++;
            } else {
              table.find('tbody').append(row);
              index++;
            }

          });
        }
      })

      
      $("#bitacoraClienteTable").DataTable(settingsBitacoraCliente);
      $("#bitacoraClienteTable").css("width", "100%");
    },
    error: function (error) {
      alert("Ha ocurrido un error, intente de nuevo m\u00E1s tarde");
    }
  });
}

function volverBitacora() {
  document.getElementById("consultaClientePanel").style.display = "block";
  document.getElementById("bitacoraClientePanel").style.display = "none";
  $(".panelrgb").css("max-width", "1010px");
  $(".panel").css("max-width", "1010px");
  $("#bitacoraClienteTable").DataTable().fnDestroy();
  $("#bitacoraClienteTable tbody").empty();
}