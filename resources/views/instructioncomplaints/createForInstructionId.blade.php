@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Add a Complaint for Instruction</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br/>
            @endif

            <div class="row">
                <div class="col-12">
                    <h4 class="display-6">Instruction info:</h4>

                    <div class="content">

                        <div class="row">
                            <div class="col-2 text-right"><b>ID:</b></div>
                            <div class="col-10">{{ $instruction->id }}</div>
                        </div>
                        <div class="row">
                            <div class="col-2 text-right"><b>Title:</b></div>
                            <div class="col-10">{{ $instruction->title }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <form enctype="multipart/form-data" method="post" action="{{ route('instructions.complaints.store') }}">
                @csrf

                <div class="form-group">
                    <input type="hidden" class="form-control" value="{{ $instruction->id }}" name="instruction_id"/>

                    <label for="description">Description:</label>
                    <textarea class="form-control" name="description" rows="10"></textarea>
                </div>
                <br>

                <button type="submit" class="btn btn-primary">Add Complaint</button>
            </form>
        </div>
    </div>
@endsection
