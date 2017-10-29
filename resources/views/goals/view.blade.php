
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{$goal->name}}</h1>
    <div class="row">
        <div class="col-md-6">
                <h4>Average Goal Data</h4>
                <h4>${{$goal->cost}}</h4>

                <h4>Days: {{$goal->days}}</h4>
                <h4>Hours: {{$goal->hours}}</h4>
                <h4># of users you have this goal on their list: {{$goal->subgoals_count}}</h4>

                <!-- Consider if I should build something cool here with React or if static content is more important... -->
                <!-- Definitly should have some cool stats on this side of the page -->



       </div>
        <div class="col-md-6">
            <div id="your-goal-data"></div>
        </div>
    </div>
</div>
@endsection