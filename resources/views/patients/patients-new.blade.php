@extends('master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Patients</h4>

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
                    <form class="form-horizontal" action="{{ url('save-patients') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title">Information</h4>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-1 text-right control-label col-form-label label-required">Name</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" placeholder="Name Here" value="{{ old('name') }}" required>
                                </div>
                                <label for="lastName" class="col-sm-1 text-right control-label col-form-label label-required">Last Name</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="lastName" placeholder="Last Name Here" value="{{ old('lastName') }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="dni" class="col-sm-1 text-right control-label col-form-label label-required">DNI</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="dni" placeholder="DNI Here" value="{{ old('dni') }}" required>
                                </div>
                                <label for="birthDate" class="col-sm-1 text-right control-label col-form-label label-required">Date of Birth</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="birthDate" placeholder="dd/mm/yyyy" value="{{ old('birthDate') }}" id="datepicker">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="nationality" class="col-sm-1 text-right control-label col-form-label label-required">Nationality</label>
                                <div class="col-sm-5">
                                    <select name="nationality" id="question_type" class="select2 form-control custom-select select2-hidden-accessible" required>
                                        <option value="0" disabled selected hidden>Select a nationality</option>
                                        @foreach( $nat as $item)
                                            <option value="{{ $item->id }}" {{ ( $item->id == old('nationality')) ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="civilState" class="col-sm-1 text-right control-label col-form-label label-required">Civil State</label>
                                <div class="col-sm-5">
                                    <select name="civilState" id="question_type" class="select2 form-control custom-select select2-hidden-accessible" required>
                                        <option value="0" disabled selected hidden>Select a civil state</option>
                                        <option value="1" {{ ( old('civilState') == 1) ? 'selected' : '' }}>Single</option>                                        
                                        <option value="2" {{ ( old('civilState') == 2) ? 'selected' : '' }}>Married</option>
                                        <option value="3" {{ ( old('civilState') == 3) ? 'selected' : '' }}>Divorced</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="address" class="col-sm-1 text-right control-label col-form-label label-required">Address</label>
                                <div class="col-sm-5">
                                    <textarea name="address" class="form-control" cols="30" rows="5" placeholder="Address Here" required>{{ old('address') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="profession" class="col-sm-1 text-right control-label col-form-label label-required">Profession</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="profession" placeholder="Profession Here" value="{{ old('profession') }}" required>
                                </div>
                                <label for="jobTitle" class="col-sm-1 text-right control-label col-form-label label-required">Job Title</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="jobTitle" placeholder="Job Title Here" value="{{ old('jobTitle') }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="jobAddress" class="col-sm-1 text-right control-label col-form-label label-required">Job Address</label>
                                <div class="col-sm-5">
                                    <textarea name="jobAddress" class="form-control" cols="30" rows="5" placeholder="Job Address Here" required>{{ old('jobAddress') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-5">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Save</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" onclick="window.location.pathname =  '/patients'"><i class="mdi mdi-undo"></i> Cancel</button>
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
    </script>
@endsection
