@extends('master')
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
            <div class="col-md-12">
                <div class="card">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#treatment" role="tab" aria-selected="true"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Tratamiento</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#revision" role="tab" aria-selected="false"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Revisión</span></a> </li>
                    </ul>
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane p-20 active show" id="treatment" role="tabpanel">
                            <form class="form-horizontal" action="{{ url('save-appointments_t') }}" method="post">
                                @csrf
                                <div class="card-body">
                                    <h4 class="card-title">Cita para Tratamiento</h4>
                                    <div class="form-group row justify-content-start">
                                        <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Paciente</label>
                                        <div class="col-sm-5">
                                            <input type="hidden" name="treatment_id" id="treatment_id" value="0">
                                            <input type="text" data-provide="typeahead" class="form-control typeahead" name="name_t" id="treatmentsList" placeholder="Buscar Pacientes..." autocomplete="off" value="{{ old('name_t') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-start">
                                        <label for="date" class="col-sm-2 text-right control-label col-form-label label-required">Fecha</label>
                                        <div class="col-sm-5">
                                            <div class="input-group date">
                                                <input type="text" class="form-control" name="date_t" placeholder="dd/mm/yyyy" value="{{ old('date_t') }}" id="datepicker_t" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-start">
                                        <label for="date" class="col-sm-2 text-right control-label col-form-label label-required">Hora de Inicio</label>
                                        <div class="col-sm-5">
                                            <div class="input-group clockpicker startTime">
                                                <input type="text" class="form-control" name="startTime_t" placeholder="HH:mm" value="{{ old('startTime_t') }}" id="startTime" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-start">
                                        <label for="date" class="col-sm-2 text-right control-label col-form-label label-required">Hora Fin</label>
                                        <div class="col-sm-5">
                                            <div class="input-group clockpicker endTime">
                                                <input type="text" class="form-control" name="endTime_t" placeholder="HH:mm" value="{{ old('endTime_t') }}" id="endTime" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-start">
                                        <label for="procedures" class="col-sm-2 text-right control-label col-form-label label-required">Procedimientos</label>
                                        <div class="col-sm-5">
                                            <select name="procedures" id="procedures" class="select2 form-control custom-select select2-hidden-accessible" required>
                                                <option value="0" disabled selected hidden>Seleccione un procedimiento</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <div class="form-group row justify-content-center">
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Guardar</button>
                                                <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/appointments'"><i class="mdi mdi-undo"></i> Cancelar</button>                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane p-20" id="revision" role="tabpanel">
                            <form class="form-horizontal" action="{{ url('save-appointments') }}" method="post">
                                @csrf
                                <div class="card-body">
                                    <h4 class="card-title">Cita para Revisión</h4>
                                    <div class="form-group row justify-content-start">
                                        <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Paciente</label>
                                        <div class="col-sm-5">
                                            <input type="hidden" name="patient_id" id="patient_id" value="0">
                                            <input type="text" data-provide="typeahead" class="form-control typeahead" id="patientsList" name="name" placeholder="Buscar Pacientes..." autocomplete="off" value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-start">
                                        <label for="date" class="col-sm-2 text-right control-label col-form-label label-required">Fecha</label>
                                        <div class="col-sm-5">
                                            <div class="input-group date">
                                                <input type="text" class="form-control" name="date" placeholder="dd/mm/yyyy" value="{{ old('date') }}" id="datepicker" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-start">
                                        <label for="date" class="col-sm-2 text-right control-label col-form-label label-required">Hora de Inicio</label>
                                        <div class="col-sm-5">
                                            <div class="input-group clockpicker startTime">
                                                <input type="text" class="form-control" name="startTime" placeholder="HH:mm" value="{{ old('startTime') }}" id="startTime" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-start">
                                        <label for="date" class="col-sm-2 text-right control-label col-form-label label-required">Hora Fin</label>
                                        <div class="col-sm-5">
                                            <div class="input-group clockpicker endTime">
                                                <input type="text" class="form-control" name="endTime" placeholder="HH:mm" value="{{ old('endTime') }}" id="endTime" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <div class="form-group row justify-content-center">
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Guardar</button>
                                                <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/appointments'"><i class="mdi mdi-undo"></i> Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('custom_scripts')
    <link href="{{ asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }} "></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <link href="{{ asset('assets/extra-libs/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet"/>
    <script src="{{ asset('assets/extra-libs/clockpicker/bootstrap-clockpicker.min.js') }} "></script>

    <link rel="stylesheet" href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}">
    <script src=" {{ asset('assets/libs/toastr/build/toastr.min.js') }} "></script>

    <script type="text/javascript">

        $('#datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            startDate: '+0d',
            orientation:'bottom',
            todayBtn: "linked",
            language:"es"
        });

        $('#datepicker_t').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            startDate: '+0d',
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
                    toastr.warning('The end time must be later than the start time!');
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
                    toastr.warning('The end time must be later than the start time!');
                    $('#endTime').val('');
                    $('#endTime').focus();
                }
            }
        });

        var bloodhound_treatments = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '{{ route('treatmentList') }}'+'?query=%query%',
                    wildcard: '%query%'
                },
            });
        $('#treatmentsList').typeahead({
            hint: true,
            highlight: true,
            minLength: 2
        },{ name: 'patients',
            source: bloodhound_treatments,
            display: function(data) {
                return data.completeName //Input value to be set when you select a suggestion.
            },
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item">No se encontraron datos.</div></div>'
                ],
                header: [
                    '<div class="list-group search-results-dropdown">'
                ],
                suggestion: function(data) {
                return '<div style="font-weight:normal; margin-top:-10px ! important;" class="list-group-item patient-list-item">' + data.completeName + '</div></div>'
                }
            }
        });

        var bloodhound_patients = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '{{ route('patientList') }}'+'?query=%query%',
                    wildcard: '%query%'
                },
            });
        $('#patientsList').typeahead({
            hint: true,
            highlight: true,
            minLength: 2
        },{ name: 'patients',
            source: bloodhound_patients,
            display: function(data) {
                return data.completeName //Input value to be set when you select a suggestion.
            },
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                ],
                header: [
                    '<div class="list-group search-results-dropdown">'
                ],
                suggestion: function(data) {
                return '<div style="font-weight:normal; margin-top:-10px ! important;" class="list-group-item patient-list-item">' + data.completeName + '</div></div>'
                }
            }
        });

        $('.typeahead').on('typeahead:selected', function(evt, item) {
            if(evt.target.id == 'patientsList')
                $('#patient_id').val(item.id);
            else{
                $('#treatment_id').val(item.id);
                $('#procedures').find('option').not(':first').remove();
                $.ajax({
                    url: '{{ route('treatmentDetails') }}'+'?query='+item.id,
                    type: 'get',
                    dataType: 'json',
                    success: function (response) {
                        var len = 0;
                        if(response != null){
                            len = response.length;
                        }

                        if(len > 0){
                        // Read data and create <option >
                            for(var i=0; i<len; i++){
                                var id = response[i].id;
                                var name = response[i].name;
                                var treatments_id = response[i].treatments_id;

                                var option = "<option value='"+id+"-"+treatments_id+"'>"+name+"</option>";
                                $("#procedures").append(option);
                            }
                        }
                    },
                    fail: function(xhr, textStatus, errorThrown){
                        alert('request failed');
                    }
                });
            }
            $('#'+evt.target.id).val(item.completeName);
        });

    </script>
@endsection
