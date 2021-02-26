@extends('base')


@section('main')
    <div class="row">
        <div class="col-12">
            <h1 class="display-3">Show a Complaint for Instruction</h1>

{{--            Возхвращает url со знаком вопроса --}}
{{--            <div class="buttons">--}}
{{--                --}}{{--            <ul class="list-group list-group-horizontal">--}}
{{--                --}}{{--                <li class="list-group-item">--}}
{{--                <div class="buttons-item d-inline-block">--}}
{{--                    <a href=" {{ redirect()->back()->getTargetUrl() }}" class="btn btn-primary">Back to list</a>--}}
{{--                    --}}{{--                </li>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <br>--}}

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

            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $complaint->id }}</td>
                        <td>{{ $complaint->user_id }}</td>
{{--                        <td>{{ $userName }}</td>--}}
                        <td>{{ $complaint->created_at }}</td>
                        <td>{{ $complaint->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
            <br>

            <div class="row">
                <div class="col-12">
                    <h4 class="display-6">Actions:</h4>

                    <div class="buttons">

                    @if ( \Illuminate\Support\Facades\Auth::user()->hasRole('admin') )
                        <div class="buttons-item d-inline-block">
                            <form action="{{ route('instructions.complaints.setAccepted', $complaint->id )}}" method="post">
                                @csrf
                                <button class="btn btn-success" type="submit">Accept</button>
                            </form>
                        </div>

                        <div class="buttons-item d-inline-block">
                            <form action="{{ route('instructions.complaints.setRejected', $complaint->id )}}" method="post">
                                @csrf
                                <button class="btn btn-warning" type="submit">Reject</button>
                            </form>
                        </div>

                        <div class="buttons-item d-inline-block">
                            <form action="{{ route('instructions.complaints.destroy', $complaint->id )}}" method="post">
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
                    <h4 class="display-6">Description:</h4>
                    {{ $complaint->description }}
                </div>
            </div>
            <br>

        </div>
    </div>
@endsection
