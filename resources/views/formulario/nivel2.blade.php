<div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">

    @foreach($lstResult as $campNivel)
        @if(!empty($campNivel->programa))
            <div class="vertical-timeline-item vertical-timeline-element">
                <div>
                    <span class="vertical-timeline-element-icon bounce-in"></span>
                    <div class="vertical-timeline-element-content bounce-in">
                        <h4 class="timeline-title">{{$campNivel->programa->id}}
                            - {{$campNivel->programa->nombre}}</h4>
                    </div>
                </div>
            </div>
        @else

            <div class="vertical-timeline-item vertical-timeline-element">
                <div>
                    <span class="vertical-timeline-element-icon bounce-in"></span>
                    <div class="vertical-timeline-element-content bounce-in">
                        <h4 class="timeline-title">-- No existen {{session('nivel2')}} asociados --</h4>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

