/**
 * Red Efectiva
 * Plugin Personalizado para agregar filtros a DataTables 1.9
 * Actualmente agrega selects debajo de la fila de los encabezados que se llenan con opciones
 * que vienen en la respuesta del servidor.
 * Para activar los filtros:
 *      $('#tabla').dataTable({
 *          'oDropDownColumnFilters': {
 *              optionsSourceKey: 'filters'
 *           },
 *           'aoColumnDefs': [
 *              {
 *                  'mData': 'sEstado',
 *                  'aTargets': [1],
 *                  'bFilter': true,
 *                  'oDropDownColumnFilters': {
 *                      config: {
 *                          firstOptionLabel: 'Seleccione',
 *                          firstOptionValue: '-1'
 *                      },
 *                      state: {
 *                          selectedValue: '-1',
 *                          lastPostedValue: '-1'
 *                      },
 *                      options: []
 *                  }
 *              }
 *          ]
 *      });
 *
 *
 * "optionsSourceKey": Define la key de la respuesta del servidor en la que vienen los filtros
 * "fnGetInstance": Obtiene la instancia del plugin que se está usando en la tabla
 * "fnGetStates": Obtiene todos los objetos de estado de los filtros
 * "fnResetFiltersStates": Reinicia el valor seleccionado al valor de la primera opción del config
 * "fnSetShouldUpdatePostedParams": se usa para indicar que al enviar el request al servidor
 *      se deben de actualizar los valores de los filtros, esto para evitar que al seleccionar otro valor
 *      y cambiar de página se actualicen los resultados con el nuevo filtro.
 *
 * Al configurar "aoColumnDefs" se recomienda que la propiedad "oDropDownColumnFilters" sea un
 * objeto "global" dentro del archivo para persistir el estado del filtro
 *
 * ********************
 * Problemas Conocidos
 * ********************
 * - Al agregar la fila de los filtros datatables llena las celdas con los nombres de los headers
 *   pero esto se corrige cuando se muestran los resultados del servidor.
 */

