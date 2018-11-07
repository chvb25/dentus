@extends('master')
@include('libs.tables_styles')
@include('libs.tables_script')
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>List of Questions Types</h5>
                    <div class="table-responsive">

                            <!--<div class="add-button" name="question-type"><i class="fas fa-plus"></i></div>-->
                            <table id="zero_config" class="table table-striped table-hover table-bordered dataTable" role="grid" aria-describedby="zero_config_info" name="question-type">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="zero_config" aria-sort="ascending">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $rows)
                                    <tr>
                                        <th role="row">1</th>
                                        <td>{{ $rows->name }}</td>
                                        <td>
                                            <form action="/question-type/{{ $task->id }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection
