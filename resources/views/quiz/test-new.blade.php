@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Cuestionario</h3>
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
                    <form class="form-horizontal" action="{{ url('save-test') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title">Información</h4>
                            <div class="form-group row justify-content-start">
                                <label for="title" class="col-sm-2 text-right control-label col-form-label label-required">Título</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="description" class="col-sm-2 text-right control-label col-form-label">Descripción</label>
                                <div class="col-sm-5">
                                    <textarea class="form-control" name="description" placeholder="Descripción (opcional)" maxlength="190">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="description" class="col-sm-2 text-right control-label col-form-label"></label>
                                <div class="col-sm-5">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" name="nqt" id="nqt">
                                        <label for="nqt" class="custom-control-label">Registar Preguntas</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Guardar</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" onclick="window.location.pathname =  '/test'"><i class="mdi mdi-undo"></i> Cancelar</button>
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
