@extends('admin.main')
@section('content')

    <div class="container my-5">
        <a href="{{  url('admin/solutions')  }}" class="d-block my-3"><i class="fas fa-caret-left"></i>&nbsp; Retour à la liste des solutions</a>
        <div class="row">
            {{ Form::open(array('url' => 'admin/create-solution', 'class' => 'w-100', 'files' => true)) }}

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="reponse" name="response" value="1">
                <label class="custom-control-label" for="reponse">Attend une réponse</label>
            </div>

            <br>
            <input type="submit" class=" btn btn-primary">
            {{ Form::close() }}
        </div>
    </div>

@endsection('content')