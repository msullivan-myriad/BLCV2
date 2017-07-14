
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @foreach ($goals as $goal)
                <div class="panel">
                    <h2><a href="/goals/{{$goal->id}}">{{$goal->name}}</a></h2>
                    <h4>Cost: {{$goal->cost}}</h4>
                    <h4>Days: {{$goal->days}}</h4>
                    <h4>Hours: {{$goal->hours}}</h4>
                    <h4>Subgoal Count: {{$goal->subgoals_count}}</h4>
                    <form action="/goals/{{$goal->id}}/new" method="POST">
                       {{ csrf_field() }}
                        <input name="goal_id" type="hidden" value="{{$goal->id}}">
                        <input name="cost" value="{{$goal->cost}}" type="hidden">
                        <input name="days" value="{{$goal->days}}" type="hidden">
                        <input name="hours" value="{{$goal->hours}}" type="hidden">
                        <button type="submit">+</button>
                    </form>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
