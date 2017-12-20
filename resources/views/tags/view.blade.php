
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{$tag->name}}</h1>
    <br>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div id="tags-sorting-section"></div>
       </div>
        <div class="col-md-6">
            <h2>Related blogs coming soon</h2>
        </div>
    </div>
</div>
@endsection