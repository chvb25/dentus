@extends('layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form-horizontal" action="#" method="post">
                    @foreach ($test->questions as $item)
                        <div class="form-group row justify-content-start">
                            <label for="address" class="col-sm-12 control-label col-form-label">{{ $item->question }}</label>
                            @if ($item->question_type_id == 1)
                                    <div class="col-sm-5">
                                        <textarea name="qt{{ $item->id }}" class="form-control" cols="30" rows="3"></textarea>
                                    </div>
                            @elseif($item->question_type_id == 2)
                                <div class="col-md-12">
                                    @foreach ($item->answers as $answer)
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="{{ $answer->id }}" value="{{ $answer->id }}" name="qt{{ $item->id }}[]">
                                            <label class="custom-control-label" for="{{ $answer->id }}">{{ $answer->answer }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="col-md-12">
                                    @foreach ($item->answers as $answer)
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" value="{{ $answer->id }}" id="{{ $answer->id }}" name="qt{{ $item->id }}[]" >
                                            <label class="custom-control-label" for="{{ $answer->id }}">{{ $answer->answer }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
