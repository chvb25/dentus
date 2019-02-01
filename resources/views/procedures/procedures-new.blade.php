@extends('master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Procedimiento</h3>
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
                    <form class="form-horizontal" action="{{ url('save-procedures') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title">Información</h4>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Nombre</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="language" class="col-sm-2 text-right control-label col-form-label label-required">Precio</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cost" placeholder="0.00" value="{{ old('cost') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">$</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="types" class="col-sm-2 text-right control-label col-form-label label-required">Tipo</label>
                                <div class="col-sm-5">
                                    <select name="type" class="select2 form-control custom-select select2-hidden-accessible">
                                        <option value="0" disabled selected hidden>Seleccione un Tipo</option>
                                        <option value="P">Cara</option>
                                        <option value="F">Pieza entera</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Color</label>
                                <div class="col-sm-5">
                                    <input type="text" id="hue" class="form-control demo minicolors-input" data-control="hue" value="#ffffff" size="7">
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Guardar</button>
                                        <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/procedures'"><i class="mdi mdi-undo"></i> Cancelar</button>
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/jquery-minicolors/jquery.minicolors.css') }}">
<script src="{{ asset('assets/libs/jquery-asColor/dist/jquery-asColor.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-asGradient/dist/jquery-asGradient.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-minicolors/jquery.minicolors.min.js') }}"></script>
<script>
    $('#hue').minicolors({
        position: 'bottom right',
        theme: 'bootstrap'
    });
</script>
@endsection
