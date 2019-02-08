@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h3 class="page-title">Pacientes</h3>
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
                    <form class="form-horizontal" action="{{ url('update-patients') }}/{{ $pts->id }}" id="wizard" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <h3>Datos personales</h3>
                        <section>
                            <div class="form-group row justify-content-start">
                                <label for="name" class="col-sm-2 text-right control-label col-form-label label-required">Nombre</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="{{ $pts->name }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="lastName" class="col-sm-2 text-right control-label col-form-label label-required">Apellido</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="lastName" value="{{ $pts->lastName }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="dni" class="col-sm-2 text-right control-label col-form-label label-required">DNI</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="dni" value="{{ $pts->dni }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="phone" class="col-sm-2 text-right control-label col-form-label label-required">Teléfono</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" minlength="5" name="phone" value="{{ $pts->phone }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="birthDate" class="col-sm-2 text-right control-label col-form-label label-required">Fecha de Nacimiento</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="birthDate" placeholder="dd/mm/yyyy" value="{{ date('d/m/Y', strtotime($pts->birthDate)) }}" id="datepicker">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="nationality" class="col-sm-2 text-right control-label col-form-label label-required">Nacionalidad</label>
                                <div class="col-sm-5">
                                    <select name="nationality" id="question_type" class="select2 form-control custom-select select2-hidden-accessible" required>
                                        <option value="0" disabled selected hidden>Seleccione un país</option>
                                        @foreach( $nat as $item)
                                            <option value="{{ $item->id }}" {{ ( $item->id == $pts->nationality) ? 'selected' : '' }}> {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="civilState" class="col-sm-2 text-right control-label col-form-label label-required">Estado Civil</label>
                                <div class="col-sm-5">
                                    <select name="civilState" id="question_type" class="select2 form-control custom-select select2-hidden-accessible" required>
                                        <option value="1" {{ ( $pts->civilState == 1) ? 'selected' : '' }}>Soltero(a)</option>
                                        <option value="2" {{ ( $pts->civilState == 2) ? 'selected' : '' }}>Casado(a)</option>
                                        <option value="3" {{ ( $pts->civilState == 3) ? 'selected' : '' }}>Divorsiado(a)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="address" class="col-sm-2 text-right control-label col-form-label label-required">Dirección</label>
                                <div class="col-sm-5">
                                    <textarea name="address" class="form-control" cols="30" rows="5" required>{{ $pts->address }}</textarea>
                                </div>
                            </div>
                        </section>
                        <h3>Datos laborales</h3>
                        <section>
                            <div class="form-group row justify-content-start">
                                <label for="profession" class="col-sm-2 text-right control-label col-form-label label-required">Profesión</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="profession" value="{{ $pts->profession }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="jobTitle" class="col-sm-2 text-right control-label col-form-label label-required">Puesto Laboral</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="jobTitle" value="{{ $pts->jobTitle }}" required>
                                </div>
                            </div>
                            <div class="form-group row justify-content-start">
                                <label for="jobAddress" class="col-sm-2 text-right control-label col-form-label label-required">Dirección Laboral</label>
                                <div class="col-sm-5">
                                    <textarea name="jobAddress" class="form-control" cols="30" rows="5" required>{{ $pts->jobAddress }}</textarea>
                                </div>
                            </div>
                        </section>
                        <h3>Cuestionario</h3>
                        <section>
                            @foreach ($test->questions as $item)
                                <div class="form-group row justify-content-start">
                                    <label for="address" class="col-sm-12 control-label col-form-label">{{ $item->question }}</label>
                                    @if ($item->question_type_id == 1)
                                        <div class="col-sm-5">
                                        @forelse ($result->where('question_id', $item->id) as $answer)
                                            <textarea name="qt{{ $item->id }}" class="form-control" cols="30" rows="3">{{ $answer->answer }}</textarea>
                                        @empty
                                            <textarea name="qt{{ $item->id }}" class="form-control" cols="30" rows="3"></textarea>
                                        @endforelse
                                        </div>
                                    @elseif($item->question_type_id == 2)
                                        <div class="col-md-12">
                                            @foreach ($item->answers as $answer)
                                            <div class="custom-control custom-checkbox mr-sm-2">
                                                @forelse ($result->where('question_id', $item->id)->where('answer', $answer->id) as $selected)
                                                    <input type="checkbox" class="custom-control-input" checked value="{{ $answer->id }}" id="{{ $answer->id }}" name="qt{{ $item->id }}[]">
                                                @empty
                                                    <input type="checkbox" class="custom-control-input" value="{{ $answer->id }}" id="{{ $answer->id }}" name="qt{{ $item->id }}[]">
                                                @endforelse
                                                <label class="custom-control-label" for="{{ $answer->id }}">{{ $answer->answer }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            @foreach ($item->answers as $answer)
                                                <div class="custom-control custom-radio">
                                                    @forelse ($result->where('question_id', $item->id)->where('answer', $answer->id) as $selected)
                                                        <input type="radio" class="custom-control-input" checked value="{{ $answer->id }}" id="{{ $answer->id }}" name="qt{{ $item->id }}" >
                                                    @empty
                                                        <input type="radio" class="custom-control-input" value="{{ $answer->id }}" id="{{ $answer->id }}" name="qt{{ $item->id }}" >
                                                    @endforelse

                                                    <label class="custom-control-label" for="{{ $answer->id }}">{{ $answer->answer }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </section>
                        <h3>Odontograma</h3>
                        <section>
                            <div class="form-group row justify-content-start">
                                <label for="procedures" class="col-sm-2 text-right control-label col-form-label">Procedimientos</label>
                                <div class="col-sm-5">
                                    <select name="procedures" id="procedures" class="select2 form-control custom-select select2-hidden-accessible">
                                        <option value="0" disabled selected hidden>Seleccione un Procedimiento</option>
                                        @foreach( $procedures as $item)
                                            <option value="{{ $item->id }}/{{ $item->type }}/{{ $item->color }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="pannel-body">
                                <input type="hidden" name="tooth" id="tooth" value="0">
                                <input type="hidden" id="color" value="0">
                                <input type="hidden" id="procedureType" value="0">
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
                        </section>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')

    <link href="{{ asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }} "></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>

    <link href="{{ asset('assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/jquery-steps/steps.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <link href="{{ asset('css/tooth.css') }}" rel="stylesheet"/>

    <script type="text/javascript">
        var form = $("#wizard");
        form.steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            labels:{
                next: "Siguiente",
                previous: "Anterior",
                finish: "Guardar",
                cancel: "Cancelar"
            },
            enableCancelButton: true,
            onCanceled: function (event)
            {
                window.location.pathname =  '/patients';
            },
            onStepChanging: function(event, currentIndex, newIndex) {
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function(event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                form.submit();
            }
        });

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
        function paintTeeth(){
            $.ajax({
                url: '{{ route('teeth') }}'+'?query='+ '{!! json_encode($pts->id); !!}',
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }

                    if(len > 0){
                        response.forEach(function(tooth){
                            if(tooth.type == 'P'){
                                $('#'+tooth.tooth).removeClass("click");
                                $('#'+tooth.tooth).addClass("selectable");
                                $('#'+tooth.tooth).attr('style', 'background-color:' + tooth.color);
                            }else{
                                var actual = $('#c'+tooth.tooth);
                                $(actual).parent().children().each(function(index, el) {
                                    if ($(el).hasClass("click")) {
                                        $(el).addClass("selectable");
                                        $(el).removeClass("click");
                                        $(el).attr('style', 'background-color:' + tooth.color);
                                    }
                                });
                            }
                            var id = tooth.tooth+'|'+tooth.id;
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
                        });
                    }
                },
                fail: function(xhr, textStatus, errorThrown){
                    alert('request failed');
                }
            });
        }

        function toothList(id){
            var procedure = $('#procedures').val().split('/')[0];
            id = id+'|'+procedure;
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
            $("a[href='#cancel']").addClass('btn-danger');
            createOdontogram();
            paintTeeth();
            $('#datepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                language: "es"
            });
            $('#procedures').change(function(){
                var data = this.value.split('/');
                $('#procedureType').val(data[1]);
                $('#color').val(data[2]);
            });
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
                        toothList($(this).attr('id'));
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
                        toothList($(this).attr('id').substring(1));
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
        });
    </script>
@endsection
