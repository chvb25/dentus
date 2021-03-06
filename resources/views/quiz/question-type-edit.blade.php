@extends('layouts.master')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Question Type</h4>

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
                <form class="form-horizontal" action="{{ url('update-qt') }}/{{ $qt->id }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="card-body">
                        <h4 class="card-title">Information</h4>
                        <div class="form-group row justify-content-start">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Nombre</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" value="{{ $qt->name }}" required>
                            </div>
                        </div>
                        <div class="form-group row justify-content-start">
                            <label for="language" class="col-sm-2 text-right control-label col-form-label label-required">Idioma</label>
                            <div class="col-sm-5">
                                <select name="language" class="select2 form-control custom-select select2-hidden-accessible">
                                    <option value="en" @if($qt->language == "en") {{ 'selected' }} @endif>English</option>
                                    <option value="es" @if($qt->language == "es") {{ 'selected' }} @endif>Español</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <div class="form-group row justify-content-center">
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Guardar</button>
                                    <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/question-type'"><i class="mdi mdi-undo"></i> Cancelar</button>
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
