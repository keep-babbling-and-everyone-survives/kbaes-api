@extends('admin.main')
@section('content')

    <div class="container my-5">
        <a href="{{  url('admin/modules')  }}" class="d-block my-3"><i class="fas fa-caret-left"></i>&nbsp; Retour à la liste des modules</a>
        <div class="row">
            {{ Form::open(array('url' => 'admin/create-module', 'class' => 'w-100', 'files' => true)) }}
            <div class="form-group">
                <label for="name">Nom du module</label>
                <input type="text" class="form-control"  name="name" id="name">
            </div>
            <div class="form-group">
                <label for="rmin">Range min</label>
                <input type="text" class="form-control"  name="rmin" id="rmin">
            </div>
            <div class="form-group">
                <label for="rmax">Range max</label>
                <input type="text" class="form-control"  name="rmax" id="rmax">
            </div>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="is_analog" name="is_analog">
                <label class="custom-control-label" for="is_analog">Module analogue</label>
            </div>

            <br>
            <input type="submit" class=" btn btn-primary">
            {{ Form::close() }}
        </div>
    </div>

@endsection('content')