
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">

                <h1>{{$goal->name}}</h1>

                <h4>${{$goal->cost}}</h4>

                <h4>Days: {{$goal->days}}</h4>
                <h4>Hours: {{$goal->hours}}</h4>
                <h4>Subgoals Count: {{$goal->subgoals_count}}</h4>

                <h1>{{$goal->slug}}</h1>
       </div>
        <div class="col-md-6">
            <p>Stuff about your own unique goal over here</p>
        </div>
    </div>
</div>
@endsection