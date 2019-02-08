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
                <h3 class="page-title">Ingresos</h3>
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
                        <h4>Listado de Ingreso por Caja</h4>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-hover table-bordered dataTable" role="grid" aria-describedby="zero_config_info" name="procedures">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="zero_config" aria-sort="ascending">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Paciente</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">Fecha</th>
                                    <th class="sorting" tabindex="0" aria-controls="zero_config">CxC - Nro. Cuota</th>
                                    <th class="sorting text-right" tabindex="0" aria-controls="zero_config">Monto</th>
                                    <th>-</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $index = 1; ?>
                                @foreach($data as $rows)
                                    <tr>
                                        <th role="row"><?php echo $index; ?></th>
                                        <td>{{ $rows->attention->completeName }}</td>
                                        <td>{{ date('d/m/Y', strtotime($rows->created_at)) }}</td>
                                        <td>{{ ($rows->receivable_id == 0) ? '-' : $rows->receivable_id }}</td>
                                        <td class="text-right">{{ $rows->amount }} {{ (Session::exists('settings')) ? Session::get('settings')->symbol : '$' }}</td>
                                        <td class="actions">
                                            <button type="submit" class="btn btn-primary" onclick="location.href='cash-edit/{{ $rows->id }}'">
                                                <i class="fas fa-sync"></i> Modificar
                                            </button>
                                            <button type="submit" class="btn btn-danger delete" data-toggle="modal" data-target="#delete_item" data-itemid="/cash/delete/{{ $rows->id }}">
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
