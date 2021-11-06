var MONTH = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    cargardashboard();

    $('#fuente-contacto').select2({
        'placeholder': 'Seleccione'
    });

    $("#oferta").change(function () {
        $.ajax({
            type: 'POST',
            url: '/dashboard/oferta',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": $(this).val()
            },
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#ofertaChart').html('<img src="../images/load.gif" width="10%" height="10%" />');
            },
            success: function (d) {
                $('#ofertaChart').html('');
                //console.log(d)
                datas = [];
                labels = [];
                backgroundColor = [];
                for (var i = 0; i < d.length; i++) {
                    dato = {
                        label: d[i].nombre,
                        backgroundColor: getRandomColor(),
                        borderColor: getRandomColor(),
                        data: [d[i].total],
                        fill: false,
                    }
                    datas.push(d[i].total);
                    labels.push(d[i].nombre + ': ' + d[i].total);
                    backgroundColor.push(getRandomColor());
                }
                //console.log(datas)
                $('#ofertaChart').remove(); // this is my <canvas> element
                $('#oferta_view').append('<canvas id="ofertaChart"  width="667" height="283"><canvas>');
                var ctx = document.getElementById('ofertaChart').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'doughnut',

                    // The data for our dataset
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Oferta Academica',
                            backgroundColor: backgroundColor,
                            borderColor: backgroundColor,
                            data: datas,
                            fill: false,
                        }]
                    },
                });
            },
            error: function (xhr) {
                toastr.error('Error: ' + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                $('#div_mensajes').addClass('d-none');
            },
        });
    });


    $("#estado").change(function () {
        $.ajax({
            type: 'POST',
            url: '/dashboard/estado',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": $(this).val()
            },
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#estadoChart').html('<img src="../images/load.gif" width="10%" height="10%" />');
            },
            success: function (d) {
                $('#estadoChart').html('');
                //console.log(d)
                datas = [];
                labels = [];
                backgroundColor = [];
                for (var i = 0; i < d.length; i++) {
                    dato = {
                        label: d[i].nombre,
                        backgroundColor: getRandomColor(),
                        borderColor: getRandomColor(),
                        data: [d[i].total],
                        fill: false,
                    }
                    datas.push(d[i].total);
                    labels.push(d[i].nombre + ': ' + d[i].total);
                    backgroundColor.push(getRandomColor());
                }
                //console.log(datas)
                $('#estadoChart').remove(); // this is my <canvas> element
                $('#estado_view').append('<canvas id="estadoChart"  width="667" height="283"><canvas>');
                var ctx = document.getElementById('estadoChart').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'horizontalBar',

                    // The data for our dataset
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Oferta Academica',
                            backgroundColor: backgroundColor,
                            borderColor: backgroundColor,
                            data: datas,
                            fill: false,
                        }]
                    },
                });
            },
            error: function (xhr) {
                toastr.error('Error: ' + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                $('#div_mensajes').addClass('d-none');
            },
        });
    })


    $("#btn_guardar").click(function () {

        var data = $('#form').serialize();

        $.ajax({
            type: 'POST',
            url: '/save_nsecundario',
            data: data,
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
            },
            success: function (data) {
                var d = JSON.parse(data);
                $('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    view_table();
                    clear_data();
                }
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: '.xhr.statusText + xhr.responseText);
            },
            complete: function () {
                $('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
    });


});

function fuente_contacto(tipo,name) {
    $.ajax({
        type: 'POST',
        url: '/dashboard/fuente-contacto',
        data:
            {"_token": $('meta[name="csrf-token"]').attr('content'), 'tipo': tipo }
        ,
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
        },
        success: function (d) {
            //console.log(d)
            datas = []
            for (var i = 0; i < d.length; i++) {
                dato = {
                    label: d[i].nombre,
                    backgroundColor: hex[i],
                    borderColor: hex[i],
                    data: [d[i].ene, d[i].feb, d[i].mar, d[i].abr, d[i].may, d[i].jun, d[i].jul, d[i].ago, d[i].sep, d[i].oct, d[i].nov, d[i].dic],
                    fill: false,
                }
                datas.push(dato)
            }
            var ctx = document.getElementById(name).getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: MONTH,
                    datasets: datas
                },

                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

        },
        error: function (xhr) {
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });
}

