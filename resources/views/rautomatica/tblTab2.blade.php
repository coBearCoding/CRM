<?php ?>

@if($op_plantilla=='P')
<table style="width: 100%;" border='0'>
   
   
     <tbody id="mail_nivel2">
        @php $count=1; @endphp
        @foreach($listNivel2 as $row) 
            <tr>
                <td style="width: 50%;" >{{$row->nom_nivel2}}<br></td>
                <td style="width: 50%;"><br>
                <div id="cmb_{{$count}}">
                 <select id='{{$count}}' name='{{$count}}[]'  multiple="multiple"  class="form-control cmb_nivel2_multiple" >
                            
                    @foreach($listMailing as $rows)
                       
                            <option value="{{$row->cod_nivel2}}_{{$rows->cod_mail}}">{{$rows->nom_mail}}</option>
                        
                    @endforeach
                    </select>
                 </div>   
                </td>
                
            </tr>
           @php $count++; @endphp
        @endforeach
           <input type='hidden' id='cont_select' name='cont_select' value='{{$count}}'>                             
    </tbody>
    
</table>

@else

<table style="width: 100%;" border='0'>
    
    <tbody>
        @php $count=1; @endphp
        @foreach($mailing as $row)
            <tr><br>
                <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="mail{{$row->id}}" name="mailing" class="custom-control-input" value="{{$row->id}}" >
                      <label class="custom-control-label" for="mail{{$row->id}}">{{$row->nombre}}</label>
                  </div>
                
            </tr>
           
        @endforeach
                                        
    </tbody>
    
</table>

@endif







