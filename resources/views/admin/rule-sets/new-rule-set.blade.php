@extends('admin.main')
@section('content')

    <div class="container my-5">
        <a href="{{  url('admin/rule-sets')  }}" class="d-block my-3"><i class="fas fa-caret-left"></i>&nbsp; Retour à la liste des rule-sets</a>
        <div class="row">
            {{ Form::open(array('url' => 'admin/create-rule-set', 'class' => 'w-100', 'files' => true)) }}

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="led_1" name="led_1" value="1">
                <label class="custom-control-label" for="led_1">LED 1</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="led_2" name="led_2" value="1">
                <label class="custom-control-label" for="led_2">LED 2</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="led_3" name="led_3" value="1">
                <label class="custom-control-label" for="led_3">LED 3</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="led_4" name="led_4" value="1">
                <label class="custom-control-label" for="led_4">LED 4</label>
            </div>
            <div class="form-group">
                <label for="id_module">Choisir un module</label>
                <select class="custom-select" name="id_module[]" id="id_module" multiple="multiple">
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="id_solution">Choisir une solution</label>
                <select class="custom-select" name="id_solution[]" id="id_solution" multiple="multiple">
                    @foreach($solutions as $solution)
                        <option value="{{ $solution->id }}">{{ $solution->response }}</option>
                    @endforeach
                </select>
            </div>

            <br>
            <input type="submit" class=" btn btn-primary">
            {{ Form::close() }}
        </div>
    </div>

@endsection('content')