@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Citas</h3>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-7">
                <div class="card">
                    <div class="card-body" style="display:inline !important;">
                        <h4>Agenda <span id="newDate">today</span> <button type="button" class="btn btn-cyan" style="float:right;" onclick="addAppointment()"><i class="fas fa-plus"></i> Nuevo</button></h4>
                    </div>
                    <ul class="list-style-none" id="appointment_list">
                    </ul>
                </div>
            </div>
            <div class="col-5">
                <div class="card">
                    <div class="card-body"><div id="calendar"></div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reschedule_item" tabindex="-1" role="dialog" aria-labelledby="title" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span><i class="far fa-clock"></i>&nbsp;&nbsp;</span> <h5 class="modal-title" id="modalTitle">Reprogramar - Proceso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="POST" class="reschedule-appointment" action="">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group row justify-content-start">
                                <label for="date" class="col-3 text-right control-label col-form-label label-required">Fecha</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="date" placeholder="dd/mm/yyyy" value="" id="datepicker" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="date" class="col-3 text-right control-label col-form-label label-required">Hora de inicio</label>
                                <div class="col-sm-5">
                                    <div class="input-group clockpicker startTime">
                                        <input type="text" class="form-control" name="startTime" placeholder="HH:mm" value="" id="startTime" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="date" class="col-3 text-right control-label col-form-label label-required">Hora fin</label>
                                <div class="col-sm-5">
                                    <div class="input-group clockpicker endTime">
                                        <input type="text" class="form-control" name="endTime" placeholder="HH:mm" value="" id="endTime" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Confirmar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true"><b>X</b></span> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancel_appointment" tabindex="-1" role="dialog" aria-labelledby="title" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Cancelar Cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Está seguro que desea cancelar la cita?
                </div>
                <div class="modal-footer">
                    <form method="POST" class="cancel_appointment" action="">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Confirmar</button>
                    </form>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true"><b>X</b></span> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
@endsection
@section('custom_scripts')

<link href="{{ asset('assets/extra-libs/calendar/calendar.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet"/>

<script src="{{ asset('assets/libs/moment/min/moment.min.js') }} "></script>
<script src="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.js') }} "></script>

<link href="{{ asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
<script src="{{ asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }} "></script>
<link href="{{ asset('assets/extra-libs/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet"/>
<script src="{{ asset('assets/extra-libs/clockpicker/bootstrap-clockpicker.min.js') }} "></script>
<script src="{{ asset('assets/libs/fullcalendar/dist/locale/es.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>


<script type="text/javascript">

$(function () {
    var d = new Date();
    d.setDate(d.getDate() - 1);
    updateDate(d);
    $('#calendar').fullCalendar({
        lang: 'es',
        defaultView: 'month',
        handleWindowResize: true,
        selectable: true,
        dayClick: function(date) {
            updateDate(date._d);
        }
    });

    $('.fc-today-button').click(function(e){
        d = new Date();
        $('#calendar').fullCalendar('gotoDate', d);
        d.setDate(d.getDate() - 1);
        updateDate(d);
    });

    $('#datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        startDate: '+1d',
        orientation:'bottom',
        todayBtn: "linked",
        language: "es"
    });

    $('.startTime').clockpicker({
        autoclose: true,
        default: 'now',
        afterDone: function(){
            var start = new Date (new Date().toDateString() + ' ' + $('#startTime').val());
            var end = new Date (new Date().toDateString() + ' ' + ($('#endTime').val() == '' ? '23:59': $('#endTime').val()));
            if(end < start){
                toastr.warning('La hora fin debe ser mayor a la inicial.');
                $('#startTime').val('');
                $('#startTime').focus();
            }
        }
    });

    $('.endTime').clockpicker({
        autoclose: true,
        default: 'now',
        afterDone: function(){
            var start = new Date (new Date().toDateString() + ' ' + $('#startTime').val());
            var end = new Date (new Date().toDateString() + ' ' + $('#endTime').val());
            if(end < start){
                toastr.warning('La hora fin debe ser mayor a la inicial.');
                $('#endTime').val('');
                $('#endTime').focus();
            }
        }
    });
});

