@extends('admin.main')
@section('content')
    <div class="container">
        <a class="btn btn-primary my-3" href="{{ url('admin/create-solution') }}">Créer une nouvelle solution</a>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Attend une réponse non vide</th>
                <th></th>

            </thead>
            <tbody>
            @foreach($solutions as $solution)

                <tr>

                    <td>{{ $solution->id }}</td>
                    <td>
                        @if(!empty($solution->response))
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-times"></i>
                        @endif
                    </td>
                    <td><a href="{{ url('admin/delete-solution/' . $solution->id) }}">Supprimer la solution</a> </td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection