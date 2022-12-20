@extends('master')
@section('title', $title)
@section('content')
{{-- create attende button right side --}}
<div class="row">
    <div class="col-md-12">
        <a  class="btn btn-primary float-right"  data-bs-toggle="modal" data-bs-target="#createModal">Create Attendee</a>
    </div>
</div>
<hr>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DataTable Example
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>No of Admissions</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendees as $attendee)                                
                    <tr>
                        <td>{{$attendee->name}}</td>
                        <td>{{$attendee->email}}</td>
                        <td>{{$attendee->phone_number}}</td>
                        <td>{{$attendee->no_of_admission}}</td>
                        <td>{{$attendee->status}}</td>
                        <td>{{$attendee->created_at}}</td>
                        <td>
                            {{-- <a  class="btn btn-primary btn-sm">Edit</a> --}}
                            <a target="_blank" href="{{route('view_attendee',$attendee->reference)}}" class="btn btn-success btn-sm">View Invite</a>
                            <a  class="btn btn-warning btn-sm" href="{{route('resend_attendee', $attendee->reference)}}">Resend</a>
                            <a  class="btn btn-danger btn-sm" href="{{route('delete_attendee', $attendee->reference)}}">Delete</a>
                        </td>
                    </tr> 
                @endforeach               
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['route' => 'create_attendee']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="amount">Name</label>
                        {!!Form::text('name','', ['class' => 'form-control'])!!}
                    </div> 
                    <div class="form-group">
                        <label for="amount">Email</label>
                        {!!Form::text('email','', ['class' => 'form-control'])!!}
                    </div>
                    <div class="form-group">
                        <label for="amount">Phone Number</label>
                        {!!Form::text('phone_number','', ['class' => 'form-control'])!!}
                    </div>
                    <div class="form-group">
                        <label for="amount">No of Admission</label>
                        {!!Form::text('no_of_admission','', ['class' => 'form-control'])!!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Login</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection