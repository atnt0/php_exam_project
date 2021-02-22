@extends('base')

@section('main')
    <div class="row">
        <div class="col-12">
            <h1 class="display-3">Instructions</h1>

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

                @if (Auth::guest())
{{--                    Only registred users can be use this function.--}}
                @else
                    <div class="col">
                        <a href="{{ route('instructions.create') }}" class="mb-3 btn btn-primary">Add instruction</a>
                    </div>
                @endif

                <div class="col">
                    <div class="float-right">
                        <form id="searchForm" name="searchForm" action="{{ route('sound.search.ajax') }}" method="post">
                            @csrf
                            <input type="text" name="searchString" placeholder="sound name" />
                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>


            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>File name</th>
                    <th>Status</th>
                    <th>Author id</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($instructions as $instruction)
                    <tr>
                        <td>{{ $instruction->id }}</td>
                        <td>{{ $instruction->title }}</td>
                        <td>{{ $instruction->description }}</td>
                        <td>{{ $instruction->file_name }}</td>
                        <td>{{ $instruction->status }}</td>
                        <td>{{ $instruction->author_id }}</td>
                        <td>{{ $instruction->created_at }}</td>
                        <td>{{ $instruction->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection
