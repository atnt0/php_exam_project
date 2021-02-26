@extends('base')

@section('main')
    <div class="row">
        <div class="col-12">
            <h1 class="display-3">Add a Instruction</h1>

            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif

                <div enctype="multipart/form-data" method="post" action="{{ route('instructions.store') }}">
                    @csrf

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="name">Title:</label>
                            <input type="text" class="form-control" name="title"/>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="description">Description:</label>
    {{--                        <input type="text" class="form-control" name="description"/>--}}
                            <textarea class="form-control" name="description" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="file">File:</label>
                            <input type="file" class="form-control" name="file"/>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary">Add instruction</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
