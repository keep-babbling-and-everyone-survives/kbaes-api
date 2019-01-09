@extends('admin.main')
@section('content')
    <div class="container">
        <a class="btn btn-primary my-3" href="{{ url('admin/create-rule-set') }}">Créer un nouveau rule set</a>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Combination Int</th>
                <th>Combination Bin</th>
                <th></th>

            </thead>
            <tbody>
            @foreach($rule_sets as $rule_set)

                <tr>

                    <td>{{ $rule_set->id }}</td>
                    <td>{{ $rule_set->combination }}</td>
                    <td>{{ decbin($rule_set->combination) }}</td>
                    <td><a href="{{ url('admin/delete-rule-set/' . $rule_set->id) }}">Supprimer le rule set</a> </td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection