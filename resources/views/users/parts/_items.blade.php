@foreach ($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            <input type="checkbox" id="checkBoxIsBlocked" disabled>
        </td>
        <td>
            <a class="btn btn-info text-white" href="{{ route('users.show',$user->id) }}">View</a>
            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>

            <form action="{{ route('users.destroy', [$user->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
