let mainDataTable = null;
const elemContractsTable = $('#container-contracts');
const elemDueDate = $('#txt-due-date');
const elemTxtSCliente = $('#txt-sCliente');
const elemTxtNIdCliente = $('#txt-nIdCliente');
const elemBtnSearch = $('#btn-search');
const settings = {
    language: {
        emptyTable: 'No se ha encontrado información',
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
        infoFiltered: '(filtrado de _MAX_ total de registros)',
        lengthMenu: 'Mostrar _MENU_ registros por página',
        loadingRecords: 'Cargando...',
        search: 'Buscar:',
        zeroRecords: 'No se encontraron coincidencias en los registros',
        paginate: {
            first: 'Primero',
            last: 'Último',
            next: 'Siguiente',
            previous: 'Anterior'
        }
    },
    paging: true,
    // scrollCollapse: false,
    // lengthMenu: [100, 250, 500],
    iDisplayLength: 25,
    // scrollX: true,
    // fixedColumns: {
        // left: 1
    // }
};

const headTable = `
        <table id="tbl-contracts-review" class="display table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>RFC</th>
                    <th>Cadena</th>
                    <th>Fecha Contrato</th>
                    <th>Fecha Renovación</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
`;

const generarDatosAutocomplete = (buscar) => {
    let filtrarClientes = CLIENTES.filter(cliente => {
        if (cliente.sNombreCliente.toLowerCase().includes(buscar.toLowerCase()) || 
            (cliente.sRFC && cliente.sRFC.toLowerCase().includes(buscar.toLowerCase())) ||
            cliente.nIdCliente == buscar.trim()) {

            cliente.text = '';
            
            if (cliente.sNombreCliente.trim() != '') {
                cliente.text = `${cliente.nIdCliente} - ${cliente.sNombreCliente}`;
            }

            return cliente;
        }
    });
   
    return filtrarClientes;
}

const initAutocomplete = () => {
    const autocomplete = new autoComplete({
        selector: '#txt-sCliente',
        minChars: 1,
        source: function(term, suggest) {
            const suggestions = [];
            term = term.toLowerCase();

            let clientes = generarDatosAutocomplete(term);

            suggest(clientes);
        },
        renderItem: function (item, search) {
            // escape special characters
            search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
            return `<div class="autocomplete-suggestion" data-val="${item.text}" data-id-cliente="${item.nIdCliente}" data-ticket-fiscal="${item.nTicketFiscal}">${item.text.replace(re, "<b>$1</b>")}</div>`;
        },
        onSelect: function (e, term, item) { 
            let nIdCliente = item.getAttribute('data-id-cliente');
            elemTxtNIdCliente.val(nIdCliente);
        }
    });
}

const agregarBotones = () => {
    const row = document.createElement('div');
    const contenedorBotones = document.createElement('div');
    const btnExportarExcel = document.createElement('button');

    row.className = 'col-xs-4';

    contenedorBotones.id = 'tblContracts_buttons';
    contenedorBotones.className = 'dataTables_buttons';
   
    btnExportarExcel.id = 'btn-export-excel';
    btnExportarExcel.type = 'button';
    btnExportarExcel.className = 'btn btn-info';
    btnExportarExcel.textContent = 'Excel';
    btnExportarExcel.addEventListener('click', function () {
        $(this).html('Excel <span class="btn-spinner hide"><i class="fa fa-spinner"></i></span>');
        exportarExcel();
    });

    contenedorBotones.appendChild(btnExportarExcel);
    row.appendChild(contenedorBotones);

    return row;
}

const exportarExcel = () => {
    let dDate = elemDueDate.val(); 
    let nIdCliente = elemTxtNIdCliente.val(); 

    $('#btn-export-excel').prop('disabled', true);
    $('#btn-export-excel span').removeClass('hide').addClass('show');

    const excelForm = `
        <form id="formExcel" method="post" action="${BASE_PATH}/ajax/RevisionContrato.php" >
            <input type="hidden" name="nType" value="2" />
            <input type="hidden" name="dDate" value="${dDate}" />
            <input type="hidden" name="nIdCliente" value="${nIdCliente}" />
        </form>
    `;

    $('body').append(excelForm);
    $('#formExcel').submit();
    $('#formExcel').remove();

    $('#btn-export-excel span').removeClass('show').addClass('hide');
    $('#btn-export-excel').prop('disabled', false);
}

const buildTable = () => {
    let dDate = elemDueDate.val();
    let nIdCliente = elemTxtNIdCliente.val(); 

    elemContractsTable.html(headTable);

    mainDataTable = $('#tbl-contracts-review').DataTable({
        ...settings,
        ajax: {
            url: `${BASE_PATH}/ajax/RevisionContrato.php`,
            type: 'post',
            data: {
                nType: 1,
                dDate,
                nIdCliente
            }
        },
        columns: [
            { data: 'sNombreCliente' },
            { data: 'sRFC' },
            { data: 'sNombreCadena' },
            { data: 'dFechaContrato' },
            { data: 'dFecRenovacion' }
        ],
        order: [[4, 'asc']],
        processing: true,
        responsive: true,
        initComplete: () => {
            let seccionBotones = agregarBotones();
            $('#tbl-contracts-review_wrapper .row')[0].childNodes[0].className = 'col-xs-4';
            $('#tbl-contracts-review_wrapper .row')[0].childNodes[1].className = 'col-xs-4';
            $('#tbl-contracts-review_wrapper .row .col-xs-4:last-child').before(seccionBotones);

            $('#tbl-contracts-review').css({'width': '100%'});

            elemBtnSearch.children('span.btn-spinner').removeClass('show').addClass('hide');
            elemBtnSearch.prop('disabled', false);
        }
    });
}

elemBtnSearch.click(() => {
    elemBtnSearch.prop('disabled', true);
    elemBtnSearch.children('span.btn-spinner').removeClass('hide').addClass('show');

    buildTable();
});

elemTxtSCliente.on('keyup', (e) => {
    if (e.target.value.trim() == '') {
        elemTxtNIdCliente.val('');
    }
});

const initContractReview = () => {
    elemDueDate.datepicker({format: 'yyyy-mm-dd'});

    initAutocomplete();
}
