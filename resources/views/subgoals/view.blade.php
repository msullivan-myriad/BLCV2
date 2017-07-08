
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <h2>{{$subgoal->name}}</h2>

            <p>Cost: {{$subgoal->cost}}</p>
            <p>Days: {{$subgoal->days}}</p>
            <p>Hours: {{$subgoal->hours}}</p>
            <p>Parent Goal: <a href="/goals/{{$goal->id}}">here</a></p>

        </div>
    </div>
</div>
@endsection
