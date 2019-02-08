@extends('errors.error_master')
@section('content')
<div class="error-body text-center">
    <h1 class="error-title text-danger">403</h1>
    <h3 class="text-uppercase error-subtitle">AUTENTICATE FIRST!</h3>
    <p class="text-muted m-t-30 m-b-30">The server understood the request, but is refusing to fulfill it.
        Authorization will not help and the request SHOULD NOT be repeated.</p>
    <a href="{{ url('/home') }}" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Back to Login</a>
</div>
@endsection
