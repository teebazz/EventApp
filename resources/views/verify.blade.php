@extends('master')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Verify
            </div>
            <div class="card-body">
                {{-- table to attendee details --}}
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <td>{{$attendee->name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$attendee->email}}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{$attendee->phone_number}}</td>
                    </tr>
                    <tr>
                        <th>No of Admissions</th>
                        <td>{{$attendee->no_of_admission}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            {{-- status badge --}}
                            @if ($attendee->status == 'pending')
                                <span class="badge bg-warning text-dark">{{$attendee->status}}</span>
                            @elseif($attendee->status == 'verified')
                                <span class="badge bg-success">{{$attendee->status}}</span>
                            @else
                                <span class="badge bg-danger">{{$attendee->status}}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created Date</th>
                        <td>{{$attendee->created_at}}</td>
                    </tr>
                </table>
                {{-- verify button --}}
                @if ($attendee->status == 'pending')
                    <a href="{{route('verify_attendee',$attendee->reference)}}" class="btn btn-success btn-block" onclick="return confirm('Are you sure you want to verify this attendee?')">Verify</a>
                @endif
                {{-- verify another  --}}
                <a href="{{route('/')}}" class="btn btn-primary btn-block">Verify Another</a>
            </div>
        </div>
    </div>
</div>
@endsection
