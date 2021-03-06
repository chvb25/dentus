@extends('layouts.master')
@include('libs.tables_styles')
@include('libs.tables_script')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Cotizaciones</h3>
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
                        <h4>Listado de Cotizaciones</h4>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-hover table-bordered dataTable" role="grid" aria-describedby="zero_config_info" name="quotes">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="zero_config" aria-sort="ascending">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Paciente</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Fecha</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Precio Final</th>
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
                                        <td>{{ (Session::exists('settings')) ? Session::get('settings')->symbol : '$' }}&nbsp;{{ $rows->final_price }}</td>
                                        <td class="actions">
                                            <button type="button" class="btn btn-cyan" data-itemid="{{ $rows->id }}" onclick="searchDetail(this)"><i class="fa fa-eye"></i> Detalle</button>
                                            <button type="submit" class="btn btn-primary delete" onclick="location.href='quotes-edit/{{ $rows->id }}'">
                                                <i class="fas fa-sync"></i> Modificar
                                            </button>
                                            <button type="submit" class="btn btn-danger delete" data-toggle="modal" data-target="#delete_item" data-itemid="/quotes/delete/{{ $rows->id }}">
                                                <i class="fa fa-trash"></i> Eliminar
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
                url: '{{ route('quoteDetails') }}'+'?query='+id,
                type: 'get',
                dataType: 'json',
                success: function (data) {
                    showDetail(element, data, false);
                },
                fail: function(xhr, textStatus, errorThrown){
                    alert('request failed');
                }
            });
        }
    </script>
@endsection
