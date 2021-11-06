
<form  method="POST" id="formularioCampana" >

        {{ csrf_field() }}
            <div class="position-relative  form-group row">
                <label for="exampleEmail" class="col-sm-2 col-form-label">Nombre : </label>
                <div class="col-sm-4">
                    <input name="nom_campana" id="nom_campana"  type="text" class="form-control">
                </div>
                <label style="text-align:right" for="exampleperiodo" class="col-sm-2  col-form-label">Periodo : </label>
                <div class="col-sm-4">
                    <select id="periodo" class="cmb_campana" name="periodo" ></select>
                </div>
            </div>


            <div class="position-relative  form-group row">

                <label for="exampleEmail" class="col-sm-2 col-form-label">Fecha Inicio : </label>
                <div class="col-sm-4">
                    <input type="text" id="fch_inicio" name="fch_inicio" class="form-control" data-date-format='yyyy-mm-dd' />
                </div>


                <label style="text-align:right" for="exampleEmail" class="col-sm-2 col-form-label">Fecha Finalización : </label>
                <div class="col-sm-4">
                    <input name="fch_fin" id="fch_fin"  type="text" class="form-control" data-date-format='yyyy-mm-dd' >
                </div>
            </div>

            <div class="position-relative  form-group row">

                <label for="exampleEmail" class=" col-sm-2 col-form-label">Nombre del Responsable: </label>
                <div class="col-sm-4">
                    <input name="nom_contacto" id="nom_contacto"  type="text" class="form-control">
                </div>


                <label  style="text-align:right" for="exampleEmail" class=" col-sm-2  col-form-label">Email del Responsable : </label>
                <div class="col-sm-4">
                    <input name="email_contacto" id="email_contacto"  type="text" class="form-control">
                </div>
            </div>

            <div class="position-relative  form-group row">

                <label for="exampleEmail" class="col-sm-2  col-form-label">Sede : </label>
                <div class="col-sm-4">
                    <select id="sedes" name="sedes" class="cmb_campana" onchange="javascript:opcionAsesor();"></select>
                </div>


                <label style="text-align:right" for="exampleEmail" class="col-sm-2  col-form-label">Metas : </label>
                <div class="col-sm-4">
                    <select id="meta" class="cmb_campana" name="meta" ></select>
                </div>
            </div>

            <div class="position-relative  form-group row">

                <label for="exampleEmail" class=" col-sm-2 col-form-label">{{session('nivel1')}} : </label>
                <div class="col-sm-4">
                    <select id="nivel1" name="nivel1" class="cmb_campana"  onchange="javascript:cargaNivel2(this.value);"></select>
                </div>


                <label style="text-align:right" for="exampleEmail" class=" col-sm-2  col-form-label">{{session('nivel2')}} : </label>
                <div class="col-sm-4">
                    <select id="nivel2" class="fav_clr form-control cmb_campana " onchange="opciones()" name="nivel2[]" multiple="multiple" ></select>
                </div>
            </div>

            <div class="position-relative  form-group row">
                <label  for="lbl_estado" class="col-sm-2  col-form-label">Estado : </label><br>
                    <div class="col-sm-4">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="estadoSi" name="estadoCampana" class="custom-control-input" checked value="A">
                            <label class="custom-control-label" for="estadoSi">Activo</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="estadoNO" name="estadoCampana" class="custom-control-input" value="I" >
                            <label class="custom-control-label" for="estadoNO" >Inactivo</label>
                        </div>
                    </div>
                 <label style="text-align:right" for="lbl_asesor" class="col-sm-2  col-form-label">Asesor : </label><br>
                    <div class="col-sm-4">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="asesorT" name="asesor" class="custom-control-input" checked value="T" onclick="javascript:opcionAsesor()">
                            <label class="custom-control-label" for="asesorT">Gestores</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="asesorG" name="asesor" class="custom-control-input" value="V" onclick="javascript:opcionAsesor()">
                            <label class="custom-control-label" for="asesorG" >Asesor</label>
                        </div>
                    </div>



            </div>
            <div class="position-relative  form-group row">
                <label for="exampleEmail" class="col-sm-2  col-form-label">Asesor : </label>
                <div class="col-sm-10">
                    <select id="vendedor" class="fav_clr_vendedor form-control cmb_campana " onchange="opciones_vendedor()"  name="vendedor[]" multiple="multiple" ></select>
                </div>
            </div>

            <div class="position-relative  form-group row">
                <label for="exampleEmail" class="col-sm-2 col-form-label">Detalle : </label>
                <div class="col-sm-10">
                    <textarea  class="form-control autosize-input" id="detalle" name="detalle"></textarea>
                </div>
            </div>

            <input type='hidden' id='cod_campana' name='cod_campana'>
            <input type='hidden' id='cod_periodo' name='cod_periodo' value="{{session('periodo')}}">
            <div class="d-block text-right card-footer">
                <button type="button" class="mr-2 btn btn-link btn-sm" onclick="javascript:resetearFormulario()" >Cancelar</button>
                <a class="btn btn-success btn-lg" id='btn_guardar' onclick="javascript:nuevaCampana()" style="color:#FFFFFF;">Guardar</a>

            </div>


</form>

