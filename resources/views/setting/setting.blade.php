@extends('master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Configuración</h3>
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
                    <form class="form-horizontal" action="{{ url('save-setting') }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <h4 class="card-title">Datos</h4>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Nombre de la Clínica</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="{{ $setting->clinic_name }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="address" class="col-sm-2 text-right control-label col-form-label label-required">Dirección de la Clínica</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <textarea name="address" class="form-control" cols="30" rows="5" required>{{ $setting->clinic_address }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="currency" class="col-sm-2 text-right control-label col-form-label label-required">Moneda</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="currency" maxlength="4" value="{{ $setting->currency }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="symbol" class="col-sm-2 text-right control-label col-form-label label-required">Abreviación</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="symbol" value="{{ $setting->symbol }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="tax" class="col-sm-2 text-right control-label col-form-label label-required">Impuesto</label>
                                <div class="col-sm-5">
                                    <input type="number" min="0" class="form-control" name="tax" value="{{ $setting->tax }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Guardar</button>
                                        <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/'"><i class="mdi mdi-undo"></i> Cancelar</button>
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
