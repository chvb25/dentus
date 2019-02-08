@section('custom_scripts')
<script src="{{ asset('assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
<script src="{{ asset('assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
<script src="{{ asset('assets/extra-libs/DataTables/datatables.js') }}"></script>
<div class="modal fade" id="delete_item" tabindex="-1" role="dialog" aria-labelledby="title" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Eliminar dato</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Está seguro de eliminar este ítem?
            </div>
            <div class="modal-footer">
                <form method="POST" class="delete" action="">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Confirmar</button>
                </form>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true"><b>X</b></span> Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>

    var table = $('#zero_config').DataTable({
                    "adding":true,
                    "language": {
			           "lengthMenu": 'Mostrar <select class="select2 form-control custom-select select2-hidden-accessible">'+
			             '<option value="10">10</option>'+
			             '<option value="20">20</option>'+
			             '<option value="30">30</option>'+
			             '<option value="40">40</option>'+
			             '<option value="50">50</option>'+
			             '<option value="-1">Todos</option>'+
                         '</select>',
                         "search": "Filtrar :",
                         "info": "Página _PAGE_ de _PAGES_",
                         "infoEmpty": "No se encontraron datos.",
                         "paginate": {
                            "previous":"Anteior",
                            "next":"Siguiente"
				        }
			         }
                });

    $('#groupTable').DataTable({
        "language": {
            "lengthMenu": 'Mostrar <select class="select2 form-control custom-select select2-hidden-accessible">'+
                '<option value="10">10</option>'+
                '<option value="20">20</option>'+
                '<option value="30">30</option>'+
                '<option value="40">40</option>'+
                '<option value="50">50</option>'+
                '<option value="-1">Todos</option>'+
                '</select>',
                "search": "Filtrar :",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron datos.",
                "paginate": {
                "previous":"Anteior",
                "next":"Siguiente"
            }
            },
        "adding":false,
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
        "order": [[ 0, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    var name = group.split('|');
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="2">'+name[0]+'</td>'+
                        '<td class="text-right">Total ' +name[3]+ ' '+parseFloat(name[2]).toFixed(2)+'</td>'+
                        '<td><button type="submit" class="btn btn-default" onclick="location.href=reschedure/'+name[1]+'"><i class="fas fa-sync"></i> Reprogramar</button></td></tr>'
                    );
                    last = group;
                }
            } );
        }
    });

    $('.add-button').click(function () {
        var name_id = $(this).attr("name").split('_');
        if(name_id.length === 1)
            window.location.pathname = name_id[0] + '/new';
        else
            window.location.pathname = name_id[0] + '/new/' + name_id[1];
    });

    $("button.delete").on("click", function (event) {
       var button = $(event.currentTarget);
       var action = button.data('itemid');
        $('form.delete').attr('action', action);
    });

    function formatDetail(data, showStatus){
        var tableDetail = '<div class="card-body" style="background-color: white;"><h5>Detalle</h5>'+
            '<table class="table"><thead><tr>'+
                '<th scope="col">Procedimiento</th>'+ ((showStatus) ?'<th scope="col">Estado</th>':'') +
                '</tr></thead><tbody>';
        data.forEach(function(element){
            tableDetail += '<tr><td>'+element.name+'</td>';
            if(showStatus){
                var status = (element.status == 0) ? 'warning' : ((element.status == 1) ? 'success' : 'info');
                var text = (element.status == 0) ? 'No iniciado' : ((element.status == 1) ? 'Completo' : 'En proceso');
                tableDetail += '<td class="text-'+ status +'">'+ text +'</td></tr>'
            }else
            tableDetail += '</tr>';
        });
        tableDetail += '</tbody></table></div>';
        return tableDetail;
    }

    function showDetail(element, data, showStatus = true){
        var tr = element.closest('tr');
        var row = table.row(tr);

        if ( row.child.isShown() ) {
            row.child.hide();
        }
        else {
            row.child(formatDetail(data, showStatus)).show();
        }
    }

</script>

@endsection
