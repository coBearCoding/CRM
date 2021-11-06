 <form method="POST" id="respuestaAutomatica">
 <br><br>
 <div class="main-card card">
    <div class="row">
      <div class="col-md-6">
          <div class="main-card mb-3 ">
            <div class="card-header">1. Respuesta Automática </div>
              <div class="card-body">
                  <div id='mensajes' style="float:center;display:none"><img src="../images/load.gif" width="5%" height="5%" /></div>
                        <div class="col-md-12">
                            <div id="inputOculto"></div>
                                    <div class="position-relative  form-group row">
                                        <input name="cod_respuesta" id="cod_respuesta"  type="hidden" >
                                        <label for="exampleEmail" class="col-sm-3 col-form-label">Nombre : </label>
                                        <div class="col-sm-9">   
                                            <input name="nombre" id="nombre"  type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="position-relative  form-group row">
                                        <label for="exampleEmail" class="col-sm-3 col-form-label">Asunto : </label>
                                        <div class="col-sm-9">   
                                            <input name="asunto" id="asunto"  type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="position-relative  form-group row">
                                        <label  for="lbl_estado" class="col-sm-3  col-form-label">Opción Plantilla : </label><br>
                                            <div class="col-sm-9">   
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="plantillaG" name="plantilla" class="custom-control-input" checked value="G" onclick="opcionPlantilla();" >
                                                    <label class="custom-control-label" for="plantillaG">Plantilla General</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="plantillaP" name="plantilla" class="custom-control-input" value="P" onclick="opcionPlantilla();" >
                                                    <label class="custom-control-label" for="plantillaP" >Plantilla por Programa</label>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="position-relative  form-group row">
                                        <label for="lbl_estado" class="col-sm-3  col-form-label">Seleccionar Plantilla : </label><br>
                                        <div class="col-sm-9">   
                                            <div class="row">
                                              @foreach($formulario as $row)  
                                                                      
                                                <div class="col-md-5"><br>
                                                    <div class="main-card mb-3 card">
                                                                           
                                                            <div class="position-relative  form-group row">
                                                                                     
                                                                <div class="col-sm-12">   
                                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" id="plantilla{{$row->id}}" name="formPlantilla" class="custom-control-input" value="{{$row->id}}" onclick="opcionPlantilla();">
                                                                        <label class="custom-control-label" for="plantilla{{$row->id}}">Formulario: {{$row->nombre}} </label>
                                                                    </div>
                                                                                          
                                                                </div>
                                                            </div>
                                                                            
                                                    </div>
                                                </div>
                                              @endforeach               
                                            </div>
                                        </div>
                                    </div>
                      
                        </div>
                </div>  
         </div>               
      </div> 
          <div class="col-md-6">
              <div class="main-card mb-3 ">
                  <div class="card-header">2. Configuración de Plantilla</div>
                  <div class="card-body">
                    <div class="col-md-12">
                          <label for="importar" class="col-form-label"><strong>Selección de Plantilla</strong></label>
                          <div id="mailing_programa"></div>  
                          <div id="arch_adjunto">
                              
                              <div class="position-relative row form-group">
                                  <label for="importar" class="col-sm-12 col-form-label"><strong>Importar el Archivo</strong></label>
                              <div id="prog_arch" class="col-sm-12 "></div>
                              <div class="col-md-12">
                                  <form method="POST"  accept-charset="UTF-8" enctype="multipart/form-data">   
                                        <div class="position-relative  form-group row">
                                            <input class="col-sm-10 col-form-label" name="archivo" id="archivo" type="file" class="form-control-file">
                                                <div class="col-sm-2">   
                                                    <a onclick="subirArchivos();" id="arch_guardar" style="color:#FFFFFF" class="btn btn-success btn-lg">Subir</a>
                                                </div>
                                                                        
                                        </div>  
                                  </form>
                              </div>

                              </div>
                              <div class="position-relative row form-group">
                                  <div id="arch_adj_prog" class="col-sm-12 ">
                                      <table border="0" style="width:100%" id="tbl_archivo" class="table table-hover table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th width="40%">Nombre</th>
                                            <th width="50%">{{session('nivel2')}}</th>

                                            <th colspan="2" width="10%" style="text-align:center">Opciones</th>
                                          </tr>
                                        </thead>
                                        <tbody id="list_arch"></tbody>
                                      </table>
                                                                  
                                   </div>
                              </div>
                          </div> 
                      </div>
                  </div>

              </div>

          </div>           
</div>                      
     <div class="d-block text-right card-footer">   
      <button type="button" class="mr-2 btn btn-link btn-sm" onclick="javascript:resetearFormulario()" >Cancelar</button>
                <a class="btn btn-success btn-lg" id='btn_guardar' onclick="javascript:guardarDatos()" style="color:#FFFFFF;">Guardar</a>
               
            </div>                   
    </div>                  
                    
                 
                       </form>