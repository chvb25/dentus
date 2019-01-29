@extends('master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Procedure</h4>

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
                    <form class="form-horizontal" action="{{ url('update-procedures') }}/{{ $procedure->id }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <h4 class="card-title">Information</h4>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-1 text-right control-label col-form-label label-required">Name</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" placeholder="Name Here" value="{{ $procedure->name }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="language" class="col-sm-1 text-right control-label col-form-label label-required">Cost</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cost" placeholder="0.00" value="{{ $procedure->cost }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">$</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                    <label for="type" class="col-sm-1 text-right control-label col-form-label label-required">Type</label>
                                    <div class="col-sm-5">
                                        <select name="types" class="select2 form-control custom-select select2-hidden-accessible">                                            
                                            <option value="P" {{ ($procedure->type == "P") ? 'selected' : '' }}>Piece</option>
                                            <option value="F" {{ ($procedure->type == "F") ? 'selected' : '' }}>Full tooth</option>                                        
                                        </select>
                                    </div>     
                                </div>
                                <div class="form-group row justify-content-start">
                                    <label for="name" class="col-sm-1 text-right control-label col-form-label label-required">Color</label>
                                    <div class="col-sm-5">                                    
                                        <input type="text" id="hue" name="color" class="form-control demo minicolors-input" data-control="hue" value="{{ $procedure->color }}" size="7">                                                                        
                                    </div>
                                </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Save</button>
                                        <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/procedures'"><i class="mdi mdi-undo"></i> Cancel</button>
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