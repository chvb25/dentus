@extends('master')

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
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body printableArea">
                    <h3><b>Ingreso</b></h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <address>
                                    <h3> &nbsp;<b class="text-danger">Clinic Name</b></h3>
                                    <p class="text-muted m-l-5">Address
                                    </p>
                                </address>
                            </div>
                            <div class="pull-right text-right">
                                <h3>To,</h3>
                                <h4 class="font-bold">{{ $attention->completeName }}</h4>
                                <p><b>Date :</b> <i class="fa fa-calendar"></i> {{ date('dS M Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Descripción</th>
                                            <th class="text-right">Piezas o caras</th>
                                            <th class="text-right">Precio Unitario</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $index = 1; $subTotal = 0;?>
                                        @foreach ($detail as $item)
                                            <?php $teeth = explode(",", $attention->tooth); ?>
                                            <tr>
                                                <td class="text-center"><?php echo $index; ?></td>
                                                <td>{{ $item->procedure->name }}</td>
                                                <td class="text-right">{{ $attention->tooth }} </td>
                                                <td class="text-right"> {{ number_format((float)($item->price), 2, '.', '') }} </td>
                                                <td class="text-right"> {{ number_format((float)($item->price * sizeof($teeth)), 2, '.', '') }} </td>
                                                <?php $subTotal += ($item->price * sizeof($teeth)); ?>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="pull-right m-t-30 text-right">
                                <p>Sub - Total amount: $<?php echo number_format((float)$subTotal, 2, '.', ''); ?></p>
                                <p>vat (10%) : $<?php $vat = ($subTotal * 0.1); echo number_format((float)$vat, 2, '.', '');  ?> </p>
                                <hr>
                                <h3><b>Total :</b> $<?php $total = $subTotal - $vat; echo(number_format((float)$total, 2, '.', '')); ?></h3>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="text-right">
                                <form action="{{ url('save-cash') }}/{{ $attention->id }}/{{ $receivable }}" method="post">
                                    @csrf
                                    <input type="hidden" name="amount" value="<?php echo(number_format((float)$total, 2, '.', '')); ?>">
                                    <button class="btn btn-danger" type="submit"> Processar pago </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