function updateActionForm(element, event){
    var action = $(element).data('itemid');
    var title = $(element).data('itemname');
    $('#modalTitle').text(title);
    $('#datepicker').val('');
    $('#startTime').val('');
    $('#endTime').val('');
    $('form.reschedule-appointment').attr('action', action);
}

function updateActionCancelForm(element, event){
    var action = $(element).data('itemid');
    $('form.cancel_appointment').attr('action', action);
}

function updateDate(newDate){
    newDate.setDate(newDate.getDate() + 1);
    var date = newDate.getFullYear() + "-" + (newDate.getMonth()+1) + "-" + newDate.getDate();
    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    $('#newDate').text(newDate.toLocaleDateString('es', options));
    $.ajax({
        url: '{{ route('appointmentsByDate') }}'+'?query='+date,
        type: 'get',
        dataType: 'json',
        success: function (response) {
            var len = 0;
            if(response != null){
                len = response.length;
            }
            $('.apointments').remove();
            if(len > 0){
            // Read data and create <option >
                for(var i=0; i<len; i++){

                    var id = response[i].id;
                    var patient = response[i].completeName;
                    var procedure = response[i].procedureName;
                    var startTime =  response[i].start_time.substr(0, response[i].start_time.length - 3);
                    var endTime = response[i].end_time.substr(0, response[i].end_time.length - 3);
                    var status = (response[i].status != 0);
                    var path = (status) ? '#' : '/attention/new/'+response[i].id;

                    var row = '<li class="d-flex no-block card-body border-top apointments"><div style="font-size: 0.9rem;">'+
                                    '<a href="'+ path +'" class="m-b-0 font-medium p-0" '+ (status ? 'style="cursor: no-drop;"': '')+'>'+ patient +'</a>'+
                                    '<span class="text-muted">'+ procedure+'</span>'+
                                    '</div>'+
                                '<div class="ml-auto">'+
                                    '<div class="tetx-right">'+
                                        '<h5 class="text-muted m-b-0 text-right">'+startTime+' - '+ endTime+'</h5>'+
                                        '<button type="submit" class="btn btn-outline-dark reschedule-appointment" data-toggle="modal" onclick="updateActionForm(this, event)"'+
                                        'data-target="#reschedule_item" data-itemid="/reschedule-appointments/'+id+'" data-itemName="'+
                                        patient+' - '+ procedure+'" '+ (status ? 'disabled style="cursor: no-drop";' : '') +'><i class="far fa-clock"></i> Reprogramar</button>'+
                                        '<button type="submit" class="btn btn-secondary delete cancel_appointment"  '+ (status ? 'disabled style="cursor: no-drop;' : '') +
                                        ' onclick="updateActionCancelForm(this, event)" data-toggle="modal" data-target="#cancel_appointment" data-itemid="/cancel-appointments/'+id+'"><i class="far fa-calendar-times"></i> Cancelar</button>'+
                                '</div></div></li>';
                    $("#appointment_list").append(row);
                }
            }else{
                var row = '<li class="d-flex no-block card-body border-top apointments"><div style="font-size: 0.9rem;>'+
                                    '<a href="#" class="m-b-0 font-medium p-0">Sin citas</a>'+
                                    '<span class="text-muted"></span>'+
                                    '</div>'+
                                '<div class="ml-auto">'+
                                    '<div class="tetx-right">'+
                                        '<h5 class="text-muted m-b-0"></h5>'+
                                        '<span class="text-muted font-16"></span>'+
                                '</div></div></li>';
                    $("#appointment_list").append(row);
            }
        },
        fail: function(xhr, textStatus, errorThrown){
            alert('request failed');
        }
    });
}

function addAppointment(){
    window.location.pathname = 'appointments/new';
}
</script>
@endsection
