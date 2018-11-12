@extends('master')
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
                <form class="form-horizontal" action="{{ url('save-q') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">Information</h4>
                        <div class="form-group row justify-content-start">
                            <label for="question" class="col-sm-1 text-right control-label col-form-label label-required">Question</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="question" placeholder="Question Here" value="{{ old('question') }}" required>
                            </div>
                        </div>
                        <div class="form-group row justify-content-start">
                            <label for="question_type" class="col-sm-1 text-right control-label col-form-label label-required">Question Type</label>
                            <div class="col-sm-5">
                                <select name="question_type" class="select2 form-control custom-select select2-hidden-accessible" required>
                                    <option value="0" disabled selected hidden>Select a type</option>
                                    @foreach( $qt as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <div class="form-group row justify-content-center">
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Save</button>
                                    <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/questions'"><i class="mdi mdi-undo"></i> Cancel</button>
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