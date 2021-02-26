{{--@extends('users.layout')--}}
@extends('base')

{{--@section('content')--}}
@section('main')
    <div class="row">
        <div class="col-12">
            <h1 class="display-3">Users management</h1>

            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="col">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <br />
                @endif
            </div>

            <div class="row">
                <div class="col">
                    @if ( Auth::user() && Auth::user()->hasRole('admin') )
                        <a class="btn btn-primary mb-2" href="{{ route('users.create') }}">Create New User</a>
                    @endif
                </div>
            </div>
            <br>

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <table class="table table-bordered" data-table="insert_here">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Is blocked</th>

                    <th colspan="3">Actions</th>
                </tr>
                </thead>
                <tbody>
                @include('users.parts._items')
                </tbody>
            </table>
        </div>
    </div>

@endsection
