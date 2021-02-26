@extends('base')

@section('main')
    <div class="row">
        <div class="col-12">
            <h1 class="display-3">Instructions</h1>

            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="col">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <br />
                @endif
            </div>

            <div class="row">
                @if (Auth::guest())
{{--                    Only registred users can be use this function.--}}
                @else
                    <div class="col">
                        <a href="{{ route('instructions.create') }}" class="mb-3 btn btn-primary">Add instruction</a>
                    </div>
                @endif

                <div class="col">
                    <div class="float-right">
                        <form id="searchForm" name="searchForm" action="{{ route('instructions.search.ajax') }}" method="post">
                            @csrf
                            <input type="text" name="searchString" placeholder="sound name" />
                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>


            <table class="table table-striped" data-table="insert_here">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>File name</th>
                    <th>Status</th>
                    <th colspan="3">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @include('instructions.parts._items')
                </tbody>
            </table>

        </div>
    </div>

@endsection
