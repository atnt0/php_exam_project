@extends('base')

@section('main')
    <div class="row">
        <div class="col-12">
            <h1 class="display-3">Show User</h1>

            <div class="row">
                <div class="col">
                    <a class="btn btn-primary" href="{{ route('users.index') }}">Back to list</a>
                </div>
            </div>
            <br>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $user->name }}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    {{ $user->email }}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Password Hash:</strong>
                    {{ $user->password }}
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <h4 class="display-6">Actions:</h4>

                    <div class="buttons">

                        <div class="buttons-item d-inline-block">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                        </div>

                        <div class="buttons-item d-inline-block" style="width: 100px; vertical-align: middle;">
                            <form action="{{ route('users.setBlocked', [$user->id]) }}" method="post">
                                @csrf
                                <input type="hidden" name="block" value="{{ $isBlocked ? "0" : "1" }}">
                                <button class="btn btn-{{ $isBlocked ? "success" : "warning" }}" type="submit">
                                    {{ $isBlocked ? "UnBlock" : "Block" }}</button>
                            </form>
                        </div>

                        <div class="buttons-item d-inline-block">
                            <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>




        </div>
    </div>
@endsection
