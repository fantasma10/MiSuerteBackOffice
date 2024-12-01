<div id="loadstep8" style="display: flex; justify-content: center;">
    <img src=<?php echo $PATHRAIZ.'/img/cargando3.gif' ?>>
</div>

<div id="contentStep8" style="display: none">

<div style="margin-bottom:10px;" class="form-group col-xs-9">
    <h4><span><i class="fa fa-gear"></i></span> Matriz de Escalamiento</h4>
    <h5>*La siguiente información se actualiza únicamente en catálogo maestro.</h5>
</div>

<table class="table" id="tabla_escalamiento">
    <thead>
        <tr>
            <th>Area</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Comentario</th>
            <!-- <th></th> -->
        </tr>
        </thead>
    <tr id="fila_0">
        <td><input data-toggle='tooltip' title='Dato modificable en catálogo maestro' type="text" id="area_0" class="form-control m-bot15" disabled></td>
        <td><input data-toggle='tooltip' title='Dato modificable en catálogo maestro' type="text" id="nombre_0" class="form-control m-bot15" disabled></td>
        <td><input data-toggle='tooltip' title='Dato modificable en catálogo maestro' type="text" id="telefono_0" maxlength="12" class="form-control m-bot15 telefono" disabled></td>
        <td><input data-toggle='tooltip' title='Dato modificable en catálogo maestro' type="text" id="correo_0" class="form-control m-bot15" disabled></td>
        <td><input data-toggle='tooltip' title='Dato modificable en catálogo maestro' type="text" id="comentario_0" class="form-control m-bot15" disabled></td>
        <!-- <td>
            <button id="row_0" class="add_button btn btn-sm btn-default" onclick="agregarFila(this.id);">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </button>
        </td> -->
    </tr>
</table>

<div class="row">
    <div class="col-lg-12"><br><br>
        <span id="span_paso8" class="" style="display: none;"></span>
    </div>
</div>

<ul class="list-inline pull-right">
    <!-- <li><button type="button" class="btn btn-default prev-step">Anterior</button></li> -->
</ul>

</div>