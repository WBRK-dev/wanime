@extends('layout.root')

@section('body')
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Requested At</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registrations as $registration)
                <tr>
                    <th scope="row">{{ $registration->id }}</th>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->email }}</td>
                    <td>{{ $registration->created_at }}</td>
                    <td>
                        <form action="{{config("app.url")}}/admin/registrations" method="post">
                            @csrf
                            <input type="hidden" name="ac" value="submit">
                            <input type="hidden" name="id" value="{{ $registration->id }}">
                            <button class="btn btn-primary">Confirm</button>
                        </form>
                        <form action="{{config("app.url")}}/admin/registrations" method="post">
                            @csrf
                            <input type="hidden" name="ac" value="remove">
                            <input type="hidden" name="id" value="{{ $registration->id }}">
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection