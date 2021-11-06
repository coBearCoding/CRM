$(document).ready(function()
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   $("#estado_comercial").select2({
    placeholder: "SELECCIONE.."
    });

   $("#estado_comercial_fc").select2({
   	placeholder: "SELECCIONE.."
    });

   var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#fecha span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $("#fecha_ini").val(start.format('YYYY-MM-DD'));
        $("#fecha_fin").val(end.format('YYYY-MM-DD'));
    }

    function cb_lc(start, end) {
        var resta = end - start;
        console.log(Math.round(resta/ (1000*60*60*24)));
        var result = Math.round(resta/ (1000*60*60*24));
        if(result > 60){
            return alert('El reporte no debe superar los 60 dias de diferencia entre fechas');
        } 
        $('#fecha_lc span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $("#fecha_ini_lc").val(start.format('YYYY-MM-DD'));
        $("#fecha_fin_lc").val(end.format('YYYY-MM-DD'));
    }



    $('#fecha').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Anterior Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    
    $('#fecha_lc').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Anterior Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb_lc);

    cb(start, end);
    cb_lc(start, end);


    $("#oferta_academica").change(function(){
        $.ajax({
            type: 'POST',
            url: '/nivel-secundario-datos',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'id':$(this).val()
            },
            success: function (data) {
                //  $('#formregisterdiv').html(data);
                var datos = JSON.parse(data);
                var option="<option value=''>Todos</option>";
                for (var i = 0; i < datos.length; i++) {
                    option += "<option value='"+datos[i].id+"'>"+datos[i].nombre+"</option>";
                }
                $("#programa").html('')
                $("#programa").append(option)
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: ' + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                $('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
    })
    
    $("#oferta_academica_r").change(function(){
        $.ajax({
            type: 'POST',
            url: '/nivel-secundario-datos',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'id':$(this).val()
            },
            success: function (data) {
                //  $('#formregisterdiv').html(data);
                var datos = JSON.parse(data);
                var option="<option value=''>Todos</option>";
                for (var i = 0; i < datos.length; i++) {
                    option += "<option value='"+datos[i].id+"'>"+datos[i].nombre+"</option>";
                }
                $("#programa_r").html('')
                $("#programa_r").append(option)
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: ' + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                $('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
    })


});


