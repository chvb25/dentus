<link rel="stylesheet" href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}">
<script src=" {{ asset('assets/libs/toastr/build/toastr.min.js') }} "></script>

@if(Session::has('success'))
    <script>
        @foreach(Session::pull('success') as $message)
            toastr.success( "{{ $message }}", "Success!");
        @endforeach
    </script>
@endif


@if(Session::has('info'))
    <script>
        @foreach(Session::pull('info') as $message)
            toastr.info( "{{ $message }}", "Information");
        @endforeach
    </script>
@endif


@if(Session::has('warning'))
    <script>
        @foreach(Session::pull('warning') as $message)
            toastr.warning( "{{ $message }}", "Oops!");
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
            toastr.error(message, 'Something went wrong!', {fadeAway: 10000});
            {{ var_dump(Session::forget('error')) }};
        @else
            @foreach(Session::pull('warning') as $message)
                toastr.warning( "{{ $message }}", "Oops!");
            @endforeach
        @endif
    </script>

@endif

