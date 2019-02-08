@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Cotización</h3>
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
                    <form class="form-horizontal" action="{{ url('save-quotes') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title">Información</h4>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Paciente</label>
                                <div class="col-sm-5">
                                    <input type="hidden" name="patient_id" id="patient_id" value="0">
                                    <input type="text" data-provide="typeahead" class="form-control typeahead" name="name" placeholder="Buscar Paciente..." autocomplete="off" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="date" class="col-sm-2 text-right control-label col-form-label label-required">Fecha</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="date" placeholder="dd/mm/yyyy" value="{{ old('date') }}" id="datepicker">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="procedures" class="col-sm-2 text-right control-label col-form-label label-required">Procedimientos</label>
                                <div class="col-sm-5">
                                    <select name="procedures" id="procedures" class="select2 form-control custom-select select2-hidden-accessible">
                                        <option value="0" disabled selected hidden>Seleccione un Procedimiento - Precio</option>
                                        @foreach( $procedures as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} - {{ (Session::exists('settings')) ? Session::get('settings')->symbol : '$' }}&nbsp;{{ $item->cost }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" name="add" id="add" class="btn btn-default"><i class="fa fa-plus"></i> Agregar</button>
                            </div>
                            <div class="form-group row justify-content-start">
                                <table class="table"  id="dynamic_field">
                                    <thead><tr><th scope="col">Nombre</th><th scope="col">Precio</th><th scope="col">Acción</th></tr></thead>
                                    <tbody id="dynamic_field"></tbody>
                                </table>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="subtotal" class="col-sm-2 text-right control-label col-form-label">SubTotal</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="subtotal" id="subtotal" value="{{ (is_nan(old('subtotal'))) ? 0.00 : old('subtotal') }}" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">{{ (Session::exists('settings')) ? Session::get('settings')->symbol : '$' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="discount" class="col-sm-2 text-right control-label col-form-label">Descuento</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="discount" name="discount" value="{{ (is_nan(old('discount'))) ? 0.00 : old('discount')  }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">{{ (Session::exists('settings')) ? Session::get('settings')->symbol : '$' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="total" class="col-sm-2 text-right control-label col-form-label">Total</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="total" name="total" value="{{ (is_nan(old('total'))) ? 0.00 : old('total') }}" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">{{ (Session::exists('settings')) ? Session::get('settings')->symbol : '$' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Guardar</button>
                                        <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/quotes'"><i class="mdi mdi-undo"></i> Cancelar</button>
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


@section('custom_scripts')
    <link href="{{ asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }} "></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script type="text/javascript">

        jQuery('#datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            language: "es"
        });

        $(document).ready(function(){
            $('#subtotal').val('0.00');
            $('#discount').val('0.00');
            $('#total').val('0.00');

            $('#add').click(function(){
                var e = document.getElementById("procedures");
                var strUser = e.options[e.selectedIndex].text;
                var name = strUser.split("-")[0].trim();
                var cost = strUser.split("-")[1].trim();
                var number = cost.substring(2);
                $('#dynamic_field').append('<tr id="row'+e.options[e.selectedIndex].value
                    +'"><td>'+name+'</td><td>'+cost+'</td><td><div class="btn_remove" id="'
                    +e.options[e.selectedIndex].value+'"><i class="mdi mdi-close text-danger"></i><input type="hidden" name="dynamic[]" value="'
                    +e.options[e.selectedIndex].value+'-'+number+'"></div></td></tr>');
                $('#procedures option[value="'+e.options[e.selectedIndex].value+'"]').remove();
                var subtotal = parseFloat($('#subtotal').val()) + parseFloat(number);
                $('#subtotal').val( parseFloat(subtotal).toFixed(2) );

                calcTotal();
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                var row = $('#row'+button_id+'')[0];
                var cost = row.children[1].innerText;
                $('#subtotal').val((parseFloat($('#subtotal').val()) - parseFloat(cost)).toFixed(2));
                $('#row'+button_id+'').remove();
                calcTotal();

                $('#procedures').append('<option value="'+button_id+'">'
                    +row.children[0].innerText+' - '+row.children[1].innerText+'</option>');
            });

            $(document).on('change', '#discount', function () {
                calcTotal();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        function calcTotal(){
            if (isNaN($('#subtotal').val()) || $('#subtotal').val() == '0' ){
                $('#discount').val('0.00');
                $('#total').val('0.00');
            }else {
                var total = parseFloat($('#subtotal').val()) - parseFloat($('#discount').val());
                $('#total').val(parseFloat(total).toFixed(2));
            }
        }


        var bloodhound = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '{{ route('patientList') }}'+'?query=%query%',
                    wildcard: '%query%'
                },
            });
        $('input.typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 2
        },{ name: 'patients',
            source: bloodhound,
            display: function(data) {
                return data.completeName //Input value to be set when you select a suggestion.
            },
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item">No se encontraron datos.</div></div>'
                ],
                header: [
                    '<div class="list-group search-results-dropdown">'
                ],
                suggestion: function(data) {
                return '<div style="font-weight:normal; margin-top:-10px ! important;" class="list-group-item patient-list-item">' + data.completeName + '</div></div>'
                }
            }
        });

        $('.typeahead').on('typeahead:selected', function(evt, item) {
            $('#patient_id').val(item.id);
            $('input.typeahead').val(item.completeName);
        });

    </script>
@endsection
