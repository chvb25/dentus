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
                <h3 class="page-title">Procesos</h3>
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
                        <h4>Listado de Procesos</h4>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-hover table-bordered dataTable" role="grid" aria-describedby="zero_config_info" name="procedures">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="zero_config" aria-sort="ascending">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Nombre</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Precio</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Tipo</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Color</th>
                                    <th>-</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $index = 1; ?>
                                @foreach($data as $rows)
                                    <tr>
                                        <th role="row"><?php echo $index; ?></th>
                                        <td>{{ $rows->name }}</td>
                                        <td>{{ (Session::exists('settings')) ? Session::get('settings')->symbol : '$' }}&nbsp;{{ $rows->cost }}</td>
                                        <td>{{ ($rows->type == "P") ? 'Cara' : 'Pieza entera' }}</td>
                                        <td><div style="height: 35px; background-color:{{ $rows->color }};"></div></td>
                                        <td class="actions">
                                            <button type="submit" class="btn btn-primary" onclick="location.href='procedures-edit/{{ $rows->id }}'">
                                                <i class="fas fa-sync"></i> Modificar
                                            </button>
                                            <button type="submit" class="btn btn-danger delete" data-toggle="modal" data-target="#delete_item" data-itemid="/procedures/delete/{{ $rows->id }}">
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
@endsection
