@extends('admin.main')
@section('content')
    <div class="container">
        <a class="btn btn-primary my-3" href="{{ url('admin/create-option') }}">Créer une nouvelle option</a>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th></th>

            </thead>
            <tbody>
            @foreach($options as $option)

                <tr>

                    <td>{{ $option->id }}</td>
                    <td>{{ $option->name }}</td>
                    <td><a href="{{ url('admin/delete-option/' . $option->id) }}">Supprimer l'option</a> </td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection