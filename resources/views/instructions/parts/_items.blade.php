@foreach($instructions as $instruction)
    <tr>
        <td>{{ $instruction->id }}</td>
        <td>{{ $instruction->title }}</td>
        <td>
            {{ mb_substr($instruction->description, 0, 20) }}
            {{ mb_strlen($instruction->description) > 20 ? "..." : "" }}
        </td>
        <td>{{ $instruction->file_name }}</td>
        <td>
            {{ ($instruction->status_approved == 1 ? "Approved" : "non Approved") }}
        </td>

        <td>
            <a href="{{ route('instructions.show', $instruction->id) }}" class="btn btn-primary">View</a>
        </td>

{{--        Actions moved to view--}}

{{--        <td>--}}
{{--        @if( \App\Http\Controllers\InstructionsController::hasRights($instruction) )--}}
{{--            <a href="{{ route('instructions.edit', $instruction->id) }}" class="btn btn-primary">Edit</a>--}}
{{--        @endif--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            @if( \App\Http\Controllers\InstructionsController::hasRights($instruction) )--}}
{{--                <form action="{{ route('instructions.destroy', $instruction->id) }}" method="post">--}}
{{--                    @csrf--}}
{{--                    @method('DELETE')--}}
{{--                    <button class="btn btn-danger" type="submit">Delete</button>--}}
{{--                </form>--}}
{{--            @endif--}}
{{--        </td>--}}
        <td>

        </td>
        <td>
        @if( \App\Models\User::hasRightsAdmin() )
            <a href="{{ route('instructions.complaints.indexComplaintsforInstruction', $instruction->id )}}"
               class="btn btn-primary" title="All complaints for Instruction">All_Complaints</a>
        @endif
        </td>
    </tr>
@endforeach
