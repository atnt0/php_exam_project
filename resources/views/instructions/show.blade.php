@extends('base')

@section('main')
    <div class="row">
        <div class="col-12">
            <h1 class="display-3">Instruction</h1>

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

            <div class="row">
                <div class="col col-6">
                    <div class="row">
                        <div class="col-4 text-right"><b>ID:</b></div>
                        <div class="col-8">{{ $instruction->id }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right"><b>Title:</b></div>
                        <div class="col-8">{{ $instruction->title }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right"><b>Description:</b></div>
                        <div class="col-8">{{ $instruction->description }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right"><b>File name:</b></div>
                        <div class="col-8">{{ $instruction->file_name }}</div>
                    </div>
                </div>
                <div class="col col-6">
                    <div class="row">
                        <div class="col-4 text-right"><b>Status:</b></div>
                        <div class="col-8">{{ $instruction->status }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right"><b>Author id:</b></div>
                        <div class="col-8">{{ $instruction->author_id }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right"><b>Created at:</b></div>
                        <div class="col-8">{{ $instruction->created_at }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right"><b>Updated at:</b></div>
                        <div class="col-8">{{ $instruction->updated_at }}</div>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-12">
                    <a href="{{ $fileLink }}"  class="btn btn-info text-white" download>Download file</a>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-12">
                    <h4 class="display-6">File content:</h4>
                    <pre>{{ $fileContent }}</pre>
                </div>
            </div>

        </div>
    </div>
@endsection
