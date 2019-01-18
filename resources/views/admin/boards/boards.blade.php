@extends('admin.main')
@section('content')
    <div class="container">
        <a class="btn btn-primary my-3" href="{{ url('admin/create-board') }}">Créer un nouveau board</a>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Modules</th>
                <th></th>

            </thead>
            <tbody>
            @foreach($boards as $board)

                <tr>

                    <td>{{ $board->id }}</td>
                    <td>Board n°{{ $board->id }}</td>
                    <td>
                        @foreach($board->modules as $module)

                            @if ($loop->last)
                                <a href="{{ url('admin/modules') }}">{{ $module->name . ' (n°' . $module->id . ')' }}</a>
                            @else
                                <a href="{{ url('admin/modules') }}">{{ $module->name . ' (n°' . $module->id . ')' . ',' }}</a>
                            @endif
                        @endforeach
                    </td>
                    <td><a href="{{ url('admin/delete-board/' . $board->id) }}">Supprimer le board</a> </td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection