@foreach($instructions as $instruction)
    <tr>
        <td>{{ $instruction->id }}</td>
        <td>{{ $instruction->title }}</td>
        <td>{{ $instruction->description }}</td>
        <td>{{ $instruction->file_name }}</td>
        <td>{{ $instruction->status }}</td>
        <td>
        @if( \App\Http\Controllers\InstructionsController::hasRights($instruction) )
            <a href="{{ route('instructions.edit', $instruction->id) }}" class="btn btn-primary">Edit</a>
        @endif
        </td>
        <td>

        </td>
        <td>
            <a href="{{ route('instructions.show', $instruction->id) }}" class="btn btn-primary">View</a>
        </td>
        <td>
        @if( \App\Http\Controllers\InstructionsController::hasRightsAdmin() )
            <a href="{{ route('instructions.complaints', $instruction->id )}}" class="btn btn-primary">Complaints</a>
        @endif
        </td>
        <td>
        @if( \App\Http\Controllers\InstructionsController::hasRights($instruction) )
            <form action="{{ route('instructions.destroy', $instruction->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Delete</button>
            </form>
        @endif
        </td>
    </tr>
@endforeach
