<link rel="stylesheet" href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}">
<script src=" {{ asset('assets/libs/toastr/build/toastr.min.js') }} "></script>

@if(Session::has('success'))
    <script>
        @foreach(Session::pull('success') as $message)
            toastr.success( "{{ $message }}", "Registro Exitoso!");
        @endforeach
    </script>
@endif


@if(Session::has('info'))
    <script>
        @foreach(Session::pull('info') as $message)
            toastr.info( "{{ $message }}", "Información:");
        @endforeach
    </script>
@endif


@if(Session::has('warning'))
    <script>
        @foreach(Session::pull('warning') as $message)
            toastr.warning( "{{ $message }}", "¡Advertencia!");
        @endforeach
    </script>
@endif


@if(Session::has('error'))
    <script>
        @if (count($errors) > 0)
            var message = "";
            @foreach ($errors->all() as $error)
                message += "{{ $error }}<br/>";
            @endforeach
            message = message.substring(0, message.length - 5);
            toastr.error(message, '¡Algo ha salio mal!', {fadeAway: 10000});
            {{ var_dump(Session::forget('error')) }};
        @elseif(Session::has('error'))
            @foreach(Session::pull('error') as $message)
                toastr.error( "{{ $message }}", "¡Error!");
            @endforeach
        @endif
    </script>

@endif

