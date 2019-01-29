@section('custom_scripts')
<script src="{{ asset('assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
<script src="{{ asset('assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
<script src="{{ asset('assets/extra-libs/DataTables/datatables.js') }}"></script>
<div class="modal fade" id="delete_item" tabindex="-1" role="dialog" aria-labelledby="title" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Delete Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <form method="POST" class="delete" action="">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Yes</button>
                </form>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true"><b>X</b></span> Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
    var table = $('#zero_config').DataTable();

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
        var tableDetail = '<div class="card-body" style="background-color: white;"><h5>Detail</h5>'+
            '<table class="table"><thead><tr>'+
                '<th scope="col">Procedure</th>'+ ((showStatus) ?'<th scope="col">State</th>':'') +
                '</tr></thead><tbody>';
        data.forEach(function(element){
            tableDetail += '<tr><td>'+element.name+'</td>';
            if(showStatus){      
                var status = (element.status == 0) ? 'warning' : ((element.status == 1) ? 'success' : 'info');
                var text = (element.status == 0) ? 'Not started' : ((element.status == 1) ? 'Completed' : 'In process');
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