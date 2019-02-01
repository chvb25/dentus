@extends('master')

@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Attention</h4>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <form id="form-save" class="form-horizontal" action="{{ url('save-attention') }}/{{ $appointment->id }}" method="post">
    @csrf
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Information</h4>
                        <div class="form-group row justify-content-start">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">Patient</label>
                            <div class="col-sm-5">
                                <label class="text-left control-label col-form-label">{{ $appointment->completeName }}</label>
                            </div>
                        </div>
                        <div class="form-group row justify-content-start">
                            <label for="date" class="col-sm-2 text-right control-label col-form-label">Date</label>
                            <div class="col-sm-5">
                                <label class="text-left control-label col-form-label">{{ date('d/m/Y', strtotime($appointment->date)) }}</label>
                            </div>
                        </div>
                        <div class="form-group row justify-content-start">
                            <label class="col-sm-2 text-right control-label col-form-label">Procedure</label>
                            <div class="col-sm-5">
                                <label class="text-left control-label col-form-label">{{ $appointment->procedureName }}</label>
                            </div>
                        </div>

                        @if ($appointment->procedure_id > 0)
                        <div class="form-group row justify-content-start">
                            <label class="col-sm-2 text-right control-label col-form-label label-required">Status</label>
                            <div class="col-sm-5">
                                <select name="status" id="status" class="select2 form-control custom-select select2-hidden-accessible">
                                    <option value="0" disabled selected hidden>Select a Status</option>
                                    <option value="2">In progess</option>
                                    <option value="1">Complete</option>
                                </select>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                                <h4 class="card-title">Odontogramma</h4>
                                <div class="pannel-body">
                                    <input type="hidden" name="tooth" id="tooth" value="0">
                                    <input type="hidden" id="color" value="{{ $appointment->procedureColor }}">
                                    <input type="hidden" id="procedureType" value="{{ $appointment->procedureType }}">
                                    <div class="row">
                                        <div id="tr" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        </div>
                                        <div id="tl" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        </div>
                                        <div id="tlr" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                        </div>
                                        <div id="tll" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="blr" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                        </div>
                                        <div id="bll" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        </div>
                                        <div id="br" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        </div>
                                        <div id="bl" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <div class="form-group row justify-content-center">
                                <div class="col-sm-3">
                                    <input type="hidden" id="cash" name="cash" value="0">
                                    <button type="submit" id="save" class="btn btn-success" onclick="$('#cash').val(0); return true;"><i class="mdi mdi-content-save"></i> Guardar</button>
                                    <button type="submit" id="save-cash" class="btn btn-success" style="display: none;" data-toggle="modal" data-target="#attention-cash" onclick="return false"><i class="mdi mdi-content-save"></i> Guardar</button>
                                    <button type="button" class="btn btn-danger" onclick="window.location.pathname =  '/'"><i class="mdi mdi-undo"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="attention-cash" tabindex="-1" role="dialog" aria-labelledby="title" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Please select a method of payment.
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="$('#cash').val(1); return true;"><i class="far fa-money-bill-alt"></i> Cash</button>
                    <button type="submit" class="btn btn-danger" onclick="$('#cash').val(2); return true;"><i class="fas fa-hand-holding-usd"></i> Receivable</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('custom_scripts')
