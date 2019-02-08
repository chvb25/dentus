@extends('layouts.master')
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
                    <form class="form-horizontal" action="{{ url('/update-user') }}/{{ $user->id }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <input type="hidden" name="profile" value="1">
                        <input type="hidden" name="status" value="1">
                        <div class="card-body">
                            <h4 class="card-title">Datos del usuario</h4>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Nombre</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="address" class="col-sm-2 text-right control-label col-form-label label-required">Nombre de Usuario</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" name="username" class="form-control" cols="30" rows="5" value="{{ $user->username }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="currency" class="col-sm-2 text-right control-label col-form-label">Contraseña Actual</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="current_password" maxlength="191" value="" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="symbol" class="col-sm-2 text-right control-label col-form-label">Nueva Contraseña</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="new_password" id="new_password" minlength="5" value="" >
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="tax" class="col-sm-2 text-right control-label col-form-label">Confirmar Contraseña</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="confirm_password" minlength="5" id="confirm_password" value="" >
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

@section('custom_scripts')
<script>

$("form").submit(function(e){
    var new_password = $('#new_password').val();
    var confirm_password = $('#confirm_password').val();
    if(new_password === confirm_password)
        console.log('password equals');
    else{
        toastr.warning('No se ha confirmado la contraseña corectamente.','¡Error!');
        e.preventDefault();
    }
});
</script>
@endsection
