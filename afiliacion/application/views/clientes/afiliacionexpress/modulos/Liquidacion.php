<div class="panel panel-default toggle panelMove panelClose panelRefresh" id=""> 
	<div class="panel-heading">
		<h4 class="panel-title">Liquidación</h4>
			<div class="panel-controls panel-controls-right">
				<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
			</div>
	</div> 
	<div class="panel-body"> 
		<br> 
        <div class="row mb5"> 
			<div class="col-xs-2">
				<h5 class="medium">Tipo de Reembolso</h5>
			</div>
			<div class="col-xs-3">
                <select id="comboReembolso" name="nIdReembolso" class="form-control">
                    <option value="-1">--</option>
				<?php
				
					echo $reembolsos;
				?>
                </select>
			</div> 
            <div class="col-xs-3">
				<h5 class="medium">Tipo de Liquidación de Reembolso</h5>
			</div>
			<div class="col-xs-3">
                <select id="comboLiqReembolso" name="nIdLiqReembolso" class="form-control">
                    <option value="-1">--</option>
				<?php
				
					echo $liquidaciones;
				?>
                </select>
			</div> 
		</div> <br>
           <div class="row mb5"> 
			<div class="col-xs-2">
				<h5 class="medium">Tipo de Comisión</h5>
			</div>
			<div class="col-xs-3">
                <select id="comboComisiones" name="nIdComision" class="form-control">
                    <option value="-1">--</option>
				<?php
				
					echo $comisiones;
				?>
                </select>
			</div>
            <div class="col-xs-3">
				<h5 class="medium">Tipo de Liquidación de Comisión</h5>
			</div>
			<div class="col-xs-3">
                <select id="comboLiqComisiones" name="nIdLiqComisiones" class="form-control">
                    <option value="-1">--</option>
				<?php
				
					echo $liquidaciones;
				?>
                </select>
			</div> 
		</div> 
	</div>      
</div> 