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
                        <h5>Listado Cuentas por Cobrar</h5>
                        <div class="table-responsive">
                            <table id="groupTable" class="table table-hover table-bordered dataTable" role="grid" aria-describedby="groupTable_info" name="">
                                <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="groupTable">Paciente</th>
                                    <th class="sorting" tabindex="0" aria-controls="groupTable">Fecha</th>
                                    <th class="sorting text-right" tabindex="0" aria-controls="groupTable">Retraso (días)&nbsp;</th>
                                    <th class="sorting text-right" tabindex="0" aria-controls="groupTable">Monto&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $rows)
                                    <tr>
                                        <td>{{ $rows->receivable->attention->completeName }}|{{ $rows->receivable_id }}|{{ $rows->receivable->amount }}|{{ (Session::exists('settings')) ? Session::get('settings')->symbol : '$' }}</td>
                                        <td class="text-center">{{ date('d/m/Y', strtotime($rows->date)) }}</td>
                                        <td class="text-danger text-right">{{ (\Carbon\Carbon::now() > \Carbon\Carbon::parse($rows->date) && $rows->status == 0) ? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($rows->date)): '0' }}</td>
                                        <td class="text-right">{{ (Session::exists('settings')) ? Session::get('settings')->symbol : '$' }} {{ $rows->amount }}</td>
                                        <td class="actions" style="width: 88%">
                                            @if ($rows->status == 1)
                                                <span class="text-success"><i class="fas fa-check"></i> Pagado</span>
                                            @else
                                                <button type="submit" class="btn btn-success"  onclick="location.href='cash/new/{{  $rows->receivable->attention->id }}/{{ $rows->receivable_id }}/{{ $rows->id }}'">
                                                    <i class="far fa-money-bill-alt"></i> Pagar
                                                </button>
                                            @endif
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

@endsection
