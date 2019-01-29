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
                <h4 class="page-title">Treatments</h4>

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
                        <h5>List of Treatments</h5>
                        <div class="table-responsive">

                            <!--<div class="add-button" name="question-type"><i class="fas fa-plus"></i></div>-->
                            <table id="zero_config" class="table table-striped table-hover table-bordered dataTable" role="grid" aria-describedby="zero_config_info" name="treatments">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="zero_config" aria-sort="ascending">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Patients</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Date</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Quote</th>                                    
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Cost</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Status</th>
                                    <th>-</th>                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php $index = 1; ?>
                                @foreach($data as $rows)
                                    <tr>
                                        <th role="row"><?php echo $index; ?></th>
                                        <td>{{ $rows->patient->completeName }}</td>
                                        <td>{{ date('d/m/Y', strtotime($rows->date)) }}</td>
                                        <td>{{ $rows->quote_id }}</td>                                        
                                        <td>{{ $rows->final_price }}</td>
                                        <td class="text-{{ ($rows->status == 0) ? 'warning' : (($rows->status == 1) ? 'success' : 'info') }}">{{ ($rows->status == 0) ? 'Not started' : (($rows->status == 1) ? 'Completed' : 'In process') }}</td>
                                        <td class="actions">
                                            <button type="submit" class="btn btn-cyan" data-itemid="{{ $rows->id }}" onclick="searchDetail(this)"><i class="fa fa-eye"></i> View</button>
                                            <button type="submit" class="btn btn-primary delete" onclick="location.href='treatments-edit/{{ $rows->id }}'" {{ ($rows->status == 1) ? 'disabled' :'' }}>
                                                <i class="fas fa-sync"></i> Update
                                            </button>
                                            <button type="submit" class="btn btn-danger delete" data-toggle="modal" data-target="#delete_item" data-itemid="/treatments/delete/{{ $rows->id }}" {{ ($rows->status == 1) ? 'disabled' :'' }}>
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
    <script>
        function searchDetail(element){
            var id = $(element).data('itemid');
            $.ajax({
                url: '{{ route('viewDetails') }}'+'?query='+id,
                type: 'get',                                        
                dataType: 'json',
                success: function (data) {                    
                    showDetail(element, data);
                },
                fail: function(xhr, textStatus, errorThrown){
                    alert('request failed');
                }
            });            
        }
    </script>
@endsection
