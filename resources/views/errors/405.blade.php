@extends('errors.error_master')
@section('content')
<div class="error-body text-center">
    <h1 class="error-title text-danger">405</h1>
    <h3 class="text-uppercase error-subtitle">METHOD NOT ALLOWED !</h3>
    <p class="text-muted m-t-30 m-b-30">SORRY FOR THE INCONVENIENCE CAUSED</p>
    <a href="{{ url('/') }}" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Back to home</a>
</div>
@endsection