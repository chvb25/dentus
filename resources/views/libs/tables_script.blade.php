@section('custom_scripts')
<script src="{{ asset('assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
<script src="{{ asset('assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
<script src="{{ asset('assets/extra-libs/DataTables/datatables.js') }}"></script>
<script>
    $('#zero_config').DataTable();
    $('.add-button').click(function () {
        window.location.href = $(this).attr("name") + '/new';
    });
</script>
@endsection