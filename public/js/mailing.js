$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    console.log('hola mundo')
    $('.cboselect').select2();
});

function view_template(){
    $.ajax({
        type: 'POST',
        url: '/mailing/template',
        data: {
            'templateid':$("#templateid").val(),
            "_token": $('meta[name="csrf-token"]').attr('content'),
        },
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#view_html').html('<img src="../images/load.gif" width="5%" height="5%" />');
        },
        success: function (data) {
            $("#view_html").html('');
            $("#view_html").html(data);

        },
        error: function (xhr) { // if error occured
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
        dataType: 'html'
    });
}

function setEmail(sl){
    var url = '/leads/html/'+$(sl).val();
    $('#view_template').prop('href',url);
    //$("#asunto").val($(sl).find(':selected').data('asunto'));
}