
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @foreach ($results as $goal)
                <div class="panel">
                    <h2><a href="/goals/{{$goal->id}}">{{$goal->name}}</a></h2>
                    <h4>Cost: {{$goal->cost}}</h4>
                    <h4>Days: {{$goal->days}}</h4>
                    <h4>Hours: {{$goal->hours}}</h4>
                    <form action="/goals/{{$goal->id}}/new" method="POST">
                       {{ csrf_field() }}
                        <h1>LEFT OFF HERE!!! </h1>
                    <button type="submit">+</button>
                    </form>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
