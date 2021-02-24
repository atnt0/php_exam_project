@foreach($complaints as $complaint)
    <tr>
        <td>{{ $complaint->id }}</td>
        <td>{{ $complaint->name }}</td>
        <td>{{ $complaint->instruction_id }}</td>
        <td>{{ mb_substr($complaint->description, 0, 20) }} {{ mb_strlen($complaint->description) > 20 ? "..." : "" }}</td>
        <td>{{ $complaint->title }}</td>

        @if ( \Illuminate\Support\Facades\Auth::user()->hasRole('Admin') )
            <td>
                <form action="{{ route('complaints.destroy', $complaint->id )}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Reject</button>
                </form>
            </td>
            <td>
                <form action="{{ route('complaints.update', $complaint->id )}}" method="post">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-success" type="submit">Accept</button>
                </form>
            </td>
        @endif


        <td>
            <a href="{{ route('complaints.show',$complaint->id)}}" class="btn btn-primary">View</a>
        </td>

    </tr>
@endforeach
