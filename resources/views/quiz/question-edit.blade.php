@extends('master')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Question Type</h4>

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
                <form class="form-horizontal" action="{{ url('update-q') }}/{{ $qs->id }}/{{ $test_id }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <input type="hidden" name="test_id" value="{{ $test_id }}">
                    <div class="card-body">
                        <h4 class="card-title">Information</h4>
                        <div class="form-group row justify-content-start">
                            <label for="question" class="col-sm-1 text-right control-label col-form-label label-required">Question</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="question" placeholder="Question Here" value="{{ $qs->question }}" required>
                            </div>
                        </div>
                        <div class="form-group row justify-content-start">
                            <label for="question_type" class="col-sm-1 text-right control-label col-form-label label-required">Question Type</label>
                            <div class="col-sm-5">
                                <select name="question_type" id="question_type" class="select2 form-control custom-select select2-hidden-accessible" required>
                                    <option value="0" disabled selected hidden>Select a type</option>
                                    @foreach( $qt as $item)
                                        <option value="{{ $item->id }}" @if( $item->id == $qs->question_type_id) {{ 'selected' }} @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="border-top" id="second_section" hidden>
                        <div class="card-body">
                            <h4 class="card-title">Answers</h4>
                            <div class="form-group row justify-content-start">
                                <table class="table" id="dynamic_field">
                                    <?php $i = 1; ?>
                                    @foreach( $answers  as $item)
                                        @if($loop->first)
                                            <tr>
                                                <td><input type="text" name="dynamic[]" class="form-control name_list dynamic" required value="{{ $item->answer }}" /></td>
                                                <td><button type="button" name="add" id="add" class="btn btn-default"><i class="fa fa-plus"></i> Add More</button></td>
                                            </tr>
                                        @else
                                            <tr id="row<?php echo $i; ?>" class="dynamic-added">
                                                <td><input type="text" name="dynamic[]"  class="form-control name_list dynamic" required value="{{ $item->answer }}"/></td>
                                                <td><button type="button" name="remove" id="<?php echo $i; ?>" class="btn btn-danger btn_remove">X</button></td>
                                            </tr>
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <div class="form-group row justify-content-center">
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Save</button>
                                    <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/questions/{{ $test_id }}'"><i class="mdi mdi-undo"></i> Cancel</button>
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
    <script type="text/javascript">
        $(document).ready(function(){
            var postURL = "<?php echo url('addmore'); ?>";
            var i=$(".dynamic").length;
            if ($('#question_type').val() > 1 ){
                $('#second_section').removeAttr('hidden');
                $('.dynamic').attr('required', true);
            }

            $('#question_type').change(function () {
                if ( $(this).val() > "1"){
                    $('#second_section').removeAttr('hidden');
                    $('.dynamic').attr('required', true);
                }else{
                    $('#second_section').attr('hidden', true);
                    $('.dynamic').removeAttr('required');
                }
            });

            $('#add').click(function(){
                i++;
                $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text" name="dynamic[]"  class="form-control name_list dynamic" required /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
            });


            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            });


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
@endsection