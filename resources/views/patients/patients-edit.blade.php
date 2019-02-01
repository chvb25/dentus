@extends('master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Pacientes</h3>
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
                    <form class="form-horizontal" action="{{ url('update-patients') }}/{{ $pts->id }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <h4 class="card-title">Información</h4>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Nombre</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="{{ $pts->name }}" required>
                                </div>
                                <label for="lastName" class="col-sm-2 text-right control-label col-form-label label-required">Apellido</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="lastName" value="{{ $pts->lastName }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="dni" class="col-sm-2 text-right control-label col-form-label label-required">DNI</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="dni" value="{{ $pts->dni }}" required>
                                </div>
                                <label for="birthDate" class="col-sm-2 text-right control-label col-form-label label-required">Fecha de Nacimiento</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="birthDate" placeholder="dd/mm/yyyy" value="{{ date('d/m/Y', strtotime($pts->birthDate))  }}" id="datepicker">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="nationality" class="col-sm-2 text-right control-label col-form-label label-required">Nacionalidad</label>
                                <div class="col-sm-5">
                                    <select name="nationality" id="question_type" class="select2 form-control custom-select select2-hidden-accessible" required>
                                        @foreach( $nat as $item)
                                            <option value="{{ $item->id }}" {{ ( $item->id == $pts->nationality) ? 'selected' : '' }}> {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="civilState" class="col-sm-2 text-right control-label col-form-label label-required">Estado Civil</label>
                                <div class="col-sm-5">
                                    <select name="civilState" id="question_type" class="select2 form-control custom-select select2-hidden-accessible" required>
                                        <option value="1" {{ ( $pts->civilState == 1) ? 'selected' : '' }}>Single</option>
                                        <option value="2" {{ ( $pts->civilState == 2) ? 'selected' : '' }}>Married</option>
                                        <option value="3" {{ ( $pts->civilState == 3) ? 'selected' : '' }}>Divorced</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="address" class="col-sm-2 text-right control-label col-form-label label-required">Dirección</label>
                                <div class="col-sm-5">
                                    <textarea name="address" class="form-control" cols="30" rows="5" required>{{ $pts->address }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="profession" class="col-sm-2 text-right control-label col-form-label label-required">Profesión</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="profession" value="{{ $pts->profession }}" required>
                                </div>
                                <label for="jobTitle" class="col-sm-2 text-right control-label col-form-label label-required">Puesto Laboral</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="jobTitle" value="{{ $pts->jobTitle }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="jobAddress" class="col-sm-2 text-right control-label col-form-label label-required">Dirección Laboral</label>
                                <div class="col-sm-5">
                                    <textarea name="jobAddress" class="form-control" cols="30" rows="5" required>{{ $pts->jobAddress }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Guardar</button>
                                        <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/patients'"><i class="mdi mdi-undo"></i> Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')

    <link href="{{ asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }} "></script>
    <script type="text/javascript">
        jQuery('#datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy'
        });
    </script>
@endsection
