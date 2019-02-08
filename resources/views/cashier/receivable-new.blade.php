@extends('layouts.master')

@section('content')
<form id="form-save" class="form-horizontal" action="{{ url('save-receivable') }}/{{ $attention->id }}" method="post">
    @csrf
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Información</h4>
                        <div class="form-group row justify-content-start">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">Paciente</label>
                            <div class="col-sm-5">
                                <label class="text-left control-label col-form-label">{{ $attention->completeName }}</label>
                            </div>
                        </div>
                        <div class="form-group row justify-content-start">
                            <label for="date" class="col-sm-2 text-right control-label col-form-label">Fecha</label>
                            <div class="col-sm-5">
                                <label class="text-left control-label col-form-label">{{ date('d/m/Y', strtotime($attention->date)) }}</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Descripción</th>
                                            <th class="text-center">Pieza o Cara</th>
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
                                    <tfoot>
                                        <tr><td colspan="5" class="text-right"><input type="hidden" name="total" value="<?php echo number_format((float)$subTotal, 2, '.', ''); ?>"> <h4 id="total"><?php echo number_format((float)$subTotal, 2, '.', ''); ?></h4></td></tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <div class="form-group row justify-content-start">
                                <label for="date" class="col-sm-2 text-right control-label col-form-label label-required">Fecha de primer pago</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                        <input type="text" class="form-control verify" name="date" id="datepicker" placeholder="dd/mm/yyyy" value="{{ old('date') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label class="col-sm-2 text-right control-label col-form-label label-required">Periocidad</label>
                                <div class="col-md-5">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input verify" id="periodicity1" name="periodicity" value="w" required>
                                        <label class="custom-control-label" for="periodicity1">Semanal</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input verify" id="periodicity2" name="periodicity" value="d" required>
                                        <label class="custom-control-label" for="periodicity2">Quincenal</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input verify" id="periodicity3" name="periodicity" value="m" required>
                                        <label class="custom-control-label" for="periodicity3">Mensual</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Número de cuotas</label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control verify" min="1" name="quota" id="cuantity" placeholder="1" autocomplete="off" value="{{ old('quota') }}" required>
                                </div>
                                <button type="submit" id="calculate" class="btn btn-default" onclick="generateQuotas(); return false;"><i class="fas fa-balance-scale"></i> Calcular</button>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col" class="text-center">Monto</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="quotas">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <div class="form-group row justify-content-center">
                                <div class="col-sm-2">
                                    <input type="hidden" id="process" value="0">
                                    <button type="submit" id="save" class="btn btn-success" onclick="return verifyQuotas();"><i class="mdi mdi-content-save"></i> Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('custom_scripts')
<link href="{{ asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
<script src="{{ asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }} "></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>
<script>
    $('#datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        startDate: '+0d',
        orientation:'bottom',
        todayBtn: "linked",
        language: "es"
    });

    $('.verify').change(function(){
        $('#process').val(0);
    });
    function generateQuotas(){
        try {
            $('.dynamic-row').remove();
            var cuantity = $('#cuantity').val();
            var firstDate = $('#datepicker').val().split('/');
            var date = new Date(firstDate[2], firstDate[1] - 1, firstDate[0]);
            var periodicity = $('input[name="periodicity"]:checked').val();
            var total = $('#total').text();
            var amount = (total / cuantity).toFixed(2);
            for(i=0; i< cuantity; i++){
                var structure = '<tr class="dynamic-row"><td>'+ (i+1) +'</td><td>#date#</td>'+
                '<td class="text-right">'+amount+'</td><td class="text-danger"><input type="hidden" name="dynamic[]" value="#value#">Sin pagar</td></tr>';
                if(i > 0){
                    switch (periodicity) {
                        case "w":
                            date.setDate(date.getDate() + 7);
                            break;
                        case "d":
                            date.setDate(date.getDate() + 14);
                            break;
                        case "m":
                            date.setMonth(date.getMonth() + 1);
                            break;
                    }
                }
                var quota = structure.replace('#date#', date.toLocaleDateString()).replace('#value#', date.toJSON() + '|' + amount );
                $("#quotas").append(quota);
            }
            $('#process').val(1);
        } catch (error) {
            toastr.error('Debes llenar los parámetros antes de calcular las cuotas.')
        }

    }
    function verifyQuotas(){
        if($('#process').val() == 0){
            toastr.warning('Debes calcular las cuotas primero.');
            return false;
        }
        return true;
    }
</script>

@endsection
