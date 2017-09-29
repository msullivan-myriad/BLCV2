
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div id="calculate-section"></div>
        </div>
        <div class="col-md-5">

                <ul>
               @foreach($subgoals as $sub)
                    <li>
                        <a href="/subgoals/{{$sub->id}}">{{ $sub->name }}</a>
                    </li>
                @endforeach
                </ul>


        </div>
    </div>
</div>
@endsection
