@extends('base')

@section('main')
    <div class="row">
        <div class="col-12">
            <h1 class="display-3">Edit User</h1>

            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul class="col">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col">
                    <a class="btn btn-primary" href="{{ route('users.index') }}">Back to list</a>
                </div>
            </div>
            <br>

            <form action="{{ route('users.update',$user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Name">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                   placeholder="Email">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Password:</strong>
                            <input type="password" name="password" value="" class="form-control" {{--{{ $user->password }}--}}
                                   placeholder="Password">
                        </div>
                    </div>

{{--                for block user need another method    --}}
{{--                    <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="isEnabled">isEnabled</label>--}}
{{--                            <input type="checkbox" name="isEnabled" id="isEnabled" value="{{ $user->blocked_at }}"--}}
{{--                                   class="form-control" placeholder="isEnabled">--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
