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
                <h4 class="page-title">Appointments</h4>

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
                        <h5>List of Appointments</h5>
                        <div class="table-responsive">

                            <!--<div class="add-button" name="question-type"><i class="fas fa-plus"></i></div>-->
                            <table id="zero_config" class="table table-striped table-hover table-bordered dataTable" role="grid" aria-describedby="zero_config_info" name="appointments">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="zero_config" aria-sort="ascending">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Patient</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Procedure</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Date</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Start Time</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">End Time</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Status</th>                                    
                                    <th>-</th>                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php $index = 1; ?>
                                @foreach($data as $rows)
                                    <tr>
                                        <th role="row"><?php echo $index; ?></th>                                        
                                        <td>{{ $rows->completeName }}</td>
                                        <td>{{ $rows->procedureName }}</td>                                                                                
                                        <td>{{ date('d/m/Y', strtotime($rows->date)) }}</td>
                                        <td>{{ $rows->start_time }}</td>
                                        <td>{{ $rows->end_time }}</td>                                        
                                        <td class="text-{{ ($rows->status == 0) ? 'warning' : (($rows->status == 1) ? 'success':'danger') }}" >{{ ($rows->status == 0) ? 'Pending' : (($rows->status == 1) ? 'Served' : 'Canceled') }}</td>                                        
                                        <td class="actions">                                            
                                            <button type="submit" class="btn btn-primary delete" onclick="location.href='appointments-edit/{{ $rows->id }}'" {{ ($rows->status == 1) ? 'disabled' : '' }}>
                                                <i class="fas fa-sync"></i> Update
                                            </button>
                                            <button type="submit" class="btn btn-danger delete" data-toggle="modal" data-target="#delete_item" data-itemid="/appointments/delete/{{ $rows->id }}" {{ ($rows->status == 1) ? 'disabled' : '' }}>
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <?php $index++; ?>
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