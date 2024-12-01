        <div id="comisionesListado"  class="modal fade col-xs-12" role="dialog">
        <center>
        <div class="modal-dialog" style="width:80%;">
                     <!-- Modal content-->
                    <div class="modal-content">
                       <div class="modal-header">
                          <span><i class="fa fa-lightbulb-o" style="font-size:18px"></i> Lista de Comisiones por Version</span>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                       </div>
                        
                        
                        
                        
                      <div class="modal-body texto " style="height:300px;overflow:auto" id="tablalista">
                         
                           
                          
                          
                     </div>
                    
                      <div class="panel-body"   >    
                         	<div class="row " id="formcomisiones" style="height:50px; background-color:#eaeeff; padding-top:10px">
						          
						          <div class="col-xs-1" style="margin-left:20px">
							         <div class="form-group">
								        <label class="">Versión <span class="asterisco">*</span></label>
								            <select class="form-control"   name="nIdVer" id="cmbVer"> 
									           <option value="-1">--</option>
                                                    <?php echo $versiones; ?>
								            </select>
							         </div>
						          </div>
                                <div class="col-xs-1">
							         <div class="form-group">
								        <label class="">Producto <span class="asterisco">*</span></label>
								            <select class="form-control"    name="nIdProductos" id="cmbProductos" onchange="cargaruta(this.value,0)"> 
									           <option value="-1">--</option>
                                                    <?php echo $productos; ?>
								            </select>
							         </div>
						          </div>
						
						          <div class="col-xs-1">
							         <div class="form-group">
								        <label class="">Ruta</label>
								            <select class="form-control" name="nIdRuta" id="cmbRuta" onchange="consultaruta(this.value)" >
									           <option value="-1">--</option>
                                                    
								            </select>
							         </div>
                                   </div>
                                
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">% Comercio</label>
								            <input type="text" class="form-controls montos montos2"  name="" id="txtporcom">
                                         <input type="hidden" class="form-controls montos"  name="" id="txtidperm">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">$ Comercio</label>
								            <input type="text" class="form-controls montos  montos2"  name="" id="txtimpcom">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">% Grupo</label>
								            <input type="text" class="form-controls montos montos2"  name="" id="txtporgrp">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">$ Grupo</label>
								            <input type="text" class="form-controls montos montos2"  name="" id="txtimpgrp">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">% Usuario</label>
								            <input type="text" class="form-controls montos montos2"  name="" id="txtporusr">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">$ Usuario</label>
								            <input type="text" class="form-controls montos montos2"  name="" id="txtimpousr">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">% Especial</label>
								          <input type="text" class="form-controls montos  montos2"  name="" id="txtporesp">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">$ Especial</label>
								           <input type="text" class="form-controls montos montos2"  name="" id="txtimpesp">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">% Costo</label>
								            <input type="text" class="form-controls montos montos2"  name="" id="txtporcost">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">$ Costo</label>
								            <input type="text" class="form-controls montos montos2"  name="" id="txtimpcost">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">$ Máximo</label>
								            <input type="text" class="form-controls montos"  name="sRFC" id="txtimpmax">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
								        <label class="">$ Mínimo</label>
								            <input type="text" class="form-controls montos montos2"  name="sRFC" id="txtimpmin">
							         </div>
                                   </div>
                                <div class="col-xs-1 montos">
							         <div class="form-group">
                                        
								        <button class="btn btn-xs btn-primary btnEditar" id="btnguardarperm" style="height:20px;margin-top:10px" onclick='guardarpermisos()'>Guardar</button>
                                         
                                   </div>
					       </div>  
                        </div>   
                          
                    
                      <div class="modal-body texto " style="height:250px;overflow:auto; " id="tablalistaProspecto">
                         
                           
                          
                          
                     </div>
                     <div class="modal-footer">
            
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                     </div>
                 </div>

        
        </div>
        </center>
    </div>