<div class="p-4">
    <div class="" style="overflow-y: scroll;max-height: 350px;">
            <div class="vertical-time-icons vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
            @foreach ($datos as $dato)
                 <div class="vertical-timeline-item vertical-timeline-element">
                    <div>
                        <div class="vertical-timeline-element-icon bounce-in">
                            <div class="timeline-icon border-primary">
                                <i class="lnr-license text-primary"></i>
                            </div>
                        </div>
                        <div class="vertical-timeline-element-content bounce-in">
                            <h4 class="timeline-title">{{ $dato->SolicitudEstado->nombre }}</h4>
                            <p>{{$dato->motivo}}</p>
                             <p>{{ $dato->observaciones ?? '' }} <br>
                                <b class="text-info">{{\Carbon\Carbon::parse($dato->fecha)->format('j F, Y')}} a las  {{\Carbon\Carbon::parse($dato->fecha)->format('h:i:s A')}}</b>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
    </div>
 </div>
