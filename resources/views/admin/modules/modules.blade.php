@extends('admin.main')
@section('content')
    <div class="container">
        <a class="btn btn-primary my-3" href="{{ url('admin/create-module') }}">Créer un nouveau module</a>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Range min</th>
                <th>Range max</th>
                <th>Analogue</th>
                <th></th>

            </thead>
            <tbody>
            @foreach($modules as $module)

                <tr>

                    <td>{{ $module->id }}</td>
                    <td>{{ $module->name }}</td>
                    <td>{{ $module->range_min }}</td>
                    <td>{{ $module->range_max }}</td>
                    <td>
                        @if($module->is_analog)
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-times"></i>
                        @endif
                    </td>
                    <td><a href="{{ url('admin/delete-module/' . $module->id) }}">Supprimer le module</a> </td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection