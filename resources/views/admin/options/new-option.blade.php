@extends('admin.main')
@section('content')

    <div class="container my-5">
        <a href="{{  url('admin/options')  }}" class="d-block my-3"><i class="fas fa-caret-left"></i>&nbsp; Retour à la liste des options</a>
        <div class="row">
            {{ Form::open(array('url' => 'admin/create-option', 'class' => 'w-100', 'files' => true)) }}
            <div class="form-group">
                <label for="name">Nom de l'option</label>
                <input type="text" class="form-control"  name="name" id="name">
            </div>

            <br>
            <input type="submit" class=" btn btn-primary">
            {{ Form::close() }}
        </div>
    </div>

@endsection('content')