<link href="{{ asset('css/tooth.css') }}" rel="stylesheet"/>
<script type="text/javascript">
    function replaceAll(find, replace, str) {
        return str.replace(new RegExp(find, 'g'), replace);
    }

    function createOdontogram() {
        var htmlLecheLeft = "",
            htmlLecheRight = "",
            htmlLeft = "",
            htmlRight = "",
            a = 1;
        for (var i = 9 - 1; i >= 1; i--) {
            //Dientes Definitivos Cuandrante Derecho (Superior/Inferior)
            htmlRight += '<div data-name="value" id="dienteindex' + i + '" class="diente" style="left:50px;">' +
                '<span style="margin-left: 45px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-info">index' + i + '</span>' +
                '<div id="tindex' + i + '" class="cuadro click">' +
                '</div>' +
                '<div id="lindex' + i + '" class="cuadro izquierdo click">' +
                '</div>' +
                '<div id="bindex' + i + '" class="cuadro debajo click">' +
                '</div>' +
                '<div id="rindex' + i + '" class="cuadro derecha click">' +
                '</div>' +
                '<div id="cindex' + i + '" class="centro click">' +
                '</div>' +
                '</div>';
            //Dientes Definitivos Cuandrante Izquierdo (Superior/Inferior)
            htmlLeft += '<div id="dienteindex' + a + '" class="diente">' +
                '<span style="margin-left: 45px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-info">index' + a + '</span>' +
                '<div id="tindex' + a + '" class="cuadro click">' +
                '</div>' +
                '<div id="lindex' + a + '" class="cuadro izquierdo click">' +
                '</div>' +
                '<div id="bindex' + a + '" class="cuadro debajo click">' +
                '</div>' +
                '<div id="rindex' + a + '" class="cuadro derecha click">' +
                '</div>' +
                '<div id="cindex' + a + '" class="centro click">' +
                '</div>' +
                '</div>';
            if (i <= 5) {
                //Dientes Temporales Cuandrante Derecho (Superior/Inferior)
                htmlLecheRight += '<div id="dienteLindex' + i + '" style="left: -26%;" class="diente-leche">' +
                    '<span style="margin-left: 40px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-primary">index' + i + '</span>' +
                    '<div id="tlecheindex' + i + '" class="cuadro-leche top-leche click">' +
                    '</div>' +
                    '<div id="llecheindex' + i + '" class="cuadro-leche izquierdo-leche click">' +
                    '</div>' +
                    '<div id="blecheindex' + i + '" class="cuadro-leche debajo-leche click">' +
                    '</div>' +
                    '<div id="rlecheindex' + i + '" class="cuadro-leche derecha-leche click">' +
                    '</div>' +
                    '<div id="clecheindex' + i + '" class="centro-leche click">' +
                    '</div>' +
                    '</div>';
            }
            if (a < 6) {
                //Dientes Temporales Cuandrante Izquierdo (Superior/Inferior)
                htmlLecheLeft += '<div id="dienteLindex' + a + '" class="diente-leche">' +
                    '<span style="margin-left: 40px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-primary">index' + a + '</span>' +
                    '<div id="tlecheindex' + a + '" class="cuadro-leche top-leche click">' +
                    '</div>' +
                    '<div id="llecheindex' + a + '" class="cuadro-leche izquierdo-leche click">' +
                    '</div>' +
                    '<div id="blecheindex' + a + '" class="cuadro-leche debajo-leche click">' +
                    '</div>' +
                    '<div id="rlecheindex' + a + '" class="cuadro-leche derecha-leche click">' +
                    '</div>' +
                    '<div id="clecheindex' + a + '" class="centro-leche click">' +
                    '</div>' +
                    '</div>';
            }
            a++;
        }
        $("#tr").append(replaceAll('index', '1', htmlRight));
        $("#tl").append(replaceAll('index', '2', htmlLeft));
        $("#tlr").append(replaceAll('index', '5', htmlLecheRight));
        $("#tll").append(replaceAll('index', '6', htmlLecheLeft));


        $("#bl").append(replaceAll('index', '3', htmlLeft));
        $("#br").append(replaceAll('index', '4', htmlRight));
        $("#bll").append(replaceAll('index', '7', htmlLecheLeft));
        $("#blr").append(replaceAll('index', '8', htmlLecheRight));
    }

    /**
    * Disabling teeth that have already been treated
    * @param {array} list List of teeth
    */
    function disableTeeth(list){
        list.forEach(tooth => {
            if(isNaN(parseInt(tooth))){
                $('#'+tooth).removeClass("click");
            }else{
                $('#t'+tooth).removeClass("click");
                $('#l'+tooth).removeClass("click");
                $('#b'+tooth).removeClass("click");
                $('#r'+tooth).removeClass("click");
                $('#c'+tooth).removeClass("click");

                $('#t'+tooth).addClass("disable-tooth");
                $('#l'+tooth).addClass("disable-tooth");
                $('#b'+tooth).addClass("disable-tooth");
                $('#r'+tooth).addClass("disable-tooth");
                $('#c'+tooth).addClass("disable-tooth");
            }
        });
    }

    function toohList(id){
        if($('#tooth').val() == '0' || $('#tooth').val() == ''){
            $('#tooth').val(id);
        }else{
            var list = $('#tooth').val().split(",");
            if (~(list.indexOf(id)))
                list = list.filter(e => e !== id);
            else
                list.push(id);
            $('#tooth').val(list.toString());
        }
    }
    var arrayPuente = [];
    $(document).ready(function() {
        createOdontogram();
        disableTeeth([]);
        $(".click").click(function(event) {
            var procedureType = $('#procedureType').val();
            switch (procedureType) {
                case "P": //piece
                    if ($(this).hasClass("click")) {
                        $(this).removeClass("click");
                        $(this).addClass("selectable");
                        $(this).attr('style', 'background-color:' + $('#color').val());
                    } else {
                        if ($(this).hasClass("selectable")) {
                            $(this).removeClass("selectable");
                            $(this).addClass("click");
                            $(this).removeAttr("style");
                        }
                    }
                    toohList($(this).attr('id'));
                    break;
                case "F": //full tooth
                    var dientePosition = $(this).position();
                    var actual = $(this);
                    $(this).parent().children().each(function(index, el) {
                        if ($(el).hasClass("click")) {
                            $(el).addClass("selectable");
                            $(el).removeClass("click");
                            $(el).attr('style', 'background-color:' + $('#color').val());
                        }else{
                            if($(el).hasClass("selectable")){
                                $(el).addClass("click");
                                $(el).removeClass("selectable");
                                $(el).removeAttr('style');
                            }
                        }
                    });
                    toohList($(this).attr('id').substring(1));
                    break;
                case "B": //bridge
                    var dientePosition = $(this).offset(), leftPX;
                    console.log($(this)[0].offsetLeft)
                    var noDiente = $(this).parent().children().first().text();
                    var cuadrante = $(this).parent().parent().attr('id');
                    var left = 0,
                        width = 0;
                    if (arrayPuente.length < 1) {
                        $(this).parent().children('.cuadro').css('border-color', 'red');
                        arrayPuente.push({
                            diente: noDiente,
                            cuadrante: cuadrante,
                            left: $(this)[0].offsetLeft,
                            father: null
                        });
                    } else {
                        $(this).parent().children('.cuadro').css('border-color', 'red');
                        arrayPuente.push({
                            diente: noDiente,
                            cuadrante: cuadrante,
                            left: $(this)[0].offsetLeft,
                            father: arrayPuente[0].diente
                        });
                        var diferencia = Math.abs((parseInt(arrayPuente[1].diente) - parseInt(arrayPuente[1].father)));
                        if (diferencia == 1) width = diferencia * 60;
                        else width = diferencia * 50;

                        if(arrayPuente[0].cuadrante == arrayPuente[1].cuadrante) {
                            if(arrayPuente[0].cuadrante == 'tr' || arrayPuente[0].cuadrante == 'tlr' || arrayPuente[0].cuadrante == 'br' || arrayPuente[0].cuadrante == 'blr') {
                                if (arrayPuente[0].diente > arrayPuente[1].diente) {
                                    console.log(arrayPuente[0])
                                    leftPX = (parseInt(arrayPuente[0].left)+10)+"px";
                                }else {
                                    leftPX = (parseInt(arrayPuente[1].left)+10)+"px";
                                    //leftPX = "45px";
                                }
                            }else {
                                if (arrayPuente[0].diente < arrayPuente[1].diente) {
                                    leftPX = "-45px";
                                }else {
                                    leftPX = "45px";
                                }
                            }
                        }
                        console.log(leftPX)
                        $(this).parent().append('<div style="z-index: 9999; height: 5px; width:' + width + 'px;" id="puente" class="click-red"></div>');
                        $(this).parent().children().last().css({
                            "position": "absolute",
                            "top": "80px",
                            "left": leftPX
                        });
                    }

                    break;
            }
			return false;
		});
        $('#status').change(function(){
            if(this.value == 1){
                $('#save-cash').removeAttr('style');
                $('#save').attr('style', 'display:none;');
            }else{
                $('#save').removeAttr('style');
                $('#save-cash').attr('style', 'display:none;');
            }
        });
    });

    </script>
@endsection