function oferta_academica() {
    $.ajax({
        type: 'POST',
        url: '/dashboard/oferta-academica',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "periodo": $("#periodo").val()
        },
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
        },
        success: function (d) {
            console.log(d)
            datas = [];
            labels = [];
            backgroundColor = [];
            for (var i = 0; i < d.length; i++) {
                dato = {
                    label: d[i].nombre,
                    backgroundColor: getRandomColor(),
                    borderColor: getRandomColor(),
                    data: [d[i].total],
                    pointHitRadius: d[i].total,
                    borderDash: [5, 5],
                    fill: false,
                }
                datas.push(d[i].total);
                labels.push(d[i].nombre + ': ' + d[i].total);
                backgroundColor.push(getRandomColor());
            }
            //console.log(datas)
            var ctx = document.getElementById('oferta_academica').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'doughnut',

                // The data for our dataset
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Oferta Academica',
                        backgroundColor: backgroundColor,
                        borderColor: backgroundColor,
                        data: datas,
                        fill: false,
                    }]
                },

                // Configuration options go here
                options: {
                    tooltips: {
                        mode: 'point',
                        intersect: false,
                        position: 'nearest',
                        bodySpacing: 4,
                    },

                }
            });
        },
        error: function (xhr) {
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });
}

var hex = ['rgb(255, 99, 132)', 'rgb(255, 159, 64)', 'rgb(69, 39, 160)', 'rgb(75, 192, 192)', 'rgb(54, 162, 235)', 'rgb(251, 192, 45)', 'rgb(159, 168, 218)', 'rgb(216, 27, 96)',
    'rgb(66, 165, 245)', 'rgb(239, 83, 80)', 'rgb(38, 166, 154)', 'rgb(197, 225, 165)', 'rgb(212, 225, 87)', 'rgb(255, 202, 40)', 'rgb(255, 138, 101)', 'rgb(0, 96, 100)',
    'rgb(171, 71, 188)', 'rgb(244, 143, 177)', 'rgb(129, 199, 132)', 'rgb(124, 179, 66)', 'rgb(255, 235, 59)', 'rgb(255, 160, 0)', 'rgb(230, 74, 25 )', 'rgb(49, 27, 146)',
    'rgb(77, 208, 225)', 'rgb(0, 151, 167)', 'rgb(85, 139, 47)', 'rgb(192, 202, 51)', 'rgb(249, 168, 37)', 'rgb(230, 81, 0)', 'rgb(216, 27, 96)', 'rgb(69, 90, 100)'];


function oferta_academica_mes() {
    $.ajax({
        type: 'POST',
        url: '/dashboard/oferta-academica-mes',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "periodo": $("#periodo").val()
        },
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
        },
        success: function (d) {
            //console.log(d)
            datas = [];
            labels = [];
            backgroundColor = [];
            for (var i = 0; i < d.length; i++) {
                dato = {
                    label: d[i].nombre,
                    backgroundColor: getRandomColor(),
                    borderColor: getRandomColor(),
                    data: [d[i].total],
                    fill: false,
                }
                datas.push(d[i].total);
                labels.push(d[i].nombre + ': ' + d[i].total);
                backgroundColor.push(getRandomColor());
            }
            //console.log(datas)
            var ctx = document.getElementById('oferta_academica_mes').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'doughnut',

                // The data for our dataset
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Oferta Academica',
                        backgroundColor: backgroundColor,
                        borderColor: backgroundColor,
                        data: datas,
                        fill: false,
                    }]
                },

                // Configuration options go here
                options: {
                    tooltips: {
                        mode: 'point',
                        intersect: false,
                        position: 'nearest',
                        bodySpacing: 4,
                    },

                }
            });
        },
        error: function (xhr) {
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });
}

