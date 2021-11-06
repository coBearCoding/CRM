<div class="row">

    @php
        $menu_padre = 0; $i=0;
    @endphp
    @foreach($lstMenu as $menu)

    @php
        $i++;
        if(empty($menu->id_princ)){
        $menu_padre = $menu->id;
        if($i > 1){
    @endphp
    </ul>
</div>
@php
    }
@endphp

<div class="col-sm-6 col-xl-4">
    <ul class="nav flex-column">
        <li class="nav-item-header nav-item">
            <div class="mb-2 mr-2 btn btn-lg btn-block btn-outline-primary ">
                <a>
                    <i class="metismenu-icon {{$menu->iconos}}"></i>
                    {{$menu->nombre}}
                </a>
            </div>
        </li>
        @php
            }else{
                if($menu_padre == $menu->id_princ){

        @endphp
        <li class="nav-item">
            <a class="nav-link">
                <span> {{ $menu->nombre}}</span>
                <div class="ml-auto">
                    <input type="checkbox" value="{{$menu->id}}" class="chkpermisos" data-size="small" data-toggle="toggle" @if ($menu->p_estado == 'A') checked
                           @endif
                           data-onstyle="success" data-offstyle="secondary">
                </div>
            </a>
        </li>
    @php
        }
        }
    @endphp

    @endforeach

</div>


