@extends('base')

@section('main')
    <div class="row">
        <div class="col-12">
            <h1 class="display-3">Edit a Instruction</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif

            <form method="post" action="{{ route('instructions.update', $instruction->id) }}">
                @csrf

                @method('PATCH')

                <div class="form-group">
                    <label for="first_name">Title:</label>
                    <input type="text" class="form-control" name="title" value="{{ $instruction->title }}" />
                </div>

                <div class="form-group">
                    <label for="last_name">Description:</label>
                    <textarea class="form-control" name="description" rows="10">{{ $instruction->description }}</textarea>
                </div>

{{--                //TODO for update File need create another method --}}

                <br>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
