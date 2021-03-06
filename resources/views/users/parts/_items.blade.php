@foreach ($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            {{ $user->is_blocked ? "Blocked" : "" }}
{{--            {{ $isBlocked ? "UnBlock" : "Block" }}--}}
{{--            <input type="checkbox" name="isEnabled" id="isEnabled" value="{{ $user->blocked_at }}"--}}
{{--                   style="box-shadow: none;" class="form-control" placeholder="isEnabled">--}}
        </td>
        <td>
            <a class="btn btn-info text-white" href="{{ route('users.show',$user->id) }}">View</a>
        </td>
{{--        <td>--}}
{{--            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>--}}
{{--        </td>--}}
{{--        <td>--}}
{{--            <form action="{{ route('users.destroy', [$user->id]) }}" method="post">--}}
{{--                @csrf--}}
{{--                @method('DELETE')--}}
{{--                <button type="submit" class="btn btn-danger">Delete</button>--}}
{{--            </form>--}}
{{--        </td>--}}
    </tr>
@endforeach
