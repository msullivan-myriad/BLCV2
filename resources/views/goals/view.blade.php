
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

                <h1>{{$goal->name}}</h1>

                <h4>${{$goal->cost}}</h4>

                <h4>Days: {{$goal->days}}</h4>
                <h4>Hours: {{$goal->hours}}</h4>


                <h2>Subgoals</h2>

                <ul>
                @foreach($subgoals as $sub)
                    <li>{{ $sub->name }}</li>
                @endforeach
                </ul>

        </div>
    </div>
</div>
@endsection