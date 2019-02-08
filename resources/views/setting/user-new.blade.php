@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Registrar usuario</h3>
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
                    <form class="form-horizontal" action="{{ url('/save-user') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title">Datos</h4>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Nombre</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="address" class="col-sm-2 text-right control-label col-form-label label-required">Nombre de Usuario</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" name="username" class="form-control" cols="30" rows="5" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="symbol" class="col-sm-2 text-right control-label col-form-label label-required">Contraseña</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="new-password" minlength="6" value="" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="tax" class="col-sm-2 text-right control-label col-form-label label-required">Confirmar Contraseña</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="confirm-password" minlength="6" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Guardar</button>
                                        <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/main'"><i class="mdi mdi-undo"></i> Cancelar</button>
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