function estado_comercial() {
    $.ajax({
        type: 'POST',
        url: '/dashboard/estado-comercial',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "periodo": $("#periodo").val()
        },
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
        },
        success: function (d) {
            //console.log(d)
            datas = [];
            labels = [];
            backgroundColor = [];
            for (var i = 0; i < d.length; i++) {
                dato = {
                    label: d[i].nombre,
                    backgroundColor: getRandomColor(),
                    borderColor: getRandomColor(),
                    data: [d[i].total],
                    fill: false,
                }
                datas.push(d[i].total);
                labels.push(d[i].nombre + ': ' + d[i].total);
                backgroundColor.push(getRandomColor());
            }
            //console.log(datas)
            var ctx = document.getElementById('estado_comercial').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Estado comercial',
                        backgroundColor: backgroundColor,
                        borderColor: backgroundColor,
                        data: datas,
                        fill: false,
                    }]
                },

                // Configuration options go here
                options: {
                    tooltips: {
                        mode: 'point',
                        intersect: false,
                        position: 'nearest',
                        bodySpacing: 4,
                    },

                }
            });
        },
        error: function (xhr) {
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });
}

function estado_comercial_mes() {
    $.ajax({
        type: 'POST',
        url: '/dashboard/estado-comercial-mes',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "periodo": $("#periodo").val()
        },
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
        },
        success: function (d) {
            //console.log(d)
            datas = [];
            labels = [];
            backgroundColor = [];
            for (var i = 0; i < d.length; i++) {
                dato = {
                    label: d[i].nombre,
                    backgroundColor: getRandomColor(),
                    borderColor: getRandomColor(),
                    data: [d[i].total],
                    fill: false,
                }
                datas.push(d[i].total);
                labels.push(d[i].nombre + ': ' + d[i].total);
                backgroundColor.push(getRandomColor());
            }
            //console.log(datas)
            var ctx = document.getElementById('estado_comercial_mes').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Estado Comercial',
                        backgroundColor: backgroundColor,
                        borderColor: backgroundColor,
                        data: datas,
                        fill: false,
                    }]
                },

                // Configuration options go here
                options: {
                    tooltips: {
                        mode: 'point',
                        intersect: false,
                        position: 'nearest',
                        bodySpacing: 4,
                    },

                }
            });
        },
        error: function (xhr) {
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });
}

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    //  var color = "#";

    /* for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }*/
    var res = hex[Math.floor(Math.random() * 32)]

    return res;
}

function editar(cod) {
    var data = cod;
    $.ajax({
        type: 'POST',
        url: '/edit_nsecundario',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id": data
        },
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
        },
        success: function (d) {
            if (d['msg'] == 'error') {
                toastr.error(d['data']);
            } else {
                $("#custom-tabs-one-profile-tab").removeClass('active');
                $("#custom-tabs-one-home-tab").addClass('active');

                $("#custom-tabs-one-profile").removeClass('show active');
                $("#custom-tabs-one-home").addClass('show active');
                toastr.success(d['info']);
                clear_data();
                $('#txt_nombre').val(d['data']['nombre']);
                $('#cmb_nprimario').val(d['data']['nprimario_id']).trigger('change');
                $('#hide_id').val(d['data']['id']);
                var est = (d['data']['estado'] == 'A' ? true : false);
                $("#chk_estado").prop('checked', est);
            }
        },
        error: function (xhr) {
            toastr.error('Error: '.xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });
}


function cargardashboard() {

    var sede = ($('#sede option:selected').val() == undefined ? 0 : $('#sede option:selected').val());
    var campana = ($('#campana option:selected').val() == undefined ? 0 : $('#campana option:selected').val());
    var periodo = ($('#periodo option:selected').val() == undefined ? 0 : $('#periodo option:selected').val());
    var nprimario = ($('#nprimario option:selected').val() == undefined ? 0 : $('#nprimario option:selected').val());

    $.ajax({
        type: 'POST',
        url: '/dashboard/detalle',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "periodo": periodo, "sede": sede, "campana": campana, "nprimario": nprimario
        },
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
        },
        success: function (d) {
            $('#dashboard').html('');
            $('#dashboard').html(d);

            fuente_contacto(1,'myChart');
            fuente_contacto(2,'myChartCli');
            oferta_academica();
            oferta_academica_mes();
            estado_comercial();
            estado_comercial_mes();
        },
        error: function (xhr) {
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });
}



