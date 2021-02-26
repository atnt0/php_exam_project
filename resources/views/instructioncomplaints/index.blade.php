@extends('base')


@section('main')
    <div class="row">
        <div class="col-12">
            <h1 class="display-3">Complaints for Instructions</h1>
            <br>

            <table class="table table-striped">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>User</td>
                    <td>Instruction</td>
                    <td>Description</td>
                    <td>Status</td>
                    <td colspan=2>Actions</td>
                </tr>
                </thead>
                <tbody >
                    @include('instructioncomplaints.parts._items')
                </tbody>
            </table>
        </div>
    </div>
@endsection
