@extends('master')

{{--@section('title', 'Dashboard') --}}
@section('title', $title)

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <h4>Total Attendess</h4>
                <h6>{{$stats['total_attendees']}}</h6>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <h4>Verified Attendess</h4>
                <h6>{{$stats['verified_attendees']}}</h6>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <h4>UnVerified Attendess</h4>
                <h6>{{$stats['unverified_attendees']}}</h6>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js_script')
@endsection