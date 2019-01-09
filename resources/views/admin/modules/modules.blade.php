@extends('admin.main')
@section('content')
    <div class="container">
        <a class="btn btn-primary my-3" href="{{ url('admin/create-module') }}">Créer un nouveau module</a>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th></th>

            </thead>
            <tbody>
            @foreach($modules as $module)

                <tr>

                    <td>{{ $module->id }}</td>
                    <td><a href="{{ url('admin/module/' . $module->id) }}">module n°{{ $module->id }}</a></td>
                    <td><a href="{{ url('admin/delete-module/' . $module->id) }}">Supprimer le module</a> </td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection