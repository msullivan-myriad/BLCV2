
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

                <h1>{{$goal->name}}</h1>

                <h4>${{$goal->cost}}</h4>

                <h4>Days: {{$goal->days}}</h4>
                <h4>Hours: {{$goal->hours}}</h4>
                <h4>Subgoals Count: {{$goal->subgoals_count}}</h4>

                <h2>Subgoals</h2>

                <ul>
                @foreach($subgoals as $sub)
                    <li>{{ $sub->name }}</li>
                @endforeach
                </ul>

                <br>
                <h1>Create Goal with your own values</h1>
                <form action="/goals/{{$goal->id}}/new" method="POST">
                    {{ csrf_field() }}
                    <input name="cost" type="number" placeholder="{{$goal->cost}}">
                    <input name="hours" type="hours" placeholder="{{$goal->hours}}">
                    <input name="days" type="days" placeholder="{{$goal->days}}">
                    <input name="goal_id" type="hidden" value="{{$goal->id}}">
                    <button type="submit">Submit</button>
                </form>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
        </div>
    </div>
</div>
@endsection