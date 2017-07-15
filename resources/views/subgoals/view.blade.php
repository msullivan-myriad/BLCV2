
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
            <br>
            <h4>Update goal here:</h4>
            <form action="/subgoals/{{ $subgoal->id }}/" method="post">
                {{ csrf_field() }}
                <input name="cost" value="{{$subgoal->cost}}" type="number">
                <input name="days" value="{{$subgoal->days}}" type="number">
                <input name="hours" value="{{$subgoal->hours}}" type="number">
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
