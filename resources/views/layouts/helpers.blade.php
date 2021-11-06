@php
        function getMonth($month){
            $mes ="";
            switch ($month) {
                case '1':
                    $mes = 'ENERO';
                    break;
                case '2':
                    $mes = 'FEBRERO';
                    break;
                case '3':
                    $mes = 'MARZO';
                    break;
                case '4':
                    $mes = 'ABRIL';
                    break;
                case '5':
                    $mes = 'MAYO';
                    break;
                case '6':
                    $mes = 'JUNIO';
                    break;
                case '7':
                    $mes = 'JULIO';
                    break;
                case '8':
                    $mes = 'AGOSTO';
                    break;
                case '9':
                    $mes = 'SEPTIEMBRE';
                    break;
                case '10':
                    $mes = 'OCTUBRE';
                    break;
                case '11':
                    $mes = 'NOVIEMBRE';
                    break;
                case '12':
                    $mes = 'DICIEMBRE';
                    break;
            }
            return $mes;
        }
     @endphp