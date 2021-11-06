$(document).ready(function()
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   $("#nivel").select2({
    placeholder: "SELECCIONE.."
    });

   $("#asesor").select2({
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

    //COMBO DE NIVELES
    $("#sedes").change(function(){
        $.ajax({
            type: 'POST',
            url: '/llamadas_nivel',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'id':$(this).val()
            },
            success: function (data) {

                //  $('#formregisterdiv').html(data);
                var datos = JSON.parse(data);
                var option="<option value='-1'>Todos</option>";
                for (var i = 0; i < datos[0].length; i++) {
                    option += "<option value='"+datos[0][i].id+"'>"+datos[0][i].nombre+"</option>";
                }
                $("#nivel").html('')
                $("#nivel").append(option)
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: ' + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                //$('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
    })

    //COMBO ASESOR
    $("#nivel").change(function(){
        $.ajax({
            type: 'POST',
            url: '/llamadas_asesor',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'id':$(this).val()
                //'id':$('#sedes').val()
                
            },
            success: function (data) {

                //  $('#formregisterdiv').html(data);
                var datos = JSON.parse(data);
                var option="<option value='-1'>Todos</option>";
                for (var i = 0; i < datos[0].length; i++) {
                    option += "<option value='"+datos[0][i].extension+"'>"+datos[0][i].name+"</option>";
                }
                $("#asesor").html('')
                $("#asesor").append(option)
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: ' + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                //$('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
    })


});












