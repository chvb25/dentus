@extends('master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Quotes</h4>

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
                    <form class="form-horizontal" action="{{ url('update-quotes') }}/{{ $quote->id }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <h4 class="card-title">Information</h4>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-1 text-right control-label col-form-label label-required">Patient</label>
                                <div class="col-sm-5">    
                                    <input type="hidden" name="patient_id" id="patient_id" value="{{ $quote->patient_id }}">                                    
                                    <input type="text" data-provide="typeahead" class="form-control typeahead" name="name" placeholder="Search patients..." autocomplete="off" value="{{ $quote->patient->completeName }}" required>
                                </div>                                                                
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="date" class="col-sm-1 text-right control-label col-form-label label-required">Date</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="date" placeholder="dd/mm/yyyy" value="{{ date('d/m/Y', strtotime($quote->date)) }}" id="datepicker">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>                             
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="procedures" class="col-sm-1 text-right control-label col-form-label label-required">Procedures</label>
                                <div class="col-sm-5">
                                    <select name="procedures" id="procedures" class="select2 form-control custom-select select2-hidden-accessible">
                                        <option value="0" disabled selected hidden>Select a Procedure - cost</option>
                                        @foreach( $procedures as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->cost }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" name="add" id="add" class="btn btn-default"><i class="fa fa-plus"></i> Add</button>
                            </div>
                            <div class="form-group row justify-content-start">
                                <table class="table"  id="dynamic_field">
                                    <thead><tr><th scope="col">Name</th><th scope="col">Cost</th><th scope="col">Actions</th></tr></thead>
                                    <tbody id="dynamic_field">
                                        @foreach( $detail as $item)
                                            <tr id="row{{ $item->id }}">
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->cost }}</td>
                                                <td><div class="btn_remove" id="{{ $item->id }}"><i class="mdi mdi-close text-danger"></i><input type="hidden" name="dynamic[]" value="{{ $item->id }}-{{ $item->cost }}"></div></td></tr>
                                        @endforeach
                                        </tbody>
                                </table>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="subtotal" class="col-sm-1 text-right control-label col-form-label">SubTotal</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="subtotal" id="subtotal" value="{{ $quote->sub_total }}" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">$</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="discount" class="col-sm-1 text-right control-label col-form-label">Discount</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="discount" name="discount" value="{{ $quote->discount }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">$</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="total" class="col-sm-1 text-right control-label col-form-label">Total</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="total" name="total" value="{{ $quote->final_price }}" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">$</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Save</button>
                                        <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/quotes'"><i class="mdi mdi-undo"></i> Cancel</button>
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
    <script type="text/javascript">
        
        jQuery('#datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy'
        });

        $(document).ready(function(){

            $('#add').click(function(){
                var e = document.getElementById("procedures");
                var strUser = e.options[e.selectedIndex].text;
                var name = strUser.split("-")[0].trim();
                var cost = strUser.split("-")[1].trim();
                $('#dynamic_field').append('<tr id="row'+e.options[e.selectedIndex].value
                    +'"><td>'+name+'</td><td>'+cost+'</td><td><div class="btn_remove" id="'
                    +e.options[e.selectedIndex].value+'"><i class="mdi mdi-close text-danger"></i><input type="hidden" name="dynamic[]" value="'
                    +e.options[e.selectedIndex].value+'-'+cost+'"></div></td></tr>');

                $('#procedures option[value="'+e.options[e.selectedIndex].value+'"]').remove();
                var subtotal = parseFloat($('#subtotal').val()) + parseFloat(cost);
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
                    '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
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
