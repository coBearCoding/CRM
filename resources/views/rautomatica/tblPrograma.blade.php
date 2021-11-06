<div class="position-relative  form-group row">
    <label for="exampleEmail" class="col-sm-12 col-form-label">Seleccionar el Programa para el archivo : </label>
      <div class="col-sm-12">   
         <select id='niv_arch' name='niv_arch'  class="form-control sel_programa" >
		  	<option value="" selected>SELECCIONE..</option>
		    @foreach($listNivel2 as $rows)
		      <option value="{{$rows->cod_nivel2}}">{{$rows->nom_nivel2}}</option>
		    @endforeach
		   </select>
      </div>
      
</div>