(function(factory) {
    factory(jQuery, window, document);
}(function (jQuery, window, document) {

    /**
     *
     * @param {any} oDT Configuración de DataTables
     * @param {any} oOpts Configuración del plugin
     * @returns DropDownColumnFilters
     */
    const DropDownColumnFilters = function (oDT, oOpts) {
        this.api = oDT;

        const dtSettings = $.fn.dataTable.Api ?
            new $.fn.dataTable.Api(oDT).settings()[0] :
            this.api.fnSettings();

        this.s = {
            that: this,
            tableId: dtSettings.sInstance,
            dt: dtSettings,
            optionsSourceKey: 'filters'
        };

        this.dom = {
            container: null,
            table: this.s.dt.nTable,
            thead: this.s.dt.nTHead,
            tbody: this.s.dt.nTBody,
            headerRow: null,
            filters: []
        };

        this.isInitialized = false;
        this.shouldUpdatePostedParams = true;
        this.configs = {};
        this.states = {};

        this._fnConstruct(oOpts);

        return this;
    };

    DropDownColumnFilters.prototype = {
        // ********************
        //  Funciones protegidas
        // ********************
        _fnConstruct: function (oOpts) {
            this.s.optionsSourceKey = oOpts.optionsSourceKey;

            this._fnAssignStates();

            this.isInitialized = true;
        },

        /**
         *
         * @param {Object} config Objeto de configuración
         * @param {Array} options Array de opciones para
         * @returns jQueryElement
         */
        _fnGenerateFilter: function (config, options)
        {
            const columnIndex = config.columnIndex;
            const firstOptionLabel = config.firstOptionLabel;
            const firstOptionValue = config.firstOptionValue;

            let html = `
                <select
                    id="tableFilter_${columnIndex}"
                    data-column-index="${columnIndex}"
                    class="column-filter"
                >
                    <option value="${firstOptionValue}">${firstOptionLabel}</option>
            `;

            options.forEach(option => {
                html += `<option value="${option.value}">${option.label}</option>`;
            });

            html + '</select>';

            const elem = $(html);

            elem.val(config.selectedValue);

            return elem;
        },
        _fnAssignStates: function () {
            this.s.dt.aoColumns.forEach((settings) => {
                if (!settings.bFilter) {
                    return;
                }

                const filterKey = settings.mData;
                if (settings.hasOwnProperty('oDropDownColumnFilters')) {
                    this.configs[filterKey] = settings.oDropDownColumnFilters.hasOwnProperty('config')
                        ? settings.oDropDownColumnFilters.config
                        : this._fnDefaultFilterConfig();

                    this.states[filterKey] = settings.oDropDownColumnFilters.hasOwnProperty('state')
                        ? settings.oDropDownColumnFilters.state
                        : this._fnDefaultFilterState();
                } else {
                    this.configs[filterKey] = this._fnDefaultFilterConfig();
                    this.states[filterKey] = this._fnDefaultFilterState();
                }
            });
        },
        _fnDraw: function () {
            // Asignar opciones
            const dt = this.s.dt;
            if (Object.hasOwn(dt.jqXHR, 'responseJSON')) {
                const options = dt.jqXHR.responseJSON[this.s.optionsSourceKey];
                if (options != null) {
                    const filterKeys = Object.keys(options);
                    if (filterKeys.length != 0) {
                        filterKeys.forEach((filterKey) => {
                            const state = this.states[filterKey];
                            // Esta validación es para cuando en la respuesta del servidor hay filtros
                            // que no existen en la configuración de la tabla
                            if (state) {
                                state.options = options[filterKey];
                            }
                        });
                    } else {
                        const filterKeys = Object.keys(this.states);
                        filterKeys.forEach((filterKey) => {
                            const state = this.states[filterKey];
                            state.options = [];
                        });
                    }
                }
            }

            // Genera fila de filtros
            const thead = $(this.dom.thead)
            const headerRow = $(document.createElement('tr'));
            headerRow.addClass('datatables-dropdown-column-filters');
            this.dom.headerRow = headerRow;

            // Mapea cada columna a un index absoluto
            // Esto para evitar el desplazo de columnas cuando hay columnas ocultas
            const mappedColumns = this.s.dt.aoColumns.map((settings, index) => [settings, index]);
            const visibleColumns = mappedColumns.filter(([settings]) => settings.bVisible);
            const columns = visibleColumns.map(([settings, columnIndex]) => {
                if (!settings.bFilter) {
                    return $('<th>');
                }

                const key = settings.mData;
                const filterConfig = this.configs[key];
                const filterState = this.states[key];
                const filterSettings = Object.assign({
                    columnIndex: columnIndex,
                    selectedValue: filterState.selectedValue
                }, filterConfig);

                const filterOptions = filterState.options || [];
                const availableOptions = filterOptions.map((option) => ({
                    label: option.name,
                    value: option.id
                }));

                const column = $('<th>');
                const select = this._fnGenerateFilter(filterSettings, availableOptions);
                select.on('change.dropDownColumnFilters', (e) => {
                    const elem = $(e.currentTarget);
                    const state = this.states[key];
                    state.selectedValue = elem.val();
                });

                this.dom.filters.push(select.get(0));

                column.append(select);
                return column;
            });

            if (this.dom.filters.length > 0) {
                headerRow.append(columns);
                thead.append(headerRow);
            }
        },
        _fnReplaceServerParams: function (aoData) {
            // En cada llamada es necesario generar los filtros por lo que se guarda el
            // valor que se envió en la última llamada para evitar envíar el nuevo valor
            // al cambiar de página
            this.s.dt.aoColumns.forEach((settings, columnIndex) => {
                const state = this.states[settings.mData] || {};
                let selectedValue = (
                    this.shouldUpdatePostedParams
                    ? state.selectedValue
                    : state.lastPostedValue
                );

                // Reemplaza valores de los filtros
                const paramName = `sSearch_${columnIndex}`;
                const param = aoData.find((param) => param.name === paramName);
                if (param != null) {
                    param.value = selectedValue;
                }

                state.lastPostedValue = selectedValue;
            });

            this.shouldUpdatePostedParams = false;
        },
        _fnSetDt: function (oDTSettings) {
            return this.s.dt = oDTSettings;
        },
        _fnClearEventListeners: function () {
            // Remueve eventos
            this.dom.filters.forEach((element) => {
                const elem = $(element);
                elem.off('change.dropDownColumnFilters');
            });

            if (this.dom.headerRow != null) {
                const headerRow = $(this.dom.headerRow);
                headerRow.off();
            }
        },
        _fnDefaultFilterConfig: function () {
            return {
                firstOptionLabel: 'Select',
                firstOptionValue: '-1'
            };
        },
        _fnDefaultFilterState: function () {
            return {
                selectedValue: '-1'
            };
        },
        _fnRemoveHeaderRow: function () {
            this._fnClearEventListeners();
            $(this.dom.headerRow).remove();
        },
        _fnClearHeaderRow: function () {
            if (this.dom.headerRow != null) {
                this._fnRemoveHeaderRow();
                this.dom.filters = [];
                this.dom.headerRow = null;
            }
        },
        _fnDestroyCallback: function () {
            const index = DropDownColumnFilters._aInstances.indexOf(this.s.that);
            if (index !== -1) {
                this._fnClearHeaderRow();
                DropDownColumnFilters._aInstances.splice(index, 1);
            }
        },

        // ********************
        //  Funciones públicas
        // ********************
        fnSetShouldUpdatePostedParams: function (value) {
            return this.shouldUpdatePostedParams = value;
        },
        fnGetFilterSelectedValue: function (key) {
            return this.states[key].selectedValue;
        },
        fnGetStates: function () {
            return this.states;
        },
        fnGetStatesKeys: function () {
            return Object.keys(this.states);
        },
        fnResetFiltersStates: function () {
            const filterKeys = Object.keys(this.states);
            filterKeys.forEach((filterKey) => {
                const config = this.configs[filterKey];
                const state = this.states[filterKey];
                state.selectedValue = config.firstOptionValue;
            });
        }
    };

    // ********************
    //  Variables Estáticas
    // ********************

    // Para cuando hay múltiples tablas que usan el plugin
    DropDownColumnFilters._aInstances = [];

    // ********************
    //  Métodos Estáticos
    // ********************
    DropDownColumnFilters.fnGetPluginSettings = function (oDTSettings) {
        const init = oDTSettings.oInit;
        return (
            init
            ? (init.dropDownColumnFilters || init.oDropDownColumnFilters || {})
            : {}
        );
    };

    DropDownColumnFilters.fnGetInstances = function () {
        return DropDownColumnFilters._aInstances;
    };

    DropDownColumnFilters.fnRemoveInstance = function (instance) {
        const index = DropDownColumnFilters._aInstances.indexOf(instance);
        if (index !== -1) {
            DropDownColumnFilters._aInstances.splice(index, 1);
        }
    };

    DropDownColumnFilters.fnGetInstance = function (elemId) {
        const id = String(elemId).replace('#', '');
        return DropDownColumnFilters._aInstances.find((instance) => {
            if (instance.s.dt.sInstance === id) {
                return instance;
            }

            return null;
        });
    };

    // Agrega clase al objeto de DataTables para hacerlo público
    $.fn.DataTable.DropDownColumnFilters = DropDownColumnFilters;

    // ********************
    //  Eventos
    // ********************
    $(document).on('preDraw.dt', (e, oDTSettings) => {
        const instance = DropDownColumnFilters.fnGetInstance(oDTSettings.sInstance);
        if (instance != null) {
            return;
        }

        const init = oDTSettings.oInit;
        const isConfigured = (
            Object.hasOwn(init, 'dropDownColumnFilters')
            || Object.hasOwn(init, 'oDropDownColumnFilters')
        );

        if (isConfigured) {
            const settings = DropDownColumnFilters.fnGetPluginSettings(oDTSettings);
            DropDownColumnFilters._aInstances.push(
                new DropDownColumnFilters(oDTSettings.oInstance, settings)
            );
        }
    });

    // Esta función la ejecuta siempre la librería de DataTables
    // ANTES de hacer el request XHR
    $(document).on('serverParams.dt', (e, aoData) => {
        const targetId = e.target.id;
        const instance = DropDownColumnFilters.fnGetInstance(targetId);
        if (instance != null) {
            instance._fnReplaceServerParams(aoData);
        }
    });

    $(document).on('header.dt', function (e) {
        const targetId = e.target.id;
        const instance = DropDownColumnFilters.fnGetInstance(targetId);
        if (instance != null) {
            instance._fnClearHeaderRow();
        }
    });

    $(document).on('draw.dt', function (e, oDTSettings) {
        const instance = DropDownColumnFilters.fnGetInstance(oDTSettings.sInstance);
        if (instance != null) {
            instance._fnSetDt(oDTSettings);
            instance._fnDraw();
        }
    });

    $(document).on('destroy.dt', function (e, oDTSettings) {
        const instance = DropDownColumnFilters.fnGetInstance(oDTSettings.sInstance);
        if (instance != null) {
            instance._fnDestroyCallback();
        }
    });

}));
