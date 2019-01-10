@extends('admin.main')
@section('content')
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Status</th>
                <th>Board</th>
                <th>Rule Set bin</th>
                <th></th>

            </thead>
            <tbody>
            @foreach($games as $game)

                <tr>

                    <td>{{ $game->id }}</td>
                    <td>{{ $game->status }}</td>
                    <td>Board n°{{ $game->id_board }}</td>
                    <td>{{ decbin($game->rulesets[0]->combination) }}</td>
                    <td><a href="{{ url('admin/delete-game/' . $game->id) }}">Supprimer la partie</a> </td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection