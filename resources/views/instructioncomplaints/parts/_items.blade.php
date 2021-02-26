
@foreach($complaints as $complaint)
    <tr>
        <td>{{ $complaint->id }}</td>
        <td>{{ $complaint->name }}</td>
        <td>
            {{ mb_substr($complaint->instruction_title, 0, 20) }}
            {{ mb_strlen($complaint->instruction_title) > 20 ? "..." : "" }}
        </td>
        <td>
            {{ mb_substr($complaint->description, 0, 20) }}
            {{ mb_strlen($complaint->description) > 20 ? "..." : "" }}
        </td>
        <td>{{ $complaint->title }}</td>

        <td>
{{--            {{ dd($complaint) }}--}}
            {{--            complaintId--}}
            <a href="{{ route('instructions.complaints.show', ['complaint' => $complaint->id] )}}"
               class="btn btn-primary">View</a>
        </td>
        <td>

        </td>

        <td>
            {{--            instructionId--}}
            <a href="{{ route('instructions.show', ['instruction' => $complaint->instruction_id]) }}"
               class="btn btn-primary" title="Link to the instruction for which the complaint was received">
                View_Instruction</a>
        </td>
        <td>
{{--            {{ dd(Illuminate\Support\Facades\Route::currentRouteName()) }}--}}
            @if( \Illuminate\Support\Facades\Route::currentRouteName() == 'instructions.complaints.index' )
            <a href="{{ route('instructions.complaints.indexComplaintsforInstruction', ['instructionId' => $complaint->instruction_id] )}}"
               class="btn btn-primary" title="All complaints for Instruction">All_Complaints</a>
            @endif
        </td>

    </tr>
@endforeach
