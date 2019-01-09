@extends('admin.main')
@section('content')
    <div class="container">
        <a class="btn btn-primary my-3" href="{{ url('admin/create-board') }}">Créer un nouveau board</a>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th></th>

            </thead>
            <tbody>
            @foreach($boards as $board)

                <tr>

                    <td>{{ $board->id }}</td>
                    <td><a href="{{ url('admin/board/' . $board->id) }}">Board n°{{ $board->id }}</a></td>
                    <td><a href="{{ url('admin/delete-board/' . $board->id) }}">Supprimer le board</a> </td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection