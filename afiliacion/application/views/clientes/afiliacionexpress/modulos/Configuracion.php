<div class="panel panel-default toggle panelMove panelClose panelRefresh" id=""> 
	<div class="panel-heading">
		<h4 class="panel-title">Configuración</h4>
			<div class="panel-controls panel-controls-right">
				<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
			</div>
	</div> 
	<div class="panel-body" > 
		<br>
		<div class="row mb5" hidden>   
			<div class="col-xs-3">  
				<h5 class="medium">PERFIL</h5>
			</div>
			<div class="col-xs-9">
				<?php
				
					echo $html_perfil;
				?>
			</div>
		</div><br>
		<div class="row mb5"> 
			<div class="col-xs-3">
				<h5 class="medium">TIPO DE ACCESO</h5>
			</div>
			<div class="col-xs-9">
				<?php
				
					echo $html_tipoacceso;
				?>
			</div> 
		</div><br> <br>
        <div class="row mb5"> 
			<div class="col-xs-3">
				<h5 class="medium">VERSIÓN</h5>
			</div>
			<div class="col-xs-3">
                <select id="comboVersiones" name="nIdVersion" class="form-control">
                    <option value="-1">--</option>
				<?php
				
					echo $versiones;
				?>
                </select>
			</div> 
            <div class="col-xs-3">
                <button type="button" class="btn btn-xs btn-primary mt15 " id="btnVerListas">Ver Lista</button>
			</div> 
           
		</div> <br>
        <div class="row mb5" >   
			<div class="col-xs-3"> 
				<h5 class="medium">FAMILIAS</h5>
			</div>
			<div class="col-xs-9" id="div-familias">
				<?php
					
					echo $html_familias;
				?>
			</div>  
		</div>
    
	</div>      
</div> 