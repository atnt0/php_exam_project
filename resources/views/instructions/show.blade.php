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

            @if (Auth::guest())
                Only registred users can be use this function.
            @else
                <a href="{{ route('instructions.complaints.createForInstructionId', ['instructionId' => $instruction->id]) }}"
                       class="btn btn-primary">Add complaint</a>
            @endif

            @if( \Illuminate\Support\Facades\Auth::user()->hasRole('admin') )
                <a href="{{ route('instructions.complaints.indexComplaintsforInstruction', ['instructionId' => $instruction->id]) }}"
                   class="btn btn-primary" title="All complaints for Instruction">All Complaints</a>
            @endif
            <br>
            <br>

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
                        <div class="col-8"><b>
                                <b>{{ ($instruction->status_approved == 1 ? "Approved" : "non Approved") }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right"><b>Author id:</b></div>
                        <div class="col-8">
                            <span data-author-id="{{ $instruction->author_id }}">
                                {{ \App\Models\User::find($instruction->author_id)->name }}
                                {{  " [id: ". $instruction->author_id ."]" }}
                                {{ ($instruction->author_id == Auth::user()->id ? " (You)" : "" ) }}
                            </span>
                        </div>
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
                    <h4 class="display-6">Actions:</h4>

                    <div class="buttons">

                    @if( \App\Http\Controllers\InstructionsController::hasRights($instruction->author_id) )
                        <div class="buttons-item d-inline-block">
                            <a href="{{ route('instructions.edit', $instruction->id) }}" class="btn btn-primary">Edit</a>
                        </div>

                        @if( $instruction->status_approved == 0 && \App\Http\Controllers\InstructionsController::hasRightsAdmin() )
                        <div class="buttons-item d-inline-block">
{{--                           , ['instructionId' => $instruction->id]--}}
                            <form action="{{ route('instructions.setApproved', $instruction->id) }}" method="post">
                                @csrf
                                <button class="btn btn-warning" type="submit">Approve</button>
                            </form>
                        </div>
                        @endif

                        <div class="buttons-item d-inline-block">
                            <form action="{{ route('instructions.destroy', $instruction->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    @endif

                    </div>
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
