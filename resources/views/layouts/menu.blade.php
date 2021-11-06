<ul class="vertical-nav-menu metismenu">

    <li class="app-sidebar__heading">MENÚ</li>
    <li>

        <a href="{{route('dashboard')}}" class="{{ Route::is('dashboard') ? 'mm-active' : '' }}">

            <i class="metismenu-icon pe-7s-display2"></i>
            Dashboard
        </a>
    </li>


    @php $lstMenu = Session::get('menu'); $menu_padre = 0; $i=0; $j=0; $c=0; @endphp

    @if(!empty($lstMenu))


        <li class="app-sidebar__heading">SISTEMA</li>
        @foreach($lstMenu as $menu)


            @php

                if($menu->p_estado == 'A'){

                $j++;
                if(empty($menu->id_princ)){
                $c++;
                $menu_padre = $menu->id;

                if($j == 1 && $i >= 1){ $i=0;
            @endphp
</ul></li>
@php
    }
    if($j == 1 && $i > 0){
@endphp
</li>
@php
    }
@endphp

<li class="{{Route::is(htmlentities($menu->prefix)) ? 'mm-active' : ''}}">
    <a class="">
        <i class="metismenu-icon {{$menu->iconos}}"></i>
        {{$menu->nombre}}
        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>

    </a>
    @php
        } else{
        $j=0;
        if($menu->p_estado == 'A'){
        if($menu_padre == $menu->id_princ){
        $i++;

        if($i == 1){
    @endphp
    <ul>
        @php
            }
        @endphp
        @if(!empty($menu->link))
        <li>
            <a href="{{route(htmlentities($menu->link))}}"
               class="{{Route::is(htmlentities($menu->link)) ? 'mm-active' : ''}}">
                <i class="metismenu-icon"></i>
                {{ $menu->nombre}}
            </a>
        </li>
        @endif
        @php
            }
            }
            }
            }
        @endphp
        @endforeach


        @if($c > 0)
    </ul>
</li>
@endif

@endif


{{--<li class="">
    <a class="">
        <i class="metismenu-icon  pe-7s-rocket"></i>
        Admisiones
        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>

    </a>
    
    <ul>
        <li>
            <a href="{{ route('solicitud.index') }}" class="">
                <i class="metismenu-icon"></i>Admisiones
            </a>
        </li>
        <li>
            <a href="{{ route('horario.index') }}" class="">
                <i class="metismenu-icon"></i>Horarios
            </a>
        </li>
        <li>
            <a href="{{ route('documento.index') }}" class="">
                <i class="metismenu-icon"></i>Documentos
            </a>
        </li>
    </ul>
</li>--}}

<li>
 <form id="logout-form" action="{{ route('logout') }}"
                                                                      method="POST"
                                                                      style="display: none;">
                                                                    {{ csrf_field() }}
                                                                </form>

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="metismenu-icon pe-7s-back-2"></i>
        Cerrar Sesión
    </a>
</li>

</ul>